<?php

namespace App\Services;

use Gemini;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\Schema;
use Gemini\Enums\DataType;
use Gemini\Enums\ResponseMimeType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisService
{
    public function extractResumeInfo($file_path): array
    {
        $emptyResult = [
            'summary' => '',
            'skills' => [],
            'experience' => [],
            'education' => [],
        ];

        try {
            $raw_text = $this->extractTextFromPdf($file_path);

            $apiKey = env('GEMINI_API_KEY');
            if (empty($apiKey)) {
                throw new \Exception('GEMINI_API_KEY is not set');
            }

            $client = Gemini::client($apiKey);

            $systemInstruction = 'You are a precise resume parser. Extract information exactly as it appears in the resume without adding any interpretation. The output must be valid JSON adhering strictly to the provided schema.';

            $prompt = <<<PROMPT
        Parse the following resume content and extract ALL information accurately.

        IMPORTANT:
        - Do not skip any section, especially education and certifications.
        - Extract all content verbatim, do not summarize or omit details.
        - Education section may appear near the end of the resume.

        Resume Content:
        {$raw_text}
        PROMPT;

            $responseSchema = new Schema(
                type: DataType::OBJECT,
                properties: [
                    'summary' => new Schema(type: DataType::STRING, description: 'Professional summary or objective.'),
                    'skills' => new Schema(
                        type: DataType::ARRAY,
                        items: new Schema(type: DataType::STRING),
                        description: 'Array of individual technical and soft skills.'
                    ),
                    'experience' => new Schema(
                        type: DataType::ARRAY,
                        items: new Schema(
                            type: DataType::OBJECT,
                            properties: [
                                'company' => new Schema(type: DataType::STRING),
                                'position' => new Schema(type: DataType::STRING),
                                'start_date' => new Schema(type: DataType::STRING),
                                'end_date' => new Schema(type: DataType::STRING),
                                'responsibilities' => new Schema(type: DataType::STRING),
                            ],
                            required: ['company', 'position', 'start_date', 'end_date', 'responsibilities']
                        ),
                        description: 'Array of work experiences.'
                    ),
                    'education' => new Schema(
                        type: DataType::ARRAY,
                        items: new Schema(
                            type: DataType::OBJECT,
                            properties: [
                                'degree' => new Schema(type: DataType::STRING),
                                'university' => new Schema(type: DataType::STRING),
                                'graduation_year' => new Schema(type: DataType::STRING),
                                'field_of_study' => new Schema(type: DataType::STRING),
                            ],
                            required: ['degree', 'university', 'graduation_year', 'field_of_study']
                        ),
                        description: 'Array of educational background including degrees, universities, graduation years, AND any certifications. Extract even if located at the bottom of the resume. Only return empty array if absolutely no education information exists.'
                    ),
                ],
                required: ['summary', 'skills', 'experience', 'education']
            );

            $generationConfig = new GenerationConfig(
                temperature: 0.0,
                responseMimeType: ResponseMimeType::APPLICATION_JSON,
                responseSchema: $responseSchema
            );

            $result = retry(3, function () use ($client, $systemInstruction, $generationConfig, $prompt) {
                Log::debug('Calling Gemini API for resume extraction');

                return $client
                    ->generativeModel('gemini-3.1-flash-lite-preview')
                    ->withSystemInstruction(Content::parse($systemInstruction))
                    ->withGenerationConfig($generationConfig)
                    ->generateContent($prompt);
            }, 2000);

            $parseResult = json_decode($result->text(), true);

            if (! is_array($parseResult)) {
                throw new \Exception('Gemini response is not valid JSON');
            }

            $requiredKeys = ['summary', 'skills', 'experience', 'education'];
            $missingKeys = array_diff($requiredKeys, array_keys($parseResult));
            if (! empty($missingKeys)) {
                throw new \Exception('Missing required keys: '.implode(', ', $missingKeys));
            }

            return [
                'summary' => $parseResult['summary'] ?? '',
                'skills' => $parseResult['skills'] ?? [],
                'experience' => $parseResult['experience'] ?? [],
                'education' => $parseResult['education'] ?? [],
            ];

        } catch (\Exception $e) {
            Log::error('Resume extraction failed', [
                'file_path' => $file_path,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $emptyResult;
        }
    }

    public function analyzeResume($jobVacancy, $resumeData)
    {
        try {
            $jobVacancyData = json_encode([
                'job_title' => $jobVacancy->title,
                'job_description' => $jobVacancy->description,
                'job_location' => $jobVacancy->location,
                'job_type' => $jobVacancy->type,
                'job_salary' => $jobVacancy->salary,
                'job_tecnologies' => $jobVacancy->tecnologies,

            ]);

            $resumeData = json_encode([
                'summary' => $resumeData['summary'],
                'skills' => $resumeData['skills'],
                'experience' => $resumeData['experience'],
                'education' => $resumeData['education'],
            ]);

            $apiKey = env('GEMINI_API_KEY');
            if (empty($apiKey)) {
                throw new \Exception('API key is not set');
            }
            $client = Gemini::client($apiKey);

            // 1. (System Instruction)
            $systemInstruction = "You are an expert HR professional and job recruiter. You are given a job vacancy and a resume.
                  Your task is to analyze the resume and determine if the candidate is a good fit for the job.
                  The output should be in JSON format.
                  Provide a score from 0 to 100 for the candidate's suitability for the job, and a detailed feedback.
                  Response should only be Json that has the following keys: 'ai_generated_score', 'ai_generated_feedback'.
                  Aigenerate feedback should be detailed and specific to the job and the candidate's resume.";

            // 2. (User Prompt)
            $prompt = "Job Vacancy: \n\n{$jobVacancyData}\n\nResume: \n\n{$resumeData}";

            $responseSchema = new Schema(
                type: DataType::OBJECT,
                properties: [
                    'ai_generated_score' => new Schema(type: DataType::INTEGER, description: 'Score from 0 to 100 representing the match percentage'),
                    'ai_generated_feedback' => new Schema(type: DataType::STRING, description: 'Detailed feedback explaining the score and suitability'),
                ],
                required: ['ai_generated_score', 'ai_generated_feedback']
            );

            // 3. (Generation Config)
            $generationConfig = new GenerationConfig(
                temperature: 0.1,
                responseMimeType: ResponseMimeType::APPLICATION_JSON,
                responseSchema: $responseSchema,
            );

            // 4. (Call the model)
            $result = retry(3, function () use ($client, $systemInstruction, $generationConfig, $prompt) {
                Log::debug('Calling Gemini API');

                return $client
                    ->generativeModel('gemini-3-flash-preview')
                    ->withSystemInstruction(Content::parse($systemInstruction))
                    ->withGenerationConfig($generationConfig)
                    ->generateContent($prompt);
            }, 2000);
            $parseResult = json_decode($result->text(), true);
            $requiredKeys = ['ai_generated_score', 'ai_generated_feedback'];
            $missingKeys = array_diff($requiredKeys, array_keys($parseResult));
            if (! empty($missingKeys)) {
                throw new \Exception('Missing required keys in parse result');
            }

            return [
                'ai_generated_score' => $parseResult['ai_generated_score'] ?? 0,
                'ai_generated_feedback' => $parseResult['ai_generated_feedback'] ?? '',
            ];

        } catch (\Exception $e) {
            Log::debug('Error analyzing resume: '.$e->getMessage());

            return [
                'ai_generated_score' => 0,
                'ai_generated_feedback' => '',
            ];
        }
    }

    private function extractTextFromPdf($file_path): string
    {
        $absolutePath = Storage::disk('public')->path($file_path);
        if (! file_exists($absolutePath)) {
            Log::debug('File not found: '.$absolutePath);
            throw new \Exception('File not found: '.$absolutePath);
        }

        $text = Pdf::getText($absolutePath);

        return $text;
    }
}

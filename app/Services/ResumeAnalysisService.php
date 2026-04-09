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
        try {
            $raw_text = $this->extractTextFromPdf($file_path);
            $apiKey = env('GEMINI_API_KEY');
            $client = Gemini::client($apiKey);

            // 1. (System Instruction)
            $systemInstruction = 'You are a precise resume parser. Extract information exactly as it appears in the resume without adding any interpretation or additional information. The output should be in JSON format.';

            // 2. (User Prompt)
            $prompt = "Parse the following resume content and extract the information as a JSON Object with the exact keys: 'summary', 'skills', 'experience', 'education'. The resume content is:\n\n{$raw_text}\n\nReturn an empty string for any key that is not found.";

            // 3. (Generation Config)
            $generationConfig = new GenerationConfig(
                temperature: 0.1,
                responseMimeType: ResponseMimeType::APPLICATION_JSON
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
            $requiredKeys = ['summary', 'skills', 'experience', 'education'];
            $missingKeys = array_diff($requiredKeys, array_keys($parseResult));
            if (! empty($missingKeys)) {
                throw new \Exception('Missing required keys in parse result');
            }

            return [
                'summary' => $parseResult['summary'] ?? '',
                'skills' => $parseResult['skills'] ?? '',
                'experience' => $parseResult['experience'] ?? '',
                'education' => $parseResult['education'] ?? '',
            ];
        } catch (\Exception $e) {
            Log::debug('Error extracting text from PDF: '.$e->getMessage());

            return [
                'summary' => '',
                'skills' => '',
                'experience' => '',
                'education' => '',
            ];
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
            throw new \Exception('File not found: '.$absolutePath);
        }

        $text = Pdf::getText($absolutePath);

        return $text;
    }
}

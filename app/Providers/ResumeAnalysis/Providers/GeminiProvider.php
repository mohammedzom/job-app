<?php

namespace App\Providers\ResumeAnalysis\Providers;

use App\Providers\ResumeAnalysis\Concerns\HasResumePrompts;
use App\Providers\ResumeAnalysis\Contracts\ResumeAnalysisProvider;
use Gemini;
use Gemini\Client;
use Gemini\Data\Content;
use Gemini\Data\GenerationConfig;
use Gemini\Data\Schema;
use Gemini\Enums\DataType;
use Gemini\Enums\ResponseMimeType;
use Illuminate\Support\Facades\Log;

class GeminiProvider implements ResumeAnalysisProvider
{
    use HasResumePrompts;

    private const EXTRACT_MODEL = 'gemini-3.1-flash-lite-preview';

    private const ANALYZE_MODEL = 'gemini-3.1-flash-lite-preview';

    private Client $client;

    public function __construct()
    {
        $apiKey = config('services.gemini.key');

        if (empty($apiKey)) {
            throw new \RuntimeException('GEMINI_API_KEY is not configured in services.gemini.key');
        }

        $this->client = Gemini::client($apiKey);
    }

    // -------------------------------------------------------------------------
    //  INTERFACE IMPLEMENTATION
    // -------------------------------------------------------------------------

    public function extract(string $rawText): array
    {
        $result = $this->callGemini(
            model: self::EXTRACT_MODEL,
            system: $this->getExtractionSystemInstruction(),
            prompt: $this->buildExtractionPrompt($rawText),
            schema: $this->buildExtractionSchema(),
            temperature: 0.0,
            context: 'extraction',
        );

        return [
            'summary' => is_string($result['summary']) ? $result['summary'] : '',
            'skills' => is_array($result['skills']) ? $result['skills'] : [],
            'experience' => is_array($result['experience']) ? $result['experience'] : [],
            'education' => is_array($result['education']) ? $result['education'] : [],
            'projects' => is_array($result['projects']) ? $result['projects'] : [],
            'other' => $this->normalizeOther($result['other']),
        ];
    }

    public function analyze(object $jobVacancy, array $resumeData): array
    {
        $jobPayload = $this->encodeJob($jobVacancy);
        $resumePayload = $this->encodeResume($resumeData);

        $result = $this->callGemini(
            model: self::ANALYZE_MODEL,
            system: $this->getAnalysisSystemInstruction(),
            prompt: $this->buildAnalysisPrompt($jobPayload, $resumePayload),
            schema: $this->buildAnalysisSchema(),
            temperature: 0.1,
            context: 'analysis',
        );

        return [
            'ai_generated_score' => (int) ($result['ai_generated_score'] ?? 0),
            'ai_generated_feedback' => is_string($result['ai_generated_feedback'])
                ? $result['ai_generated_feedback']
                : '',
        ];
    }

    // -------------------------------------------------------------------------
    //  PRIVATE
    // -------------------------------------------------------------------------

    private function callGemini(
        string $model,
        string $system,
        string $prompt,
        Schema $schema,
        float $temperature,
        string $context,
    ): array {
        $generationConfig = new GenerationConfig(
            temperature: $temperature,
            responseMimeType: ResponseMimeType::APPLICATION_JSON,
            responseSchema: $schema,
        );

        $startTime = microtime(true);

        $result = retry(3, function () use ($model, $system, $generationConfig, $prompt, $context) {
            Log::debug("[ResumeAnalysis][Gemini] Calling model for {$context}.");

            return $this->client
                ->generativeModel($model)
                ->withSystemInstruction(Content::parse($system))
                ->withGenerationConfig($generationConfig)
                ->generateContent($prompt);
        }, 2000, fn (\Exception $e) => $this->isRetryable($e));

        Log::debug(sprintf(
            '[ResumeAnalysis][Gemini] %s completed in %.2fs.',
            $context,
            microtime(true) - $startTime,
        ));

        return $this->decodeAndValidate($result->text());
    }

    private function buildExtractionSchema(): Schema
    {
        return new Schema(
            type: DataType::OBJECT,
            properties: [
                'summary' => new Schema(type: DataType::STRING),
                'skills' => new Schema(type: DataType::ARRAY, items: new Schema(type: DataType::STRING)),
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
                        required: ['company', 'position', 'start_date', 'end_date', 'responsibilities'],
                    ),
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
                        required: ['degree', 'university', 'graduation_year', 'field_of_study'],
                    ),
                ),
                'projects' => new Schema(
                    type: DataType::ARRAY,
                    items: new Schema(
                        type: DataType::OBJECT,
                        properties: [
                            'name' => new Schema(type: DataType::STRING),
                            'description' => new Schema(type: DataType::STRING),
                            'url' => new Schema(type: DataType::STRING),
                        ],
                        required: ['name', 'description', 'url'],
                    ),
                ),
                'other' => new Schema(type: DataType::OBJECT),
            ],
            required: ['summary', 'skills', 'experience', 'education', 'projects', 'other'],
        );
    }

    private function buildAnalysisSchema(): Schema
    {
        return new Schema(
            type: DataType::OBJECT,
            properties: [
                'ai_generated_score' => new Schema(type: DataType::INTEGER),
                'ai_generated_feedback' => new Schema(type: DataType::STRING),
            ],
            required: ['ai_generated_score', 'ai_generated_feedback'],
        );
    }

    private function decodeAndValidate(string $json): array
    {
        $decoded = json_decode($json, true);

        if (! is_array($decoded)) {
            throw new \Exception('[Gemini] Response is not valid JSON: '.$json);
        }

        return $decoded;
    }

    private function normalizeOther(mixed $other): array|\stdClass
    {
        return (is_array($other) && ! array_is_list($other)) ? $other : new \stdClass;
    }

    private function encodeJob(object $job): string
    {
        return json_encode([
            'job_title' => $job->title ?? '',
            'job_description' => $job->description ?? '',
            'job_location' => $job->location ?? '',
            'job_type' => $job->type ?? '',
            'job_salary' => $job->salary ?? '',
            'job_technologies' => $job->technologies ?? [],
        ], JSON_UNESCAPED_UNICODE);
    }

    private function encodeResume(array $resume): string
    {
        return json_encode([
            'summary' => $resume['summary'] ?? '',
            'skills' => $resume['skills'] ?? [],
            'experience' => $resume['experience'] ?? [],
            'education' => $resume['education'] ?? [],
            'projects' => $resume['projects'] ?? [],
            'other' => $resume['other'] ?? [],
        ], JSON_UNESCAPED_UNICODE);
    }

    private function isRetryable(\Exception $e): bool
    {
        $msg = strtolower($e->getMessage());

        return str_contains($msg, '429')
            || str_contains($msg, '500')
            || str_contains($msg, '502')
            || str_contains($msg, '503')
            || str_contains($msg, 'timeout')
            || str_contains($msg, 'connection');
    }
}

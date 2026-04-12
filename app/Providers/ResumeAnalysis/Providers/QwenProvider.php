<?php

namespace App\Providers\ResumeAnalysis\Providers;

use App\Providers\ResumeAnalysis\Concerns\HasResumePrompts;
use App\Providers\ResumeAnalysis\Contracts\ResumeAnalysisProvider;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QwenProvider implements ResumeAnalysisProvider
{
    use HasResumePrompts;

    private const BASE_URL = 'https://dashscope-intl.aliyuncs.com/compatible-mode/v1/chat/completions';

    private const EXTRACT_MODEL = 'qwen3.5-flash';

    private const ANALYZE_MODEL = 'qwen3-max-2026-01-23';

    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.qwen.key');

        if (empty($this->apiKey)) {
            throw new \RuntimeException('QWEN_API_KEY is not configured in services.qwen.key');
        }
    }

    // -------------------------------------------------------------------------
    //  INTERFACE IMPLEMENTATION
    // -------------------------------------------------------------------------

    public function extract(string $rawText): array
    {
        $response = $this->callQwen(
            model: self::EXTRACT_MODEL,
            system: $this->getExtractionSystemInstruction(),
            user: $this->buildExtractionPrompt($rawText),
            temp: 0.0,
            context: 'extraction',
        );

        $parsed = $this->decodeAndValidate($response);

        return [
            'summary' => is_string($parsed['summary']) ? $parsed['summary'] : '',
            'skills' => is_array($parsed['skills']) ? $parsed['skills'] : [],
            'experience' => is_array($parsed['experience']) ? $parsed['experience'] : [],
            'education' => is_array($parsed['education']) ? $parsed['education'] : [],
            'projects' => is_array($parsed['projects']) ? $parsed['projects'] : [],
            'other' => $this->normalizeOther($parsed['other']),
        ];
    }

    public function analyze(object $jobVacancy, array $resumeData): array
    {
        $jobPayload = $this->encodeJob($jobVacancy);
        $resumePayload = $this->encodeResume($resumeData);

        $response = $this->callQwen(
            model: self::ANALYZE_MODEL,
            system: $this->getAnalysisSystemInstruction(),
            user: $this->buildAnalysisPrompt($jobPayload, $resumePayload),
            temp: 0.1,
            context: 'analysis',
        );

        $parsed = $this->decodeAndValidate($response);

        return [
            'ai_generated_score' => (int) ($parsed['ai_generated_score'] ?? 0),
            'ai_generated_feedback' => is_string($parsed['ai_generated_feedback'])
                ? $parsed['ai_generated_feedback']
                : '',
        ];
    }

    // -------------------------------------------------------------------------
    //  PRIVATE
    // -------------------------------------------------------------------------

    private function callQwen(string $model, string $system, string $user, float $temp, string $context): string
    {
        $maxRetries = 3;
        $attempt = 0;
        $lastException = null;

        while ($attempt < $maxRetries) {
            $attempt++;

            try {
                $startTime = microtime(true);

                Log::debug("[ResumeAnalysis][Qwen] Calling model for {$context}, attempt {$attempt}/{$maxRetries}.");

                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])->timeout(120)->post(self::BASE_URL, [
                    'model' => $model,
                    'temperature' => $temp,
                    'response_format' => ['type' => 'json_object'],
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user',   'content' => $user],
                    ],
                ]);

                Log::debug(sprintf(
                    '[ResumeAnalysis][Qwen] %s responded in %.2fs (HTTP %d).',
                    $context,
                    microtime(true) - $startTime,
                    $response->status(),
                ));

                if ($response->successful()) {
                    $content = $response->json('choices.0.message.content');

                    if (empty($content)) {
                        throw new \Exception('[Qwen] Empty message content in response.');
                    }

                    Log::info("[ResumeAnalysis][Qwen] {$context} raw response: {$content}");

                    return $content;
                }

                $status = $response->status();
                $message = $response->json('error.message') ?? $response->body();

                if (in_array($status, [400, 401, 403])) {
                    throw new \Exception("[Qwen] Non-retryable error [{$status}]: {$message}");
                }

                $lastException = new \Exception("[Qwen] Retryable error [{$status}]: {$message}");
                Log::warning("[ResumeAnalysis][Qwen] Error [{$status}] on attempt {$attempt}. Retrying in 2s...");

            } catch (ConnectionException $e) {
                $lastException = $e;
                Log::warning("[ResumeAnalysis][Qwen] Connection error on attempt {$attempt}: {$e->getMessage()}.");
            }

            if ($attempt < $maxRetries) {
                sleep(2);
            }
        }

        throw $lastException ?? new \Exception('[Qwen] API call failed after all retries.');
    }

    private function decodeAndValidate(string $json): array
    {
        $clean = preg_replace('/^```(?:json)?\s*/i', '', trim($json));
        $clean = preg_replace('/\s*```$/', '', $clean);
        $decoded = json_decode($clean, true);

        if (! is_array($decoded)) {
            throw new \Exception('[Qwen] Response is not valid JSON: '.$json);
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
}

<?php

namespace App\Services;

use App\Providers\ResumeAnalysis\Contracts\ResumeAnalysisProvider;
use App\Providers\ResumeAnalysis\Providers\GeminiProvider;
use App\Providers\ResumeAnalysis\Providers\LocalAgentProvider;
use App\Providers\ResumeAnalysis\Providers\QwenProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToText\Pdf;

class ResumeAnalysisService
{
    private ResumeAnalysisProvider $provider;

    public function __construct()
    {
        $this->provider = $this->resolveProvider();
    }

    // -------------------------------------------------------------------------
    //  PUBLIC API
    // -------------------------------------------------------------------------

    public function extractResumeInfo(string $file_path): array
    {
        $emptyResult = [
            'summary' => '',
            'skills' => [],
            'experience' => [],
            'education' => [],
            'projects' => [],
            'other' => new \stdClass,
            'status' => 'failed',
        ];

        try {
            $rawText = $this->extractTextFromPdf($file_path);

            if (empty(trim($rawText))) {
                throw new \Exception('PDF text extraction returned empty content.');
            }

            $result = $this->provider->extract($rawText);

            return array_merge($result, ['status' => 'analyzed']);

        } catch (\Exception $e) {
            Log::error('[ResumeAnalysis] Resume extraction failed.', [
                'provider' => $this->providerName(),
                'file_path' => $file_path,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $emptyResult;
        }
    }

    /**
     * Analyze a candidate's resume against a job vacancy.
     *
     * @param  object  $jobVacancy  Eloquent model.
     * @param  array  $resumeData  Output from extractResumeInfo().
     * @return array{ai_generated_score: int, ai_generated_feedback: string}
     */
    public function analyzeResume(object $jobVacancy, array $resumeData): array
    {
        $emptyResult = [
            'ai_generated_score' => 0,
            'ai_generated_feedback' => '',
        ];

        try {
            return $this->provider->analyze($jobVacancy, $resumeData);

        } catch (\Exception $e) {
            Log::error('[ResumeAnalysis] Resume analysis failed.', [
                'provider' => $this->providerName(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $emptyResult;
        }
    }

    // -------------------------------------------------------------------------
    //  PROVIDER RESOLUTION
    // -------------------------------------------------------------------------

    /**
     * Resolve the correct provider based on the USE_AI .env variable.
     *
     * Supported values:
     *   api-gemini    → GeminiProvider
     *   api-qwen      → QwenProvider
     *   local-agent   → LocalAgentProvider
     *
     * @throws \InvalidArgumentException for unsupported values.
     */
    private function resolveProvider(): ResumeAnalysisProvider
    {
        $driver = strtolower(trim(config('services.ai_driver', 'api-gemini')));

        Log::debug("[ResumeAnalysis] Resolved AI provider: {$driver}");

        return match ($driver) {
            'api-gemini' => new GeminiProvider,
            'api-qwen' => new QwenProvider,
            'local-agent' => new LocalAgentProvider,
            default => throw new \InvalidArgumentException(
                "Unsupported USE_AI driver: [{$driver}]. Allowed values: api-gemini, api-qwen, local-agent"
            ),
        };
    }

    private function providerName(): string
    {
        return class_basename($this->provider);
    }

    // -------------------------------------------------------------------------
    //  PDF EXTRACTION
    // -------------------------------------------------------------------------

    private function extractTextFromPdf(string $file_path): string
    {
        $absolutePath = Storage::disk('public')->path($file_path);

        if (! file_exists($absolutePath)) {
            throw new \Exception("PDF file not found at path: {$absolutePath}");
        }

        Log::debug('[ResumeAnalysis] Extracting text from PDF.', ['path' => $absolutePath]);

        return Pdf::getText($absolutePath);
    }
}

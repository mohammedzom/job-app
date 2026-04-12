<?php

namespace App\Providers\ResumeAnalysis\Providers;

use App\Providers\ResumeAnalysis\Contracts\ResumeAnalysisProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * LocalAgentProvider — calls a self-hosted LLM endpoint (e.g. Ollama, LM Studio, vLLM).
 *
 * Configure in .env:
 *   LOCAL_AGENT_URL=http://localhost:11434/v1/chat/completions
 *   LOCAL_AGENT_EXTRACT_MODEL=llama3.2
 *   LOCAL_AGENT_ANALYZE_MODEL=llama3.2
 */
class LocalAgentProvider implements ResumeAnalysisProvider
{
    private string $baseUrl;

    private string $extractModel;

    private string $analyzeModel;

    public function __construct()
    {
        $this->baseUrl = config('services.local_agent.url', 'http://localhost:11434/v1/chat/completions');
        $this->extractModel = config('services.local_agent.extract_model', 'llama3.2');
        $this->analyzeModel = config('services.local_agent.analyze_model', 'llama3.2');

        if (empty($this->baseUrl)) {
            throw new \RuntimeException('LOCAL_AGENT_URL is not configured in services.local_agent.url');
        }
    }

    // -------------------------------------------------------------------------
    //  INTERFACE IMPLEMENTATION
    // -------------------------------------------------------------------------

    public function extract(string $rawText): array
    {
        // TODO: implement local model extraction
        // The local agent follows the same OpenAI-compatible API as Qwen.
        // You can copy QwenProvider logic here and point it at $this->baseUrl.

        Log::warning('[ResumeAnalysis][LocalAgent] extract() is not yet implemented. Returning empty result.');

        return [
            'summary' => '',
            'skills' => [],
            'experience' => [],
            'education' => [],
            'projects' => [],
            'other' => new \stdClass,
        ];
    }

    public function analyze(object $jobVacancy, array $resumeData): array
    {
        // TODO: implement local model analysis

        Log::warning('[ResumeAnalysis][LocalAgent] analyze() is not yet implemented. Returning empty result.');

        return [
            'ai_generated_score' => 0,
            'ai_generated_feedback' => '',
        ];
    }
}

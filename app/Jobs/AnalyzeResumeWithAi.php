<?php

namespace App\Jobs;

use App\Models\Resumes;
use App\Services\ResumeAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeResumeWithAi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $resume;

    public $timeout = 120;

    public $tries = 3;

    public $maxExceptions = 3;

    public function __construct(Resumes $resume)
    {
        $this->resume = $resume;
    }

    public function handle(ResumeAnalysisService $resumeAnalysisService): void
    {
        $ai_data = $resumeAnalysisService->extractResumeInfo($this->resume->file_url);

        $this->resume->update([
            'summary' => $ai_data['summary'],
            'skills' => $ai_data['skills'],
            'experience' => $ai_data['experience'],
            'education' => $ai_data['education'],
            'projects' => $ai_data['projects'],
            'other' => $ai_data['other'],
            'status' => $ai_data['status'],
        ]);
    }
}

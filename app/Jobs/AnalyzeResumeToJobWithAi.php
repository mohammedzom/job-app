<?php

namespace App\Jobs;

use App\Models\JobApplications;
use App\Models\JobVacancies;
use App\Models\Resumes;
use App\Services\ResumeAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeResumeToJobWithAi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $application;

    public $resume;

    public $jobVacancy;

    public $timeout = 120;

    public function __construct(JobApplications $application, Resumes $resume, JobVacancies $jobVacancy)
    {
        $this->application = $application;
        $this->resume = $resume;
        $this->jobVacancy = $jobVacancy;
    }

    public function handle(ResumeAnalysisService $resumeAnalysisService): void
    {
        $resumeData = [
            'summary' => $this->resume->summary,
            'skills' => $this->resume->skills,
            'experience' => $this->resume->experience,
            'education' => $this->resume->education,
        ];

        $ai_data = $resumeAnalysisService->analyzeResume($this->jobVacancy, $resumeData);
        Log::debug('AI Analysis Completed for Application ID: '.$this->application->id);

        $this->application->update([
            'ai_generated_score' => $ai_data['ai_generated_score'],
            'ai_generated_feedback' => $ai_data['ai_generated_feedback'],
            'status' => 'pending',
        ]);
    }
}

<?php

namespace App\Providers\ResumeAnalysis\Contracts;

interface ResumeAnalysisProvider
{
    /**
     * Extract structured resume data from raw PDF text.
     *
     * @return array{summary: string, skills: list<string>, experience: list<array>,
     *               education: list<array>, projects: list<array>,
     *               other: array<string, list<string>>}
     */
    public function extract(string $rawText): array;

    /**
     * Analyze a resume against a job vacancy and return a score + feedback.
     *
     * @return array{ai_generated_score: int, ai_generated_feedback: string}
     */
    public function analyze(object $jobVacancy, array $resumeData): array;
}

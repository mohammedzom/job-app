<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplication\JobApplicationCreateRequest;
use App\Jobs\AnalyzeResumeToJobWithAi;
use App\Jobs\AnalyzeResumeWithAi;
use App\Models\JobApplications;
use App\Models\JobVacancies;
use App\Models\Resumes;
use App\Services\ResumeAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class JobApplicationsController extends Controller
{
    protected $resumeAnalysisService;

    public function __construct(ResumeAnalysisService $resumeAnalysisService)
    {
        $this->resumeAnalysisService = $resumeAnalysisService;
    }

    public function index(Request $request)
    {
        $query = JobApplications::with('resume', 'job')->where('user_id', Auth::id())->whereHas('job');

        if ($request->has('archived') && $request->archived == 'true') {
            $query->onlyTrashed();
        } else {
            $query->withoutTrashed();
        }

        $jobApplications = $query->latest()->paginate(10)->withQueryString();

        return view('job-applications.index', compact('jobApplications'));
    }

    public function store(JobApplicationCreateRequest $request)
    {
        $id = $request->job_id;
        $jobVacancy = JobVacancies::findOrFail($id);
        $resume_id = null;
        $extracted_data = null;
        if ($request->resume_option == 'new_resume') {
            if ($request->hasFile('resume_file')) {
                $file = $request->file('resume_file');
                $fileOriginalName = explode('.', $file->getClientOriginalName())[0];
                $extension = $file->getClientOriginalExtension();
                if ($extension == 'pdf') {
                    $fileName = 'resume_'.$fileOriginalName.'_'.time().'.'.$extension;
                    $path = $file->storeAs('resumes', $fileName, 'public');
                    Log::debug('File uploaded successfully: '.$path);
                } else {
                    return redirect()->back()->with('error', 'Please upload a PDF file.');
                }
            } else {
                return redirect()->back()->with('error', 'Please upload a resume.');
            }

            $resume = Resumes::create([
                'user_id' => Auth::id(),
                'file_name' => $fileOriginalName,
                'file_url' => $path,
                'contact_details' => json_encode([
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ]),
                'summary' => '',
                'skills' => [],
                'experience' => [],
                'education' => [],
            ]);
            $needExtractData = true;
            $resume_id = $resume->id;
        } else {
            $resume = Resumes::where('user_id', Auth::id())->where('id', $request->resume_option)->first();
            if (! $resume) {
                return redirect()->back()->with('error', 'Resume not found.');
            }
            $needExtractData = false;
            $resume_id = $resume->id;
        }

        $jobVacancy->increment('apply_count');
        $jobApplication = JobApplications::create([
            'job_id' => $id,
            'resume_id' => $resume_id,
            'user_id' => Auth::id(),
            'ai_generated_score' => 0,
            'ai_generated_feedback' => 'Analyzing...',
            'status' => 'pending',
        ]);
        if ($needExtractData) {
            Bus::chain([
                new AnalyzeResumeWithAi($resume),
                new AnalyzeResumeToJobWithAi($jobApplication, $resume, $jobVacancy),
            ])->dispatch();
        } else {
            AnalyzeResumeToJobWithAi::dispatch($jobApplication, $resume, $jobVacancy);
        }

        return redirect()->route('job-applications.index')->with('success', 'Job application created successfully.');

    }

    public function show(string $id)
    {
        $jobApplication = JobApplications::with('resume', 'job')->where('user_id', Auth::id())->findOrFail($id);

        return view('job-applications.show', compact('jobApplication'));
    }

    public function destroy(string $id)
    {
        $jobApplication = JobApplications::where('user_id', Auth::id())->findOrFail($id);
        $jobApplication->job->decrement('apply_count');
        $jobApplication->delete();

        return redirect()->route('job-applications.index')->with('success', 'Job application archived successfully.');
    }

    public function restore(string $id)
    {
        $jobApplication = JobApplications::onlyTrashed()->where('user_id', Auth::id())->findOrFail($id);
        $jobApplication->restore();
        $jobApplication->job->increment('apply_count');

        return redirect()->route('job-applications.index', ['archived' => 'true'])->with('success', 'Job application restored successfully.');
    }
}

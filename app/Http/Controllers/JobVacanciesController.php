<?php

namespace App\Http\Controllers;

use App\Models\JobUserViews;
use App\Models\JobVacancies;
use Illuminate\Support\Facades\Auth;

class JobVacanciesController extends Controller
{
    public function show($id)
    {
        $jobVacancy = JobVacancies::with('company')->findOrFail($id);

        if (Auth::user()->role == 'job_seeker') {
            $viewRecord = JobUserViews::firstOrCreate([
                'job_id' => $jobVacancy->id,
                'user_id' => Auth::id(),
            ]);

            if ($viewRecord->wasRecentlyCreated) {
                $jobVacancy->increment('view_count');
            }
        }

        return view('job-vacancies.show', compact('jobVacancy'));
    }

    public function apply($id)
    {
        $user = Auth::user();
        $jobVacancy = JobVacancies::with('company')->findOrFail($id);
        $resumes = $user->resumes;
        $job_id = $id;

        return view('job-vacancies.apply', compact('jobVacancy', 'resumes', 'job_id'));
    }
}

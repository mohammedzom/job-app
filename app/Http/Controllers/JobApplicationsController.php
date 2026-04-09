<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplication\JobApplicationCreateRequest;
use App\Models\JobApplications;
use App\Models\Resumes;
use Gemini;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationsController extends Controller
{
    public function index()
    {
        $jobApplications = JobApplications::where('user_id', Auth::id())->get();

        return view('job-applications.index', compact('jobApplications'));
    }

    public function store(JobApplicationCreateRequest $request)
    {
        $id = $request->job_id;
        if ($request->hasFile('resume_file')) {
            $file = $request->file('resume_file');
            $fileOriginalName = explode('.', $file->getClientOriginalName())[0];
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'pdf') {
                $fileName = 'resume_'.$fileOriginalName.'_'.time().'.'.$extension;
                $path = $file->storeAs('resumes', $fileName, 'public');
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
            'skills' => '',
            'experience' => '',
            'education' => '',
        ]);

        $jobApplication = JobApplications::create([
            'job_id' => $id,
            'resume_id' => $resume->id,
            'user_id' => Auth::id(),
            'ai_generated_score' => 0,
            'ai_generated_feedback' => '',
            'status' => 'pending',
        ]);

        return redirect()->route('job-applications.index')->with('success', 'Job application created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function GetAidetails($path): array
    {

        $apiKey = env('GEMINI_API_KEY');
        $client = Gemini::client($apiKey);

        $pdfContent = file_get_contents(storage_path('app/public/'.$path));
        $model = $client->generativeModel('gemini-3-flash-preview');
        $prompt = "You are a HR Manager. I need extract summry,skills,experience,education and contact details and i need score between 0 to 100 and feedback from the resume i need response in json format:
        $pdfContent
        ";
        $result = $model->generateContent($prompt);

        return json_decode($result->text(), true);
    }
}

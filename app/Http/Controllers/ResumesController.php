<?php

namespace App\Http\Controllers;

use App\Http\Requests\Resume\ResumeCreateRequest;
use App\Jobs\AnalyzeResumeWithAi;
use App\Models\Resumes;
use Illuminate\Support\Facades\Auth;

class ResumesController extends Controller
{
    public function index()
    {
        $resumes = Auth::user()->resumes()->whereNull('deleted_at')->get();

        return view('resumes.index', compact('resumes'));
    }

    public function show($id)
    {
        $resume = Resumes::where('user_id', Auth::id())->findOrFail($id);

        return view('resumes.show', compact('resume'));
    }

    public function create()
    {
        return view('resumes.create');
    }

    public function store(ResumeCreateRequest $request)
    {
        $file = $request->file('resume');
        $fileOriginalName = explode('.', $file->getClientOriginalName())[0];
        $extension = $file->getClientOriginalExtension();
        if ($extension == 'pdf') {
            $fileName = 'resume_'.$fileOriginalName.'_'.time().'.'.$extension;
            $path = $file->storeAs('resumes', $fileName, 'public');
        } else {
            return redirect()->back()->with('error', 'Please upload a PDF file.');
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
            'projects' => [],
            'other' => [],
            'status' => 'pending',
        ]);
        AnalyzeResumeWithAi::dispatch($resume);

        return redirect()->route('resumes.index')->with('success', 'Resume created successfully.');
    }

    public function destroy($id)
    {
        $resume = Resumes::where('user_id', Auth::id())->findOrFail($id);
        $resume->delete();

        return redirect()->route('resumes.index')->with('success', 'Resume deleted successfully.');
    }
}

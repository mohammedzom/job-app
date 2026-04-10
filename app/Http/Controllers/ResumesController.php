<?php

namespace App\Http\Controllers;

use App\Models\Resumes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumesController extends Controller
{
    public function index()
    {
        $resumes = Auth::user()->resumes;

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

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf',
        ]);

        $file = $request->file('file');
        $fileName = 'resume_'.time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('resumes', $fileName, 'public');

        $resume = Resumes::create([
            'user_id' => Auth::id(),
            'file_name' => $fileName,
            'file_url' => $path,
        ]);

        return redirect()->route('resumes.index')->with('success', 'Resume created successfully.');
    }

    public function destroy($id)
    {
        $resume = Resumes::where('user_id', Auth::id())->findOrFail($id);
        $resume->delete();

        return redirect()->route('resumes.index')->with('success', 'Resume deleted successfully.');
    }
}

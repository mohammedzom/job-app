<?php

namespace App\Http\Requests\JobApplication;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resume_id' => 'required|exists:resumes,id',
            'file' => 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'resume_id.required' => 'Please select a resume.',
            'resume_id.exists' => 'The selected resume does not exist.',
            'file.required' => 'Please upload a resume.',
            'file.file' => 'The file must be a file.',
            'file.mimes' => 'The file must be a PDF.',
            'file.max' => 'The file must be less than 2MB.',
        ];
    }
}

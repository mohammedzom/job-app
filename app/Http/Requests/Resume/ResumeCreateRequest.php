<?php

namespace App\Http\Requests\Resume;

use Illuminate\Foundation\Http\FormRequest;

class ResumeCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resume' => 'required|file|mimes:pdf|max:5120|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'resume.required' => 'Please upload a resume.',
            'resume.file' => 'Please upload a valid file.',
            'resume.mimes' => 'Please upload a PDF file.',
            'resume.max' => 'Please upload a file smaller than 5MB.',
            'resume.min' => 'Please upload a file larger than 1KB.',
        ];
    }
}

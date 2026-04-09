<?php

namespace App\Http\Requests\JobApplication;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resume_file' => 'required|file|mimes:pdf|max:5120',
            'job_id' => 'required|exists:job_vacancies,id',
        ];
    }

    public function messages(): array
    {
        return [
            'resume_file.required' => 'Please upload a resume.',
            'resume_file.file' => 'The file must be a file.',
            'resume_file.mimes' => 'The file must be a PDF.',
            'resume_file.max' => 'The file must be less than 5MB.',
            'job_id.required' => 'Please select a job.',
            'job_id.exists' => 'The selected job does not exist.',
        ];
    }
}

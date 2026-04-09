<?php

namespace App\Http\Requests\JobApplication;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'resume_option' => 'required|string',
            'resume_file' => 'required_if:resume_option,new_resume|file|mimes:pdf|max:5120|min:1',
            'job_id' => 'required|exists:job_vacancies,id',
        ];
    }

    public function messages(): array
    {
        return [
            'resume_option.required' => 'Please select a resume.',
            'resume_option.string' => 'Please select a valid resume.',
            'resume_file.required_if' => 'Please upload a resume.',
            'resume_file.file' => 'The file must be a file.',
            'resume_file.mimes' => 'The file must be a PDF.',
            'resume_file.max' => 'The file must be less than 5MB.',
            'resume_file.min' => 'The file must be at least 1KB.',
            'job_id.required' => 'Please select a job.',
            'job_id.exists' => 'The selected job does not exist.',
        ];
    }
}

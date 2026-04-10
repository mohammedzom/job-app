<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationsController;
use App\Http\Controllers\JobVacanciesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
});

Route::middleware(['auth', 'checkrole:admin,job_seeker'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('job-applications', JobApplicationsController::class)->names('job-applications')->except(['edit', 'update']);

    Route::put('job-applications/{id}/restore', [JobApplicationsController::class, 'restore'])->name('job-applications.restore');

    Route::get('job-vacancies/{id}', [JobVacanciesController::class, 'show'])->name('job-vacancies.show');
    Route::get('job-vacancies/{id}/apply', [JobVacanciesController::class, 'apply'])->name('job-vacancies.apply');

    Route::post('job-vacancies/{id}/apply', [JobApplicationsController::class, 'store'])->name('applications.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

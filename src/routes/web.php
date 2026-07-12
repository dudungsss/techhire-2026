<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use App\Models\Job;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Auth;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('auth.social.redirect');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('auth.social.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');

Route::view('/jobs', 'pages.jobs.index')->name('jobs.index');

Route::get('/jobs/{job:slug}', function (Job $job) {
    abort_unless($job->is_published, 404);

    $job->load(['company', 'category', 'skills']);

    $matchScore = null;
    $matchedSkills = collect();
    $missingSkills = collect();

    if (Auth::check() && Auth::user()->hasRole('pelamar')) {
        $user = Auth::user()->load('skills');
        $jobSkillIds = $job->skills->pluck('id');
        $userSkillIds = $user->skills->pluck('id');

        $matchedSkills = $job->skills->whereIn('id', $userSkillIds);
        $missingSkills = $job->skills->reject(fn ($s) => $userSkillIds->contains($s->id));

        if ($jobSkillIds->isNotEmpty()) {
            $matchCount = $userSkillIds->intersect($jobSkillIds)->count();
            $matchScore = (int) round(($matchCount / $jobSkillIds->count()) * 100);
        }
    }

    return view('pages.jobs.show', [
        'job' => $job,
        'matchScore' => $matchScore,
        'matchedSkills' => $matchedSkills,
        'missingSkills' => $missingSkills,
    ]);
})->name('jobs.show');

/*
|--------------------------------------------------------------------------
| Applicant Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pelamar'])
    ->prefix('applicant')
    ->name('applicant.')
    ->group(function () {
        Route::view('/dashboard', 'pages.applicant.dashboard')->name('dashboard');

        Route::view('/profile', 'pages.applicant.profile')->name('profile');

        Route::view('/applications', 'pages.applicant.applications')->name('applications.index');

        Route::view('/bookmarks', 'pages.applicant.bookmarks')->name('bookmarks');
    });

/*
|--------------------------------------------------------------------------
| Recruiter Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:recruiter', 'recruiter_verified'])
    ->prefix('recruiter')
    ->name('recruiter.')
    ->group(function () {
        Route::view('/dashboard', 'pages.recruiter.dashboard')->name('dashboard');

        Route::view('/company', 'pages.recruiter.company')->name('company');

        Route::view('/applications', 'pages.recruiter.applications')->name('applications');

        Route::view('/jobs', 'pages.recruiter.jobs.index')->name('jobs.index');

        Route::view('/jobs/create', 'pages.recruiter.jobs.form')->name('jobs.create');

        Route::get('/jobs/{job}/edit', function (Job $job) {
            abort_unless($job->company->user_id === Auth::id(), 403);

            return view('pages.recruiter.jobs.form', [
                'job' => $job,
            ]);
        })->name('jobs.edit');
    });


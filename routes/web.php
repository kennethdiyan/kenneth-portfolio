<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PersonalInfoController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\ContactInfoController;
use App\Http\Controllers\Admin\SocialLinkController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');

Route::get('/home', [AdminController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Personal Info Management
    Route::resource('personal-info', PersonalInfoController::class);

    // Skills Management
    Route::resource('skills', SkillController::class);

    // Projects Management
    Route::resource('projects', ProjectController::class);

    // Experience Management
    Route::resource('experiences', ExperienceController::class);

    // Education Management
    Route::resource('educations', EducationController::class);

    // Certifications Management
    Route::resource('certifications', CertificationController::class);

    // Contact Info Management
    Route::resource('contact-info', ContactInfoController::class);

    // Social Links Management
    Route::resource('social-links', SocialLinkController::class);
});

require __DIR__.'/auth.php';

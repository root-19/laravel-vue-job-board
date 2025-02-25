<?php



use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\JobPostingController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Grouped Routes with Authentication Middleware
Route::middleware(['auth'])->group(function () {
    
    // General dashboard route (Redirects to role-based dashboards)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Dashboard
    Route::get('/Admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard')->middleware('auth');
   
    //employer
 
    Route::get('/employer/dashboard', function () {
        return Inertia::render('Employer/dashboard');
    })->name('employer.dashboard')->middleware('auth');
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/employer/job-postings', [JobPostingController::class, 'index'])->name('employer.job_postings');
        Route::get('/employer/job-postings/create', [JobPostingController::class, 'create'])->name('employer.job_postings.create');
        Route::post('/employer/job-postings', [JobPostingController::class, 'store'])->name('employer.job_postings.store');
    });
    Route::middleware(['auth'])->group(function () {
        Route::resource('job_postings', JobPostingController::class);
    });

    // Job Seeker Dashboard
    Route::get('/job_seeker/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('job_seeker.dashboard')->middleware('auth');
    Route::get('/dashboard', [JobPostingController::class, 'allJobs'])->name('dashboard');
    
  

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';

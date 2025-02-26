<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\EmployerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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
    
    // ✅ Employer Route (Fix)
    Route::get('/employer/home', [EmployerController::class, 'index'])->name('employer.home'); 

    // ✅ Admin Dashboard
    Route::get('/Admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');
    //  // ✅ Job Seeker Dashboard
    //  Route::get('/Employer/home', function () {
    //     return Inertia::render('employer/home');
    // })->name('employer.homze');
    Route::get('/home', function () {
        return redirect('/employer/home');
    })->name('home');

    // ✅ Job Posting Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/employer/job-postings', [JobPostingController::class, 'index'])->name('employer.job_postings');
        Route::get('/employer/job-postings/create', [JobPostingController::class, 'create'])->name('employer.job_postings.create');
        Route::post('/employer/job-postings', [JobPostingController::class, 'store'])->name('employer.job_postings.store');
    });
    // Route::middleware(['auth'])->group(function () {
    //     Route::get('/jobs', [JobPostingController::class, 'index']);
    //     Route::post('/jobs', [JobPostingController::class, 'store']);
    // });

    Route::resource('job_postings', JobPostingController::class);

    // ✅ Job Seeker Dashboard
    Route::get('/job_seeker/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('job_seeker.dashboard');

    Route::get('/dashboard', [JobPostingController::class, 'allJobs'])->name('dashboard');
  
    // ✅ Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/employer', [ProfileController::class, 'editEmployer'])->name('employer.edit');
    Route::patch('/employer', [ProfileController::class, 'updateemployer'])->name('employer.update');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// Route::middleware(['auth', 'verified'])->get('/profile', function () {
//     return Inertia::render('Profile', [
//         'user' => Auth::user(), // Ensure this passes the correct role
//     ]);
// })->name('profile');


require __DIR__.'/auth.php';

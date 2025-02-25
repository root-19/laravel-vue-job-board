<?php



use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobPostingController;
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

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    // General Dashboard Route (Redirects to role-based dashboards)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Dashboard
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    // Employer Routes
    Route::prefix('employer')->name('employer.')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Employer/Dashboard');
        })->name('dashboard');

        Route::get('/job-postings', [JobPostingController::class, 'index'])->name('job_postings');
        Route::get('/job-postings/create', [JobPostingController::class, 'create'])->name('job_postings.create');
        Route::post('/job-postings', [JobPostingController::class, 'store'])->name('job_postings.store');
    });

    // Job Seeker Dashboard - Displays All Job Postings
    Route::get('/job_seeker/dashboard', [JobPostingController::class, 'allJobs'])->name('job_seeker.dashboard');

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';

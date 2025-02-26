<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Redirect based on role
        $user = Auth::user();
        return redirect()->intended($this->redirectBasedOnRole($user));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user(); // Store the user before logout
    
        Auth::guard('web')->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect based on the previous role before logout
        return redirect()->intended($user ? $this->redirectBasedOnRole($user) : '/');
    }
    

    /**
     * Determine redirection based on user role.
     */

     protected function redirectBasedOnRole($user)
{
    return match ($user->role) {
        'admin' => route('admin.dashboard'),
        'employer' => route('employer.home'),
        'job_seeker' => route('job_seeker.dashboard'),
        default => route('dashboard'),
    };
}

     
     
}

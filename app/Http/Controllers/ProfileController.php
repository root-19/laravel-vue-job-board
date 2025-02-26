<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;



class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function edit(Request $request): Response
    {
        $user = $request->user();
    
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => [
                'name' => $user->name,
                'role' => $user->role,
                'profile_image' => $user->profile_image ? asset('storage/' . $user->profile_image) : null,
                'cover_image' => $user->cover_image ? asset('storage/' . $user->cover_image) : null,
            ],
        ]);
    }
    
    public function editEmployer(Request $request): Response
    {
        $user = $request->user();
    
        return Inertia::render('Employer.edit', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => [
                'name' => $user->name,
                'role' => $user->role,
                'profile_image' => $user->profile_image ? asset('storage/' . $user->profile_image) : null,
                'cover_image' => $user->cover_image ? asset('storage/' . $user->cover_image) : null,
            ],
        ]);
    }
    
    /**
     * Update the user's profile images.
     */
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id()); // Ensure user is an Eloquent model
    
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $updateData = [];
    
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $updateData['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }
    
        if ($request->hasFile('cover_image')) {
            if ($user->cover_image) {
                Storage::disk('public')->delete($user->cover_image);
            }
            $updateData['cover_image'] = $request->file('cover_image')->store('profile_images', 'public');
        }
    
      
    
        if (!empty($updateData)) {
            $user->update($updateData);
        }
    
        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    public function updateEmployer(Request $request)
    {
        $user = User::findOrFail(Auth::id()); // Ensure user is an Eloquent model
    
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $updateData = [];
    
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $updateData['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }
    
        if ($request->hasFile('cover_image')) {
            if ($user->cover_image) {
                Storage::disk('public')->delete($user->cover_image);
            }
            $updateData['cover_image'] = $request->file('cover_image')->store('profile_images', 'public');
        }
    
      
    
        if (!empty($updateData)) {
            $user->update($updateData);
        }
    
        return Redirect::route('employer.edit')->with('success', 'Profile updated successfully!');
    }
}    
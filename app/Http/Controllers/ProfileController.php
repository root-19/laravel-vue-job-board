<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

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

    /**
     * Update the user's profile images.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate inputs
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $updateData = [];

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $profilePath = $request->file('profile_image')->store('profile_images', 'public');
            $updateData['profile_image'] = $profilePath;
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            if ($user->cover_image) {
                Storage::disk('public')->delete($user->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('profile_images', 'public');
            $updateData['cover_image'] = $coverPath;
        }

        // Debugging: Log the update data
        \Log::info('Profile Update Data:', $updateData);

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}

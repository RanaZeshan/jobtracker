<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Team members cannot update their name or email
        if ($user->role === 'team') {
            // Only allow password updates for team members
            // Name and email changes are restricted
            return Redirect::route('profile.edit')->with('error', 'Team members cannot update their name or email. Please contact your administrator.');
        }
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Team members cannot delete their own accounts
        if ($request->user()->role === 'team') {
            return Redirect::route('profile.edit')->with('error', 'Team members cannot delete their own accounts. Please contact your administrator.');
        }
        
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's profile picture.
     */
    public function updatePicture(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // 2MB max
        ]);

        $user = $request->user();

        // Delete old profile picture if exists
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Process and resize the image
        $image = Image::read($request->file('profile_picture'));
        
        // Resize to 300x300 pixels (standard size)
        $image->cover(300, 300);
        
        // Generate unique filename
        $filename = 'profile-' . $user->id . '-' . time() . '.jpg';
        $path = 'profile-pictures/' . $filename;
        
        // Save the resized image
        Storage::disk('public')->put($path, $image->toJpeg(85)); // 85% quality

        // Update user record
        $user->profile_picture = $path;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'picture-updated');
    }

    /**
     * Remove the user's profile picture.
     */
    public function destroyPicture(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_picture) {
            // Delete the file from storage
            Storage::disk('public')->delete($user->profile_picture);

            // Update user record
            $user->profile_picture = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'picture-removed');
    }
}

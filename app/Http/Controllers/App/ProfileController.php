<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = User::find(auth()->user()->id);

        return view('app.profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {


        // Get the authenticated user or the user being updated
        $user = $request->user();

        // If updating another user (admin case), find that user
        if ($request->has('id') && auth()->user()->hasRole('admin')) {
            $user = User::findOrFail($request->id);
        }

        // Handle profile picture upload
        $profilePicPath = $user->profile_pic; // Keep existing if not changed
        if ($request->hasFile('profile_pic')) {
            // Delete old profile picture if exists
            if ($user->profile_pic) {
                Storage::disk('website')->delete($user->profile_pic);
            }

            $profilePicPath = $request->file('profile_pic')
                ->store("tenants/admin/profile_pics", 'website');
        }

        // Prepare update data
        $updateData = [
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'gender'      => $request->gender,
            'dob'         => $request->dob,
            'profile_pic' => $profilePicPath,
        ];

        // Handle password change if provided
        if ($request->filled('current_password') && $request->filled('password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            // Update password
            $updateData['password'] = $request->password;
        }

        // Update user data
        $user->update($updateData);

        // Sync roles if provided (admin only)
        if ($request->user()->hasRole('admin') && $request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        // Handle email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('dashboard')
            ->with('status', 'Profile updated successfully')
            ->with('status-type', 'success');


        // // Get the authenticated user or the user being updated
        // $user = $request->user();

        // // If admin is updating another user's profile
        // if ($request->has('id') && auth()->user()->hasRole('admin')) {
        //     $user = User::findOrFail($request->id);
        // }

        // // Handle profile picture upload
        // $profilePicPath = $user->profile_pic; // Keep existing if not updated
        // if ($request->hasFile('profile_pic')) {
        //     // Delete old profile picture if exists
        //     if ($user->profile_pic) {
        //         Storage::disk('website')->delete($user->profile_pic);
        //     }

        //     $profilePicPath = $request->file('profile_pic')
        //         ->store("tenants/admin/profile_pics", 'website');
        // }

        // // Prepare update data
        // $updateData = [
        //     'name'        => $request->name,
        //     'email'       => $request->email,
        //     'profile_pic' => $profilePicPath,
        //     'phone'       => $request->phone,
        //     'address'     => $request->address,
        //     'gender'      => $request->gender,
        //     'dob'         => $request->dob,
        // ];

        // // Only update password if provided
        // if ($request->filled('password')) {
        //     $updateData['password'] = $request->password;
        // }

        // // Handle email verification if email changed
        // // if ($user->isDirty('email')) {
        // //     $user->email_verified_at = null;
        // //     // You might want to send verification email here
        // // }
        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // // Update user
        // $user->update($updateData);

        // // Sync roles if provided (only for admins)
        // if ($request->has('roles') && auth()->user()->hasRole('admin')) {
        //     $user->syncRoles($request->roles);
        // }



        // return redirect()->route('dashboard')
        //     ->with('status', 'Profile updated successfully')
        //     ->with('status-type', 'success');

        // $request->user()->fill($request->validated());

        // if ($request->user()->isDirty('email')) {
        //     $request->user()->email_verified_at = null;
        // }

        // $request->user()->save();

        return Redirect::route('dashboard')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
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
}

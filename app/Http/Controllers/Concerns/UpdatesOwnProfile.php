<?php

namespace App\Http\Controllers\Concerns;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

trait UpdatesOwnProfile
{
    protected function updateOwnProfile(
        ProfileUpdateRequest $request,
        string $redirectRoute,
        string $profilePicFolder,
        bool $allowRoleSync = false,
    ): RedirectResponse {
        $user = $request->user();

        $profilePicPath = $user->profile_pic;
        if ($request->hasFile('profile_pic')) {
            if ($user->profile_pic) {
                Storage::disk('website')->delete($user->profile_pic);
            }

            $profilePicPath = $request->file('profile_pic')->store($profilePicFolder, 'website');
        }

        $updateData = [
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'gender'      => $request->gender,
            'dob'         => $request->dob,
            'profile_pic' => $profilePicPath,
        ];

        if ($request->filled('current_password') && $request->filled('password')) {
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            $updateData['password'] = $request->password;
        }

        $user->update($updateData);

        if ($allowRoleSync && $request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        if ($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route($redirectRoute)
            ->with('status', 'Profile updated successfully')
            ->with('status-type', 'success');
    }

    protected function profileEditView(string $view, bool $withRoles = false)
    {
        $user = User::find(auth()->id());
        $roles = $withRoles ? \Spatie\Permission\Models\Role::orderBy('name')->get() : collect();

        return view($view, compact('user', 'roles'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\UpdatesOwnProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use UpdatesOwnProfile;

    public function edit(): View
    {
        return $this->profileEditView('app.admin.profile.edit', withRoles: true);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        return $this->updateOwnProfile(
            $request,
            'admin.profile.edit',
            'tenants/admin/profile_pics',
            allowRoleSync: auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'),
        );
    }
}

<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Concerns\UpdatesOwnProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use UpdatesOwnProfile;

    /**
     * Display the authenticated student's own profile.
     */
    public function index(): View
    {
        $student = auth()->user()->load([
            'studentProfile.class',
            'studentProfile.section',
            'parents',
            'branch',
        ]);

        return view('app.student.profile', compact('student'));
    }

    public function edit(): View
    {
        return $this->profileEditView('app.student.profile.edit');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        return $this->updateOwnProfile(
            $request,
            'student.profile.edit',
            'tenants/students/profile',
        );
    }
}

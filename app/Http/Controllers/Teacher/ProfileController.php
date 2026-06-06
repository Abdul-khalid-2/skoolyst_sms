<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Concerns\UpdatesOwnProfile;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use UpdatesOwnProfile;

    /**
     * Display the authenticated teacher's own profile.
     */
    public function index(): View
    {
        $teacher = auth()->user()->load([
            'teacherProfile.classTeacherOf',
            'teacherSubjects',
            'teacherClasses',
            'branch',
        ]);

        return view('app.teacher.profile', compact('teacher'));
    }

    public function edit(): View
    {
        return $this->profileEditView('app.teacher.profile.edit');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        return $this->updateOwnProfile(
            $request,
            'teacher.profile.edit',
            'tenants/teachers/profile_pics',
        );
    }
}

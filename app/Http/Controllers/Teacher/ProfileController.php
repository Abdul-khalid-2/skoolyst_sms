<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
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
}

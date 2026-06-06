<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ProfileController extends Controller
{
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
}

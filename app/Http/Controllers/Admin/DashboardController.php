<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Section;
use App\Models\User;;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {

        
        $numberOfTeachers   = User::role('teacher')->count();
        $numberOfStudent    = User::role('student')->count();
        $section            = Section::sum('capacity');

        return view('app.admin.dashboard', compact('numberOfTeachers', 'numberOfStudent', 'section'));
    }
}

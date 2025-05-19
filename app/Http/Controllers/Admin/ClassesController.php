<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\School;
use App\Models\Section;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ClassesController extends Controller
{
    /**
     * Display a listing of the classes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // Get classes with their class teacher and sections count
        // $classes = Classes::with(['classTeacher', 'sections', 'classStudents'])->orderBy('numeric_value')->get();
        $classes = Classes::with(['classTeachersSubjects.teacher', 'classTeachersSubjects.subject'])->orderBy('numeric_value')->get();

        return view('app.admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new class.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get teachers for dropdown
        $teachers = User::role('teacher')
            ->orderBy('name')
            ->get();

        return view('app.admin.classes.create', compact('teachers'));
    }

    /**
     * Store a newly created class in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_value' => 'required|integer|min:0',
            'teacher_id' => 'nullable|exists:users,id'
        ]);

        $school = School::first();
        $validated['school_id'] = auth()->user()->school_id ?? $school->id;

        $class          = Classes::create($validated);
        $systemSetting  =  SystemSetting::where('setting_key', 'default_class_capacity')->first();
        $capacity       = $systemSetting->setting_value ?? 20;

        Section::create([
            'schoo_id' => auth()->user()->school_id ?? $school->id,
            'class_id' => $class->id,
            'name'     => 'A',
            'capacity' => $capacity,

        ]);

        return redirect()->route('admin.academic.classes.index')
            ->with('success', 'Class created successfully');
    }

    /**
     * Show the form for editing the specified class.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($encodedId)
    {
        $id = Crypt::decrypt($encodedId);
        $class = Classes::findOrFail($id);

        $teachers = User::role('teacher')
            ->orderBy('name')
            ->get();

        return view('app.admin.classes.edit', compact('class', 'teachers'));
    }


    public function show($encodedId)
    {
        $id = Crypt::decrypt($encodedId);
        echo "<h1>Under Construction</h1>";

        // $teachers = User::role('teacher')
        //     ->orderBy('name')
        //     ->get();

        // return view('app.admin.classes.edit', compact('class', 'teachers'));
    }
    /**
     * Update the specified class in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $class = Classes::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_value' => 'required|integer',
            'teacher_id' => 'nullable|exists:users,id'
        ]);

        $class->update($validated);

        return redirect()->route('admin.academic.classes.index')
            ->with('success', 'Class updated successfully');
    }

    /**
     * Remove the specified class from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);

        // Check if class has sections before deleting
        if ($class->sections()->count() > 1) {
            return back()->with('error', 'Cannot delete class with sections');
        }

        $class->delete();
        $class->sections()->delete();

        return redirect()->route('admin.academic.classes.index')
            ->with('success', 'Class deleted successfully');
    }
}

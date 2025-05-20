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
    protected $schoolId;

    public function __construct()
    {
        $this->schoolId = auth()->user()->school_id ?? School::first()->id ?? null;
    }

    private function redirectWithMessage($route, $message, $type = 'success')
    {
        return redirect()->route($route)
            ->with([
                'alert-type' => $type,
                'message' => $message
            ]);
    }

    public function index()
    {
        $classes = Classes::withTrashed()
            ->where('school_id', $this->schoolId)
            ->with(['classTeachersSubjects.teacher' => function ($query) {
                $query->withTrashed();
            }, 'classTeachersSubjects.subject' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('numeric_value')
            ->get();

        return view('app.admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = User::role('teacher')
            ->orderBy('name')
            ->get();

        return view('app.admin.classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_value' => 'required|integer|min:0',
            'teacher_id' => 'nullable|exists:users,id'
        ]);

        $validated['school_id'] = $this->schoolId;

        $class = Classes::create($validated);
        $systemSetting = SystemSetting::where('setting_key', 'default_class_capacity')->first();
        $capacity = $systemSetting->setting_value ?? 20;

        Section::create([
            'school_id' => $this->schoolId, // Fixed typo: schoo_id -> school_id
            'class_id' => $class->id,
            'name' => 'A',
            'capacity' => $capacity,
        ]);

        return $this->redirectWithMessage('admin.academic.classes.index', 'Class created successfully');
    }

    public function edit($encodedId)
    {
        $id = Crypt::decrypt($encodedId);
        $class = Classes::where('school_id', $this->schoolId)->findOrFail($id);

        $teachers = User::role('teacher')
            ->orderBy('name')
            ->get();

        return view('app.admin.classes.edit', compact('class', 'teachers'));
    }

    public function show($encodedId)
    {
        $id = Crypt::decrypt($encodedId);
        $class = Classes::withTrashed()
            ->where('school_id', $this->schoolId)
            ->with(['sections', 'classTeachersSubjects.teacher', 'classTeachersSubjects.subject'])
            ->findOrFail($id);

        return view('app.admin.classes.show', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = Classes::where('school_id', $this->schoolId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_value' => 'required|integer',
            'teacher_id' => 'nullable|exists:users,id'
        ]);

        $class->update($validated);

        return $this->redirectWithMessage('admin.academic.classes.index', 'Class updated successfully');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $class = Classes::where('school_id', $this->schoolId)->findOrFail($id);

        if ($class->sections()->count() > 1) {
            return $this->redirectWithMessage('admin.academic.classes.index', 'Cannot delete class with sections', 'error');
        }

        $class->delete();
        $class->sections()->delete();

        return $this->redirectWithMessage('admin.academic.classes.index', 'Class deleted successfully');
    }

    public function restore($id)
    {
        $class = Classes::withTrashed()
            ->where('school_id', $this->schoolId)
            ->findOrFail(decrypt($id));

        $class->restore();
        $class->sections()->restore();

        return $this->redirectWithMessage('admin.academic.classes.index', 'Class restored successfully');
    }
}

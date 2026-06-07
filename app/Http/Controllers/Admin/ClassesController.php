<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Branch;
use App\Models\Section;
use App\Models\SectionSubjectTeacher;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ClassesController extends Controller
{
    protected $branchId;

    public function __construct()
    {
        $user = auth()->user();
        $this->branchId = $user && $user->hasRole('super-admin') ? null : $user?->branch_id;
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
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->withCount(['sections', 'classStudents'])
            ->orderBy('numeric_value')
            ->get();

        return view('app.admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('app.admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_value' => 'required|integer|min:0',
        ]);

        $validated['branch_id'] = $this->branchId;

        $class = Classes::create($validated);
        $systemSetting = SystemSetting::where('setting_key', 'default_class_capacity')->first();
        $capacity = $systemSetting->setting_value ?? 20;

        Section::create([
            'branch_id' => $this->branchId, // Fixed typo: schoo_id -> school_id
            'class_id' => $class->id,
            'name' => 'A',
            'capacity' => $capacity,
        ]);

        return $this->redirectWithMessage('admin.academic.classes.index', 'Class created successfully');
    }

    public function edit($encodedId)
    {
        $id = Crypt::decrypt($encodedId);
        $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))->findOrFail($id);

        return view('app.admin.classes.edit', compact('class'));
    }

    public function show($encodedId)
    {
        $id = Crypt::decrypt($encodedId);
        $class = Classes::withTrashed()
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with([
                'sections',
                'classTeacher',
                'classTeacherProfiles.teacher',
                'subjects',
            ])
            ->findOrFail($id);

        $sectionIds = $class->sections->pluck('id');
        $allocations = SectionSubjectTeacher::whereIn('section_id', $sectionIds)
            ->with('teacher:id,name,email')
            ->get();

        // [section_id][subject_id] => teacher
        $allocationMap = [];
        foreach ($allocations as $a) {
            if ($a->teacher) {
                $allocationMap[$a->section_id][$a->subject_id] = $a->teacher;
            }
        }

        $sectionCurriculum = [];
        foreach ($class->sections as $section) {
            $rows = [];
            foreach ($class->subjects as $subject) {
                $teacher = $allocationMap[$section->id][$subject->id] ?? null;
                $rows[] = [
                    'subject'  => $subject,
                    'teachers' => $teacher ? collect([$teacher]) : collect(),
                ];
            }
            $sectionCurriculum[$section->id] = $rows;
        }

        return view('app.admin.classes.show', compact('class', 'sectionCurriculum'));
    }

    public function update(Request $request, $id)
    {
        $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_value' => 'required|integer',
        ]);

        $class->update($validated);

        return $this->redirectWithMessage('admin.academic.classes.index', 'Class updated successfully');
    }

    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))->findOrFail($id);

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
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->findOrFail(decrypt($id));

        $class->restore();
        $class->sections()->restore();

        return $this->redirectWithMessage('admin.academic.classes.index', 'Class restored successfully');
    }
}



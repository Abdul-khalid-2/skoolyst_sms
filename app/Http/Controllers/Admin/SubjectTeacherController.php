<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Section;
use App\Models\SectionSubjectTeacher;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectTeacherController extends Controller
{
    protected $branchId;

    public function __construct()
    {
        $user = auth()->user();
        $this->branchId = $user && $user->hasRole('super-admin') ? null : $user?->branch_id;
    }

    /**
     * Show the class/section selector form.
     */
    public function index()
    {
        $classes = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->orderBy('numeric_value')
            ->get();

        return view('app.admin.subjects.assign_section_teacher', compact('classes'));
    }

    /**
     * Branch-scoped sections of a class (AJAX, for the section dropdown).
     */
    public function getSections($classId)
    {
        $sections = Section::where('class_id', $classId)
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->orderBy('name')
            ->pluck('name', 'id');

        return response()->json($sections);
    }

    /**
     * Curriculum subjects of a class with the teachers eligible to teach each
     * (teacher_subjects) and the teacher currently assigned for this section.
     */
    public function getSubjects(Request $request)
    {
        $request->validate([
            'class_id'   => 'required|integer',
            'section_id' => 'required|integer',
        ]);

        $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with('subjects')
            ->findOrFail($request->class_id);

        // Current allocations for this section: subject_id => teacher_id
        $assigned = SectionSubjectTeacher::where('section_id', $request->section_id)
            ->pluck('teacher_id', 'subject_id');

        $subjects = $class->subjects->map(function (Subject $subject) use ($assigned) {
            $teachers = $subject->teachers()
                ->when($this->branchId, fn ($q) => $q->where('users.branch_id', $this->branchId))
                ->orderBy('name')
                ->get(['users.id', 'users.name'])
                ->map(fn ($t) => ['id' => $t->id, 'name' => $t->name])
                ->values();

            return [
                'id'                  => $subject->id,
                'name'                => $subject->name,
                'code'                => $subject->code,
                'teachers'            => $teachers,
                'assigned_teacher_id' => $assigned[$subject->id] ?? null,
            ];
        })->values();

        return response()->json(['subjects' => $subjects]);
    }

    /**
     * Save the teacher assigned to each subject for the chosen section.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id'     => 'required|integer',
            'section_id'   => 'required|integer',
            'teachers'     => 'nullable|array',
            'teachers.*'   => 'nullable|exists:users,id',
        ]);

        // Validate class & section belong to the branch.
        $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with('subjects:id')
            ->findOrFail($data['class_id']);

        Section::where('id', $data['section_id'])
            ->where('class_id', $class->id)
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->firstOrFail();

        $curriculumIds = $class->subjects->pluck('id');

        try {
            DB::beginTransaction();

            foreach ($curriculumIds as $subjectId) {
                $teacherId = $data['teachers'][$subjectId] ?? null;

                if ($teacherId) {
                    SectionSubjectTeacher::updateOrCreate(
                        ['section_id' => $data['section_id'], 'subject_id' => $subjectId],
                        ['class_id' => $class->id, 'teacher_id' => $teacherId]
                    );
                } else {
                    SectionSubjectTeacher::where('section_id', $data['section_id'])
                        ->where('subject_id', $subjectId)
                        ->delete();
                }
            }

            DB::commit();

            return redirect()->route('admin.academic.subjects.section_teacher')
                ->with('success', 'Subject teachers saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error saving subject teachers: ' . $e->getMessage());
        }
    }
}

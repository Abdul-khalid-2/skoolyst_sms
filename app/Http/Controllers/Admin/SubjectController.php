<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use App\Services\Academic\AssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{

    protected $branchId;

    public function __construct()
    {
        $user = auth()->user();
        $this->branchId = $user && $user->hasRole('super-admin') ? null : $user?->branch_id;
    }
    /**
     * Display a listing of the subjects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $subjects = Subject::withCount('classes')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->orderBy('name')
            ->get();

        return view('app.admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new subject.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.admin.subjects.create');
    }

    /**
     * Store a newly created subject in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
        ]);

        $validated['branch_id'] = $this->branchId;

        Subject::updateOrCreate(
            [
                'code'      => $validated['code'],
                'branch_id' => $validated['branch_id'],
            ],
            $validated
        );

        return redirect()->route('admin.academic.subjects.index')
            ->with('success', 'Subject saved successfully');
    }

    /**
     * Show the form for editing the specified subject.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $subject = Subject::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))->findOrFail($id);

        return view('app.admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified subject in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $subject = Subject::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
        ]);

        $subject->update($validated);

        return redirect()->route('admin.academic.subjects.index')
            ->with('success', 'Subject updated successfully');
    }

    /**
     * Remove the specified subject from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $subject = Subject::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->findOrFail($id);

        if ($subject->teachers()->count() > 0) {
            return back()->with('error', 'Cannot delete subject with assigned teachers');
        }

        $subject->delete();

        return redirect()->route('admin.academic.subjects.index')
            ->with('success', 'Subject deleted successfully');
    }

    /**
     * Show the form for assigning teachers to subjects.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign()
    {

        $subjects = Subject::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->orderBy('name')
            ->get();

        $teachers = User::role('teacher')
            ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with(['teacherProfile', 'teacherSubjects'])
            ->orderBy('name')
            ->get();

        $classes = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->with('subjects:id')
            ->orderBy('numeric_value')
            ->get();

        // class_id => [subject ids] — for the "Class Subjects" (curriculum) form
        $classSubjectIds = [];
        foreach ($classes as $class) {
            $classSubjectIds[$class->id] = $class->subjects->pluck('id')->toArray();
        }

        $teacherSubjectIds = [];
        foreach ($teachers as $teacher) {
            $teacherSubjectIds[$teacher->id] = $teacher->teacherSubjects->pluck('id')->toArray();
        }

        $classes->load('classTeacherProfile');
        $classTeachers = [];
        foreach ($classes as $class) {
            $classTeachers[$class->id] = optional($class->classTeacherProfile)->teacher_id;
        }

        return view('app.admin.subjects.assign', compact(
            'subjects',
            'teachers',
            'classes',
            'teacherSubjectIds',
            'classSubjectIds',
            'classTeachers'
        ));
    }

    /**
     * Assign subjects (curriculum) to each class — class_subject pivot.
     */
    public function assignClassSubjectStore(Request $request)
    {
        $request->validate([
            'class_subjects'     => 'required|array',
            'class_subjects.*'   => 'nullable|array',
            'class_subjects.*.*' => 'exists:subjects,id',
        ]);

        try {
            DB::beginTransaction();

            $service = app(AssignmentService::class);

            foreach ($request->class_subjects as $classId => $subjectIds) {
                $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($classId);

                $service->assignClassCurriculum($class, $subjectIds ?? []);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Class subjects updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating class subjects: ' . $e->getMessage());
        }
    }

    /**
     * Assign subjects to each teacher (inverse of the old subject→teachers form).
     */
    public function assignTeacherStore(Request $request)
    {
        $request->validate([
            'teacher_subjects'     => 'required|array',
            'teacher_subjects.*'   => 'nullable|array',
            'teacher_subjects.*.*' => 'exists:subjects,id',
        ]);

        try {
            DB::beginTransaction();

            $service = app(AssignmentService::class);

            foreach ($request->teacher_subjects as $teacherId => $subjectIds) {
                $teacher = User::role('teacher')
                    ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($teacherId);

                $service->assignTeacherCapabilities($teacher, $subjectIds ?? []);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Subject assignments updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating subject assignments: ' . $e->getMessage());
        }
    }

    /**
     * Assign a class (class-teacher role) to each teacher (inverse of the old class→teacher form).
     * Sets teacher_profiles.class_teacher_of via AssignmentService (single source of truth).
     */
    public function assignClassTeacherStore(Request $request)
    {
        $request->validate([
            'class_teacher'   => 'required|array',
            'class_teacher.*' => 'nullable|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            $service = app(AssignmentService::class);

            foreach ($request->class_teacher as $classId => $teacherId) {
                $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($classId);

                if (empty($teacherId)) {
                    $service->assignClassTeacher(null, $class);
                    continue;
                }

                $teacher = User::role('teacher')
                    ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($teacherId);

                $service->assignClassTeacher($teacher, $class);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Class teacher assignments updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating class teacher assignments: ' . $e->getMessage());
        }
    }
}



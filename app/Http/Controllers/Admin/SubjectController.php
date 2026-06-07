<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
use App\Models\TeacherProfile;
use App\Models\User;
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

        $subjects = Subject::with([
            'subjectTeacherClass.teacher',
            'subjectTeacherClass.class',
        ])
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

        $classes  = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))->orderBy('numeric_value')->get();
        $sections = Section::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))->orderBy('name')->get();

        return view('app.admin.subjects.create', compact('classes', 'sections'));
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
            'name'       => 'required|string|max:255',
            'code'       => 'required|string|max:10',
            'class_id'   => 'nullable|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
        ]);

        $validated['branch_id'] = $this->branchId;

        Subject::updateOrCreate(
            [
                'code' => $validated['code'],
                'name' => $validated['name'],
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

        $subject  = Subject::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))->findOrFail($id);
        $classes  = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))->orderBy('numeric_value')->get();
        $sections = $subject->class_id
            ? Section::where('class_id', $subject->class_id)->orderBy('name')->get()
            : collect();

        return view('app.admin.subjects.edit', compact('subject', 'classes', 'sections'));
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
            'name'       => 'required|string|max:255',
            'code'       => 'required|string|max:10',
            'class_id'   => 'nullable|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
        ]);

        // Clear section if class was cleared
        if (empty($validated['class_id'])) {
            $validated['section_id'] = null;
        }

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

        // teacher_id => [subject ids] — for the "Assign Subjects (to teachers)" form
        $teacherSubjectIds = [];
        // teacher_id => class_id — for the "Assign Classes (to teachers)" form
        $teacherClassOf = [];
        foreach ($teachers as $teacher) {
            $teacherSubjectIds[$teacher->id] = $teacher->teacherSubjects->pluck('id')->toArray();
            $teacherClassOf[$teacher->id]    = optional($teacher->teacherProfile)->class_teacher_of;
        }

        // Kept for the read-only summary tabs.
        $subjectAssignments = [];
        foreach ($subjects as $subject) {
            $subjectAssignments[$subject->id] = $subject->teachers()->pluck('users.id')->toArray();
        }

        $classTeachers = [];
        foreach ($classes as $class) {
            $classTeachers[$class->id] = $class->teacher_id;
        }

        return view('app.admin.subjects.assign', compact(
            'subjects',
            'teachers',
            'classes',
            'teacherSubjectIds',
            'teacherClassOf',
            'classSubjectIds',
            'subjectAssignments',
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

            foreach ($request->class_subjects as $classId => $subjectIds) {
                $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($classId);

                $class->subjects()->sync($subjectIds ?? []);
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

            foreach ($request->teacher_subjects as $teacherId => $subjectIds) {
                $teacher = User::role('teacher')
                    ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($teacherId);

                $teacher->teacherSubjects()->sync($subjectIds ?? []);
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
     * Keeps teacher_profiles.class_teacher_of and classes.teacher_id in sync.
     */
    public function assignClassTeacherStore(Request $request)
    {
        $request->validate([
            'teacher_class'   => 'required|array',
            'teacher_class.*' => 'nullable|exists:classes,id',
        ]);

        try {
            DB::beginTransaction();

            // Reset current class-teacher links within the branch, then re-apply from the form.
            Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                ->update(['teacher_id' => null]);
            TeacherProfile::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                ->update(['class_teacher_of' => null, 'is_class_teacher' => false]);

            foreach ($request->teacher_class as $teacherId => $classId) {
                $teacher = User::role('teacher')
                    ->when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($teacherId);

                if (empty($classId)) {
                    continue;
                }

                $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($classId);

                TeacherProfile::where('teacher_id', $teacher->id)
                    ->update(['class_teacher_of' => $class->id, 'is_class_teacher' => true]);

                $class->update(['teacher_id' => $teacher->id]);
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



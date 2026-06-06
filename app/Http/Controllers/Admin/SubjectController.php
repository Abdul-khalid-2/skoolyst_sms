<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Subject;
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
            ->orderBy('name')
            ->get();

        $classes = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
            ->orderBy('numeric_value')
            ->get();

        $subjectAssignments = [];
        foreach ($subjects as $subject) {
            $assignedTeachers = $subject->teachers()->get();
            $subjectAssignments[$subject->id] = $assignedTeachers->pluck('id')->toArray();
        }

        $classTeachers = [];
        foreach ($classes as $class) {
            $classTeachers[$class->id] = $class->teacher_id;
        }

        return view('app.admin.subjects.assign', compact(
            'subjects',
            'teachers',
            'classes',
            'subjectAssignments',
            'classTeachers'
        ));
    }

    public function assignTeacherStore(Request $request)
    {
        $request->validate([
            'subject_assignments' => 'required|array',
            'subject_assignments.*' => 'nullable|array',
            'subject_assignments.*.*' => 'exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->subject_assignments as $subjectId => $teacherIds) {
                $subject = Subject::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($subjectId);
                $subject->teachers()->sync($teacherIds ?? []);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Teacher assignments updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating teacher assignments: ' . $e->getMessage());
        }
    }

    public function assignClassTeacherStore(Request $request)
    {
        $request->validate([
            'class_teachers' => 'required|array',
            'class_teachers.*' => 'nullable|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->class_teachers as $classId => $teacherId) {
                $class = Classes::when($this->branchId, fn ($q) => $q->where('branch_id', $this->branchId))
                    ->findOrFail($classId);
                $class->update(['teacher_id' => $teacherId]);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Class teachers updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating class teachers: ' . $e->getMessage());
        }
    }
}



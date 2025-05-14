<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the subjects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get subjects with their classes and teachers
        $subjects = Subject::with([
            'subjectTeacherClass.teacher',
            'subjectTeacherClass.class',
        ])
            ->where('school_id', auth()->user()->school_id)
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
        $classes = Classes::where('school_id', auth()->user()->school_id)
            ->orderBy('numeric_value')
            ->get();

        return view('app.admin.subjects.create', compact('classes'));
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
            'class_id' => 'nullable|exists:classes,id'
        ]);

        $validated['school_id'] = auth()->user()->school_id ?? 1;

        Subject::create($validated);

        return redirect()->route('admin.academic.subjects.index')
            ->with('success', 'Subject created successfully');
    }

    /**
     * Show the form for editing the specified subject.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        $classes = Classes::where('school_id', auth()->user()->school_id)
            ->orderBy('numeric_value')
            ->get();

        return view('app.admin.classes.edit', compact('subject', 'classes'));
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
        $subject = Subject::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10',
            'class_id' => 'nullable|exists:classes,id'
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
        $subject = Subject::where('school_id', auth()->user()->school_id)
            ->findOrFail($id);

        // Check if subject has teachers assigned before deleting
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
    // public function assign()
    // {
    //     $subjects = Subject::where('school_id', auth()->user()->school_id)
    //         ->orderBy('name')
    //         ->get();

    //     // $classes = Classes::where('school_id', auth()->user()->school_id)
    //     //     ->orderBy('numeric_value')
    //     //     ->get();

    //     $teachers = User::role('teacher')
    //         ->where('school_id', auth()->user()->school_id)
    //         ->orderBy('name')
    //         ->get();

    //     // Get current assignments
    //     // $assignments = [];
    //     // foreach ($subjects as $subject) {
    //     //     // foreach ($classes as $class) {
    //     //     $teacher = $subject->teachers()
    //     //         ->wherePivot('class_id', $class->id)
    //     //         ->first();

    //     //     $assignments[$subject->id] = [
    //     //         'teacher_id' => $teacher ? $teacher->id : null,
    //     //         'is_class_teacher' => $teacher ? $teacher->pivot->is_class_teacher : false
    //     //     ];
    //     //     // }
    //     // }

    //     // dd($assignments);
    //     return view('app.admin.subjects.assign', compact('subjects', 'teachers',));
    // }

    // public function assign()
    // {
    //     $subjects = Subject::where('school_id', auth()->user()->school_id)
    //         ->orderBy('name')
    //         ->get();

    //     $teachers = User::role('teacher')
    //         ->where('school_id', auth()->user()->school_id)
    //         ->orderBy('name')
    //         ->get();

    //     // Get current assignments with all teachers for each subject
    //     $assignments = [];
    //     foreach ($subjects as $subject) {
    //         $assignedTeachers = $subject->teachers()->get();

    //         $assignments[$subject->id] = $assignedTeachers->mapWithKeys(function ($teacher) {
    //             return [
    //                 $teacher->id => [
    //                     'is_class_teacher' => $teacher->pivot->is_class_teacher ?? false
    //                 ]
    //             ];
    //         })->toArray();
    //     }

    //     return view('app.admin.subjects.assign', compact('subjects', 'teachers', 'assignments'));
    // }

    // public function assignTeacherStore(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'assignments' => 'required|array',
    //         'assignments.*' => 'required|array',
    //         'assignments.*.teachers' => 'nullable|array',
    //         'assignments.*.teachers.*' => 'exists:users,id',
    //         'assignments.*.class_teacher_id' => 'nullable|exists:users,id'
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         // Get all subjects in the school
    //         $subjects = Subject::where('school_id', auth()->user()->school_id)->get();

    //         foreach ($request->assignments as $subjectId => $assignmentData) {
    //             $subject = Subject::findOrFail($subjectId);

    //             // Get current assignments for this subject
    //             $currentTeachers = $subject->teachers()
    //                 ->get()
    //                 ->pluck('pivot.is_class_teacher', 'id')
    //                 ->toArray();

    //             // Get new teacher IDs from request
    //             $newTeacherIds = $assignmentData['teachers'] ?? [];
    //             $classTeacherId = $assignmentData['class_teacher_id'] ?? null;

    //             // Prepare sync data
    //             $syncData = [];

    //             foreach ($newTeacherIds as $teacherId) {
    //                 $syncData[$teacherId] = [
    //                     'is_class_teacher' => ($teacherId == $classTeacherId)
    //                 ];
    //             }

    //             // Sync the teachers
    //             $subject->teachers()->sync($syncData);

    //             // If class teacher was removed from assigned teachers but still set as class teacher
    //             if ($classTeacherId && !in_array($classTeacherId, $newTeacherIds)) {
    //                 $subject->teachers()->updateExistingPivot($classTeacherId, [
    //                     'is_class_teacher' => false
    //                 ]);
    //             }
    //         }

    //         DB::commit();

    //         return redirect()->back()
    //             ->with('success', 'Teacher assignments updated successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()
    //             ->with('error', 'Error updating assignments: ' . $e->getMessage());
    //     }
    // }


    public function assign()
    {
        // For Subjects Assignment
        $subjects = Subject::where('school_id', auth()->user()->school_id)
            ->orderBy('name')
            ->get();

        $teachers = User::role('teacher')
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('name')
            ->get();

        // For Classes Assignment
        $classes = Classes::where('school_id', auth()->user()->school_id)
            ->orderBy('numeric_value')
            ->get();

        // Get current subject-teacher assignments
        $subjectAssignments = [];
        foreach ($subjects as $subject) {
            $assignedTeachers = $subject->teachers()->get();
            $subjectAssignments[$subject->id] = $assignedTeachers->pluck('id')->toArray();
        }

        // Get current class teachers
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
        // Validate subject assignments
        $request->validate([
            'subject_assignments' => 'required|array',
            'subject_assignments.*' => 'nullable|array',
            'subject_assignments.*.*' => 'exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            // Process subject-teacher assignments
            foreach ($request->subject_assignments as $subjectId => $teacherIds) {
                $subject = Subject::findOrFail($subjectId);
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
        // Validate class teacher assignments
        $request->validate([
            'class_teachers' => 'required|array',
            'class_teachers.*' => 'nullable|exists:users,id',
        ]);

        try {
            DB::beginTransaction();

            // Process class teacher assignments
            foreach ($request->class_teachers as $classId => $teacherId) {
                $class = Classes::findOrFail($classId);
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ParentProfile;
use App\Models\Setting;
use App\Models\Section;
use App\Models\StudentParent;
use App\Models\StudentProfile;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        $branchId = auth()->user()->branch_id;

        // Get students with their profiles and related data
        $students = User::role('student')->with(['studentProfile.class', 'studentProfile.section'])
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->when($request->has('class_id'), function ($query) use ($request) {
                $query->whereHas('studentProfile', function ($q) use ($request) {
                    $q->where('class_id', $request->class_id);
                });
            })
            ->when($request->has('section_id'), function ($query) use ($request) {
                $query->whereHas('studentProfile', function ($q) use ($request) {
                    $q->where('section_id', $request->section_id);
                });
            })
            ->orderBy('name')
            ->get();

        // If it's an AJAX request (for table data)
        return view('app.admin.students', compact('students'));
    }

    public function create()
    {
        $branchId = auth()->user()->branch_id;
        $classes  = Classes::with('sections')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();
        return view('app.admin.add_student', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string',
            'gender'            => 'required|in:male,female,other',
            'dob'               => 'required|date',
            'admission_no'      => 'required|string|unique:student_profiles,admission_no',
            'admission_date'    => 'required|date',
            'class_id'          => 'required|exists:classes,id',
            'section_id'        => 'required|exists:sections,id',
            'previous_school'   => 'nullable|string',
            'blood_group'       => 'nullable|string',
            'medical_history'   => 'nullable|string',
            'transport_details' => 'nullable|string',
            'hobbies'           => 'nullable|string',
            'awards'            => 'nullable|string',
            'id_card_issued'    => 'boolean',
            'id_card_number'    => 'nullable|string',
            'student_photo'     => 'nullable|image|max:2048',
            'signature'         => 'nullable|image',
            'documents'         => 'nullable|array',
            'documents.*'       => 'file|max:5120',

            // Parent / Guardian (optional)
            'parent_name'       => 'nullable|required_with:parent_email|string|max:255',
            'parent_email'      => 'nullable|email|max:255',
            'parent_phone'      => 'nullable|string|max:20',
            'parent_relation'   => 'nullable|required_with:parent_email|in:father,mother,guardian',
            'parent_occupation' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $branchId = auth()->user()->branch_id;

            $studentPhotoPath = null;
            if ($request->hasFile('student_photo')) {
                $studentPhotoPath = $request->file('student_photo')
                    ->store("tenants/students/profile", 'website');
            }

            // Create user account
            $user = User::create([
                'branch_id'     => $branchId,
                'name'          => $validated['name'],
                'email'         => $validated['email'],
                'profile_pic'   => $studentPhotoPath,
                'phone'         => $validated['phone'],
                'address'       => $validated['address'],
                'gender'        => $validated['gender'],
                'dob'           => $validated['dob'],
                'password'      => '12345678',
                'role'          => 'student',
            ]);

            $user->assignRole('student');
            // Handle file uploads

            $signaturePath = null;
            if ($request->hasFile('signature')) {
                $signaturePath = $request->file('signature')
                    ->store("tenants/students/profile", 'website');
            }

            $documentPaths = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $documentPaths[] = $document
                        ->store("tenants/students/documents", 'website');
                }
            }

            // Create student profile
            $studentProfile = StudentProfile::create([
                'student_id'        => $user->id,
                'branch_id'         => $user->branch_id,
                'admission_no'      => $validated['admission_no'],
                'admission_date'    => $validated['admission_date'],
                'class_id'          => $validated['class_id'],
                'section_id'        => $validated['section_id'],
                'previous_school'   => $validated['previous_school'],
                'medical_history'   => $validated['medical_history'],
                'transport_details' => $validated['transport_details'],
                'hobbies'           => $validated['hobbies'],
                'awards'            => $validated['awards'],
                'blood_group'       => $validated['blood_group'],
                'id_card_issued'    => $validated['id_card_issued'] ?? false,
                'id_card_number'    => $validated['id_card_number'],
                'signature'         => $signaturePath,
                'documents'         => json_encode($documentPaths),
            ]);

            // Optionally create / link a parent for this student
            $this->syncParent($user, $validated, $branchId);

            DB::commit();

            return redirect()->route('dashboard.students')
                ->with('success', 'Student created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating student: ' . $e->getMessage());
        }

        /* Future funtionality 
        Create a student observer to handle related events:
        create:
        // app/Observers/StudentObserver.php
        // Generate ID card if needed
        // Send welcome email
        Delete:
        // Soft delete related records
        Create a student resource for API responses
        Create a form request for validation
        */
    }

    public function show($id)
    {
        $student = User::with([
            'studentProfile.class',
            'studentProfile.section',
        ])->findOrFail($id);

        return view('app.admin.show_student', compact('student'));
    }

    public function edit($id)
    {
        $branchId = auth()->user()->branch_id;
        $student  = User::with(['studentProfile.class', 'studentProfile.section', 'parents.parentProfile'])->findOrFail($id);
        $classes  = Classes::with('sections')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();

        // The student's primary (or first) linked parent, for pre-filling the form.
        $parent = $student->parents->firstWhere('pivot.is_primary', true) ?? $student->parents->first();

        return view('app.admin.edit_student', compact('student', 'classes', 'parent'));
    }

    public function update(Request $request, $id)
    {
        $student = User::findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $id,
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string',
            'gender'            => 'required|in:male,female,other',
            'dob'               => 'required|date',
            'admission_no'      => 'required|string|unique:student_profiles,admission_no,' . optional($student->studentProfile)->id,
            'admission_date'    => 'required|date',
            'class_id'          => 'required|exists:classes,id',
            'section_id'        => 'required|exists:sections,id',
            'previous_school'   => 'nullable|string',
            'blood_group'       => 'nullable|string',
            'medical_history'   => 'nullable|string',
            'transport_details' => 'nullable|string',
            'hobbies'           => 'nullable|string',
            'awards'            => 'nullable|string',
            'id_card_issued'    => 'nullable|boolean',
            'id_card_number'    => 'nullable|string',
            'student_photo'     => 'nullable|image|max:2048',

            // Parent / Guardian (optional)
            'parent_name'       => 'nullable|required_with:parent_email|string|max:255',
            'parent_email'      => 'nullable|email|max:255',
            'parent_phone'      => 'nullable|string|max:20',
            'parent_relation'   => 'nullable|required_with:parent_email|in:father,mother,guardian',
            'parent_occupation' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('student_photo')) {
                $validated['profile_pic'] = $request->file('student_photo')
                    ->store('tenants/students/profile', 'website');
            }

            $student->update([
                'name'        => $validated['name'],
                'email'       => $validated['email'],
                'phone'       => $validated['phone'],
                'address'     => $validated['address'],
                'gender'      => $validated['gender'],
                'dob'         => $validated['dob'],
                'profile_pic' => $validated['profile_pic'] ?? $student->profile_pic,
            ]);

            $student->studentProfile()->updateOrCreate(
                ['student_id' => $student->id],
                [
                    'admission_no'      => $validated['admission_no'],
                    'admission_date'    => $validated['admission_date'],
                    'class_id'          => $validated['class_id'],
                    'section_id'        => $validated['section_id'],
                    'previous_school'   => $validated['previous_school'],
                    'medical_history'   => $validated['medical_history'],
                    'transport_details' => $validated['transport_details'],
                    'hobbies'           => $validated['hobbies'],
                    'awards'            => $validated['awards'],
                    'blood_group'       => $validated['blood_group'],
                    'id_card_issued'    => $request->boolean('id_card_issued'),
                    'id_card_number'    => $validated['id_card_number'],
                ]
            );

            // Optionally create / link a parent for this student
            $this->syncParent($student, $validated, $student->branch_id);

            DB::commit();

            return redirect()->route('dashboard.students')
                ->with('message', 'Student updated successfully')
                ->with('alert-type', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('message', 'Error updating student: ' . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }

    public function destroy($id)
    {
        try {
            $student = User::findOrFail($id);
            $student->studentProfile()->delete();
            $student->delete();

            return redirect()->route('dashboard.students')
                ->with('message', 'Student deleted successfully')
                ->with('alert-type', 'success');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.students')
                ->with('message', 'Error deleting student: ' . $e->getMessage())
                ->with('alert-type', 'error');
        }
    }

    /**
     * Create or link a parent/guardian for the given student.
     * No-op when no parent email is supplied.
     */
    private function syncParent(User $student, array $data, $branchId): void
    {
        if (empty($data['parent_email'])) {
            return;
        }

        // Reuse an existing parent account with this email, otherwise create one.
        $parent = User::firstOrCreate(
            ['email' => $data['parent_email']],
            [
                'branch_id' => $branchId,
                'name'      => $data['parent_name'],
                'phone'     => $data['parent_phone'] ?? null,
                'password'  => '12345678', // default password (auto-hashed)
                'role'      => 'parent',
            ]
        );

        if (! $parent->hasRole('parent')) {
            $parent->assignRole('parent');
        }

        ParentProfile::updateOrCreate(
            ['parent_id' => $parent->id],
            [
                'branch_id'     => $branchId,
                'occupation'    => $data['parent_occupation'] ?? null,
                'relation_type' => $data['parent_relation'],
                'is_primary'    => true,
            ]
        );

        StudentParent::updateOrCreate(
            ['student_id' => $student->id, 'parent_id' => $parent->id],
            [
                'relationship' => $data['parent_relation'],
                'is_primary'   => true,
            ]
        );
    }

    public function getSections($classId)
    {
        $sections = Section::where('class_id', $classId)->pluck('name', 'id');
        return response()->json($sections);
    }
}



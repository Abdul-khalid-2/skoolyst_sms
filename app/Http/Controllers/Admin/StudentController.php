<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\School;
use App\Models\Section;
use App\Models\StudentProfile;
use App\Models\User;;

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
        // Get students with their profiles and related data
        $students = User::role('student')->with(['studentProfile.class', 'studentProfile.section'])
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
            // ->where('school_id', auth()->user()->school_id)
            ->orderBy('name')
            ->get();

        // If it's an AJAX request (for table data)
        return view('app.admin.students', compact('students'));
    }

    public function create()
    {
        $classes = Classes::with('sections')->get();
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
        ]);

        try {
            DB::beginTransaction();

            $school = School::first();

            $studentPhotoPath = null;
            if ($request->hasFile('student_photo')) {
                $studentPhotoPath = $request->file('student_photo')
                    ->store("tenants/" . tenant('id') . "/students/profile", 'website');
            }

            // Create user account
            $user = User::create([
                'school_id'     => auth()->user()->school_id ?? $school->id,
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
                    ->store("tenants/" . tenant('id') . "/students/profile", 'website');
            }

            $documentPaths = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $documentPaths[] = $document
                        ->store("tenants/" . tenant('id') . "/students/documents", 'website');
                }
            }

            // Create student profile
            $studentProfile = StudentProfile::create([
                'student_id'        => $user->id,
                'school_id'         => $user->school_id,
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

    public function getSections($classId)
    {
        $sections = Section::where('class_id', $classId)->pluck('name', 'id');
        return response()->json($sections);
    }
}

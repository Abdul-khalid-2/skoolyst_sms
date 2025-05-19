<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\School;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{

    protected $schoolId;

    public function __construct()
    {
        $this->schoolId = auth()->user()->school_id ?? School::first()->id ?? null;
    }
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $teachers = User::role('teacher')->with('teacherProfile')
            ->where('school_id', $this->schoolId)
            ->orderBy('name')
            ->get();

        return view('app.admin.teachers', compact('teachers'));
    }

    public function create()
    {
        $classes = Classes::where('school_id', $this->schoolId)
            ->get();
        return view('app.admin.add_teacher', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string',
            'gender'    => 'required|in:male,female,other',
            'dob'       => 'required|date',
            'roles'     => 'required|array',
            'roles.*'   => 'in:admin,teacher',

            // Teacher profile fields
            'employee_id'       => 'required|string|max:50|unique:teacher_profiles,employee_id',
            'qualification'     => 'required|string|max:255',
            'specialization'    => 'required|string|max:255',
            'experience_years'  => 'required|integer|min:0',
            'joining_date'      => 'required|date',
            'salary_grade'      => 'required|string|max:50',
            'bank_details'      => 'nullable|string',
            'emergency_contact' => 'required|string|max:255',
            'bio'               => 'nullable|string',
            'social_links'      => 'nullable|string',
            'is_class_teacher'  => 'boolean',
            'class_teacher_of'  => 'nullable|exists:classes,id',

            // File uploads
            'qualification_documents' => 'nullable|file|max:5120',
            'signature'     => 'nullable|image|max:2048',
            'profile_pic'   => 'required|image|max:2048',
            'documents'     => 'nullable|array',
            'documents.*'   => 'file|max:5120',
        ]);

        try {
            DB::beginTransaction();

            $profilePicPath = null;
            if ($request->hasFile('profile_pic')) {
                $profilePicPath = $request->file('profile_pic')
                    ->store("tenants/teachers/profile_pics", 'website');
            }


            // Create user account
            $user = User::create([
                'school_id'   => $this->schoolId,
                'name'        => $validated['name'],
                'email'       => $validated['email'],
                'profile_pic' => $profilePicPath,
                'phone'       => $validated['phone'],
                'address'     => $validated['address'],
                'gender'      => $validated['gender'],
                'dob'         => $validated['dob'],
                'password'    => bcrypt('12345678'), // Default password
                'role'        => in_array('admin', $validated['roles']) ? 'admin' : 'teacher',
            ]);

            // dd($profilePicPath);
            // Assign roles
            foreach ($validated['roles'] as $role) {
                $user->assignRole($role);
            }

            // Handle file uploads
            $qualificationDocPath = null;
            if ($request->hasFile('qualification_documents')) {
                $qualificationDocPath = $request->file('qualification_documents')
                    ->store("tenants/teachers/qualifications", 'website');
            }

            $signaturePath = null;
            if ($request->hasFile('signature')) {
                $signaturePath = $request->file('signature')
                    ->store("tenants/teachers/signatures", 'website');
            }

            $documentPaths = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $documentPaths[] = $document
                        ->store("tenants/teachers/documents", 'website');
                }
            }

            // Create teacher profile
            TeacherProfile::create([
                'teacher_id'        => $user->id,
                'school_id'         => $user->school_id,
                'employee_id'       => $validated['employee_id'],
                'qualification'     => $validated['qualification'],
                'specialization'    => $validated['specialization'],
                'experience_years'  => $validated['experience_years'],
                'joining_date'      => $validated['joining_date'],
                'salary_grade'      => $validated['salary_grade'],
                'bank_details'      => $validated['bank_details'],
                'emergency_contact' => $validated['emergency_contact'],
                'documents'         => json_encode($documentPaths),
                'signature'         => $signaturePath,
                'bio'               => $validated['bio'],
                'social_links'      => $validated['social_links'],
                'is_class_teacher'  => $validated['is_class_teacher'] ?? false,
                'class_teacher_of'  => $validated['class_teacher_of'],
                'qualification_documents' => $qualificationDocPath,
            ]);


            // In future I might want to add additional features like:
            // Sending a welcome email with login credentials
            // Generating an ID card for the teacher
            // Setting up default permissions based on roles
            // Adding audit logging for the creation

            DB::commit();

            return redirect()->route('dashboard.teachers')
                ->with('success', 'Teacher created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating teacher: ' . $e->getMessage());
        }
    }
    public function edit($encodedId = null)
    {
        $id = Crypt::decrypt($encodedId);
        $teacher = User::role('teacher')->where('school_id', $this->schoolId)->with('teacherProfile')
            ->orderBy('name')
            ->findorfail($id);
        $classes = Classes::where('school_id', $this->schoolId)->get();
        return view('app.admin.edit_teacher', compact('teacher', 'classes'));
    }

    public function show($encodedId = null)
    {
        $id = Crypt::decrypt($encodedId);
        $teacher = User::role('teacher')->where('school_id', $this->schoolId)->with(['teacherProfile', 'teacherSubjects', 'teacherClasses'])
            ->orderBy('name')
            ->findorfail($id);

        return view('app.admin.teacher', compact('teacher'));
    }

    public function update(Request $request, $id)
    {


        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $id,
            'phone'     => 'required|string|max:20',
            'address'   => 'required|string',
            'gender'    => 'required|in:male,female,other',
            'dob'       => 'required|date',
            'roles'      => 'required|array',
            'roles.*'    => 'in:admin,teacher',

            // Teacher profile fields
            'employee_id'       => 'required|string|max:50|unique:teacher_profiles,employee_id,' . $id . ',teacher_id',
            'qualification'     => 'required|string|max:255',
            'specialization'    => 'required|string|max:255',
            'experience_years'  => 'required|integer|min:0',
            'joining_date'      => 'required|date',
            'base_salary'       => 'required|numeric|min:0',
            'current_salary'    => 'required|numeric|min:0',
            'last_increment_date' => 'nullable|date_format:Y/m/d', // Changed to match your input format
            'salary_grade'      => 'required|string|max:50',
            'bank_details'      => 'nullable|string',
            'emergency_contact' => 'required|string|max:255',
            'bio'               => 'nullable|string',
            'social_links'      => 'nullable|string',
            'is_class_teacher'  => 'sometimes|boolean', // Changed to sometimes
            'class_teacher_of'  => 'nullable|exists:classes,id',

            // File uploads
            'profile_pic'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signature'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'documents'     => 'nullable|array',
            'documents.*'   => 'file|mimes:pdf,doc,docx,jpeg,png,jpg',
        ]);
        try {
            DB::beginTransaction();

            $user = User::where('school_id', $this->schoolId)->findorfail($id);
            $teacherProfile = TeacherProfile::where('teacher_id', $id)->firstOrFail();

            // Handle profile picture update
            if ($request->hasFile('profile_pic')) {
                // Delete old profile pic if exists
                if ($user->profile_pic) {
                    Storage::disk('website')->delete($user->profile_pic);
                }

                $profilePicPath = $request->file('profile_pic')
                    ->store("tenants/teachers/profile_pics", 'website');
                $user->profile_pic = $profilePicPath;
            }

            // Update user account
            $user->update([
                'name'        => $validated['name'],
                'email'       => $validated['email'],
                'phone'       => $validated['phone'],
                'address'     => $validated['address'],
                'gender'      => $validated['gender'],
                'dob'         => $validated['dob'],
                'roles'        => in_array('admin', $validated['roles']) ? 'admin' : 'teacher',
            ]);

            // Sync roles
            $user->syncRoles($validated['roles']);

            // Handle signature update
            $signaturePath = $teacherProfile->signature;
            if ($request->hasFile('signature')) {
                // Delete old signature if exists
                if ($signaturePath) {
                    Storage::disk('website')->delete($signaturePath);
                }

                $signaturePath = $request->file('signature')
                    ->store("tenants/teachers/signatures", 'website');
            }

            // Handle documents update
            $documentPaths = json_decode($teacherProfile->documents, true) ?? [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $documentPaths[] = $document
                        ->store("tenants/teachers/documents", 'website');
                }
            }

            // Update teacher profile
            $teacherProfile->update([
                'employee_id'       => $validated['employee_id'],
                'qualification'     => $validated['qualification'],
                'specialization'    => $validated['specialization'],
                'experience_years'  => $validated['experience_years'],
                'joining_date'      => $validated['joining_date'],
                'base_salary'       => $validated['base_salary'],
                'current_salary'    => $validated['current_salary'],
                'last_increment_date' => $validated['last_increment_date'],
                'salary_grade'      => $validated['salary_grade'],
                'bank_details'      => $validated['bank_details'],
                'emergency_contact' => $validated['emergency_contact'],
                'documents'         => json_encode($documentPaths),
                'signature'        => $signaturePath,
                'bio'               => $validated['bio'],
                'social_links'     => $validated['social_links'],
                'is_class_teacher'  => $validated['is_class_teacher'] ?? false,
                'class_teacher_of'  => $validated['class_teacher_of'],
            ]);

            DB::commit();

            return redirect()->route('dashboard.teachers')
                ->with('success', 'Teacher updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating teacher: ' . $e->getMessage());
        }
    }


    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $teacher = User::where('school_id', $this->schoolId)->findOrFail($request->id); // Assuming User is teacher
        $teacher->status = $request->status;
        $teacher->save();

        return response()->json(['success' => true, 'status' => $teacher->status]);
    }
}

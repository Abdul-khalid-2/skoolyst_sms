<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentProfile;
use App\Models\School;
use App\Models\StudentParent;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ParentController extends Controller
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
        $parents = User::with(['parentProfile', 'children.studentProfile.class'])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'parent');
            })
            ->where('school_id', $this->schoolId)
            ->get();

        $students = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        })
            ->where('school_id', $this->schoolId)
            ->get();

        return view('app.admin.parents', compact('parents', 'students'));
    }
    public function create()
    {
        $students = User::whereHas('roles', function ($q) {
            $q->where('name', 'student');
        })->where('school_id', $this->schoolId)
            ->get();
        return view('app.admin.add_parent', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'gender' => 'required|in:male,female,other',

            // Parent profile fields
            'occupation' => 'required|string|max:255',
            'employer' => 'nullable|string|max:255',
            'income_range' => 'required|string|max:50',
            'education_level' => 'required|string|max:50',
            'relation_type' => 'required|string|in:father,mother,guardian,other',
            'emergency_contact' => 'required|string|max:255',
            'is_primary' => 'boolean',
            'children' => 'required|array',
            'children.*' => 'exists:users,id',

            // File uploads
            'address_proof' => 'required|file|max:5120',
            'id_proof' => 'required|file|max:5120',
            'documents' => 'nullable|array',
            'documents.*' => 'file|max:5120',
        ]);

        try {
            DB::beginTransaction();

            // Create user account
            $user = User::create([
                'school_id' => $this->schoolId,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'gender' => $validated['gender'],
                'password' => bcrypt('12345678'), // Default password
                'role' => 'parent',
            ]);

            $user->assignRole('parent');

            // Handle file uploads
            $addressProofPath = $request->file('address_proof')
                ->store("tenants/parents/address_proofs", 'website');

            $idProofPath = $request->file('id_proof')
                ->store("tenants/parents/id_proofs", 'website');

            $documentPaths = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $documentPaths[] = $document
                        ->store("tenants/parents/documents", 'website');
                }
            }

            // Create parent profile
            $parentProfile = ParentProfile::create([
                'parent_id' => $user->id,
                'school_id' => $user->school_id,
                'occupation' => $validated['occupation'],
                'employer' => $validated['employer'],
                'income_range' => $validated['income_range'],
                'education_level' => $validated['education_level'],
                'relation_type' => $validated['relation_type'],
                'is_primary' => $validated['is_primary'] ?? false,
                'emergency_contact' => $validated['emergency_contact'],
                'address_proof' => $addressProofPath,
                'id_proof' => $idProofPath,
                'documents' => !empty($documentPaths) ? json_encode($documentPaths) : null,
            ]);

            // Create student-parent relationships
            foreach ($validated['children'] as $childId) {
                StudentParent::create([
                    'student_id' => $childId,
                    'parent_id' => $user->id,
                    'relationship' => $validated['relation_type'],
                    'is_primary' => $validated['is_primary'] ?? false,
                ]);
            }


            // Additional recommendations:
            // Password Handling:
            // Consider generating a random password and emailing it to the parent
            // Or implement a "set password" flow via email invitation
            // Notification:
            // Send a welcome email to the parent
            // Notify students about the added parent (if applicable)
            // Audit Logging:
            // Log the creation of the parent account for security purposes
            // Future Enhancements:
            // Parent portal access
            // Two-factor authentication
            // Document verification status tracking
            DB::commit();

            return redirect()->route('dashboard.parents')
                ->with('success', 'Parent created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating parent: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            DB::beginTransaction();

            $parent = User::find($id);

            // Delete parent relationships
            $parent->studentParentRelationships()->delete();

            // Delete parent profile
            if ($parent->parentProfile) {
                $parent->parentProfile()->delete();
            }

            // Delete user account
            $parent->delete();

            // DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Parent deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting parent: ' . $e->getMessage()
            ], 500);
        }
    }
}

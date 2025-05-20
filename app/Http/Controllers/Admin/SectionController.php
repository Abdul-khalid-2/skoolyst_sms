<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\School;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;

class SectionController extends Controller
{

    protected $schoolId;

    public function __construct()
    {
        $this->schoolId = auth()->user()->school_id ?? School::first()->id ?? null;
    }

    public function index()
    {
        // Get sections (including deleted) with their class and students count
        $sections = Section::withTrashed()
            ->with(['class' => function ($query) {
                $query->withTrashed(); // Include deleted classes if needed
            }, 'students'])
            ->where('school_id', $this->schoolId)
            // ->whereHas('class', function ($query) {
            //     $query->whereNull('deleted_at'); // Only sections with non-deleted classes
            // })
            ->orderBy('class_id')
            ->orderBy('name')
            ->get();

        return view('app.admin.sections.index', compact('sections'));
    }


    public function create()
    {
        $classes = Classes::orderBy('numeric_value')
            ->get();

        return view('app.admin.sections.create', compact('classes'));
    }


    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'capacity' => 'required|integer|min:1'
        ]);

        $validated['school_id'] = $this->schoolId;

        try {
            Section::create($validated);

            return redirect()->route('admin.academic.sections.index')
                ->with('success', 'Section created successfully');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                // 1062 is MySQL error code for duplicate entry
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['duplicate' => 'A section with this name already exists for the class.']);
            }

            // rethrow or handle other DB errors
            return redirect()->back()
                ->withInput()
                ->withErrors(['db' => 'An unexpected database error occurred.']);
        }
    }



    public function edit($id)
    {

        $section = Section::where('school_id', $this->schoolId)
            ->findOrFail($id);

        $classes = Classes::where('school_id', $this->schoolId)
            ->orderBy('numeric_value')
            ->get();

        return view('app.admin.sections.edit', compact('section', 'classes'));
    }


    public function update(Request $request, $id)
    {

        $section = Section::where('school_id', $this->schoolId)
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'capacity' => 'required|integer|min:1'
        ]);

        $section->update($validated);

        return redirect()->route('admin.academic.sections.index')
            ->with('success', 'Section updated successfully');
    }


    public function destroy($id)
    {
        try {
            $section = Section::with(['class'])
                ->where('school_id', $this->schoolId)
                ->findOrFail(decrypt($id));

            if ($section->students()->count() > 0) {
                return redirect()->route('admin.academic.sections.index')
                    ->with('error', 'Cannot delete section with students');
            }

            $section->delete();

            // Check if this was the last active section
            if (!$section->class->sections()->whereNull('deleted_at')->exists()) {
                $section->class->delete();
                return redirect()->route('admin.academic.sections.index')
                    ->with('success', 'Section deleted successfully. Class was also deleted as it had no active sections');
            }

            return redirect()->route('admin.academic.sections.index')
                ->with('success', 'Section deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.academic.sections.index')
                ->with('error', 'Error deleting section: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $section = Section::withTrashed()
                ->with(['class' => function ($query) {
                    $query->withTrashed();
                }])
                ->where('school_id', $this->schoolId)
                ->findOrFail(decrypt($id));

            $section->restore();

            if ($section->class->trashed()) {
                $section->class->restore();
                return redirect()->route('admin.academic.sections.index')
                    ->with('success', 'Section and its parent class restored successfully');
            }

            return redirect()->route('admin.academic.sections.index')
                ->with('success', 'Section restored successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.academic.sections.index')
                ->with('error', 'Error restoring section: ' . $e->getMessage());
        }
    }

    public function getSectionsByClass($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json(['sections' => $sections]);
    }
}

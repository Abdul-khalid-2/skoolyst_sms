<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;

class SectionController extends Controller
{

    protected $branchId;

    public function __construct()
    {
        $this->branchId = auth()->user()->branch_id ?? Branch::first()->id ?? null;
    }

    public function index()
    {
        $sections = Section::withTrashed()
            ->with(['class' => function ($query) {
                $query->withTrashed();
            }, 'students'])
            ->where('branch_id', $this->branchId)
            ->orderBy('class_id')
            ->orderBy('name')
            ->get();

        return view('app.admin.sections.index', compact('sections'));
    }


    public function create()
    {
        $classes = Classes::orderBy('numeric_value')->get();
        return view('app.admin.sections.create', compact('classes'));
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'class_id'  => 'required|exists:classes,id',
            'capacity'  => 'required|integer|min:1'
        ]);

        $validated['branch_id'] = $this->branchId;

        try {
            Section::create($validated);

            return redirect()->route('admin.academic.sections.index')
                ->with('alert-type', 'success')
                ->with('message', 'Section created successfully!');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()
                    ->withInput()
                    ->with('alert-type', 'error')
                    ->with('message', 'A section with this name already exists for the selected class.');
            }

            return redirect()->back()
                ->withInput()
                ->with('alert-type', 'error')
                ->with('message', 'An unexpected error occurred while creating the section.');
        }
    }



    public function show($id)
    {
        $section = Section::withTrashed()
            ->with([
                'class' => fn($q) => $q->withTrashed(),
                'students.studentProfile',
            ])
            ->where('branch_id', $this->branchId)
            ->findOrFail(decrypt($id));

        return view('app.admin.sections.show', compact('section'));
    }

    public function edit($id)
    {

        $section = Section::where('branch_id', $this->branchId)
            ->findOrFail(decrypt($id));

        $classes = Classes::where('branch_id', $this->branchId)
            ->orderBy('numeric_value')
            ->get();

        return view('app.admin.sections.edit', compact('section', 'classes'));
    }


    public function update(Request $request, $id)
    {
        $section = Section::where('branch_id', $this->branchId)
            ->findOrFail(decrypt($id));

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'class_id'  => 'required|exists:classes,id',
            'capacity'  => 'required|integer|min:1'
        ]);

        try {
            $section->update($validated);

            return redirect()->route('admin.academic.sections.index')
                ->with('alert-type', 'success')
                ->with('message', 'Section updated successfully!');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()
                    ->withInput()
                    ->with('alert-type', 'error')
                    ->with('message', 'A section with this name already exists for the selected class.');
            }

            return redirect()->back()
                ->withInput()
                ->with('alert-type', 'error')
                ->with('message', 'An unexpected error occurred while updating the section.');
        }
    }


    public function destroy($id)
    {
        try {
            $section = Section::with(['class'])
                ->where('branch_id', $this->branchId)
                ->findOrFail(decrypt($id));

            if ($section->students()->count() > 0) {
                return redirect()->route('admin.academic.sections.index')
                    ->with('alert-type', 'error')
                    ->with('message', 'Cannot delete section because it contains students.');
            }

            $section->delete();

            if (!$section->class->sections()->whereNull('deleted_at')->exists()) {
                $section->class->delete();
                return redirect()->route('admin.academic.sections.index')
                    ->with('alert-type', 'success')
                    ->with('message', 'Section deleted successfully. The associated class was also deleted as it had no remaining active sections.');
            }

            return redirect()->route('admin.academic.sections.index')
                ->with('alert-type', 'success')
                ->with('message', 'Section deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.academic.sections.index')
                ->with('alert-type', 'error')
                ->with('message', 'Failed to delete section: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $section = Section::withTrashed()
                ->with(['class' => function ($query) {
                    $query->withTrashed();
                }])
                ->where('branch_id', $this->branchId)
                ->findOrFail(decrypt($id));

            $section->restore();

            if ($section->class->trashed()) {
                $section->class->restore();
                return redirect()->route('admin.academic.sections.index')
                    ->with('alert-type', 'success')
                    ->with('message', 'Section and its associated class restored successfully!');
            }

            return redirect()->route('admin.academic.sections.index')
                ->with('alert-type', 'success')
                ->with('message', 'Section restored successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.academic.sections.index')
                ->with('alert-type', 'error')
                ->with('message', 'Failed to restore section: ' . $e->getMessage());
        }
    }

    public function getSectionsByClass($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json(['sections' => $sections]);
    }
}



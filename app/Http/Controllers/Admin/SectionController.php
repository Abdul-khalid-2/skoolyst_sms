<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\School;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SectionController extends Controller
{
    /**
     * Display a listing of the sections.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school = School::first();
        // Get sections with their class and students count
        $sections = Section::with(['class', 'students'])
            ->where('school_id', auth()->user()->school_id ?? $school->id)
            ->orderBy('class_id')
            ->orderBy('name')
            ->get();


        return view('app.admin.sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new section.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Classes::orderBy('numeric_value')
            ->get();

        return view('app.admin.sections.create', compact('classes'));
    }

    /**
     * Store a newly created section in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $school = School::first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'capacity' => 'required|integer|min:1'
        ]);

        $validated['school_id'] = auth()->user()->school_id ?? $school->id;

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


    /**
     * Show the form for editing the specified section.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = School::first();
        $section = Section::where('school_id', auth()->user()->school_id ?? $school->id)
            ->findOrFail($id);

        $classes = Classes::where('school_id', auth()->user()->school_id ?? $school->id)
            ->orderBy('numeric_value')
            ->get();

        return view('app.admin.sections.edit', compact('section', 'classes'));
    }

    /**
     * Update the specified section in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $school = School::first();
        $section = Section::where('school_id', auth()->user()->school_id ?? $school->id)
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

    /**
     * Remove the specified section from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::first();
        $section = Section::where('school_id', auth()->user()->school_id ?? $school->id)
            ->findOrFail($id);

        // Check if section has students before deleting
        if ($section->students()->count() > 0) {
            return back()->with('error', 'Cannot delete section with students');
        }

        $section->delete();

        return redirect()->route('admin.academic.sections.index')
            ->with('success', 'Section deleted successfully');
    }

    public function getSectionsByClass($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();
        return response()->json(['sections' => $sections]);
    }
}

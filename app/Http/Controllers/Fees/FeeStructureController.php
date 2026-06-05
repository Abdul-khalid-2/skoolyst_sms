<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeCategory;
use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        $structures = FeeStructure::with(['category', 'schoolClass'])
            ->withCount('fees')
            ->orderBy('name')
            ->get();

        return view('app.fees.structures.index', compact('structures'));
    }

    public function create()
    {
        $categories = FeeCategory::orderBy('name')->get();
        $classes    = Classes::orderBy('numeric_value')->get();
        return view('app.fees.structures.create', compact('categories', 'classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'category_id' => 'required|exists:fee_categories,id',
            'class_id'    => 'nullable|exists:classes,id',
            'amount'      => 'required|numeric|min:0',
            'frequency'   => 'nullable|in:one_time,monthly,quarterly,yearly',
            'due_date'    => 'nullable|date',
        ]);

        FeeStructure::create($data);

        return redirect()->route('fees.structures.index')
            ->with('message', 'Fee structure created successfully.')
            ->with('alert-type', 'success');
    }

    public function edit(FeeStructure $structure)
    {
        $categories = FeeCategory::orderBy('name')->get();
        $classes    = Classes::orderBy('numeric_value')->get();
        return view('app.fees.structures.edit', compact('structure', 'categories', 'classes'));
    }

    public function update(Request $request, FeeStructure $structure)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'category_id' => 'required|exists:fee_categories,id',
            'class_id'    => 'nullable|exists:classes,id',
            'amount'      => 'required|numeric|min:0',
            'frequency'   => 'nullable|in:one_time,monthly,quarterly,yearly',
            'due_date'    => 'nullable|date',
        ]);

        $structure->update($data);

        return redirect()->route('fees.structures.index')
            ->with('message', 'Fee structure updated successfully.')
            ->with('alert-type', 'success');
    }

    public function destroy(FeeStructure $structure)
    {
        $structure->delete();

        return redirect()->route('fees.structures.index')
            ->with('message', 'Fee structure deleted.')
            ->with('alert-type', 'success');
    }
}

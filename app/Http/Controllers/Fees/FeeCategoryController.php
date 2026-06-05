<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Models\FeeCategory;
use Illuminate\Http\Request;

class FeeCategoryController extends Controller
{
    public function index()
    {
        $categories = FeeCategory::withCount('structures')->orderBy('name')->get();
        return view('app.fees.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('app.fees.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        FeeCategory::create($data);

        return redirect()->route('fees.categories.index')
            ->with('message', 'Fee category created successfully.')
            ->with('alert-type', 'success');
    }

    public function edit(FeeCategory $category)
    {
        return view('app.fees.categories.edit', compact('category'));
    }

    public function update(Request $request, FeeCategory $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category->update($data);

        return redirect()->route('fees.categories.index')
            ->with('message', 'Fee category updated successfully.')
            ->with('alert-type', 'success');
    }

    public function destroy(FeeCategory $category)
    {
        $category->delete();

        return redirect()->route('fees.categories.index')
            ->with('message', 'Fee category deleted.')
            ->with('alert-type', 'success');
    }
}

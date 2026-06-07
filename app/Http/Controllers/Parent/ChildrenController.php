<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ChildrenController extends Controller
{
    public function index(): View
    {
        $parent = auth()->user();
        $children = $parent->children()
            ->with(['studentProfile.class', 'studentProfile.section'])
            ->get();

        return view('app.parent.children.index', compact('parent', 'children'));
    }
}

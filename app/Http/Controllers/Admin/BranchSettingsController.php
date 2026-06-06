<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BranchSettingsController extends Controller
{
    /**
     * Branch admin manages their own branch details.
     */
    public function edit(): View
    {
        $branch = $this->resolveBranch();

        return view('app.admin.branch-settings.edit', compact('branch'));
    }

    public function update(Request $request): RedirectResponse
    {
        $branch = $this->resolveBranch();

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'email'   => ['nullable', 'email', 'max:255', 'unique:branches,email,'.$branch->id],
        ]);

        $branch->update($data);

        return redirect()->route('branch.settings')
            ->with('status', 'Branch settings updated successfully.')
            ->with('status-type', 'success');
    }

    private function resolveBranch(): Branch
    {
        $user = auth()->user();

        abort_unless($user->branch_id, 403, 'You are not assigned to a branch.');

        return Branch::findOrFail($user->branch_id);
    }
}

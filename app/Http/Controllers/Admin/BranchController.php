<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function index(): View
    {
        $branches = Branch::withCount('users')
            ->orderBy('name')
            ->get();

        $stats = [
            'total'  => $branches->count(),
            'active' => $branches->where('is_active', true)->count(),
        ];

        return view('app.admin.branches.index', compact('branches', 'stats'));
    }

    public function create(): View
    {
        return view('app.admin.branches.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'address'        => ['nullable', 'string'],
            'phone'          => ['nullable', 'string', 'max:30'],
            'email'          => ['nullable', 'email', 'max:255', 'unique:branches,email'],
            'is_active'      => ['boolean'],
            'admin_name'     => ['nullable', 'required_with:admin_email', 'string', 'max:255'],
            'admin_email'    => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['nullable', 'required_with:admin_email', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($data) {
            $branch = Branch::create([
                'name'      => $data['name'],
                'address'   => $data['address'] ?? null,
                'phone'     => $data['phone'] ?? null,
                'email'     => $data['email'] ?? null,
                'is_active' => $data['is_active'] ?? true,
            ]);

            if (! empty($data['admin_email'])) {
                $admin = User::create([
                    'branch_id' => $branch->id,
                    'name'      => $data['admin_name'],
                    'email'     => $data['admin_email'],
                    'password'  => $data['admin_password'],
                    'role'      => 'admin',
                    'status'    => 'active',
                ]);

                $admin->assignRole('admin');
            }
        });

        return redirect()->route('admin.branches.index')
            ->with('status', 'Branch created successfully.')
            ->with('status-type', 'success');
    }

    public function edit(Branch $branch): View
    {
        $branch->loadCount('users');
        $admins = User::role('admin')->where('branch_id', $branch->id)->get(['id', 'name', 'email', 'status']);

        return view('app.admin.branches.edit', compact('branch', 'admins'));
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $data = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'address'        => ['nullable', 'string'],
            'phone'          => ['nullable', 'string', 'max:30'],
            'email'          => ['nullable', 'email', 'max:255', 'unique:branches,email,'.$branch->id],
            'is_active'      => ['boolean'],
            'admin_name'     => ['nullable', 'required_with:admin_email', 'string', 'max:255'],
            'admin_email'    => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['nullable', 'required_with:admin_email', 'string', 'min:8', 'confirmed'],
        ]);

        $adminCreated = false;

        DB::transaction(function () use ($request, $branch, $data, &$adminCreated) {
            $branch->update([
                'name'      => $data['name'],
                'address'   => $data['address'] ?? null,
                'phone'     => $data['phone'] ?? null,
                'email'     => $data['email'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);

            if (! empty($data['admin_email'])) {
                $admin = User::create([
                    'branch_id' => $branch->id,
                    'name'      => $data['admin_name'],
                    'email'     => $data['admin_email'],
                    'password'  => $data['admin_password'],
                    'role'      => 'admin',
                    'status'    => 'active',
                ]);

                $admin->assignRole('admin');
                $adminCreated = true;
            }
        });

        $message = $adminCreated
            ? 'Branch updated and branch admin created successfully.'
            : 'Branch updated successfully.';

        return redirect()->route('admin.branches.edit', $branch)
            ->with('status', $message)
            ->with('status-type', 'success');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        if ($branch->users()->exists()) {
            return back()->with('status', 'Cannot delete a branch that has users assigned. Deactivate it instead.')
                ->with('status-type', 'danger');
        }

        $branch->delete();

        return redirect()->route('admin.branches.index')
            ->with('status', 'Branch deleted successfully.')
            ->with('status-type', 'success');
    }
}

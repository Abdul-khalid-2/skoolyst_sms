<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Active branch for the current user. Null for super-admins (see all branches).
     */
    private function branchId(): ?int
    {
        $user = auth()->user();

        return $user && $user->hasRole('super-admin') ? null : $user?->branch_id;
    }

    /**
     * Abort if a non-super-admin tries to access a user outside their branch.
     */
    private function authorizeBranch(User $user): void
    {
        $branchId = $this->branchId();

        if ($branchId && $user->branch_id !== $branchId) {
            abort(404);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branchId = $this->branchId();

        $users = User::with('roles')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();

        return view('app.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $validate['branch_id'] = auth()->user()->branch_id;   // null for super-admin

        User::create($validate);
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorizeBranch($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorizeBranch($user);

        $roles = Role::get();
        return view('app.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeBranch($user);

        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required|array'
        ]);

        $user->update($validate);
        $user->roles()->sync($request->roles);
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorizeBranch($user);
    }
}


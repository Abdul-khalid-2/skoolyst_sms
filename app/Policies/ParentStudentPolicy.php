<?php

namespace App\Policies;

use App\Models\User;

class ParentStudentPolicy
{
    /**
     * Determine whether the parent can view the student's data.
     */
    public function view(User $parent, User $student): bool
    {
        if (! $parent->hasRole('parent')) {
            return false;
        }

        return $parent->children()
            ->where('users.id', $student->id)
            ->exists();
    }
}

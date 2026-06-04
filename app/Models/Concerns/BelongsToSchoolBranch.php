<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToSchoolBranch
{
    public static function resolveActiveBranchId(): ?int
    {
        $user = Auth::user();

        if ($user && $user->role === 'super-admin') {
            return null;
        }

        if (app()->bound('current.branch_id')) {
            return (int) app('current.branch_id');
        }

        return $user?->branch_id ? (int) $user->branch_id : null;
    }

    protected static function bootBelongsToSchoolBranch(): void
    {
        static::addGlobalScope('branch_id', function (Builder $builder) {
            $branchId = static::resolveActiveBranchId();

            if ($branchId) {
                $builder->where($builder->qualifyColumn('branch_id'), $branchId);
            }
        });
    }

    public function scopeWithoutBranchScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('branch_id');
    }

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }
}

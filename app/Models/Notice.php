<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
        'title',
        'content',
        'target_roles',
        'target_classes',
        'start_date',
        'end_date',
        'is_published'
    ];

    protected $casts = [
        'target_roles' => 'array',
        'target_classes' => 'array'
    ];

    public function scopeActive(Builder $query): Builder
    {
        $today = now()->toDateString();

        return $query->where('is_published', true)
            ->where(function (Builder $q) use ($today) {
                $q->whereNull('start_date')->orWhereDate('start_date', '<=', $today);
            })
            ->where(function (Builder $q) use ($today) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', $today);
            });
    }

    public function scopeForBranch(Builder $query, ?int $branchId): Builder
    {
        return $query->when($branchId, fn (Builder $q) => $q->where('branch_id', $branchId));
    }

    public function isVisibleTo(string $role, ?int $classId = null, array $childClassIds = []): bool
    {
        return $this->matchesRole($role) && $this->matchesClasses($role, $classId, $childClassIds);
    }

    public function matchesRole(string $role): bool
    {
        $roles = $this->target_roles;

        if ($roles === null || $roles === []) {
            return true;
        }

        return in_array($role, $roles, true);
    }

    public function matchesClasses(string $role, ?int $classId = null, array $childClassIds = []): bool
    {
        $targets = $this->normalizedTargetClasses();

        if ($targets === []) {
            return true;
        }

        if (! in_array($role, ['student', 'parent'], true)) {
            return true;
        }

        if ($role === 'student') {
            return $classId !== null && in_array($classId, $targets, true);
        }

        if ($childClassIds === []) {
            return false;
        }

        return (bool) array_intersect($childClassIds, $targets);
    }

    /** @return int[] */
    public function normalizedTargetClasses(): array
    {
        return array_values(array_map('intval', $this->target_classes ?? []));
    }
}


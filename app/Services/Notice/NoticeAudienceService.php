<?php

namespace App\Services\Notice;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Support\Collection;

class NoticeAudienceService
{
    /**
     * Published notices visible to the given user (role + class targeting).
     */
    public function forUser(User $user, ?int $limit = null): Collection
    {
        [$role, $classId, $childClassIds] = $this->buildAudienceContext($user);

        $query = Notice::query()
            ->active()
            ->forBranch($user->branch_id)
            ->orderByDesc('start_date')
            ->orderByDesc('id');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get()
            ->filter(fn (Notice $notice) => $notice->isVisibleTo($role, $classId, $childClassIds))
            ->values();
    }

    /**
     * @return array{0: string, 1: ?int, 2: int[]}
     */
    public function audienceContextForUser(User $user): array
    {
        return $this->buildAudienceContext($user);
    }

    /**
     * Users who should receive a notification for this published notice.
     */
    public function eligibleUsers(Notice $notice): Collection
    {
        if (! $notice->is_published) {
            return collect();
        }

        $roles = $notice->target_roles ?? \App\Http\Controllers\Notice\NoticeController::TARGET_ROLES;

        return User::query()
            ->when($notice->branch_id, fn ($q) => $q->where('branch_id', $notice->branch_id))
            ->whereIn('role', $roles)
            ->with(['studentProfile', 'children.studentProfile'])
            ->get()
            ->filter(function (User $user) use ($notice) {
                [$role, $classId, $childClassIds] = $this->buildAudienceContext($user);

                return $notice->isVisibleTo($role, $classId, $childClassIds);
            })
            ->values();
    }

    /**
     * @return array{0: string, 1: ?int, 2: int[]}
     */
    private function buildAudienceContext(User $user): array
    {
        $role = (string) $user->role;
        $classId = null;
        $childClassIds = [];

        if ($role === 'student') {
            $classId = $user->studentProfile?->class_id;
            $classId = $classId !== null ? (int) $classId : null;
        } elseif ($role === 'parent') {
            $childClassIds = $user->children()
                ->with('studentProfile:id,student_id,class_id')
                ->get()
                ->pluck('studentProfile.class_id')
                ->filter()
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all();
        }

        return [$role, $classId, $childClassIds];
    }
}

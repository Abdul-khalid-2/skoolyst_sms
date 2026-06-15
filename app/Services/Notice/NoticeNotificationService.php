<?php

namespace App\Services\Notice;

use App\Models\AppNotification;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NoticeNotificationService
{
    public function __construct(
        private NoticeAudienceService $audience,
    ) {}

    public function noticeLink(Notice $notice): string
    {
        return route('my-notices.show', $notice);
    }

    public function notifyPublishedNotice(Notice $notice, bool $updated = false): void
    {
        $this->syncForNotice($notice, $updated);
    }

    /**
     * Align stored notifications with the notice's current audience and publish state.
     */
    public function syncForNotice(Notice $notice, bool $updated = false): void
    {
        $link = $this->noticeLink($notice);

        if (! $notice->is_published) {
            $this->purgeForNotice($notice);

            return;
        }

        $eligibleUsers = $this->audience->eligibleUsers($notice);
        $eligibleUserIds = $eligibleUsers->pluck('id');

        AppNotification::where('type', 'notice')
            ->where('link', $link)
            ->whereNotIn('user_id', $eligibleUserIds)
            ->delete();

        $existingUserIds = AppNotification::where('type', 'notice')
            ->where('link', $link)
            ->pluck('user_id');

        $title = $updated ? 'Notice updated' : 'New notice';
        $message = Str::limit($notice->title, 120);

        foreach ($eligibleUsers as $user) {
            if ($existingUserIds->contains($user->id)) {
                continue;
            }

            AppNotification::create([
                'branch_id' => $notice->branch_id ?? $user->branch_id,
                'user_id'   => $user->id,
                'title'     => $title,
                'message'   => $message,
                'type'      => 'notice',
                'link'      => $link,
            ]);
        }

        AppNotification::where('type', 'notice')
            ->where('link', $link)
            ->update([
                'title'   => $title,
                'message' => $message,
            ]);
    }

    public function purgeForNotice(Notice $notice): void
    {
        AppNotification::where('type', 'notice')
            ->where('link', $this->noticeLink($notice))
            ->delete();
    }

    public function pruneStaleForUser(User $user): void
    {
        AppNotification::where('user_id', $user->id)
            ->where('type', 'notice')
            ->get()
            ->each(function (AppNotification $notification) use ($user) {
                if (! $this->isValidForUser($notification, $user)) {
                    $notification->delete();
                }
            });
    }

    public function notificationsForUser(User $user, int $limit = 6): Collection
    {
        $this->pruneStaleForUser($user);

        return AppNotification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    public function unreadCountForUser(User $user): int
    {
        $this->pruneStaleForUser($user);

        return AppNotification::where('user_id', $user->id)->unread()->count();
    }

    public function isValidForUser(AppNotification $notification, User $user): bool
    {
        if ($notification->type !== 'notice') {
            return true;
        }

        $notice = $this->noticeFromNotification($notification);

        if (! $notice) {
            return false;
        }

        return $this->userCanViewNotice($user, $notice);
    }

    public function userCanViewNotice(User $user, Notice $notice): bool
    {
        if (! $notice->is_published) {
            return false;
        }

        if ($notice->branch_id && $user->branch_id && (int) $notice->branch_id !== (int) $user->branch_id) {
            return false;
        }

        [$role, $classId, $childClassIds] = $this->audience->audienceContextForUser($user);

        return $notice->isVisibleTo($role, $classId, $childClassIds);
    }

    public function markNoticeReadForUser(Notice $notice, int $userId): void
    {
        AppNotification::where('user_id', $userId)
            ->where('link', $this->noticeLink($notice))
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function removeNoticeNotificationForUser(Notice $notice, int $userId): void
    {
        AppNotification::where('user_id', $userId)
            ->where('link', $this->noticeLink($notice))
            ->delete();
    }

    private function noticeFromNotification(AppNotification $notification): ?Notice
    {
        $noticeId = $this->noticeIdFromLink($notification->link);

        if ($noticeId === null) {
            return null;
        }

        return Notice::find($noticeId);
    }

    private function noticeIdFromLink(?string $link): ?int
    {
        if ($link === null || ! preg_match('#/my-notices/(\d+)#', $link, $matches)) {
            return null;
        }

        return (int) $matches[1];
    }
}

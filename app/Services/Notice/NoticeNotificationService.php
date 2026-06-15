<?php

namespace App\Services\Notice;

use App\Models\AppNotification;
use App\Models\Notice;
use Illuminate\Support\Str;

class NoticeNotificationService
{
    public function __construct(
        private NoticeAudienceService $audience,
    ) {}

    public function notifyPublishedNotice(Notice $notice, bool $updated = false): void
    {
        if (! $notice->is_published) {
            return;
        }

        $title = $updated ? 'Notice updated' : 'New notice';
        $message = Str::limit($notice->title, 120);
        $link = route('my-notices.show', $notice);

        foreach ($this->audience->eligibleUsers($notice) as $user) {
            AppNotification::create([
                'branch_id' => $notice->branch_id ?? $user->branch_id,
                'user_id'   => $user->id,
                'title'     => $title,
                'message'   => $message,
                'type'      => 'notice',
                'link'      => $link,
            ]);
        }
    }

    public function markNoticeReadForUser(Notice $notice, int $userId): void
    {
        AppNotification::where('user_id', $userId)
            ->where('link', route('my-notices.show', $notice))
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}

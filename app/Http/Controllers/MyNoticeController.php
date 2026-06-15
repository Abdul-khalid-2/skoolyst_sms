<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Services\Notice\NoticeAudienceService;
use App\Services\Notice\NoticeNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MyNoticeController extends Controller
{
    public function index(NoticeAudienceService $notices): View
    {
        return view('app.my-notices.index', [
            'notices' => $notices->forUser(auth()->user()),
        ]);
    }

    public function show(
        Notice $notice,
        NoticeAudienceService $audience,
        NoticeNotificationService $notifier,
    ): View|RedirectResponse {
        $user = auth()->user();
        [$role, $classId, $childClassIds] = $audience->audienceContextForUser($user);

        if (! $notice->is_published || ! $notice->isVisibleTo($role, $classId, $childClassIds)) {
            abort(404);
        }

        if ($notice->branch_id && $user->branch_id && (int) $notice->branch_id !== (int) $user->branch_id) {
            abort(404);
        }

        $notifier->markNoticeReadForUser($notice, $user->id);

        return view('app.my-notices.show', compact('notice'));
    }
}

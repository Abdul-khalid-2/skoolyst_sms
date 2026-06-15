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
        NoticeNotificationService $notifier,
    ): View|RedirectResponse {
        $user = auth()->user();

        if (! $notifier->userCanViewNotice($user, $notice)) {
            $notifier->removeNoticeNotificationForUser($notice, $user->id);

            return redirect()
                ->route('notifications.index')
                ->with('message', 'This notice is no longer available to you.')
                ->with('alert-type', 'warning');
        }

        $notifier->markNoticeReadForUser($notice, $user->id);

        return view('app.my-notices.show', compact('notice'));
    }
}

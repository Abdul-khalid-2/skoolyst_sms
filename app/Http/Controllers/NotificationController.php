<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use App\Services\Notice\NoticeNotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request, NoticeNotificationService $notifier): View
    {
        $user = auth()->user();

        $notifier->pruneStaleForUser($user);

        $notifications = AppNotification::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        if ($request->boolean('mark_read')) {
            AppNotification::where('user_id', $user->id)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return view('app.notifications.index', compact('notifications'));
    }
}

<?php

namespace App\Http\Controllers\Notice;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Notice;
use App\Services\Notice\NoticeNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    /** Roles a notice can be targeted to. */
    public const TARGET_ROLES = ['admin', 'teacher', 'student', 'parent', 'accountant'];

    private function branchId(): ?int
    {
        return Auth::user()?->branch_id;
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'target_roles'     => 'nullable|array',
            'target_roles.*'   => 'in:' . implode(',', self::TARGET_ROLES),
            'target_classes'   => 'nullable|array',
            'target_classes.*' => 'exists:classes,id',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
        ]);

        // Always persist audience fields (unchecked boxes are omitted from the request).
        $roles = array_values(array_filter((array) $request->input('target_roles', [])));
        $classes = array_values(array_map('intval', array_filter((array) $request->input('target_classes', []))));

        $data['target_roles']   = $roles !== [] ? $roles : null;
        $data['target_classes'] = $classes !== [] ? $classes : null;
        $data['is_published']   = $request->boolean('is_published');

        return $data;
    }

    public function index()
    {
        $notices = Notice::where('branch_id', $this->branchId())
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('app.notices.index', compact('notices'));
    }

    public function create()
    {
        $classes = Classes::when($this->branchId(), fn ($q) => $q->where('branch_id', $this->branchId()))->orderBy('numeric_value')->get();
        $roles   = self::TARGET_ROLES;
        return view('app.notices.create', compact('classes', 'roles'));
    }

    public function store(Request $request, NoticeNotificationService $notifier)
    {
        $data = $this->validated($request);
        $data['branch_id'] = $this->branchId();

        $notice = Notice::create($data);

        if ($notice->is_published) {
            $notifier->notifyPublishedNotice($notice);
        }

        return redirect()->route('notices.index')
            ->with('message', 'Notice published successfully.')->with('alert-type', 'success');
    }

    public function show(Notice $notice)
    {
        return view('app.notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        $classes = Classes::when($this->branchId(), fn ($q) => $q->where('branch_id', $this->branchId()))->orderBy('numeric_value')->get();
        $roles   = self::TARGET_ROLES;
        return view('app.notices.edit', compact('notice', 'classes', 'roles'));
    }

    public function update(Request $request, Notice $notice, NoticeNotificationService $notifier)
    {
        $wasPublished = (bool) $notice->is_published;

        $notice->update($this->validated($request));
        $notice->refresh();

        if ($notice->is_published && ! $wasPublished) {
            $notifier->notifyPublishedNotice($notice);
        }

        return redirect()->route('notices.index')
            ->with('message', 'Notice updated successfully.')->with('alert-type', 'success');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return redirect()->route('notices.index')
            ->with('message', 'Notice deleted.')->with('alert-type', 'success');
    }
}

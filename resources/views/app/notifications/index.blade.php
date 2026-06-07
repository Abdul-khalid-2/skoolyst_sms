<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-8">
                <h3 style="margin:0;"><i class="fa fa-bell"></i> Notifications</h3>
            </div>
            <div class="col-lg-4 text-right">
                <a href="{{ route('notifications.index', ['mark_read' => 1]) }}" class="btn btn-default btn-sm">Mark all read</a>
            </div>
        </div>

        <div class="white-box">
            @forelse($notifications as $notification)
                <div style="padding:12px 0; border-bottom:1px solid #eee; {{ $notification->read_at ? '' : 'background:#f9fcff;' }}">
                    <strong>{{ $notification->title }}</strong>
                    @if(! $notification->read_at)<span class="label label-info" style="margin-left:6px;">New</span>@endif
                    <p class="text-muted" style="margin:6px 0 0; font-size:13px;">{{ $notification->message }}</p>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    @if($notification->link)
                        <a href="{{ $notification->link }}" class="btn btn-xs btn-link">View</a>
                    @endif
                </div>
            @empty
                <p class="text-muted text-center" style="padding:30px 0;">No notifications yet.</p>
            @endforelse

            {{ $notifications->links() }}
        </div>
    </div>
</x-tenant-app-layout>

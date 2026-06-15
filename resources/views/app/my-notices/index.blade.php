<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top:20px;">
        <h3 style="margin-bottom:15px;"><i class="fa fa-bullhorn"></i> Notices</h3>
        <div class="white-box">
            @forelse($notices as $notice)
                <div style="padding:12px 0; border-bottom:1px solid #eee;">
                    <h4 style="margin:0 0 6px;">
                        <a href="{{ route('my-notices.show', $notice) }}">{{ $notice->title }}</a>
                    </h4>
                    <p style="margin:0; white-space:pre-line;">{{ \Illuminate\Support\Str::limit(strip_tags($notice->content), 160) }}</p>
                    <small class="text-muted">{{ $notice->start_date ? \Carbon\Carbon::parse($notice->start_date)->format('d M Y') : '' }}</small>
                </div>
            @empty
                <p class="text-muted text-center" style="padding:30px;">No notices at this time.</p>
            @endforelse
        </div>
    </div>
</x-tenant-app-layout>

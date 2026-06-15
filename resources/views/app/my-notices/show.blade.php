<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top:20px;">
        <div style="margin-bottom:15px;">
            <a href="{{ route('my-notices.index') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> All Notices</a>
        </div>
        <div class="white-box">
            <h3 style="margin-top:0;"><i class="fa fa-bullhorn"></i> {{ $notice->title }}</h3>
            @if($notice->start_date)
                <p class="text-muted" style="margin-bottom:15px;">
                    <i class="fa fa-calendar"></i> {{ \Carbon\Carbon::parse($notice->start_date)->format('d M Y') }}
                    @if($notice->end_date)
                        &mdash; {{ \Carbon\Carbon::parse($notice->end_date)->format('d M Y') }}
                    @endif
                </p>
            @endif
            <div style="white-space:pre-line; line-height:1.6;">{{ $notice->content }}</div>
        </div>
    </div>
</x-tenant-app-layout>

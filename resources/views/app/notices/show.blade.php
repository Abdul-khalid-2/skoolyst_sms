<x-tenant-app-layout>
    @push('css')
        <style>
            .notice-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:28px 32px; }
            .notice-card h2 { margin:0 0 6px; font-size:24px; font-weight:700; color:#2c3e50; }
            .notice-meta { color:#888; font-size:13px; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid #f0f0f0; }
            .notice-body { font-size:15px; line-height:1.7; color:#444; white-space:pre-wrap; }
            .pill { display:inline-block; padding:3px 10px; border-radius:12px; font-size:12px; margin:2px; background:#eef2f7; color:#475569; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Notice Detail">
                <a href="{{ route('notices.edit', $notice) }}" style="color:#333;"><i class="fa fa-edit"></i> Edit Notice</a>
                <a href="{{ route('notices.index') }}" style="color:#333;"><i class="fa fa-list"></i> All Notices</a>
            </x-page-header>

            <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                <div class="notice-card">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                        <h2>{{ $notice->title }}</h2>
                        @if($notice->is_published)
                            <span class="label label-success" style="font-size:13px;">Published</span>
                        @else
                            <span class="label label-default" style="font-size:13px;">Draft</span>
                        @endif
                    </div>

                    <div class="notice-meta">
                        <i class="fa fa-calendar"></i>
                        {{ $notice->start_date ? \Carbon\Carbon::parse($notice->start_date)->format('d M Y') : '—' }}
                        @if($notice->end_date)
                            &nbsp;to&nbsp; {{ \Carbon\Carbon::parse($notice->end_date)->format('d M Y') }}
                        @endif
                        &nbsp;·&nbsp; Posted {{ $notice->created_at?->diffForHumans() }}
                    </div>

                    <div class="notice-body">{{ $notice->content }}</div>

                    <div style="margin-top:24px; padding-top:16px; border-top:1px solid #f0f0f0;">
                        <strong style="font-size:13px; color:#666;">Audience:</strong>
                        @forelse($notice->target_roles ?? [] as $role)
                            <span class="pill">{{ ucfirst($role) }}</span>
                        @empty
                            <span class="pill">Everyone</span>
                        @endforelse

                        @if(!empty($notice->target_classes))
                            <br><strong style="font-size:13px; color:#666;">Classes:</strong>
                            @foreach(\App\Models\Classes::whereIn('id', $notice->target_classes)->pluck('name') as $cn)
                                <span class="pill">{{ $cn }}</span>
                            @endforeach
                        @endif
                    </div>

                    <div style="margin-top:24px; display:flex; gap:10px;">
                        <a href="{{ route('notices.edit', $notice) }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('notices.destroy', $notice) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this notice?')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-tenant-app-layout>

<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .badge-role { background:#eef2f7; color:#475569; padding:2px 8px; border-radius:12px; font-size:11px; margin:1px; display:inline-block; }
            .badge-published { background:#27ae60; color:#fff; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .badge-draft     { background:#95a5a6; color:#fff; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .badge-active    { background:#3498db; color:#fff; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .badge-expired   { background:#e74c3c; color:#fff; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .badge-scheduled { background:#f39c12; color:#fff; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Notices & Announcements">
                    <a href="{{ route('notices.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Create Notice</a>
                </x-page-header>

                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered hover-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Audience</th>
                                                <th>Start</th>
                                                <th>End</th>
                                                <th>State</th>
                                                <th>Published</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($notices as $i => $notice)
                                                @php
                                                    $today = now()->format('Y-m-d');
                                                    if ($notice->end_date && $notice->end_date < $today) {
                                                        $state = ['expired', 'Expired'];
                                                    } elseif ($notice->start_date && $notice->start_date > $today) {
                                                        $state = ['scheduled', 'Scheduled'];
                                                    } else {
                                                        $state = ['active', 'Active'];
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $notices->firstItem() + $i }}</td>
                                                    <td><strong>{{ \Illuminate\Support\Str::limit($notice->title, 50) }}</strong></td>
                                                    <td>
                                                        @forelse($notice->target_roles ?? [] as $role)
                                                            <span class="badge-role">{{ ucfirst($role) }}</span>
                                                        @empty
                                                            <span class="badge-role">Everyone</span>
                                                        @endforelse
                                                    </td>
                                                    <td>{{ $notice->start_date ? \Carbon\Carbon::parse($notice->start_date)->format('d M Y') : '—' }}</td>
                                                    <td>{{ $notice->end_date ? \Carbon\Carbon::parse($notice->end_date)->format('d M Y') : '—' }}</td>
                                                    <td><span class="badge-{{ $state[0] }}">{{ $state[1] }}</span></td>
                                                    <td>
                                                        @if($notice->is_published)
                                                            <span class="badge-published">Published</span>
                                                        @else
                                                            <span class="badge-draft">Draft</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div style="display:flex; gap:4px;">
                                                            <a href="{{ route('notices.show', $notice) }}" class="btn btn-xs btn-success" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('notices.edit', $notice) }}" class="btn btn-xs btn-primary" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('notices.destroy', $notice) }}" method="POST">
                                                                @csrf @method('DELETE')
                                                                <button class="btn btn-xs btn-danger" title="Delete"
                                                                    onclick="return confirm('Delete this notice?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted" style="padding:40px;">
                                                        <i class="fa fa-bullhorn fa-3x" style="color:#ddd;"></i>
                                                        <br><br>No notices yet.
                                                        <br><a href="{{ route('notices.create') }}">Create the first notice</a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($notices->hasPages())
                                    <div style="margin-top:15px;">{{ $notices->links() }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/data-table/bootstrap-table.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
    @endpush
</x-tenant-app-layout>

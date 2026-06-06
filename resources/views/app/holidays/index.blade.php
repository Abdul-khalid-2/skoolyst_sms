<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .hol-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .hol-stat h2 { margin:4px 0; font-size:26px; font-weight:700; }
            .hol-stat p  { margin:0; font-size:13px; color:#777; }
            .hol-stat.blue   { border-top:3px solid #3498db; }
            .hol-stat.green  { border-top:3px solid #27ae60; }
            .hol-stat.orange { border-top:3px solid #f39c12; }
            .badge-recurring { background:#8e44ad; color:#fff; padding:2px 9px; border-radius:12px; font-size:11px; }
            .badge-onetime   { background:#eef2f7; color:#475569; padding:2px 9px; border-radius:12px; font-size:11px; }
            .badge-upcoming  { background:#3498db; color:#fff; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .badge-ongoing   { background:#f39c12; color:#fff; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .badge-past      { background:#95a5a6; color:#fff; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Holidays">
                    <a href="{{ route('holidays.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Add Holiday</a>
                </x-page-header>

                {{-- Summary --}}
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="hol-stat blue">
                        <p><i class="fa fa-calendar"></i> Total Holidays</p>
                        <h2>{{ number_format($total) }}</h2>
                        <p>On record</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="hol-stat green">
                        <p><i class="fa fa-clock-o"></i> Upcoming</p>
                        <h2>{{ number_format($upcoming) }}</h2>
                        <p>Ahead of today</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="hol-stat orange">
                        <p><i class="fa fa-refresh"></i> Recurring</p>
                        <h2>{{ number_format($recurring) }}</h2>
                        <p>Annual / monthly / weekly</p>
                    </div>
                </div>

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
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Days</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($holidays as $i => $holiday)
                                                @php
                                                    $today = now()->format('Y-m-d');
                                                    $start = \Carbon\Carbon::parse($holiday->start_date);
                                                    $end   = \Carbon\Carbon::parse($holiday->end_date);
                                                    $days  = $start->diffInDays($end) + 1;
                                                    if ($holiday->end_date < $today) {
                                                        $state = ['past', 'Past'];
                                                    } elseif ($holiday->start_date > $today) {
                                                        $state = ['upcoming', 'Upcoming'];
                                                    } else {
                                                        $state = ['ongoing', 'Ongoing'];
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>{{ $holidays->firstItem() + $i }}</td>
                                                    <td><strong>{{ $holiday->title }}</strong></td>
                                                    <td>{{ $start->format('d M Y') }}</td>
                                                    <td>{{ $end->format('d M Y') }}</td>
                                                    <td>{{ $days }}</td>
                                                    <td>
                                                        @if($holiday->is_recurring)
                                                            <span class="badge-recurring">{{ ucfirst($holiday->recurring_pattern ?? 'Recurring') }}</span>
                                                        @else
                                                            <span class="badge-onetime">One-time</span>
                                                        @endif
                                                    </td>
                                                    <td><span class="badge-{{ $state[0] }}">{{ $state[1] }}</span></td>
                                                    <td>
                                                        <div style="display:flex; gap:4px;">
                                                            <a href="{{ route('holidays.show', $holiday) }}" class="btn btn-xs btn-success" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('holidays.edit', $holiday) }}" class="btn btn-xs btn-primary" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('holidays.destroy', $holiday) }}" method="POST">
                                                                @csrf @method('DELETE')
                                                                <button class="btn btn-xs btn-danger" title="Delete"
                                                                    onclick="return confirm('Delete this holiday?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted" style="padding:40px;">
                                                        <i class="fa fa-calendar-o fa-3x" style="color:#ddd;"></i>
                                                        <br><br>No holidays added yet.
                                                        <br><a href="{{ route('holidays.create') }}">Add the first holiday</a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($holidays->hasPages())
                                    <div style="margin-top:15px;">{{ $holidays->links() }}</div>
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

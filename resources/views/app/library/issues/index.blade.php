<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <style>
            .filter-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; }
            .filter-card label { font-weight:600; font-size:13px; color:#555; }
            .status-issued   { background:#e8f4fd; color:#3498db; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .status-returned { background:#e6f9ee; color:#27ae60; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .status-overdue  { background:#fdecea; color:#e74c3c; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .status-lost     { background:#f5f5f5; color:#7f8c8d; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
            .status-damaged  { background:#fff8e1; color:#f39c12; padding:3px 9px; border-radius:20px; font-size:12px; font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Book Issue History">
                    <a href="{{ route('library.issues.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Issue Book</a>
                    <a href="{{ route('library.index') }}" style="color:#333;"><i class="fa fa-tachometer"></i> Dashboard</a>
                </x-page-header>

                {{-- Filters --}}
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('library.issues.index') }}">
                        <div class="filter-card">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Member Name</label>
                                        <input type="text" name="member" class="form-control input-sm"
                                            placeholder="Search student/teacher..." value="{{ request('member') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" class="form-control input-sm datepicker"
                                            placeholder="YYYY-MM-DD" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" class="form-control input-sm datepicker"
                                            placeholder="YYYY-MM-DD" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control input-sm">
                                            <option value="">All</option>
                                            <option value="issued"   {{ request('status') === 'issued'   ? 'selected' : '' }}>Issued</option>
                                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                                            <option value="overdue"  {{ request('status') === 'overdue'  ? 'selected' : '' }}>Overdue</option>
                                            <option value="lost"     {{ request('status') === 'lost'     ? 'selected' : '' }}>Lost</option>
                                            <option value="damaged"  {{ request('status') === 'damaged'  ? 'selected' : '' }}>Damaged</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block">
                                                <i class="fa fa-search"></i> Filter
                                            </button>
                                            <a href="{{ route('library.issues.index') }}" class="btn btn-default btn-sm" title="Reset">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered hover-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Book Title</th>
                                                <th>Issued To</th>
                                                <th>Role</th>
                                                <th>Issue Date</th>
                                                <th>Due Date</th>
                                                <th>Return Date</th>
                                                <th>Status</th>
                                                <th>Fine</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($issues as $i => $issue)
                                                @php $isOverdue = $issue->status === 'issued' && $issue->due_date < now()->format('Y-m-d'); @endphp
                                                <tr>
                                                    <td>{{ $issues->firstItem() + $i }}</td>
                                                    <td><strong>{{ $issue->book?->title ?? 'N/A' }}</strong></td>
                                                    <td>{{ $issue->user?->name ?? 'N/A' }}</td>
                                                    <td>{{ ucfirst($issue->user?->role ?? '—') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($issue->due_date)->format('d M Y') }}</td>
                                                    <td>{{ $issue->return_date ? \Carbon\Carbon::parse($issue->return_date)->format('d M Y') : '—' }}</td>
                                                    <td>
                                                        @if($issue->status === 'returned')
                                                            <span class="status-returned">Returned</span>
                                                        @elseif($issue->status === 'lost')
                                                            <span class="status-lost">Lost</span>
                                                        @elseif($issue->status === 'damaged')
                                                            <span class="status-damaged">Damaged</span>
                                                        @elseif($isOverdue)
                                                            <span class="status-overdue">Overdue</span>
                                                        @else
                                                            <span class="status-issued">Issued</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $issue->fine_amount > 0 ? 'PKR '.number_format($issue->fine_amount,2) : '—' }}</td>
                                                    <td>
                                                        <div style="display:flex; gap:4px;">
                                                            <a href="{{ route('library.issues.show', $issue) }}" class="btn btn-xs btn-success" title="View">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            @if($issue->status === 'issued')
                                                                <form action="{{ route('library.issues.return', $issue) }}" method="POST">
                                                                    @csrf @method('PUT')
                                                                    <button class="btn btn-xs btn-primary" title="Mark Returned"
                                                                        onclick="return confirm('Mark this book as returned?')">
                                                                        <i class="fa fa-check"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center text-muted" style="padding:40px;">
                                                        <i class="fa fa-history fa-3x" style="color:#ddd;"></i>
                                                        <br><br>No issue records found.
                                                        @if(request()->hasAny(['member','from_date','to_date','status']))
                                                            <br><a href="{{ route('library.issues.index') }}">Clear filters</a>
                                                        @else
                                                            <br><a href="{{ route('library.issues.create') }}">Issue a book now</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                @if($issues->hasPages())
                                    <div style="margin-top:15px;">{{ $issues->links() }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {
            if ($.fn.datepicker) {
                $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
            }
        });
        </script>
    @endpush
</x-tenant-app-layout>

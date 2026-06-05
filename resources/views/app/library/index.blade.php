<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .lib-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .lib-stat h2 { margin:4px 0; font-size:26px; font-weight:700; }
            .lib-stat p  { margin:0; font-size:13px; color:#777; }
            .lib-stat.blue   { border-top:3px solid #3498db; }
            .lib-stat.green  { border-top:3px solid #27ae60; }
            .lib-stat.orange { border-top:3px solid #f39c12; }
            .lib-stat.red    { border-top:3px solid #e74c3c; }
            .quick-link { display:block; padding:12px 16px; border-radius:5px; margin-bottom:10px; color:#fff; font-weight:600; text-decoration:none; }
            .quick-link:hover { opacity:.88; color:#fff; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Library Management">
                    <a href="{{ route('library.books.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Add Book</a>
                    <a href="{{ route('library.issues.create') }}" style="color:#333;"><i class="fa fa-share"></i> Issue Book</a>
                    <a href="{{ route('library.books.index') }}" style="color:#333;"><i class="fa fa-book"></i> All Books</a>
                    <a href="{{ route('library.issues.index') }}" style="color:#333;"><i class="fa fa-history"></i> Issue History</a>
                </x-page-header>

                {{-- Summary Cards --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="lib-stat blue">
                        <p><i class="fa fa-book"></i> Total Books</p>
                        <h2>{{ number_format($totalBooks) }}</h2>
                        <p>In catalog</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="lib-stat green">
                        <p><i class="fa fa-check-circle"></i> Available</p>
                        <h2>{{ number_format($availableBooks) }}</h2>
                        <p>Ready to issue</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="lib-stat orange">
                        <p><i class="fa fa-share"></i> Currently Issued</p>
                        <h2>{{ number_format($issuedBooks) }}</h2>
                        <p>Books out</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="lib-stat red">
                        <p><i class="fa fa-exclamation-triangle"></i> Overdue</p>
                        <h2>{{ number_format($overdueBooks) }}</h2>
                        <p>Past due date</p>
                    </div>
                </div>

                {{-- Quick Actions + Recent Issues --}}
                <div class="col-lg-4 col-md-12 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Quick Actions</h3>
                        <a href="{{ route('library.issues.create') }}" class="quick-link" style="background:#3498db;">
                            <i class="fa fa-share"></i> Issue a Book
                        </a>
                        <a href="{{ route('library.books.create') }}" class="quick-link" style="background:#27ae60;">
                            <i class="fa fa-plus"></i> Add New Book
                        </a>
                        <a href="{{ route('library.issues.index') }}?status=issued" class="quick-link" style="background:#f39c12;">
                            <i class="fa fa-clock-o"></i> View Issued Books
                        </a>
                        <a href="{{ route('library.issues.index') }}?status=overdue" class="quick-link" style="background:#e74c3c;">
                            <i class="fa fa-exclamation-triangle"></i> Overdue Books
                        </a>
                    </div>
                </div>

                {{-- Recent Issues --}}
                <div class="col-lg-8 col-md-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Recent Book Issues</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Book</th>
                                            <th>Issued To</th>
                                            <th>Issue Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentIssues as $issue)
                                            @php $isOverdue = $issue->status === 'issued' && $issue->due_date < now()->format('Y-m-d'); @endphp
                                            <tr>
                                                <td>{{ $issue->book?->title ?? 'N/A' }}</td>
                                                <td>{{ $issue->user?->name ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($issue->due_date)->format('d M Y') }}</td>
                                                <td>
                                                    @if($issue->status === 'returned')
                                                        <span class="label label-success">Returned</span>
                                                    @elseif($issue->status === 'lost')
                                                        <span class="label label-default">Lost</span>
                                                    @elseif($isOverdue)
                                                        <span class="label label-danger">Overdue</span>
                                                    @else
                                                        <span class="label label-info">Issued</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('library.issues.show', $issue) }}" class="btn btn-xs btn-success" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted" style="padding:30px;">
                                                    <i class="fa fa-book fa-2x" style="color:#ddd;"></i>
                                                    <br>No issues recorded yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Books by Category --}}
                <div class="col-lg-12" style="margin-top:10px;">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Books by Category</h1>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Total Books</th>
                                            <th>Available</th>
                                            <th>Issued</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($byCategory as $cat)
                                            <tr>
                                                <td>{{ $cat->category ?: 'Uncategorized' }}</td>
                                                <td>{{ $cat->total }}</td>
                                                <td><span class="text-success">{{ $cat->available }}</span></td>
                                                <td>{{ $cat->total - $cat->available }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted" style="padding:30px;">
                                                    No books in catalog yet.
                                                    <a href="{{ route('library.books.create') }}">Add books</a>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-tenant-app-layout>

<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <style>
            .filter-card { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; }
            .filter-card label { font-weight:600; font-size:13px; color:#555; }
            .rep-stat { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:16px 20px; margin-bottom:20px; text-align:center; }
            .rep-stat h2 { margin:4px 0; font-size:24px; font-weight:700; }
            .rep-stat p  { margin:0; font-size:12px; color:#888; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Library Report">
                    <a href="javascript:window.print()" style="color:#333;"><i class="fa fa-print"></i> Print</a>
                    <a href="#" style="color:#333;"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    <a href="{{ route('reports.index') }}" style="color:#333;"><i class="fa fa-th-large"></i> All Reports</a>
                </x-page-header>

                <div class="col-lg-12">
                    <form method="GET" action="{{ route('reports.library') }}">
                        <div class="filter-card">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>From Date</label>
                                        <input type="text" name="from_date" class="form-control input-sm datepicker" placeholder="YYYY-MM-DD" value="{{ request('from_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>To Date</label>
                                        <input type="text" name="to_date" class="form-control input-sm datepicker" placeholder="YYYY-MM-DD" value="{{ request('to_date') }}">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control input-sm">
                                            <option value="">All</option>
                                            <option value="issued"   {{ request('status') === 'issued'   ? 'selected' : '' }}>Issued</option>
                                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                                            <option value="overdue"  {{ request('status') === 'overdue'  ? 'selected' : '' }}>Overdue</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div style="display:flex; gap:6px;">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-search"></i> Generate</button>
                                            <a href="{{ route('reports.library') }}" class="btn btn-default btn-sm" title="Reset"><i class="fa fa-refresh"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #3498db;"><p>Total Books</p><h2>{{ number_format($summary['books']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #27ae60;"><p>Issued</p><h2>{{ number_format($summary['issued']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #16a085;"><p>Returned</p><h2>{{ number_format($summary['returned']) }}</h2></div></div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"><div class="rep-stat" style="border-top:3px solid #e74c3c;"><p>Overdue</p><h2>{{ number_format($summary['overdue']) }}</h2></div></div>

                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd"><div class="main-sparkline13-hd"><h1>Most Issued Books</h1></div></div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr><th>Book</th><th>Author</th><th>Category</th><th>Times Issued</th></tr>
                                    </thead>
                                    <tbody>
                                        @forelse($mostIssued as $row)
                                            <tr>
                                                <td><strong>{{ $row->title }}</strong></td>
                                                <td>{{ $row->author ?? '—' }}</td>
                                                <td>{{ $row->category ?? '—' }}</td>
                                                <td><span class="badge badge-info">{{ $row->times }}</span></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-center text-muted" style="padding:30px;">
                                                <i class="fa fa-book fa-2x" style="color:#ddd;"></i><br>No issue records match the selected filters.
                                            </td></tr>
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

    @push('js')
        <script>
        $(document).ready(function () {
            if ($.fn.datepicker) { $('.datepicker').datepicker({ format: 'yyyy-mm-dd', autoclose: true }); }
        });
        </script>
    @endpush
</x-tenant-app-layout>

<x-tenant-app-layout>
    @push('css')
        <style>
            .report-card {
                display:block; background:#fff; border:1px solid #e0e0e0; border-radius:8px;
                padding:24px 22px; margin-bottom:24px; text-decoration:none; color:inherit;
                transition:all .15s ease; height:100%;
            }
            .report-card:hover { box-shadow:0 6px 18px rgba(0,0,0,.08); transform:translateY(-2px); color:inherit; text-decoration:none; }
            .report-icon { width:54px; height:54px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:24px; color:#fff; margin-bottom:14px; }
            .report-card h3 { margin:0 0 6px; font-size:17px; font-weight:700; color:#2c3e50; }
            .report-card p  { margin:0; font-size:13px; color:#888; line-height:1.5; }
            .report-card .go { margin-top:14px; font-size:13px; font-weight:600; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Reports & Analytics" />

                <div class="col-lg-12" style="margin-bottom:8px;">
                    <p class="text-muted" style="font-size:14px;">
                        Generate and export reports across all modules. Select a report category below to view detailed insights.
                    </p>
                </div>

                @php
                    $reports = [
                        ['students',   'Student Report',     'fa-users',            '#3498db', 'Enrollment by class, section, gender and status.'],
                        ['attendance', 'Attendance Report',  'fa-calendar-check-o', '#27ae60', 'Daily and monthly attendance summaries and trends.'],
                        ['fees',       'Fee Collection',     'fa-money',            '#16a085', 'Collected, outstanding and defaulter breakdowns.'],
                        ['exams',      'Exam Results',       'fa-bar-chart',        '#8e44ad', 'Pass rates, grade distribution and toppers.'],
                        ['library',    'Library Report',     'fa-book',             '#e67e22', 'Issued, returned and overdue book statistics.'],
                        ['inventory',  'Inventory Report',   'fa-cubes',            '#e74c3c', 'Stock levels, low-stock and movement history.'],
                    ];
                @endphp

                @foreach($reports as [$route, $title, $icon, $color, $desc])
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <a href="{{ route('reports.' . $route) }}" class="report-card">
                            <div class="report-icon" style="background:{{ $color }};">
                                <i class="fa {{ $icon }}"></i>
                            </div>
                            <h3>{{ $title }}</h3>
                            <p>{{ $desc }}</p>
                            <div class="go" style="color:{{ $color }};">View Report <i class="fa fa-arrow-right"></i></div>
                        </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-tenant-app-layout>

<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $profile = $student->studentProfile;
        $className = $profile->class->name ?? '—';
        $sectionName = $profile->section->name ?? '—';
        $fmt = fn ($n) => rtrim(rtrim(number_format($n, 2), '0'), '.');
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-trophy"></i> {{ $exam->name }}
                </h3>
                <small class="text-muted">
                    Mark Sheet &middot;
                    {{ $exam->start_date ? \Carbon\Carbon::parse($exam->start_date)->format('d M Y') : '' }}
                </small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('student.results') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Results
                </a>
            </div>
        </div>

        {{-- Student / summary cards --}}
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-user"></i> Student</h3>
                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:45%; border-top:none;">Name</th>
                                <td style="border-top:none;">{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <th>Admission No.</th>
                                <td>{{ $profile->admission_no ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Class</th>
                                <td>{{ $className }}</td>
                            </tr>
                            <tr>
                                <th>Section</th>
                                <td>{{ $sectionName }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box text-center">
                            <h2 class="text-info" style="margin:0;">{{ $fmt($summary['total_obtained']) }}<small class="text-muted">/{{ $fmt($summary['total_max']) }}</small></h2>
                            <small class="text-muted">Total Marks</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box text-center">
                            <h2 style="margin:0;" class="{{ $summary['percentage'] < 50 ? 'text-danger' : ($summary['percentage'] < 60 ? 'text-warning' : 'text-success') }}">
                                {{ $summary['percentage'] }}%
                            </h2>
                            <small class="text-muted">Percentage</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box text-center">
                            <h2 class="text-primary" style="margin:0;">{{ $summary['grade'] }}</h2>
                            <small class="text-muted">Overall Grade</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box text-center">
                            @if($summary['passed'])
                                <h2 class="text-success" style="margin:0;">PASS</h2>
                            @else
                                <h2 class="text-danger" style="margin:0;">FAIL</h2>
                            @endif
                            <small class="text-muted">Result</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Subject-wise breakdown --}}
        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-book"></i> Subject-wise Marks</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Subject</th>
                                    <th>Marks Obtained</th>
                                    <th>Max Marks</th>
                                    <th>Passing Marks</th>
                                    <th>Percentage</th>
                                    <th>Grade</th>
                                    <th>Result</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->subject }}</td>
                                        <td>{{ $fmt($row->marks) }}</td>
                                        <td>{{ $fmt($row->max_marks) }}</td>
                                        <td>{{ $fmt($row->pass_marks) }}</td>
                                        <td>{{ $row->percentage }}%</td>
                                        <td><span class="label label-info">{{ $row->grade }}</span></td>
                                        <td>
                                            @if($row->passed)
                                                <span class="label label-success">Pass</span>
                                            @else
                                                <span class="label label-danger">Fail</span>
                                            @endif
                                        </td>
                                        <td>{{ $row->remarks ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="font-weight:bold; background:#f9f9f9;">
                                    <td colspan="2" class="text-right">Total</td>
                                    <td>{{ $fmt($summary['total_obtained']) }}</td>
                                    <td>{{ $fmt($summary['total_max']) }}</td>
                                    <td>—</td>
                                    <td>{{ $summary['percentage'] }}%</td>
                                    <td><span class="label label-info">{{ $summary['grade'] }}</span></td>
                                    <td colspan="2">
                                        @if($summary['passed'])
                                            <span class="label label-success">Pass</span>
                                        @else
                                            <span class="label label-danger">Fail</span>
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>

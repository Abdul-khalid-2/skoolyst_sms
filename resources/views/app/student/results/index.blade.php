<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $profile = $student->studentProfile;
        $className = $profile->class->name ?? '—';
        $sectionName = $profile->section->name ?? '—';
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-trophy"></i> My Results
                </h3>
                <small class="text-muted">{{ $className }} ({{ $sectionName }})</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-list-alt"></i> Published Exams</h3>

                    @if($exams->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-inbox fa-3x" style="display:block; margin-bottom:12px;"></i>
                            No published results are available yet.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Exam</th>
                                        <th>Date</th>
                                        <th>Subjects</th>
                                        <th>Marks</th>
                                        <th>Percentage</th>
                                        <th>Grade</th>
                                        <th>Result</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exams as $row)
                                        <tr>
                                            <td>
                                                <strong>{{ $row->exam->name }}</strong>
                                            </td>
                                            <td>
                                                {{ $row->exam->start_date ? \Carbon\Carbon::parse($row->exam->start_date)->format('d M Y') : '—' }}
                                            </td>
                                            <td>{{ $row->subject_count }}</td>
                                            <td>{{ rtrim(rtrim(number_format($row->total_obtained, 2), '0'), '.') }} / {{ rtrim(rtrim(number_format($row->total_max, 2), '0'), '.') }}</td>
                                            <td>
                                                <span class="{{ $row->percentage < 50 ? 'text-danger' : ($row->percentage < 60 ? 'text-warning' : 'text-success') }}">
                                                    {{ $row->percentage }}%
                                                </span>
                                            </td>
                                            <td><span class="label label-info">{{ $row->grade }}</span></td>
                                            <td>
                                                @if($row->passed)
                                                    <span class="label label-success">Pass</span>
                                                @else
                                                    <span class="label label-danger">Fail</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('student.results.show', $row->exam->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>

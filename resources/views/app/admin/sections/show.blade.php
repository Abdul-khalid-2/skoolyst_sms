<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Breadcrumb & actions --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-sitemap"></i>
                    {{ $section->class->name ?? 'N/A' }} – Section {{ $section->name }}
                    @if($section->trashed())
                        <span class="badge" style="background:#e74c3c; font-size:11px;">Deleted</span>
                    @endif
                </h3>
                <small class="text-muted">Section Detail View</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('admin.academic.sections.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Sections
                </a>
                @if($section->class)
                    <a href="{{ route('admin.academic.classes.show', encrypt($section->class_id)) }}"
                       class="btn btn-default btn-sm">
                        <i class="fa fa-graduation-cap"></i> View Class
                    </a>
                @endif
                @unless($section->trashed())
                    <a href="{{ route('admin.academic.sections.edit', encrypt($section->id)) }}"
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                @endunless
            </div>
        </div>

        <div class="row">

            {{-- ── Section Info Card ──────────────────────────── --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">
                        <i class="fa fa-info-circle"></i> Section Information
                    </h3>
                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:45%; border-top:none;">Class</th>
                                <td style="border-top:none;">{{ $section->class->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Section</th>
                                <td>{{ $section->name }}</td>
                            </tr>
                            <tr>
                                <th>Capacity</th>
                                <td>{{ $section->capacity ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Enrolled</th>
                                <td>
                                    <span class="badge" style="background:#27ae60;">
                                        {{ $section->students->count() }}
                                    </span>
                                    @if($section->capacity)
                                        / {{ $section->capacity }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Occupancy</th>
                                <td>
                                    @php
                                        $pct = $section->capacity
                                            ? round($section->students->count() / $section->capacity * 100)
                                            : 0;
                                        $bar = $pct >= 90 ? 'danger' : ($pct >= 70 ? 'warning' : 'success');
                                    @endphp
                                    <div class="progress" style="margin:4px 0 0; height:14px;">
                                        <div class="progress-bar progress-bar-{{ $bar }}"
                                             style="width:{{ $pct }}%; font-size:11px; line-height:14px;">
                                            {{ $pct }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($section->trashed())
                                        <span class="label label-danger">Deleted</span>
                                    @else
                                        <span class="label label-success">Active</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ── Students Table ─────────────────────────────── --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">
                        <i class="fa fa-users"></i> Students
                        <span class="badge" style="background:#27ae60; margin-left:6px;">
                            {{ $section->students->count() }}
                        </span>
                    </h3>

                    @if($section->students->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No students enrolled in this section yet.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped"
                                   style="margin-bottom:0;">
                                <thead style="background:#f5f5f5;">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Admission No.</th>
                                        <th>Gender</th>
                                        <th>Blood Group</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($section->students as $i => $student)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <i class="fa fa-user text-muted" style="margin-right:4px;"></i>
                                                {{ $student->student->name ?? '—' }}
                                            </td>
                                            <td>
                                                {{ $student->admission_no ?? '—' }}
                                            </td>
                                            <td>
                                                @php $gender = $student->student->gender ?? null; @endphp
                                                @if($gender === 'male')
                                                    <span class="label label-primary">Male</span>
                                                @elseif($gender === 'female')
                                                    <span class="label label-danger">Female</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $student->blood_group ?? '—' }}
                                            </td>
                                            <td>
                                                @php $status = $student->student->status ?? null; @endphp
                                                @if($status === 'active')
                                                    <span class="label label-success">Active</span>
                                                @else
                                                    <span class="label label-default">{{ ucfirst($status ?? 'unknown') }}</span>
                                                @endif
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

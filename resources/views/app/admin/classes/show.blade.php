<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Breadcrumb & actions --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-graduation-cap"></i>
                    {{ $class->name }}
                    @if($class->trashed())
                        <span class="badge" style="background:#e74c3c; font-size:11px;">Deleted</span>
                    @endif
                </h3>
                <small class="text-muted">Class Detail View</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('admin.academic.classes.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Classes
                </a>
                @unless($class->trashed())
                    <a href="{{ route('admin.academic.classes.edit', encrypt($class->id)) }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                @endunless
            </div>
        </div>

        <div class="row">

            {{-- ── Class Info Card ─────────────────────────────── --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">
                        <i class="fa fa-info-circle"></i> Class Information
                    </h3>
                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:45%; border-top:none;">Class Name</th>
                                <td style="border-top:none;">{{ $class->name }}</td>
                            </tr>
                            <tr>
                                <th>Numeric Value</th>
                                <td>{{ $class->numeric_value }}</td>
                            </tr>
                            <tr>
                                <th>Total Sections</th>
                                <td>
                                    <span class="badge" style="background:#2980b9;">
                                        {{ $class->sections->count() }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Students</th>
                                <td>
                                    <span class="badge" style="background:#27ae60;">
                                        {{ $class->sections->sum(fn($s) => $s->students_count ?? 0) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Subjects Assigned</th>
                                <td>
                                    <span class="badge" style="background:#8e44ad;">
                                        {{ $class->classTeachersSubjects->unique('subject_id')->count() }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($class->trashed())
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

            {{-- ── Sections Card ───────────────────────────────── --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">
                        <i class="fa fa-sitemap"></i> Sections
                        <span class="badge" style="background:#2980b9; margin-left:6px;">
                            {{ $class->sections->count() }}
                        </span>
                        @unless($class->trashed())
                            <a href="{{ route('admin.academic.sections.create') }}"
                               class="btn btn-xs btn-primary pull-right"
                               style="margin-top:-2px;">
                                <i class="fa fa-plus"></i> Add Section
                            </a>
                        @endunless
                    </h3>

                    @if($class->sections->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No sections found for this class.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" style="margin-bottom:0;">
                                <thead style="background:#f5f5f5;">
                                    <tr>
                                        <th>#</th>
                                        <th>Section Name</th>
                                        <th>Capacity</th>
                                        <th>Students</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class->sections as $i => $section)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <strong>{{ $class->name }} – {{ $section->name }}</strong>
                                            </td>
                                            <td>{{ $section->capacity ?? '—' }}</td>
                                            <td>
                                                <span class="badge" style="background:#27ae60;">
                                                    {{ $section->students()->count() }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.academic.sections.edit', encrypt($section->id)) }}"
                                                   class="btn btn-xs btn-primary" title="Edit">
                                                    <i class="fa fa-edit"></i>
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

        {{-- ── Teacher–Subject Assignments ─────────────────────── --}}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">
                        <i class="fa fa-book"></i> Subject &amp; Teacher Assignments
                        <span class="badge" style="background:#8e44ad; margin-left:6px;">
                            {{ $class->classTeachersSubjects->count() }}
                        </span>
                    </h3>

                    @if($class->classTeachersSubjects->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No subject assignments found for this class.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped" style="margin-bottom:0;">
                                <thead style="background:#f5f5f5;">
                                    <tr>
                                        <th>#</th>
                                        <th>Subject</th>
                                        <th>Subject Code</th>
                                        <th>Teacher</th>
                                        <th>Teacher Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($class->classTeachersSubjects as $i => $assignment)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                @if($assignment->subject)
                                                    <i class="fa fa-book text-muted" style="margin-right:4px;"></i>
                                                    {{ $assignment->subject->name }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($assignment->subject)
                                                    <span class="label label-default">
                                                        {{ $assignment->subject->code }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($assignment->teacher)
                                                    <i class="fa fa-user text-muted" style="margin-right:4px;"></i>
                                                    {{ $assignment->teacher->name }}
                                                @else
                                                    <span class="text-muted">Not assigned</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $assignment->teacher->email ?? '—' }}
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

    </div>{{-- /container-fluid --}}
</x-tenant-app-layout>

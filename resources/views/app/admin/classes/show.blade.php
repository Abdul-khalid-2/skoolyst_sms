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
                                        {{ $class->subjects->count() }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Class Teacher</th>
                                <td>
                                    @php
                                        $classTeacherNames = $class->classTeacherProfiles
                                            ->map(fn ($p) => $p->teacher?->name)
                                            ->filter()
                                            ->unique()
                                            ->values();
                                    @endphp
                                    @if($classTeacherNames->isNotEmpty())
                                        @foreach($classTeacherNames as $name)
                                            <span class="label label-success" style="margin-right:4px;">
                                                <i class="fa fa-user"></i> {{ $name }}
                                            </span>
                                        @endforeach
                                    @elseif($class->classTeacher)
                                        <span class="label label-success">
                                            <i class="fa fa-user"></i> {{ $class->classTeacher->name }}
                                        </span>
                                    @else
                                        <span class="text-muted">Not assigned</span>
                                    @endif
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

        {{-- ── Curriculum (Subjects Offered) ───────────────────── --}}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">
                        <i class="fa fa-list-alt"></i> Subjects Offered (Curriculum)
                        <span class="badge" style="background:#16a085; margin-left:6px;">
                            {{ $class->subjects->count() }}
                        </span>
                        @unless($class->trashed())
                            <a href="{{ route('admin.academic.subjects.assign') }}#assign-class-subjects"
                               class="btn btn-xs btn-primary pull-right" style="margin-top:-2px;">
                                <i class="fa fa-plus"></i> Manage Subjects
                            </a>
                        @endunless
                    </h3>

                    @if($class->subjects->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No subjects assigned to this class yet.
                        </p>
                    @else
                        <div style="padding: 6px 0;">
                            @foreach($class->subjects as $subject)
                                <span class="label label-info" style="margin:0 4px 6px 0; display:inline-block; font-size:13px; padding:6px 10px;">
                                    <i class="fa fa-book"></i> {{ $subject->name }}
                                    <small style="opacity:.8;">({{ $subject->code }})</small>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Subject & Teacher Assignments (per section) ─────── --}}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title">
                        <i class="fa fa-book"></i> Subject &amp; Teacher Assignments
                        @unless($class->trashed())
                            <span class="pull-right" style="margin-top:-2px;">
                                <a href="{{ route('admin.academic.subjects.assign') }}#assign-class-subjects"
                                   class="btn btn-xs btn-primary">
                                    <i class="fa fa-list-alt"></i> Manage Curriculum
                                </a>
                                <a href="{{ route('admin.academic.subjects.section_teacher') }}"
                                   class="btn btn-xs btn-success">
                                    <i class="fa fa-user-plus"></i> Assign Subject Teachers
                                </a>
                            </span>
                        @endunless
                    </h3>

                    <p class="text-muted" style="margin-bottom:14px; font-size:13px;">
                        Curriculum subjects for each section and the teacher assigned to teach them.
                    </p>

                    @if($class->subjects->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No subjects in this class's curriculum yet.
                            <br><a href="{{ route('admin.academic.subjects.assign') }}#assign-class-subjects">Add subjects to the curriculum</a>
                        </p>
                    @elseif($class->sections->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            This class has no sections yet.
                        </p>
                    @else
                        @foreach($class->sections as $section)
                            <h4 style="font-size:14px; font-weight:700; margin:18px 0 8px;">
                                <i class="fa fa-sitemap text-muted"></i>
                                {{ $class->name }} – {{ $section->name }}
                            </h4>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped" style="margin-bottom:0;">
                                    <thead style="background:#f5f5f5;">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Subject</th>
                                            <th>Subject Code</th>
                                            <th>Teacher</th>
                                            <th>Teacher Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sectionCurriculum[$section->id] as $i => $row)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    <i class="fa fa-book text-muted" style="margin-right:4px;"></i>
                                                    {{ $row['subject']->name }}
                                                </td>
                                                <td>
                                                    <span class="label label-default">{{ $row['subject']->code }}</span>
                                                </td>
                                                <td>
                                                    @forelse($row['teachers'] as $teacher)
                                                        <span style="display:inline-block; margin-right:6px;">
                                                            <i class="fa fa-user text-muted"></i> {{ $teacher->name }}
                                                        </span>
                                                    @empty
                                                        <span class="text-muted">Not assigned</span>
                                                    @endforelse
                                                </td>
                                                <td>
                                                    @forelse($row['teachers'] as $teacher)
                                                        <div>{{ $teacher->email }}</div>
                                                    @empty
                                                        <span class="text-muted">—</span>
                                                    @endforelse
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- /container-fluid --}}
</x-tenant-app-layout>

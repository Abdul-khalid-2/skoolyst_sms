<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-users"></i> My Students
                </h3>
                <small class="text-muted">Students from the classes and sections you teach</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- Summary cards --}}
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-info" style="margin:0;">{{ $stats['students'] }}</h2>
                    <small class="text-muted">Total Students</small>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-primary" style="margin:0;">{{ $stats['classes'] }}</h2>
                    <small class="text-muted">Classes</small>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-success" style="margin:0;">{{ $stats['sections'] }}</h2>
                    <small class="text-muted">Sections</small>
                </div>
            </div>
        </div>

        {{-- Filter + table --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <div class="row" style="margin-bottom: 12px;">
                        <div class="col-md-8">
                            <h3 class="box-title" style="margin:0;"><i class="fa fa-list"></i> Student List</h3>
                        </div>
                        <div class="col-md-4">
                            @if($classes->isNotEmpty())
                                <form method="GET" action="{{ route('teacher.students') }}" class="form-inline text-right">
                                    <select name="class_id" class="form-control input-sm" onchange="this.form.submit()">
                                        <option value="">All Classes</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ (int) $selectedClassId === $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select name="section_id" class="form-control input-sm" onchange="this.form.submit()">
                                        <option value="">All Sections</option>
                                        @foreach($classes as $class)
                                            <optgroup label="{{ $class->name }}">
                                                @foreach($class->sections as $section)
                                                    <option value="{{ $section->id }}" {{ (int) $selectedSectionId === $section->id ? 'selected' : '' }}>
                                                        {{ $section->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @if($selectedClassId || $selectedSectionId)
                                        <a href="{{ route('teacher.students') }}" class="btn btn-default btn-sm">Reset</a>
                                    @endif
                                </form>
                            @endif
                        </div>
                    </div>

                    @if($students->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-inbox fa-3x" style="display:block; margin-bottom:12px;"></i>
                            No students found for your assigned classes.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Admission No</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Gender</th>
                                        <th>Contact</th>
                                        <th>Guardian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $profile)
                                        @php
                                            $user = $profile->student;
                                            $guardian = $user
                                                ? ($user->parents->firstWhere('pivot.is_primary', 1) ?? $user->parents->first())
                                                : null;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if($user && $user->profile_pic)
                                                    <img src="{{ asset('assets/' . $user->profile_pic) }}"
                                                         class="rounded-circle" width="34" height="34"
                                                         style="object-fit:cover; margin-right:6px;" alt="{{ $user->name }}">
                                                @else
                                                    <img src="{{ asset('backend/img/profile/1.jpg') }}"
                                                         class="rounded-circle" width="34" height="34"
                                                         style="object-fit:cover; margin-right:6px;" alt="">
                                                @endif
                                                {{ $user->name ?? '—' }}
                                            </td>
                                            <td>{{ $profile->admission_no ?? '—' }}</td>
                                            <td>{{ $profile->class->name ?? '—' }}</td>
                                            <td>{{ $profile->section->name ?? '—' }}</td>
                                            <td>
                                                @if(($user->gender ?? null) === 'male')
                                                    <span class="label label-primary">Male</span>
                                                @elseif(($user->gender ?? null) === 'female')
                                                    <span class="label label-danger">Female</span>
                                                @else
                                                    <span class="label label-default">{{ ucfirst($user->gender ?? '—') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->phone ?? '—' }}</td>
                                            <td>
                                                @if($guardian)
                                                    {{ $guardian->name }}
                                                    @if($guardian->phone)
                                                        <br><small class="text-muted">{{ $guardian->phone }}</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">—</span>
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

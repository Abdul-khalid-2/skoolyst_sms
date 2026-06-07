<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php
        $profile = $teacher->teacherProfile;
        $emergencyContact = $profile
            ? (is_array($profile->emergency_contact)
                ? implode(', ', array_filter($profile->emergency_contact))
                : $profile->getRawOriginal('emergency_contact'))
            : null;
    @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-id-card"></i> My Profile
                </h3>
                <small class="text-muted">View your personal and professional information</small>
            </div>
        </div>

        <div class="row">

            {{-- Profile Card --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="white-box text-center">
                    @if($teacher->profile_pic)
                        <img src="{{ asset('assets/' . $teacher->profile_pic) }}"
                             class="rounded-circle" width="120" height="120" style="object-fit:cover;" alt="{{ $teacher->name }}">
                    @else
                        <img src="{{ asset('backend/img/profile/1.jpg') }}"
                             class="rounded-circle" width="120" height="120" style="object-fit:cover;" alt="{{ $teacher->name }}">
                    @endif

                    <h3 style="margin-bottom: 2px;">{{ $teacher->name }}</h3>
                    <p class="text-muted" style="margin-bottom: 8px;">
                        @if($profile && $profile->employee_id)
                            Employee ID: {{ $profile->employee_id }}
                        @else
                            Teacher
                        @endif
                    </p>

                    @if($profile && $profile->class_teacher_of && $profile->classTeacherOf)
                        <span class="label label-success">Class Teacher — {{ $profile->classTeacherOf->name }}</span>
                    @endif

                    <hr>

                    <table class="table table-condensed" style="margin-bottom:0; text-align:left;">
                        <tbody>
                            <tr>
                                <th style="width:40%; border-top:none;">Email</th>
                                <td style="border-top:none;">{{ $teacher->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $teacher->phone ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Branch</th>
                                <td>{{ $teacher->branch->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($teacher->status === 'active')
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-default">{{ ucfirst($teacher->status ?? 'Active') }}</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Details --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                {{-- Personal Information --}}
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-user"></i> Personal Information</h3>
                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:35%; border-top:none;">Full Name</th>
                                <td style="border-top:none;">{{ $teacher->name }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>
                                    @if($teacher->gender === 'male')
                                        <span class="label label-primary">Male</span>
                                    @elseif($teacher->gender === 'female')
                                        <span class="label label-danger">Female</span>
                                    @else
                                        <span class="label label-default">{{ ucfirst($teacher->gender ?? '—') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $teacher->dob ? \Carbon\Carbon::parse($teacher->dob)->format('d M Y') : '—' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $teacher->address ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Emergency Contact</th>
                                <td>{{ $emergencyContact ?: '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Professional Information --}}
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-briefcase"></i> Professional Information</h3>

                    @if(!$profile)
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No professional profile has been set up yet.
                        </p>
                    @else
                        <table class="table table-condensed" style="margin-bottom:0;">
                            <tbody>
                                <tr>
                                    <th style="width:35%; border-top:none;">Employee ID</th>
                                    <td style="border-top:none;">{{ $profile->employee_id ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Qualification</th>
                                    <td>{{ $profile->qualification ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Specialization</th>
                                    <td>{{ $profile->specialization ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Experience</th>
                                    <td>{{ $profile->experience_years !== null ? $profile->experience_years . ' year(s)' : '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Joining Date</th>
                                    <td>{{ $profile->joining_date ? \Carbon\Carbon::parse($profile->joining_date)->format('d M Y') : '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Salary Grade</th>
                                    <td>{{ $profile->salary_grade ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Class Teacher</th>
                                    <td>
                                        @if($profile->class_teacher_of && $profile->classTeacherOf)
                                            <span class="label label-success">Yes</span>
                                            &nbsp;<small class="text-muted">{{ $profile->classTeacherOf->name }}</small>
                                        @else
                                            <span class="label label-default">No</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($profile->bio)
                                <tr>
                                    <th>Bio</th>
                                    <td>{{ $profile->bio }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- Assigned Subjects & Classes --}}
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-book"></i> Teaching Assignments</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-muted"><i class="fa fa-flask"></i> Subjects</h5>
                            @forelse($teacher->teacherSubjects as $subject)
                                <span class="label label-info" style="display:inline-block; margin:2px;">{{ $subject->name }}</span>
                            @empty
                                <p class="text-muted">No subjects assigned.</p>
                            @endforelse
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted"><i class="fa fa-graduation-cap"></i> Classes</h5>
                            @forelse($teacher->allAssignedClasses() as $class)
                                <span class="label label-primary" style="display:inline-block; margin:2px;">{{ $class->name }}</span>
                            @empty
                                <p class="text-muted">No classes assigned.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Subject allocations (class + section + subject) --}}
                <div class="white-box">
                    <h3 class="box-title">
                        <i class="fa fa-list-alt"></i> My Subject Allocations
                        <span class="badge" style="background:#16a085; margin-left:6px;">
                            {{ $teacher->subjectAllocations->count() }}
                        </span>
                    </h3>

                    @if($teacher->subjectAllocations->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            You have not been allocated any subjects yet.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="margin-bottom:0;">
                                <thead style="background:#f5f5f5;">
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Subject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teacher->subjectAllocations->sortBy(fn ($a) => [$a->class?->name, $a->section?->name]) as $i => $alloc)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $alloc->class?->name ?? '—' }}</td>
                                            <td>{{ $alloc->section?->name ?? '—' }}</td>
                                            <td>
                                                <i class="fa fa-book text-muted"></i>
                                                {{ $alloc->subject?->name ?? '—' }}
                                                @if($alloc->subject)
                                                    <span class="label label-default">{{ $alloc->subject->code }}</span>
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

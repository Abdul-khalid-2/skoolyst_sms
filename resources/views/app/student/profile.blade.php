<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $profile = $student->studentProfile; @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-id-card"></i> My Profile
                </h3>
                <small class="text-muted">View your personal and academic information</small>
            </div>
        </div>

        <div class="row">

            {{-- Profile Card --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="white-box text-center">
                    @if($student->profile_pic)
                        <img src="{{ asset('assets/' . $student->profile_pic) }}"
                             class="rounded-circle" width="120" height="120" alt="{{ $student->name }}">
                    @else
                        <img src="{{ asset('backend/img/profile/1.jpg') }}"
                             class="rounded-circle" width="120" height="120" alt="{{ $student->name }}">
                    @endif

                    <h3 style="margin-bottom: 2px;">{{ $student->name }}</h3>
                    <p class="text-muted" style="margin-bottom: 8px;">
                        @if($profile && $profile->admission_no)
                            Admission No: {{ $profile->admission_no }}
                        @else
                            Student
                        @endif
                    </p>

                    @if($profile)
                        <span class="label label-info">{{ $profile->class->name ?? 'No Class' }}</span>
                        <span class="label label-default">{{ $profile->section->name ?? 'No Section' }}</span>
                    @endif

                    <hr>

                    <table class="table table-condensed" style="margin-bottom:0; text-align:left;">
                        <tbody>
                            <tr>
                                <th style="width:40%; border-top:none;">Email</th>
                                <td style="border-top:none;">{{ $student->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $student->phone ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Branch</th>
                                <td>{{ $student->branch->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($student->status === 'active')
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-default">{{ ucfirst($student->status ?? 'Active') }}</span>
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
                                <td style="border-top:none;">{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>
                                    @if($student->gender === 'male')
                                        <span class="label label-primary">Male</span>
                                    @elseif($student->gender === 'female')
                                        <span class="label label-danger">Female</span>
                                    @else
                                        <span class="label label-default">{{ ucfirst($student->gender ?? '—') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M Y') : '—' }}</td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td>{{ $profile->blood_group ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $student->address ?? '—' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Academic Information --}}
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Academic Information</h3>

                    @if(!$profile)
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No academic profile has been set up yet.
                        </p>
                    @else
                        <table class="table table-condensed" style="margin-bottom:0;">
                            <tbody>
                                <tr>
                                    <th style="width:35%; border-top:none;">Admission No.</th>
                                    <td style="border-top:none;">{{ $profile->admission_no ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Admission Date</th>
                                    <td>{{ $profile->admission_date ? \Carbon\Carbon::parse($profile->admission_date)->format('d M Y') : '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Class</th>
                                    <td>{{ $profile->class->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Section</th>
                                    <td>{{ $profile->section->name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Previous School</th>
                                    <td>{{ $profile->previous_school ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>ID Card</th>
                                    <td>
                                        @if($profile->id_card_issued)
                                            <span class="label label-success">Issued</span>
                                            @if($profile->id_card_number)
                                                &nbsp;<small class="text-muted">{{ $profile->id_card_number }}</small>
                                            @endif
                                        @else
                                            <span class="label label-default">Not Issued</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- Guardian / Parent Information --}}
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-users"></i> Guardian Information</h3>

                    @if($student->parents->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-user-times fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No guardian linked to your account.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed" style="margin-bottom:0;">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Relationship</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Primary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($student->parents as $parent)
                                        <tr>
                                            <td>{{ $parent->name }}</td>
                                            <td>{{ ucfirst($parent->pivot->relationship ?? '—') }}</td>
                                            <td>{{ $parent->phone ?? '—' }}</td>
                                            <td>{{ $parent->email }}</td>
                                            <td>
                                                @if($parent->pivot->is_primary)
                                                    <span class="label label-success">Yes</span>
                                                @else
                                                    <span class="label label-default">No</span>
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

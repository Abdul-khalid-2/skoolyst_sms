<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-user-circle"></i> {{ $student->name }}
                </h3>
                <small class="text-muted">Student Profile</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard.students') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('admin.edit.student', $student->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="row">

            {{-- Personal Info --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-user"></i> Personal Information</h3>

                    <div class="text-center" style="margin-bottom: 15px;">
                        @if($student->profile_pic)
                            <img src="{{ asset('tenancy/assets/' . $student->profile_pic) }}"
                                 class="rounded-circle" width="80" height="80" alt="{{ $student->name }}">
                        @else
                            <img src="{{ asset('backend/img/profile/1.jpg') }}"
                                 class="rounded-circle" width="80" height="80" alt="{{ $student->name }}">
                        @endif
                    </div>

                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:40%; border-top:none;">Name</th>
                                <td style="border-top:none;">{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $student->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $student->phone ?? '—' }}</td>
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
                                <th>Address</th>
                                <td>{{ $student->address ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($student->status === 'active')
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-default">{{ ucfirst($student->status ?? '—') }}</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Academic Info --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-graduation-cap"></i> Academic Information</h3>

                    @php $profile = $student->studentProfile; @endphp

                    @if(!$profile)
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No academic profile found for this student.
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
                                    <th>Blood Group</th>
                                    <td>{{ $profile->blood_group ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Previous School</th>
                                    <td>{{ $profile->previous_school ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Medical History</th>
                                    <td>{{ $profile->medical_history ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Transport Details</th>
                                    <td>{{ $profile->transport_details ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Hobbies</th>
                                    <td>{{ $profile->hobbies ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Awards</th>
                                    <td>{{ $profile->awards ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>ID Card Issued</th>
                                    <td>
                                        @if($profile->id_card_issued)
                                            <span class="label label-success">Yes</span>
                                            @if($profile->id_card_number)
                                                &nbsp;<small class="text-muted">{{ $profile->id_card_number }}</small>
                                            @endif
                                        @else
                                            <span class="label label-default">No</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-tenant-app-layout>

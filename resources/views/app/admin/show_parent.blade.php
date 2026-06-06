<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-user-circle"></i> {{ $parent->name }}
                </h3>
                <small class="text-muted">Parent / Guardian Profile</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard.parents') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
                <a href="{{ route('admin.edit.parent', $parent->id) }}" class="btn btn-primary btn-sm">
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
                        @if($parent->profile_pic)
                            <img src="{{ asset('assets/' . $parent->profile_pic) }}"
                                 class="rounded-circle" width="80" height="80" alt="{{ $parent->name }}">
                        @else
                            <img src="{{ asset('backend/img/profile/1.jpg') }}"
                                 class="rounded-circle" width="80" height="80" alt="{{ $parent->name }}">
                        @endif
                    </div>

                    <table class="table table-condensed" style="margin-bottom:0;">
                        <tbody>
                            <tr>
                                <th style="width:40%; border-top:none;">Name</th>
                                <td style="border-top:none;">{{ $parent->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $parent->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $parent->phone ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td>
                                    @if($parent->gender === 'male')
                                        <span class="label label-primary">Male</span>
                                    @elseif($parent->gender === 'female')
                                        <span class="label label-danger">Female</span>
                                    @else
                                        <span class="label label-default">{{ ucfirst($parent->gender ?? '—') }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $parent->address ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($parent->status === 'active')
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-default">{{ ucfirst($parent->status ?? '—') }}</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Family Info --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-users"></i> Family Information</h3>

                    @php $profile = $parent->parentProfile; @endphp

                    @if(!$profile)
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No profile details found for this parent.
                        </p>
                    @else
                        <table class="table table-condensed" style="margin-bottom:0;">
                            <tbody>
                                <tr>
                                    <th style="width:35%; border-top:none;">Relation Type</th>
                                    <td style="border-top:none;">{{ ucfirst($profile->relation_type ?? '—') }}</td>
                                </tr>
                                <tr>
                                    <th>Primary Contact</th>
                                    <td>
                                        @if($profile->is_primary)
                                            <span class="label label-success">Yes</span>
                                        @else
                                            <span class="label label-default">No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td>{{ $profile->occupation ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Employer</th>
                                    <td>{{ $profile->employer ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Income Range</th>
                                    <td>{{ $profile->income_range ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Education Level</th>
                                    <td>{{ $profile->education_level ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Emergency Contact</th>
                                    <td>{{ $profile->emergency_contact ?? '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>

                {{-- Children --}}
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-child"></i> Children</h3>

                    @if($parent->children->isEmpty())
                        <p class="text-muted text-center" style="padding: 20px 0;">
                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom:8px;"></i>
                            No children linked to this parent.
                        </p>
                    @else
                        <table class="table table-condensed table-hover" style="margin-bottom:0;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Admission No.</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Relationship</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($parent->children as $child)
                                    <tr>
                                        <td>{{ $child->name }}</td>
                                        <td>{{ $child->studentProfile->admission_no ?? '—' }}</td>
                                        <td>{{ $child->studentProfile->class->name ?? '—' }}</td>
                                        <td>{{ $child->studentProfile->section->name ?? '—' }}</td>
                                        <td>{{ ucfirst($child->pivot->relationship ?? '—') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-tenant-app-layout>

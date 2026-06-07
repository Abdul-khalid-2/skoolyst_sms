<x-tenant-app-layout>
    <x-slot name="header"></x-slot>
    
    <div class="single-pro-review-area mt-t-30 mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>All Teachers</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li>
                                        <a href="{{ route('dashboard.teachers') }}" class="btn btn-primary btn-sm" style="color: white">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="profile-info-inner">
                        <div class="profile-img">
                            <img src="{{ asset('assets/'. $teacher->profile_pic) ?? asset('backend/img/product/profile-bg.jpg') }}" alt="Profile Picture">
                        </div>
                        <div class="profile-details-hr">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                    <div class="address-hr">
                                        <p><b>Name</b><br> {{ $teacher->name }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                    <div class="address-hr tb-sm-res-d-n dps-tb-ntn">
                                        <p><b>Role</b><br> {{ ucfirst($teacher->role) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                    <div class="address-hr">
                                        <p><b>Email ID</b><br> {{ $teacher->email }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6">
                                    <div class="address-hr tb-sm-res-d-n dps-tb-ntn">
                                        <p><b>Phone</b><br> {{ $teacher->phone }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="address-hr">
                                        <p><b>Address</b><br> {{ $teacher->address ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="address-hr">
                                        <p><b>Gender</b><br> {{ ucfirst($teacher->gender) }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="address-hr">
                                        <p><b>DOB</b><br> {{ $teacher->dob }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <div class="address-hr">
                                        <p><b>Employee ID</b><br> {{ $teacher->teacherProfile->employee_id ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-info-inner">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="address-hr">
                                    <p><b>Signatrue</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="profile-img">
                            <img src="{{ asset('assets/'. $teacher->teacherProfile->signature) ?? asset('backend/img/product/profile-bg.jpg') }}" alt="Profile Picture">
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="product-payment-inner-st res-mg-t-30 analysis-progrebar-ctn">
                        <ul id="myTabedu1" class="tab-review-design">
                            {{-- <li class=""><a href="#description">Activity</a></li> --}}
                            <li class="active"><a href="#reviews"> Biography</a></li>
                        </ul>
                        <div id="myTabContent" class="tab-content custom-product-edit">
                            <div class="product-tab-list tab-pane fade" id="description">
                                <!-- Activity content would go here -->
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <p>Activity feed would be displayed here.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-tab-list tab-pane fade active in" id="reviews">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="review-content-section">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                    <div class="address-hr biography">
                                                        <p><b>Qualification</b><br> {{ $teacher->teacherProfile->qualification ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                    <div class="address-hr biography">
                                                        <p><b>Specialization</b><br> {{ $teacher->teacherProfile->specialization ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                    <div class="address-hr biography">
                                                        <p><b>Experience</b><br> {{ $teacher->teacherProfile->experience_years ?? '0' }} years</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                    <div class="address-hr biography">
                                                        <p><b>Joining Date</b><br> {{ $teacher->teacherProfile->joining_date ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="content-profile">
                                                        <h4>Bio</h4>
                                                        <p>{{ $teacher->teacherProfile->bio ?? 'No bio available' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mg-b-15">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="skill-title">
                                                                <h2>Professional Details</h2>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="address-hr biography">
                                                                <p><b>Salary Grade</b><br> {{ $teacher->teacherProfile->salary_grade ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="address-hr biography">
                                                                <p><b>Current Salary</b><br> {{ $teacher->teacherProfile->current_salary ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="address-hr biography">
                                                                <p><b>Emergency Contact</b><br> {{ $teacher->teacherProfile->emergency_contact ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="address-hr biography">
                                                                <p><b>Bank Details</b><br> {{ $teacher->teacherProfile->bank_details ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="address-hr biography">
                                                                <p><b>Class Teacher</b><br>
                                                                    @if($teacher->teacherProfile->class_teacher_of && $teacher->teacherProfile->classTeacherOf)
                                                                        Yes — {{ $teacher->teacherProfile->classTeacherOf->name }}
                                                                    @else
                                                                        No
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- Subjects -->
                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="skill-title">
                                                        <h2>Subjects</h2>
                                                        <hr>
                                                    </div>
                                                    <div class="ex-pro">
                                                        @if(count($teacher->teacherSubjects) > 0)
                                                            <ul>
                                                                @foreach($teacher->teacherSubjects as $subject)
                                                                    <li><i class="fa fa-angle-right"></i> {{ $subject->name }} (Code: {{ $subject->code }})</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <p>No subjects assigned yet.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="skill-title">
                                                        <h2>Classes</h2>
                                                        <hr>
                                                    </div>
                                                    <div class="ex-pro">
                                                        @php $assignedClasses = $teacher->allAssignedClasses(); @endphp
                                                        @if($assignedClasses->count() > 0)
                                                            <ul>
                                                                @foreach($assignedClasses as $teacherClass)
                                                                    <li><i class="fa fa-angle-right"></i> {{ $teacherClass->name }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <p>No classes assigned yet.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            

                                            <div class="row">
                                                <!-- All Assigned Classes -->
                                                <!-- Current Subjects -->
                                                <div class="col-xs-12 col-sm-12">
                                                    <div class="skill-title">
                                                        <h2>Current Subjects</h2>
                                                        <hr>
                                                    </div>
                                                    <div class="ex-pro">
                                                        @if(count($teacher->timeTables) > 0)
                                                            <ul>
                                                                @foreach($teacher->timeTables as $teacherSubjects)
                                                                    <li><i class="fa fa-angle-right"></i> {{ $teacherSubjects->subject->name }} ({{ $teacherSubjects->subject->code }}) - In  {{ $teacherSubjects->class->name }} ({{ $teacherSubjects->section->name }})</li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <p>No subjects assigned yet.</p>
                                                        @endif
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                {{-- Subject Allocations (class + section + subject) --}}
                                                <div class="col-xs-12 col-sm-12">
                                                    <div class="skill-title">
                                                        <h2>Subject Allocations</h2>
                                                        <hr>
                                                    </div>
                                                    <div class="ex-pro">
                                                        @if(count($teacher->subjectAllocations) > 0)
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
                                                                        @foreach($teacher->subjectAllocations->sortBy(fn ($a) => [$a->class?->name, $a->section?->name]) as $alloc)
                                                                            <tr>
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                <td>{{ $alloc->class?->name ?? '—' }}</td>
                                                                                <td>{{ $alloc->section?->name ?? '—' }}</td>
                                                                                <td>{{ $alloc->subject?->name ?? '—' }} @if($alloc->subject)({{ $alloc->subject->code }})@endif</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <p>No subject allocations yet.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



             

            </div>
        </div>
    </div>    
</x-tenant-app-layout>

@php
    $teacherRole = old('role', $teacher->roles->pluck('name')->intersect(['admin', 'teacher'])->first() ?? ($teacher->role === 'admin' ? 'admin' : 'teacher'));
@endphp

<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <style>
            .req { color: #e74c3c; }
            .form-group-inner.has-error .form-control,
            .form-group-inner.has-error select,
            .form-group-inner.has-error textarea {
                border-color: #e74c3c;
            }
            .teacher-form-alert { margin-bottom: 15px; }
            .current-file-preview {
                max-height: 100px;
                margin-bottom: 10px;
                border-radius: 6px;
                border: 1px solid #ddd;
            }
        </style>
    @endpush

    <x-slot name="header"></x-slot>

    <div class="advanced-form-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <x-page-header
                    title="Update Teacher Information"
                    :back-route="route('dashboard.teachers')"
                />

                @if($errors->any())
                    <div class="col-lg-12 teacher-form-alert">
                        <div class="alert alert-danger">
                            <strong><i class="fa fa-exclamation-circle"></i> Please fix the following errors:</strong>
                            <ul style="margin: 8px 0 0; padding-left: 18px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="col-lg-12 teacher-form-alert">
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    </div>
                @endif

                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="sparkline12-list">
                        <div class="sparkline12-graph">
                            <div class="basic-login-form-ad">
                                <form id="teacherForm" method="POST" action="{{ route('admin.update.teacher', $teacher->id) }}" enctype="multipart/form-data" novalidate>
                                    @csrf
                                    @method('PUT')

                                    {{-- Personal Information --}}
                                    <div class="all-form-element-inner">
                                        <div class="section-headline"><h3>Personal Information</h3></div>

                                        @if($teacher->profile_pic)
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Current Profile</label></div>
                                                    <div class="col-lg-8">
                                                        <img src="{{ asset('assets/'. $teacher->profile_pic) }}" class="current-file-preview" alt="Current profile">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group-inner @error('profile_pic') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Update Profile Image</label></div>
                                                <div class="col-lg-8">
                                                    <input type="file" class="form-control" name="profile_pic" accept="image/*">
                                                    <small class="text-muted">Leave empty to keep the current photo.</small>
                                                    @error('profile_pic')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('name') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Full Name <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="name" value="{{ old('name', $teacher->name) }}" required>
                                                    @error('name')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('email') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Email <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <input type="email" class="form-control" name="email" value="{{ old('email', $teacher->email) }}" required>
                                                    @error('email')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('phone') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Phone Number <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $teacher->phone) }}" required>
                                                    @error('phone')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('address') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Address <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <textarea class="form-control" name="address" required>{{ old('address', $teacher->address) }}</textarea>
                                                    @error('address')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('gender') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Gender <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <select class="form-control" name="gender" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                                        <option value="other" {{ old('gender', $teacher->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                                    </select>
                                                    @error('gender')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('dob') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Date of Birth <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" name="dob" readonly class="form-control" value="{{ old('dob', $teacher->dob) }}" required>
                                                    </div>
                                                    @error('dob')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('role') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Role <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <select name="role" class="form-control" required>
                                                        <option value="">Select Role</option>
                                                        <option value="teacher" {{ $teacherRole == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                                        <option value="admin" {{ $teacherRole == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                    @error('role')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Professional Information --}}
                                    <div class="all-form-element-inner">
                                        <div class="section-headline"><h3>Professional Information</h3></div>

                                        <div class="form-group-inner @error('employee_id') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Employee ID <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="employee_id" value="{{ old('employee_id', $teacher->teacherProfile->employee_id) }}" required>
                                                    @error('employee_id')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('qualification') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Qualification <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="qualification" value="{{ old('qualification', $teacher->teacherProfile->qualification) }}" required>
                                                    @error('qualification')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('specialization') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Specialization <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="specialization" value="{{ old('specialization', $teacher->teacherProfile->specialization) }}" required>
                                                    @error('specialization')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('experience_years') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Years of Experience <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <input type="number" class="form-control" name="experience_years" min="0" value="{{ old('experience_years', $teacher->teacherProfile->experience_years) }}" required>
                                                    @error('experience_years')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('joining_date') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Joining Date <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" name="joining_date" readonly class="form-control" value="{{ old('joining_date', $teacher->teacherProfile->joining_date) }}" required>
                                                    </div>
                                                    @error('joining_date')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('base_salary') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Base Salary</label></div>
                                                <div class="col-lg-8">
                                                    <input type="number" step="0.01" min="0" class="form-control" name="base_salary" value="{{ old('base_salary', $teacher->teacherProfile->base_salary) }}" placeholder="Optional">
                                                    @error('base_salary')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('current_salary') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Current Salary</label></div>
                                                <div class="col-lg-8">
                                                    <input type="number" step="0.01" min="0" class="form-control" name="current_salary" value="{{ old('current_salary', $teacher->teacherProfile->current_salary) }}" placeholder="Optional">
                                                    @error('current_salary')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('last_increment_date') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Last Increment Date</label></div>
                                                <div class="col-lg-8">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input type="text" name="last_increment_date" readonly class="form-control" value="{{ old('last_increment_date', $teacher->teacherProfile->last_increment_date) }}">
                                                    </div>
                                                    @error('last_increment_date')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('salary_grade') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Salary Grade</label></div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="salary_grade" value="{{ old('salary_grade', $teacher->teacherProfile->salary_grade) }}" placeholder="e.g. Grade A, Grade B">
                                                    <small class="text-muted">Internal pay-scale label — see guide on the right.</small>
                                                    @error('salary_grade')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('bank_details') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Bank Details</label></div>
                                                <div class="col-lg-8">
                                                    <textarea class="form-control" name="bank_details">{{ old('bank_details', $teacher->teacherProfile->bank_details) }}</textarea>
                                                    @error('bank_details')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('emergency_contact') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Emergency Contact <span class="req">*</span></label></div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="emergency_contact" value="{{ old('emergency_contact', $teacher->teacherProfile->emergency_contact) }}" required>
                                                    @error('emergency_contact')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('bio') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Bio</label></div>
                                                <div class="col-lg-8">
                                                    <textarea class="form-control" name="bio">{{ old('bio', $teacher->teacherProfile->bio) }}</textarea>
                                                    @error('bio')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('social_links') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Social Links</label></div>
                                                <div class="col-lg-8">
                                                    <input type="text" class="form-control" name="social_links" value="{{ old('social_links', $teacher->teacherProfile->social_links) }}" placeholder="Comma separated links">
                                                    @error('social_links')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('class_teacher_of') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Class Teacher Of</label></div>
                                                <div class="col-lg-8">
                                                    <select class="form-control" name="class_teacher_of">
                                                        <option value="">Select Class</option>
                                                        @foreach($classes as $class)
                                                            <option value="{{ $class->id }}" {{ old('class_teacher_of', $teacher->teacherProfile->class_teacher_of) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('class_teacher_of')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Documents --}}
                                    <div class="all-form-element-inner">
                                        <div class="section-headline"><h3>Documents</h3></div>

                                        @if($teacher->teacherProfile->signature)
                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Current Signature</label></div>
                                                    <div class="col-lg-8">
                                                        <img src="{{ asset('assets/'. $teacher->teacherProfile->signature) }}" class="current-file-preview" alt="Current signature">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group-inner @error('signature') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Update Signature</label></div>
                                                <div class="col-lg-8">
                                                    <input type="file" class="form-control" name="signature" accept="image/*">
                                                    @error('signature')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group-inner @error('documents') has-error @enderror">
                                            <div class="row">
                                                <div class="col-lg-4"><label class="login2">Additional Documents</label></div>
                                                <div class="col-lg-8">
                                                    <input type="file" class="form-control" name="documents[]" multiple>
                                                    @error('documents')<span class="help-block text-danger">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group-inner">
                                        <div class="login-btn-inner">
                                            <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-8">
                                                    <button class="btn btn-sm btn-primary login-submit-cs" type="submit">
                                                        <i class="fa fa-save"></i> Update Teacher
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-5 col-sm-12">
                    <x-teacher-form-guide mode="edit" />
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/datapicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('backend/js/datapicker/datepicker-active.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var form = document.getElementById('teacherForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        if (!form.checkValidity()) {
                            e.preventDefault();
                            var firstInvalid = form.querySelector(':invalid');
                            if (firstInvalid) {
                                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                firstInvalid.focus({ preventScroll: true });
                            }
                            var alertBox = document.querySelector('.teacher-client-alert');
                            if (!alertBox) {
                                alertBox = document.createElement('div');
                                alertBox.className = 'col-lg-12 teacher-form-alert teacher-client-alert';
                                alertBox.innerHTML = '<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> Please fill in all required fields marked with <span class="req">*</span>.</div>';
                                document.querySelector('.container-fluid > .row').prepend(alertBox);
                            }
                        }
                    });

                    form.querySelectorAll('[required]').forEach(function(field) {
                        field.addEventListener('invalid', function() {
                            this.closest('.form-group-inner')?.classList.add('has-error');
                        });
                        field.addEventListener('input', function() {
                            if (this.checkValidity()) {
                                this.closest('.form-group-inner')?.classList.remove('has-error');
                            }
                        });
                    });
                }

                $('input[name="base_salary"]').on('change', function() {
                    var baseSalary = $(this).val();
                    if (baseSalary && !$('input[name="current_salary"]').val()) {
                        $('input[name="current_salary"]').val(baseSalary);
                    }
                });
            });
        </script>
    @endpush
</x-tenant-app-layout>

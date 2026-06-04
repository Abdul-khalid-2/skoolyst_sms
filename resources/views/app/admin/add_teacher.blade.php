<x-tenant-app-layout>
    @push('css')
        <style>
            #profilePicPreview {
                display: none;
                max-height: 120px;
                max-width: 120px;
                margin-bottom: 10px;
                border-radius: 8px;
                object-fit: cover;
                border: 1px solid #ddd;
            }
        </style>
    @endpush
    <x-slot name="header"></x-slot>
        <!-- Advanced Form Start -->
        <div class="advanced-form-area mg-b-15">
           
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="breadcome-list">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="breadcome-heading" style="margin-top: 10px">
                                        <h3>Teacher Registration Form</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <ul class="breadcome-menu">
                                        <li>
                                            <a href="{{ route('dashboard.teachers') }}"
                                                class="btn btn-primary btn-sm" style="color: white">
                                                <i class="fa fa-arrow-left"></i> Back
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline12-list">
                            <div class="sparkline12-graph">
                                <div class="basic-login-form-ad">
                                    <div class="row">
                                        <form id="teacherForm" method="POST" action="{{ route('admin.store.teacher') }}" enctype="multipart/form-data">
                                            @csrf

                                            <!-- Personal Information Section -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="all-form-element-inner">
                                                    <div class="section-headline">
                                                        <h3>Personal Information</h3>
                                                    </div>

                                                    <div class="form-group-inner {{ $errors->has('profile_pic') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Profile Image</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <img id="profilePicPreview" src="" alt="Profile preview">
                                                                <input type="file" id="profile_pic" class="form-control" name="profile_pic" accept="image/*" required/>
                                                                @if($errors->has('profile_pic'))
                                                                    <span class="help-block text-danger">{{ $errors->first('profile_pic') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group-inner {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Full Name*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required />
                                                                @if($errors->has('name'))
                                                                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('email') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Email*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required />
                                                                @if($errors->has('email'))
                                                                    <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('phone') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Phone Number*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required />
                                                                @if($errors->has('phone'))
                                                                    <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('address') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Address*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <textarea class="form-control" name="address" required>{{ old('address') }}</textarea>
                                                                @if($errors->has('address'))
                                                                    <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('gender') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Gender*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <select class="form-control" name="gender" required>
                                                                    <option value="">Select Gender</option>
                                                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                                                </select>
                                                                @if($errors->has('gender'))
                                                                    <span class="help-block text-danger">{{ $errors->first('gender') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('dob') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Date of birth*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input
                                                                    type="date"
                                                                    name="dob"
                                                                    class="form-control @error('dob') is-invalid @enderror"
                                                                    value="{{ old('dob') }}"
                                                                    max="{{ date('Y-m-d') }}"
                                                                    required
                                                                >
                                                                @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group-inner {{ $errors->has('role') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Select Role*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <select name="role" class="form-control" required>
                                                                    <option value="">Select Role</option>
                                                                    <option value="teacher" {{ old('role', 'teacher') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                </select>
                                                                @if($errors->has('role'))
                                                                    <span class="help-block text-danger">{{ $errors->first('role') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        
                                            <!-- Professional Information Section -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="all-form-element-inner">
                                                    <div class="section-headline">
                                                        <h3>Professional Information</h3>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Employee ID*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="employee_id" value="{{ old('employee_id') }}" required />
                                                                @if($errors->has('employee_id'))
                                                                    <span class="help-block text-danger">{{ $errors->first('employee_id') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('qualification') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Qualification*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="qualification" value="{{ old('qualification') }}" required />
                                                                @if($errors->has('qualification'))
                                                                    <span class="help-block text-danger">{{ $errors->first('qualification') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('specialization') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Specialization*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="specialization" value="{{ old('specialization') }}" required />
                                                                @if($errors->has('specialization'))
                                                                    <span class="help-block text-danger">{{ $errors->first('specialization') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('experience_years') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Years of Experience*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="number" class="form-control" name="experience_years" value="{{ old('experience_years') }}" required />
                                                                @if($errors->has('experience_years'))
                                                                    <span class="help-block text-danger">{{ $errors->first('experience_years') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('joining_date') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Joining Date*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input
                                                                    type="date"
                                                                    name="joining_date"
                                                                    class="form-control @error('joining_date') is-invalid @enderror"
                                                                    value="{{ old('joining_date') }}"
                                                                    required
                                                                >
                                                                @error('joining_date') <small class="text-danger">{{ $message }}</small> @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('salary_grade') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Salary Grade</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="salary_grade" value="{{ old('salary_grade') }}" />
                                                                @if($errors->has('salary_grade'))
                                                                    <span class="help-block text-danger">{{ $errors->first('salary_grade') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('bank_details') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Bank Details</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <textarea class="form-control" name="bank_details">{{ old('bank_details') }}</textarea>
                                                                @if($errors->has('bank_details'))
                                                                    <span class="help-block text-danger">{{ $errors->first('bank_details') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('emergency_contact') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Emergency Contact*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="emergency_contact" value="{{ old('emergency_contact') }}" required />
                                                                @if($errors->has('emergency_contact'))
                                                                    <span class="help-block text-danger">{{ $errors->first('emergency_contact') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('bio') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Bio</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <textarea class="form-control" name="bio">{{ old('bio') }}</textarea>
                                                                @if($errors->has('bio'))
                                                                    <span class="help-block text-danger">{{ $errors->first('bio') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('social_links') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Social Links</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="text" class="form-control" name="social_links" value="{{ old('social_links') }}" placeholder="Comma separated links (e.g., facebook.com, twitter.com)" />
                                                                @if($errors->has('social_links'))
                                                                    <span class="help-block text-danger">{{ $errors->first('social_links') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Is Class Teacher</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <div class="bt-df-checkbox">
                                                                    <input type="checkbox" name="is_class_teacher" value="1" id="isClassTeacher" {{ old('is_class_teacher') ? 'checked' : '' }}>
                                                                    <span class="checkmark"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('class_teacher_of') ? 'has-error' : '' }}" id="classTeacherOfContainer" style="display:{{ old('is_class_teacher') ? 'block' : 'none' }};">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Class Teacher Of</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <select class="form-control select2_demo_3" name="class_teacher_of">
                                                                    <option value="">Select Class</option>
                                                                    @foreach($classes as $class)
                                                                        <option value="{{ $class->id }}" {{ old('class_teacher_of') == $class->id ? 'selected' : '' }} >
                                                                            {{ $class->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('class_teacher_of')
                                                                    <span class="help-block text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <!-- Documents Section -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="all-form-element-inner">
                                                    <div class="section-headline">
                                                        <h3>Documents</h3>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('qualification_documents') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Qualifications Documents*</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="file" class="form-control" name="qualification_documents" required />
                                                                @if($errors->has('qualification_documents'))
                                                                    <span class="help-block text-danger">{{ $errors->first('qualification_documents') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('signature') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Signature</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="file" class="form-control" name="signature" />
                                                                @if($errors->has('signature'))
                                                                    <span class="help-block text-danger">{{ $errors->first('signature') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group-inner {{ $errors->has('documents') ? 'has-error' : '' }}">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                                <label class="login2">Other Documents</label>
                                                            </div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <input type="file" class="form-control" name="documents[]" multiple />
                                                                @if($errors->has('documents'))
                                                                    <span class="help-block text-danger">{{ $errors->first('documents') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <!-- Submit Button -->
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group-inner">
                                                    <div class="login-btn-inner">
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                                <div class="login-horizental">
                                                                    <button class="btn btn-sm btn-primary login-submit-cs" type="submit">Register Teacher</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Advanced Form End-->
        </div>
        @push('js')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var profileInput = document.getElementById('profile_pic');
                    var preview = document.getElementById('profilePicPreview');
                    var classTeacherCheckbox = document.getElementById('isClassTeacher');
                    var classTeacherContainer = document.getElementById('classTeacherOfContainer');

                    if (profileInput && preview) {
                        profileInput.addEventListener('change', function() {
                            var file = this.files[0];

                            if (file && file.type.startsWith('image/')) {
                                preview.src = URL.createObjectURL(file);
                                preview.style.display = 'block';
                            } else {
                                preview.src = '';
                                preview.style.display = 'none';
                            }
                        });
                    }

                    if (classTeacherCheckbox && classTeacherContainer) {
                        classTeacherCheckbox.addEventListener('change', function() {
                            classTeacherContainer.style.display = this.checked ? 'block' : 'none';
                        });
                    }
                });
            </script>
        @endpush
</x-tenant-app-layout>
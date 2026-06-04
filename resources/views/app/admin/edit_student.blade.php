<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/touchspin/jquery.bootstrap-touchspin.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/form/themesaller-forms.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/colorpicker/colorpicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/chosen/bootstrap-chosen.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}">
    @endpush

    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading" style="margin-top: 10px">
                                <h3>Edit Student — {{ $student->name }}</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="action-buttons">
                                <a href="{{ route('dashboard.students') }}" class="btn btn-primary btn-sm" style="color: white">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="dropdown-container">
                                <button class="dropdown-toggle-custom">
                                    <i class="fa fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu-custom">
                                    <a href="{{ route('dashboard.students') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <div class="row">
                                <form method="POST" action="{{ route('admin.update.student', $student->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Personal Information --}}
                                    <div class="col-lg-12">
                                        <div class="all-form-element-inner">
                                            <div class="section-headline"><h3>Personal Information</h3></div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Full Name*</label></div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                                               value="{{ old('name', $student->name) }}" required>
                                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Email*</label></div>
                                                    <div class="col-lg-8">
                                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                               value="{{ old('email', $student->email) }}" required>
                                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Phone*</label></div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                                               value="{{ old('phone', $student->phone) }}" required>
                                                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Address*</label></div>
                                                    <div class="col-lg-8">
                                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $student->address) }}</textarea>
                                                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Gender*</label></div>
                                                    <div class="col-lg-8">
                                                        <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                                            <option value="">Select Gender</option>
                                                            @foreach(['male', 'female', 'other'] as $g)
                                                                <option value="{{ $g }}" {{ old('gender', $student->gender) === $g ? 'selected' : '' }}>
                                                                    {{ ucfirst($g) }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Date of Birth*</label></div>
                                                    <div class="col-lg-8">
                                                        <div class="sparkline16-graph">
                                                            <div class="date-picker-inner">
                                                                <div class="form-group data-custon-pick" id="data_1">
                                                                    <div class="input-group date">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        <input type="text" name="dob" readonly
                                                                               class="form-control @error('dob') is-invalid @enderror"
                                                                               value="{{ old('dob', $student->dob ? \Carbon\Carbon::parse($student->dob)->format('Y/m/d') : '') }}" required>
                                                                    </div>
                                                                    @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Student Photo</label></div>
                                                    <div class="col-lg-8">
                                                        @if($student->profile_pic)
                                                            <img src="{{ asset('tenancy/assets/' . $student->profile_pic) }}"
                                                                 class="rounded-circle" width="50" height="50" style="margin-bottom:8px;">
                                                        @endif
                                                        <input type="file" name="student_photo" class="form-control" accept="image/*">
                                                        @error('student_photo') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Academic Information --}}
                                    <div class="col-lg-12">
                                        <div class="all-form-element-inner">
                                            <div class="section-headline"><h3>Academic Information</h3></div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Admission Number*</label></div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="admission_no" class="form-control @error('admission_no') is-invalid @enderror"
                                                               value="{{ old('admission_no', $student->studentProfile->admission_no ?? '') }}" required>
                                                        @error('admission_no') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Admission Date*</label></div>
                                                    <div class="col-lg-8">
                                                        <div class="sparkline16-graph">
                                                            <div class="date-picker-inner">
                                                                <div class="form-group data-custon-pick" id="data_1">
                                                                    <div class="input-group date">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        <input type="text" name="admission_date" readonly
                                                                               class="form-control @error('admission_date') is-invalid @enderror"
                                                                               value="{{ old('admission_date', $student->studentProfile->admission_date ? \Carbon\Carbon::parse($student->studentProfile->admission_date)->format('Y/m/d') : '') }}" required>
                                                                    </div>
                                                                    @error('admission_date') <small class="text-danger">{{ $message }}</small> @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Class*</label></div>
                                                    <div class="col-lg-8">
                                                        <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror" required>
                                                            <option value="">Select Class</option>
                                                            @foreach($classes as $class)
                                                                <option value="{{ $class->id }}"
                                                                    {{ old('class_id', $student->studentProfile->class_id ?? '') == $class->id ? 'selected' : '' }}>
                                                                    {{ $class->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('class_id') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">Section*</label></div>
                                                    <div class="col-lg-8">
                                                        <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror" required>
                                                            <option value="">Select Section</option>
                                                            @if($student->studentProfile && $student->studentProfile->section)
                                                                <option value="{{ $student->studentProfile->section_id }}" selected>
                                                                    {{ $student->studentProfile->section->name }}
                                                                </option>
                                                            @endif
                                                        </select>
                                                        @error('section_id') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            @php
                                                $profile = $student->studentProfile;
                                                $optionalFields = ['previous_school', 'blood_group', 'medical_history', 'transport_details', 'hobbies', 'awards'];
                                            @endphp
                                            @foreach($optionalFields as $field)
                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4"><label class="login2">{{ ucwords(str_replace('_', ' ', $field)) }}</label></div>
                                                        <div class="col-lg-8">
                                                            @if(in_array($field, ['medical_history', 'awards']))
                                                                <textarea name="{{ $field }}" class="form-control">{{ old($field, $profile->$field ?? '') }}</textarea>
                                                            @elseif($field === 'blood_group')
                                                                <select name="blood_group" class="form-control">
                                                                    <option value="">Select Blood Group</option>
                                                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $group)
                                                                        <option value="{{ $group }}"
                                                                            {{ old('blood_group', $profile->blood_group ?? '') === $group ? 'selected' : '' }}>
                                                                            {{ $group }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <input type="text" name="{{ $field }}" class="form-control"
                                                                       value="{{ old($field, $profile->$field ?? '') }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- ID Card --}}
                                    <div class="col-lg-12">
                                        <div class="all-form-element-inner">
                                            <div class="section-headline"><h3>ID Card</h3></div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">ID Card Issued</label></div>
                                                    <div class="col-lg-8">
                                                        <input type="checkbox" name="id_card_issued" value="1"
                                                               {{ old('id_card_issued', $profile->id_card_issued ?? false) ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group-inner">
                                                <div class="row">
                                                    <div class="col-lg-4"><label class="login2">ID Card Number</label></div>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="id_card_number" class="form-control"
                                                               value="{{ old('id_card_number', $profile->id_card_number ?? '') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="col-lg-12">
                                        <div class="form-group-inner">
                                            <div class="row">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-8">
                                                    <div class="login-horizental">
                                                        <button type="submit" class="btn btn-sm btn-primary login-submit-cs">
                                                            <i class="fa fa-save"></i> Update Student
                                                        </button>
                                                        <a href="{{ route('dashboard.students') }}" class="btn btn-sm btn-default" style="margin-left:8px;">
                                                            Cancel
                                                        </a>
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

    @push('js')
        <script src="{{ asset('backend/js/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ asset('backend/js/touchspin/touchspin-active.js') }}"></script>
        <script src="{{ asset('backend/js/colorpicker/jquery.spectrum.min.js') }}"></script>
        <script src="{{ asset('backend/js/colorpicker/color-picker-active.js') }}"></script>
        <script src="{{ asset('backend/js/datapicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('backend/js/datapicker/datepicker-active.js') }}"></script>
        <script src="{{ asset('backend/js/input-mask/jasny-bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/js/chosen/chosen.jquery.js') }}"></script>
        <script src="{{ asset('backend/js/chosen/chosen-active.js') }}"></script>
        <script src="{{ asset('backend/js/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('backend/js/select2/select2-active.js') }}"></script>
        <script src="{{ asset('backend/js/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>
        <script src="{{ asset('backend/js/ionRangeSlider/ion.rangeSlider.active.js') }}"></script>
        <script src="{{ asset('backend/js/rangle-slider/jquery-ui-1.10.4.custom.min.js') }}"></script>
        <script src="{{ asset('backend/js/rangle-slider/jquery-ui-touch-punch.min.js') }}"></script>
        <script src="{{ asset('backend/js/rangle-slider/rangle-active.js') }}"></script>
        <script src="{{ asset('backend/js/knob/jquery.knob.js') }}"></script>
        <script src="{{ asset('backend/js/knob/knob-active.js') }}"></script>
        <script src="{{ asset('backend/js/tab.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Pre-load sections for the selected class
                var initialClassId = $('#class_id').val();
                var initialSectionId = {{ $student->studentProfile->section_id ?? 'null' }};

                if (initialClassId) {
                    loadSections(initialClassId, initialSectionId);
                }

                $('#class_id').on('change', function() {
                    loadSections($(this).val(), null);
                });

                function loadSections(classId, selectedId) {
                    $('#section_id').html('<option value="">Loading...</option>');
                    if (!classId) {
                        $('#section_id').html('<option value="">Select Section</option>');
                        return;
                    }
                    $.ajax({
                        url: '/get-sections/' + classId,
                        type: 'GET',
                        success: function(data) {
                            $('#section_id').empty().append('<option value="">Select Section</option>');
                            $.each(data, function(id, name) {
                                var selected = (selectedId && id == selectedId) ? ' selected' : '';
                                $('#section_id').append('<option value="' + id + '"' + selected + '>' + name + '</option>');
                            });
                        },
                        error: function() {
                            $('#section_id').html('<option value="">Error loading sections</option>');
                        }
                    });
                }
            });
        </script>
    @endpush
</x-tenant-app-layout>

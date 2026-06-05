<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/chosen/bootstrap-chosen.css') }}">
    @endpush
    <x-slot name="header"></x-slot>

    <div class="advanced-form-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header
                    title="Edit Subject"
                    :back-route="route('admin.academic.subjects.index')"
                />

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list">
                        <div class="sparkline12-graph">
                            <div class="basic-login-form-ad">
                                <div class="row">
                                    <form method="POST" action="{{ route('admin.academic.subjects.update', $subject->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="all-form-element-inner">

                                                <div class="form-group-inner {{ $errors->has('name') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Subject Name <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="name"
                                                                   value="{{ old('name', $subject->name) }}" required />
                                                            @error('name')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner {{ $errors->has('code') ? 'has-error' : '' }}">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Subject Code <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <input type="text" class="form-control" name="code"
                                                                   value="{{ old('code', $subject->code) }}" required />
                                                            @error('code')
                                                                <span class="help-block text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Assigned Class <small class="text-muted">(Optional)</small></label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <select class="form-control" name="class_id" id="subject_class_id">
                                                                <option value="">-- All Classes (School-wide) --</option>
                                                                @foreach($classes as $class)
                                                                    <option value="{{ $class->id }}"
                                                                        {{ old('class_id', $subject->class_id) == $class->id ? 'selected' : '' }}>
                                                                        {{ $class->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                            <label class="login2">Assigned Section <small class="text-muted">(Optional)</small></label>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <select class="form-control" name="section_id" id="subject_section_id">
                                                                <option value="">-- All Sections --</option>
                                                                @foreach($sections as $section)
                                                                    <option value="{{ $section->id }}"
                                                                        {{ old('section_id', $subject->section_id) == $section->id ? 'selected' : '' }}>
                                                                        {{ $section->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <small class="text-muted">Only available after selecting a class.</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group-inner">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"></div>
                                                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                                                            <button class="btn btn-sm btn-primary" type="submit">
                                                                <i class="fa fa-save"></i> Update Subject
                                                            </button>
                                                            <a href="{{ route('admin.academic.subjects.index') }}" class="btn btn-sm btn-default" style="margin-left:8px;">
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
    </div>

    @push('js')
        <script>
        $(document).ready(function () {

            function loadSections(classId, selectedId) {
                var $sec = $('#subject_section_id');
                if (!classId) {
                    $sec.html('<option value="">-- All Sections --</option>');
                    return;
                }
                $sec.html('<option value="">Loading...</option>').prop('disabled', true);
                $.ajax({
                    url: '{{ route('attendance.get-sections') }}',
                    data: { class_id: classId },
                    success: function (res) {
                        var opts = '<option value="">-- All Sections --</option>';
                        $.each(res.sections, function (i, s) {
                            var sel = (selectedId && selectedId == s.id) ? 'selected' : '';
                            opts += '<option value="' + s.id + '" ' + sel + '>' + s.name + '</option>';
                        });
                        $sec.html(opts).prop('disabled', false);
                    },
                    error: function () {
                        $sec.html('<option value="">-- All Sections --</option>').prop('disabled', false);
                    }
                });
            }

            $('#subject_class_id').on('change', function () {
                loadSections($(this).val(), null);
            });

            // Pre-load sections for already-selected class on page load
            var initClass   = $('#subject_class_id').val();
            var initSection = '{{ old('section_id', $subject->section_id) }}';
            if (initClass) {
                loadSections(initClass, initSection);
            }
        });
        </script>
    @endpush
</x-tenant-app-layout>

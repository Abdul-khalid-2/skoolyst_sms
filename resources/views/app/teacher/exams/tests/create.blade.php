<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-plus"></i> Schedule Class Test
                </h3>
                <small class="text-muted">Add a test schedule for your class and subject</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('teacher.exams.tests.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        @if($classes->isEmpty())
            <div class="white-box">
                <p class="text-muted text-center" style="padding: 30px 0;">
                    <i class="fa fa-info-circle fa-3x" style="display:block; margin-bottom:12px;"></i>
                    You have no classes assigned yet, so you cannot schedule a test.
                </p>
            </div>
        @elseif($exams->isEmpty())
            <div class="white-box">
                <p class="text-muted text-center" style="padding: 30px 0;">
                    <i class="fa fa-info-circle fa-3x" style="display:block; margin-bottom:12px;"></i>
                    No active exam periods are available. Please contact the administrator.
                </p>
            </div>
        @else
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="white-box">
                    <form action="{{ route('teacher.exams.tests.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Exam Period <span class="text-danger">*</span></label>
                                    <select name="exam_id" class="form-control" required>
                                        <option value="">-- Select Exam --</option>
                                        @foreach($exams as $exam)
                                            <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                                {{ $exam->name }}
                                                ({{ \Carbon\Carbon::parse($exam->start_date)->format('d M') }} – {{ \Carbon\Carbon::parse($exam->end_date)->format('d M Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('exam_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Class <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_id" class="form-control" required>
                                        <option value="">-- Select Class --</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Subject <span class="text-danger">*</span></label>
                                    <select name="subject_id" id="subject_id" class="form-control" required>
                                        <option value="">-- Select Subject --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Test Date <span class="text-danger">*</span></label>
                                    <input type="date" name="exam_date" class="form-control" value="{{ old('exam_date') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Start Time</label>
                                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>End Time</label>
                                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Room</label>
                                    <input type="text" name="room_number" class="form-control" placeholder="e.g. Room 101" value="{{ old('room_number') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Max Marks</label>
                                    <input type="number" name="max_marks" class="form-control" min="1" value="{{ old('max_marks', 100) }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Passing Marks</label>
                                    <input type="number" name="passing_marks" class="form-control" min="1" value="{{ old('passing_marks', 40) }}">
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top:10px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Test Schedule
                                </button>
                                <a href="{{ route('teacher.exams.tests.index') }}" class="btn btn-default" style="margin-left:8px;">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

    </div>

    @push('js')
        <script>
        $(document).ready(function () {
            function loadSubjects(classId, selected) {
                var $subject = $('#subject_id');
                $subject.html('<option value="">Loading...</option>');

                if (!classId) {
                    $subject.html('<option value="">-- Select Subject --</option>');
                    return;
                }

                $.ajax({
                    url: '{{ route('teacher.exams.tests.subjects') }}',
                    data: { class_id: classId },
                    success: function (res) {
                        var opts = '<option value="">-- Select Subject --</option>';
                        $.each(res.subjects, function (i, s) {
                            var sel = (selected && selected == s.id) ? ' selected' : '';
                            opts += '<option value="' + s.id + '"' + sel + '>' + s.name + '</option>';
                        });
                        $subject.html(opts);
                    },
                    error: function () {
                        $subject.html('<option value="">-- Select Subject --</option>');
                    }
                });
            }

            $('#class_id').on('change', function () {
                loadSubjects($(this).val(), null);
            });

            @if(old('class_id'))
                loadSubjects('{{ old('class_id') }}', '{{ old('subject_id') }}');
            @endif
        });
        </script>
    @endpush
</x-tenant-app-layout>

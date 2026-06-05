<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Edit Schedule — {{ $exam->name }}" :back-route="route('exams.show', $exam)" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('exams.schedule.update', [$exam, $schedule]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Class <span class="text-danger">*</span></label>
                                            <select name="class_id" class="form-control" required>
                                                <option value="">-- Select Class --</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ old('class_id', $schedule->class_id) == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Subject <span class="text-danger">*</span></label>
                                            <select name="subject_id" class="form-control" required>
                                                <option value="">-- Select Subject --</option>
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}"
                                                        {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Exam Date <span class="text-danger">*</span></label>
                                            <input type="date" name="exam_date" class="form-control"
                                                value="{{ old('exam_date', $schedule->exam_date) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <input type="time" name="start_time" class="form-control"
                                                value="{{ old('start_time', $schedule->start_time) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <input type="time" name="end_time" class="form-control"
                                                value="{{ old('end_time', $schedule->end_time) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Room / Hall</label>
                                            <input type="text" name="room_number" class="form-control"
                                                value="{{ old('room_number', $schedule->room_number) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Max Marks</label>
                                            <input type="number" name="max_marks" class="form-control"
                                                value="{{ old('max_marks', $schedule->max_marks) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Passing Marks</label>
                                            <input type="number" name="passing_marks" class="form-control"
                                                value="{{ old('passing_marks', $schedule->passing_marks) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update Schedule
                                        </button>
                                        <a href="{{ route('exams.show', $exam) }}" class="btn btn-default" style="margin-left:8px;">
                                            Cancel
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-tenant-app-layout>

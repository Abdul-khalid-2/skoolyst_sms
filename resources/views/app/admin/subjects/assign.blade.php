<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/chosen/bootstrap-chosen.css') }}">
    @endpush

    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <x-page-header
                title="Academic Assignments"
                :back-route="route('admin.academic.setup')"
            />
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('error') }}
            </div>
        @endif

        <div class="row" style="margin-bottom: 20px;">
            <div class="col-lg-12">
                <div class="white-box" style="padding: 16px 20px;">
                    <p style="margin: 0 0 10px; font-weight: 600;">Setup order (follow top to bottom):</p>
                    <ol style="margin: 0; padding-left: 18px; color: #555;">
                        <li><strong>Class Curriculum</strong> — subjects each class offers</li>
                        <li><strong>Teacher Capabilities</strong> — subjects each teacher can teach</li>
                        <li><strong>Section Teacher Allocation</strong> — who teaches what in each section (required for timetable)</li>
                        <li><strong>Class Teachers</strong> — one homeroom teacher per class</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- Step 1: Class Curriculum --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h4 style="margin: 0 0 6px;">
                        <span class="label label-primary">1</span>
                        Class Curriculum
                    </h4>
                    <p class="text-muted" style="margin-bottom: 14px; font-size: 13px;">
                        Select subjects offered by each class. Timetable and section allocation use this list.
                    </p>

                    <form method="POST" action="{{ route('admin.academic.subjects.assign_class_subject') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="margin-bottom: 0;">
                                <thead style="background:#f5f5f5;">
                                    <tr>
                                        <th style="width: 28%;">Class</th>
                                        <th>Subjects Offered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classes as $class)
                                        <tr>
                                            <td style="vertical-align: middle;"><strong>{{ $class->name }}</strong></td>
                                            <td>
                                                <select name="class_subjects[{{ $class->id }}][]" class="chosen-select" multiple style="width:100%;">
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}"
                                                            {{ in_array($subject->id, $classSubjectIds[$class->id] ?? []) ? 'selected' : '' }}>
                                                            {{ $subject->name }} ({{ $subject->code }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">No classes found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right" style="margin-top: 12px;">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-save"></i> Save Curriculum
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Step 2: Teacher Capabilities --}}
        <div class="row" id="teacher-capabilities">
            <div class="col-lg-12">
                <div class="white-box">
                    <h4 style="margin: 0 0 6px;">
                        <span class="label label-primary">2</span>
                        Teacher Capabilities
                    </h4>
                    <p class="text-muted" style="margin-bottom: 14px; font-size: 13px;">
                        Subjects a teacher is qualified to teach. This does not assign them to a class section yet.
                    </p>

                    <form method="POST" action="{{ route('admin.academic.subjects.assign_teacher') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="margin-bottom: 0;">
                                <thead style="background:#f5f5f5;">
                                    <tr>
                                        <th style="width: 28%;">Teacher</th>
                                        <th>Qualified Subjects</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($teachers as $teacher)
                                        <tr>
                                            <td style="vertical-align: middle;">
                                                <strong>{{ $teacher->name }}</strong>
                                                <small class="text-muted" style="display:block;">{{ $teacher->email }}</small>
                                            </td>
                                            <td>
                                                <select name="teacher_subjects[{{ $teacher->id }}][]" class="chosen-select" multiple style="width:100%;">
                                                    @foreach($subjects as $subject)
                                                        <option value="{{ $subject->id }}"
                                                            {{ in_array($subject->id, $teacherSubjectIds[$teacher->id] ?? []) ? 'selected' : '' }}>
                                                            {{ $subject->name }} ({{ $subject->code }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">No teachers found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right" style="margin-top: 12px;">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-save"></i> Save Capabilities
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Step 3: Section allocation (link) --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box" style="border-left: 4px solid #27ae60;">
                    <h4 style="margin: 0 0 6px;">
                        <span class="label label-success">3</span>
                        Section Teacher Allocation
                        <span class="label label-warning" style="margin-left: 6px;">Primary</span>
                    </h4>
                    <p class="text-muted" style="margin-bottom: 14px; font-size: 13px;">
                        Assign which teacher teaches each subject in a specific section. Timetable only allows allocated teachers.
                    </p>
                    <a href="{{ route('admin.academic.subjects.section_teacher') }}" class="btn btn-success btn-sm">
                        <i class="fa fa-users"></i> Open Section Teacher Allocation
                    </a>
                </div>
            </div>
        </div>

        {{-- Step 4: Class Teachers --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h4 style="margin: 0 0 6px;">
                        <span class="label label-primary">4</span>
                        Class Teachers
                    </h4>
                    <p class="text-muted" style="margin-bottom: 14px; font-size: 13px;">
                        One homeroom teacher per class (attendance and class-wide access).
                    </p>

                    <form method="POST" action="{{ route('admin.academic.subjects.assign_class_teacher') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" style="margin-bottom: 0;">
                                <thead style="background:#f5f5f5;">
                                    <tr>
                                        <th style="width: 28%;">Class</th>
                                        <th>Class Teacher</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classes as $class)
                                        <tr>
                                            <td style="vertical-align: middle;"><strong>{{ $class->name }}</strong></td>
                                            <td>
                                                <select name="class_teacher[{{ $class->id }}]" class="form-control">
                                                    <option value="">-- Not Assigned --</option>
                                                    @foreach($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}"
                                                            {{ ($classTeachers[$class->id] ?? null) == $teacher->id ? 'selected' : '' }}>
                                                            {{ $teacher->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="text-center text-muted">No classes found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right" style="margin-top: 12px;">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-save"></i> Save Class Teachers
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/chosen/chosen.jquery.js') }}"></script>
        <script>
            $(function () {
                $('.chosen-select').chosen({ width: '100%', disable_search_threshold: 8 });
            });
        </script>
    @endpush
</x-tenant-app-layout>

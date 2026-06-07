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

    <!-- Advanced Form Start -->
    <div class="advanced-form-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header
                    title="Assign Subjects & Classes & Teachers"
                    :back-route="route('admin.academic.subjects.index')"
                />

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list">
                        <div class="sparkline12-graph">
                            <div class="basic-login-form-ad">

                                {{-- Tab Navigation --}}
                                <ul class="nav nav-tabs" style="margin-bottom: 0;">
                                    <li class="active">
                                        <a href="#assign-subjects" data-toggle="tab">
                                            <i class="fa fa-book"></i> Teachers Subjects 
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#assign-class-teacher" data-toggle="tab">
                                            <i class="fa fa-graduation-cap"></i> Teachers Class
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#assign-class-subjects" data-toggle="tab">
                                            <i class="fa fa-list-alt"></i> Class Subjects
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#teachers-subjects" data-toggle="tab">
                                            <i class="fa fa-user"></i> Teachers &amp; Subjects
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#teachers-classes" data-toggle="tab">
                                            <i class="fa fa-users"></i> Teachers &amp; Classes
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" style="padding: 20px; border: 1px solid #ddd; border-top: none;">

                                    {{-- Tab 1: Assign Subjects to Teachers --}}
                                    <div class="tab-pane active" id="assign-subjects">
                                        <form id="assignTeacherForm" method="POST" action="{{ route('admin.academic.subjects.assign_teacher') }}">
                                            @csrf
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead style="background:#f5f5f5;">
                                                        <tr>
                                                            <th style="width:35%;">Teacher</th>
                                                            <th>Assigned Subjects</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($teachers as $teacher)
                                                            <tr>
                                                                <td>
                                                                    <strong>{{ $teacher->name }}</strong>
                                                                    <small class="text-muted" style="display:block;">{{ $teacher->email }}</small>
                                                                </td>
                                                                <td>
                                                                    <select name="teacher_subjects[{{ $teacher->id }}][]"
                                                                        class="chosen-select" multiple style="width:100%;">
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
                                                            <tr><td colspan="2" class="text-center text-muted" style="padding:20px;">No teachers found.</td></tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-right" style="margin-top: 15px;">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i> Save Subject Assignments
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Tab 2: Assign Classes to Teachers (class-teacher role) --}}
                                    <div class="tab-pane" id="assign-class-teacher">
                                        <form id="assignClassTeacherForm" method="POST" action="{{ route('admin.academic.subjects.assign_class_teacher') }}">
                                            @csrf
                                            <p class="text-muted" style="margin-bottom:12px;">
                                                Choose which class each teacher is the <strong>class teacher</strong> of.
                                                This is what lets them mark that class's attendance.
                                            </p>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead style="background:#f5f5f5;">
                                                        <tr>
                                                            <th style="width:35%;">Teacher</th>
                                                            <th>Class Teacher Of</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($teachers as $teacher)
                                                            <tr>
                                                                <td><strong>{{ $teacher->name }}</strong></td>
                                                                <td>
                                                                    <select name="teacher_class[{{ $teacher->id }}]" class="form-control">
                                                                        <option value="">-- Not a Class Teacher --</option>
                                                                        @foreach($classes as $class)
                                                                            <option value="{{ $class->id }}"
                                                                                {{ ($teacherClassOf[$teacher->id] ?? null) == $class->id ? 'selected' : '' }}>
                                                                                {{ $class->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr><td colspan="2" class="text-center text-muted" style="padding:20px;">No teachers found.</td></tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-right" style="margin-top: 15px;">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i> Save Class Teachers
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Tab 3: Class Subjects (curriculum) --}}
                                    <div class="tab-pane" id="assign-class-subjects">
                                        <form id="assignClassSubjectForm" method="POST" action="{{ route('admin.academic.subjects.assign_class_subject') }}">
                                            @csrf
                                            <p class="text-muted" style="margin-bottom:12px;">
                                                Choose which <strong>subjects each class offers</strong> (its curriculum).
                                                Teacher and timetable subject pickers will be limited to these.
                                            </p>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead style="background:#f5f5f5;">
                                                        <tr>
                                                            <th style="width:35%;">Class</th>
                                                            <th>Subjects Offered</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($classes as $class)
                                                            <tr>
                                                                <td><strong>{{ $class->name }}</strong></td>
                                                                <td>
                                                                    <select name="class_subjects[{{ $class->id }}][]"
                                                                        class="chosen-select" multiple style="width:100%;">
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
                                                            <tr><td colspan="2" class="text-center text-muted" style="padding:20px;">No classes found.</td></tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-right" style="margin-top: 15px;">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fa fa-save"></i> Save Class Subjects
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    {{-- Tab 4: Teachers & Subjects (read-only summary) --}}
                                    <div class="tab-pane" id="teachers-subjects">
                                        @php
                                            // Pivot: teacher_id => [subject names]
                                            $teacherSubjectMap = [];
                                            foreach ($subjectAssignments as $subjectId => $teacherIds) {
                                                $subjectName = $subjects->firstWhere('id', $subjectId)?->name ?? '—';
                                                foreach ($teacherIds as $tid) {
                                                    $teacherSubjectMap[$tid][] = $subjectName;
                                                }
                                            }
                                        @endphp
                                        <div class="table-responsive" style="margin-top: 5px;">
                                            <table class="table table-striped table-bordered">
                                                <thead style="background:#f5f5f5;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Teacher</th>
                                                        <th>Subjects Assigned</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($teachers as $i => $teacher)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td><strong>{{ $teacher->name }}</strong></td>
                                                            <td>
                                                                @if(!empty($teacherSubjectMap[$teacher->id]))
                                                                    @foreach($teacherSubjectMap[$teacher->id] as $subName)
                                                                        <span class="label label-primary" style="margin-right:4px;">{{ $subName }}</span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted">No subjects assigned</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Tab 4: Teachers & Classes (read-only summary) --}}
                                    <div class="tab-pane" id="teachers-classes">
                                        @php
                                            // Pivot: teacher_id => [class names]
                                            $teacherClassMap = [];
                                            foreach ($classTeachers as $classId => $teacherId) {
                                                if ($teacherId) {
                                                    $className = $classes->firstWhere('id', $classId)?->name ?? '—';
                                                    $teacherClassMap[$teacherId][] = $className;
                                                }
                                            }
                                        @endphp
                                        <div class="table-responsive" style="margin-top: 5px;">
                                            <table class="table table-striped table-bordered">
                                                <thead style="background:#f5f5f5;">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Teacher</th>
                                                        <th>Class Teacher Of</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($teachers as $i => $teacher)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td><strong>{{ $teacher->name }}</strong></td>
                                                            <td>
                                                                @if(!empty($teacherClassMap[$teacher->id]))
                                                                    @foreach($teacherClassMap[$teacher->id] as $className)
                                                                        <span class="label label-success" style="margin-right:4px;">{{ $className }}</span>
                                                                    @endforeach
                                                                @else
                                                                    <span class="text-muted">Not a class teacher</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>{{-- /tab-content --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Advanced Form End-->
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
                // Initialize chosen select
                $(".chosen-select").chosen({
                    width: "100%",
                    disable_search_threshold: 5
                });

                // Open the tab referenced by the URL hash (e.g. links from the class page).
                var hash = window.location.hash;
                if (hash && $('.nav-tabs a[href="' + hash + '"]').length) {
                    $('.nav-tabs a[href="' + hash + '"]').tab('show');
                }
            });
        </script>
    @endpush
</x-tenant-app-layout>
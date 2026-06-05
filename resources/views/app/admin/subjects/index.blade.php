<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/editor/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/datetimepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/bootstrap-editable.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/editor/x-editor-style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-editable.css') }}">
    @endpush
    <x-slot name="header"></x-slot>
    
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                
                <x-page-header title="All Subjects">
                    <a href="{{ route('admin.academic.subjects.create') }}" style="color: #333;">
                        <i class="fa fa-plus"></i> Add Subject
                    </a>
                    <a href="{{ route('admin.academic.subjects.assign') }}" style="color: #333;">
                        <i class="fa fa-user-plus"></i> Assign Teachers
                    </a>
                </x-page-header>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <div id="toolbar">
                                    <select class="form-control dt-tb">
                                        <option value="">Excel</option>
                                        <option value="">PDF</option>
                                        <option value="">CSV</option>
                                    </select>
                                </div>
                                <table id="timetable-table" 
                                    class="table hover-table timetable-datatable"
                                    data-toggle="table" 
                                    data-pagination="true" 
                                    data-search="true"
                                    data-resizable="true"
                                    data-cookie-id-table="saveId"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="id" data-sortable="true">S.no#</th>
                                            <th data-field="name" data-sortable="true">Subject Name</th>
                                            <th data-field="code" data-sortable="true">Code</th>
                                            {{-- <th data-field="classes">Assigned Teacher & Classes</th> --}}
                                            {{-- <th data-field="teachers">Assigned Teachers</th> --}}
                                            <th data-field="action">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subjects as $key => $subject)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $subject->name }}</td>
                                            <td>{{ $subject->code }}</td>
                                            {{-- <td>
                                                @if($subject->subjectTeacherClass && $subject->subjectTeacherClass->count())
                                                    @foreach($subject->subjectTeacherClass as $classAssignment)
                                                        <span class="badge badge-info">
                                                            {{ $classAssignment->class->name??"" }} : 
                                                            {{ $classAssignment->teacher->name??"" }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    Not assigned
                                                @endif
                                            </td> --}}
                                           
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 4px;">
                                                    <a href="{{ route('admin.academic.subjects.edit', $subject->id) }}" 
                                                       class="btn btn-xs btn-success" 
                                                       style="margin-right: 2px;color: white"
                                                       title="Edit">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.academic.subjects.edit', $subject->id) }}" 
                                                       class="btn btn-xs btn-primary" 
                                                       style="margin-right: 2px;color: white"
                                                       title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('admin.academic.subjects.destroy', $subject->id) }}" 
                                                          method="POST" 
                                                          class="d-inline delete-subject-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-xs btn-danger" 
                                                                style="margin-left: 2px"
                                                                title="Delete"
                                                                data-subject-id="{{ $subject->id }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/data-table/bootstrap-table.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/tableExport.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/bootstrap-table-editable.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/bootstrap-editable.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/bootstrap-table-resizable.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/colResizable-1.5.source.js') }}"></script>
        <script src="{{ asset('backend/js/data-table/bootstrap-table-export.js') }}"></script>
        <script src="{{ asset('backend/js/editable/jquery.mockjax.js') }}"></script>
        <script src="{{ asset('backend/js/editable/mock-active.js') }}"></script>
        <script src="{{ asset('backend/js/editable/select2.js') }}"></script>
        <script src="{{ asset('backend/js/editable/moment.min.js') }}"></script>
        <script src="{{ asset('backend/js/editable/bootstrap-datetimepicker.js') }}"></script>
        <script src="{{ asset('backend/js/editable/bootstrap-editable.js') }}"></script>
        <script src="{{ asset('backend/js/editable/xediable-active.js') }}"></script>
        <script src="{{ asset('backend/js/chart/jquery.peity.min.js') }}"></script>
        <script src="{{ asset('backend/js/peity/peity-active.js') }}"></script>
        <script src="{{ asset('backend/js/tab.js') }}"></script>
    @endpush
</x-tenant-app-layout>
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
                
                <x-page-header
                    title="All Students"
                    :add-route="route('dashboard.add.student')"
                    add-label="Add Student"
                    add-icon="fa-user-plus"
                />
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
                                data-show-columns="true" 
                                {{-- data-show-pagination-switch="true"  --}}
                                {{-- data-show-refresh="true" --}}
                                {{-- data-key-events="true"  --}}
                                {{-- data-show-toggle="true"  --}}
                                data-resizable="true"
                                {{-- data-cookie="true" --}}
                                data-cookie-id-table="student"
                                {{-- data-show-export="true"  --}}
                                {{-- data-click-to-select="true" --}}
                                 {{-- data-export-types="['csv', 'txt', 'excel']" --}}
                                data-toolbar="#toolbar">
                                   <thead>
                                        <tr>
                                            <th data-field="id" data-sortable="true">ID</th>
                                            <th data-field="name" data-sortable="true">Name</th>
                                            <th data-field="email">Email</th>
                                            <th data-field="phone">Phone</th>
                                            <th data-field="admission_no">Admission No</th>
                                            <th data-field="class">Class</th>
                                            <th data-field="section">Section</th>
                                            <th data-field="dob">Date of Birth</th>
                                            <th data-field="gender">Gender</th>
                                            <th data-field="actions" data-align="center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $student->id }}</td>
                                                <td>
                                                    @if(isset($student->profile_pic))
                                                        <img src="{{ asset('assets/'. $student->profile_pic) }}" 
                                                            alt="{{ $student->name }}" 
                                                            class="rounded-circle" 
                                                            width="30" 
                                                            height="30">
                                                        @else
                                                            <img src="{{ asset('backend/img/profile/1.jpg') }}" 
                                                                alt="{{ $student->name }}" 
                                                                class="rounded-circle" 
                                                                width="30" 
                                                                height="30">
                                                    @endif
                                                    {{ $student->name }}
                                                </td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->phone }}</td>
                                                <td>{{ $student->studentProfile->admission_no ?? 'N/A' }}</td>
                                                <td>{{ $student->studentProfile->class->name ?? 'N/A' }}</td>
                                                <td>{{ $student->studentProfile->section->name ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($student->dob)->format('d-M-Y') }}</td>
                                                <td>
                                                    @if($student->gender == 'male')
                                                        <span class="badge badge-primary">Male</span>
                                                    @elseif($student->gender == 'female')
                                                        <span class="badge badge-pink">Female</span>
                                                    @else
                                                        <span class="badge badge-secondary">Other</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <a href="{{ route('admin.show.student', $student->id) }}" class="btn btn-xs btn-success" title="Show">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.edit.student', $student->id) }}" 
                                                           class="btn btn-xs btn-primary" 
                                                           title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                
                                                        <form action="{{ route('admin.destroy.student', $student->id) }}" 
                                                              method="POST" 
                                                              class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-xs btn-danger" 
                                                                    title="Delete"
                                                                    onclick="return confirm('Are you sure you want to delete this student?')">
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

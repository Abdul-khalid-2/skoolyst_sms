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
               

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>All Sections</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.academic.sections.create') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-plus"></i> Add Section
                                    </a>
                                </div>
                                <div class="dropdown-container">
                                    <button class="dropdown-toggle-custom">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu-custom">
                                        <a href="{{ route('admin.academic.sections.create') }}" class="btn btn-primary btn-sm" style="color: white">
                                            <i class="fa fa-plus"></i> Add Section
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    {{-- data-show-columns="true"  --}}
                                    {{-- data-show-pagination-switch="true"  --}}
                                    {{-- data-show-refresh="true" --}}
                                    {{-- data-key-events="true"  --}}
                                    {{-- data-show-toggle="true"  --}}
                                    data-resizable="true"
                                    {{-- data-cookie="true" --}}
                                    data-cookie-id-table="timetable"
                                    {{-- data-show-export="true"  --}}
                                    {{-- data-click-to-select="true" --}}
                                     {{-- data-export-types="['csv', 'txt', 'excel']" --}}
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            {{-- <th data-field="state" data-checkbox="true"></th> --}}
                                            <th data-field="id" data-sortable="true">S.no#</th>
                                            <th data-field="class" data-sortable="true">Class</th>
                                            <th data-field="name" data-sortable="true">Section Name</th>
                                            <th data-field="capacity" data-sortable="true">Capacity</th>
                                            <th data-field="students" data-sortable="true">Students</th>
                                            <th data-field="action">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sections as $section)
                                            <tr @if($section->trashed()) style="opacity: 0.6; background-color: #f8f9fa;" @endif>
                                                <td>
                                                    {{ $section->id }}
                                                    @if($section->trashed())
                                                        <span class="badge badge-danger">Deleted</span>
                                                    @endif
                                                </td>
                                                <td>{{ $section->class->name ?? 'N/A' }}</td>
                                                <td>{{ $section->name }}</td>
                                                <td>{{ $section->capacity }}</td>
                                                <td>{{ $section->students->count() }}</td>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <a href="{{ route('admin.academic.sections.show', encrypt($section->id)) }}"
                                                        class="btn btn-xs btn-success" 
                                                        title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        
                                                        @unless($section->trashed())
                                                            <a href="{{ route('admin.academic.sections.edit', encrypt($section->id)) }}" 
                                                            class="btn btn-xs btn-primary" 
                                                            title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        
                                                            <form action="{{ route('admin.academic.sections.destroy', encrypt($section->id)) }}" 
                                                                method="POST" 
                                                                class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="btn btn-xs btn-danger" 
                                                                        title="Delete"
                                                                        onclick="return confirm('Are you sure you want to delete this section?')">
                                                                    <i class="fa fa-close"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('admin.academic.sections.restore', encrypt($section->id)) }}" 
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit" 
                                                                        class="btn btn-xs btn-warning" 
                                                                        title="Restore"
                                                                        onclick="return confirm('Are you sure you want to restore this section?')">
                                                                    <i class="fa fa-refresh"></i> Restore
                                                                </button>
                                                            </form>
                                                        @endunless
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
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
                    title="All Parents"
                    :add-route="route('dashboard.add.parent')"
                    add-label="Add Parent"
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
                                    data-resizable="true"
                                    data-cookie-id-table="parent"
                                    data-toolbar="#toolbar">
                                    <thead>
                                        <tr>
                                            <th data-field="state" data-checkbox="true"></th>
                                            <th data-field="id" data-sortable="true">ID</th>
                                            <th data-field="name" data-sortable="true">Parent Name</th>
                                            <th data-field="email">Email</th>
                                            <th data-field="phone">Phone</th>
                                            <th data-field="occupation">Occupation</th>
                                            <th data-field="children">Children</th>
                                            <th data-field="relation">Relation</th>
                                            <th data-field="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($parents as $parent)
                                            <tr>
                                                <td></td>
                                                <td>{{ $parent->id }}</td>
                                                <td>{{ $parent->name }}</td>
                                                <td>{{ $parent->email }}</td>
                                                <td>{{ $parent->phone }}</td>
                                                <td>{{ $parent->parentProfile->occupation ?? 'N/A' }}</td>
                                                <td>
                                                    @foreach($parent->children as $child)
                                                        {{ $child->name }} ({{ $child->studentProfile->class->name ?? 'N/A' }})<br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($parent->studentParentRelationships as $relationship)
                                                        {{ ucfirst($relationship->relationship) }}<br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <a href="{{ route('admin.show.parent', $parent->id) }}" class="btn btn-xs btn-success" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.edit.parent', $parent->id) }}" class="btn btn-xs btn-primary" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.destroy.parent', $parent->id) }}"
                                                            method="POST"
                                                            class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-xs btn-danger"
                                                                    title="Delete"
                                                                    onclick="return confirm('Are you sure you want to delete this Parent?')">
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

<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Fee Categories">
                    <a href="{{ route('fees.categories.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Add Category</a>
                    <a href="{{ route('fees.index') }}" style="color:#333;"><i class="fa fa-tachometer"></i> Fees Dashboard</a>
                </x-page-header>

                <div class="col-lg-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-graph">
                            <div class="datatable-dashv1-list custom-datatable-overright">
                                <table class="table hover-table timetable-datatable"
                                    data-toggle="table"
                                    data-pagination="true"
                                    data-search="true"
                                    data-show-columns="true">
                                    <thead>
                                        <tr>
                                            <th data-field="id"          data-sortable="true">#</th>
                                            <th data-field="name"        data-sortable="true">Category Name</th>
                                            <th data-field="description">Description</th>
                                            <th data-field="structures"  data-sortable="true">Structures</th>
                                            <th data-field="actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $i => $cat)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><strong>{{ $cat->name }}</strong></td>
                                            <td>{{ $cat->description ?: '—' }}</td>
                                            <td><span class="badge badge-info">{{ $cat->structures_count }}</span></td>
                                            <td>
                                                <div style="display:flex; gap:4px;">
                                                    <a href="{{ route('fees.categories.edit', $cat) }}" class="btn btn-xs btn-primary" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('fees.categories.destroy', $cat) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-xs btn-danger" title="Delete"
                                                            onclick="return confirm('Delete this category?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted" style="padding:30px;">
                                                <i class="fa fa-tags fa-2x"></i><br>No categories yet.
                                                <br><a href="{{ route('fees.categories.create') }}">Add the first one</a>
                                            </td>
                                        </tr>
                                        @endforelse
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
        <script src="{{ asset('backend/js/data-table/data-table-active.js') }}"></script>
    @endpush
</x-tenant-app-layout>

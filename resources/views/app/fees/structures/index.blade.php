<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Fee Structures">
                    <a href="{{ route('fees.structures.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Add Structure</a>
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
                                            <th data-field="id"        data-sortable="true">#</th>
                                            <th data-field="name"      data-sortable="true">Structure Name</th>
                                            <th data-field="category"  data-sortable="true">Category</th>
                                            <th data-field="class"     data-sortable="true">Class</th>
                                            <th data-field="amount"    data-sortable="true">Amount</th>
                                            <th data-field="frequency" data-sortable="true">Frequency</th>
                                            <th data-field="due_date">Due Date</th>
                                            <th data-field="actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($structures as $i => $s)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><strong>{{ $s->name }}</strong></td>
                                            <td>{{ $s->category?->name ?? '—' }}</td>
                                            <td>{{ $s->schoolClass?->name ?? 'All Classes' }}</td>
                                            <td>PKR {{ number_format($s->amount, 2) }}</td>
                                            <td>{{ $s->frequency ? ucfirst(str_replace('_',' ', $s->frequency)) : '—' }}</td>
                                            <td>{{ $s->due_date ? \Carbon\Carbon::parse($s->due_date)->format('d M Y') : '—' }}</td>
                                            <td>
                                                <div style="display:flex; gap:4px;">
                                                    <a href="{{ route('fees.structures.edit', $s) }}" class="btn btn-xs btn-primary" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('fees.structures.destroy', $s) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button class="btn btn-xs btn-danger" title="Delete"
                                                            onclick="return confirm('Delete this structure?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted" style="padding:30px;">
                                                <i class="fa fa-list-alt fa-2x"></i><br>No fee structures yet.
                                                <br><a href="{{ route('fees.structures.create') }}">Create the first one</a>
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

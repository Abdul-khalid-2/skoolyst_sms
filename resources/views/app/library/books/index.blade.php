<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .avail-badge { padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
            .avail-high { background:#e6f9ee; color:#27ae60; }
            .avail-low  { background:#fff8e1; color:#f39c12; }
            .avail-none { background:#fdecea; color:#e74c3c; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="Book Catalog">
                    <a href="{{ route('library.books.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Add Book</a>
                    <a href="{{ route('library.index') }}" style="color:#333;"><i class="fa fa-tachometer"></i> Dashboard</a>
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
                                            <th data-field="id"       data-sortable="true">#</th>
                                            <th data-field="title"    data-sortable="true">Title</th>
                                            <th data-field="author"   data-sortable="true">Author</th>
                                            <th data-field="isbn">ISBN</th>
                                            <th data-field="category" data-sortable="true">Category</th>
                                            <th data-field="shelf">Shelf</th>
                                            <th data-field="qty"      data-sortable="true">Total Qty</th>
                                            <th data-field="avail"    data-sortable="true">Available</th>
                                            <th data-field="actions">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($books as $i => $book)
                                            @php
                                                $cls = $book->available <= 0 ? 'avail-none'
                                                     : ($book->available <= ($book->quantity * 0.3) ? 'avail-low' : 'avail-high');
                                            @endphp
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td><strong>{{ $book->title }}</strong></td>
                                                <td>{{ $book->author ?? '—' }}</td>
                                                <td>{{ $book->isbn ?? '—' }}</td>
                                                <td>{{ $book->category ?? '—' }}</td>
                                                <td>{{ $book->shelf_number ?? '—' }}</td>
                                                <td>{{ $book->quantity }}</td>
                                                <td><span class="avail-badge {{ $cls }}">{{ $book->available }}</span></td>
                                                <td>
                                                    <div style="display:flex; gap:4px;">
                                                        <a href="{{ route('library.books.show', $book) }}" class="btn btn-xs btn-success" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('library.books.edit', $book) }}" class="btn btn-xs btn-primary" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        @if($book->available > 0)
                                                            <a href="{{ route('library.issues.create') }}?book_id={{ $book->id }}" class="btn btn-xs btn-info" title="Issue">
                                                                <i class="fa fa-share"></i>
                                                            </a>
                                                        @endif
                                                        <form action="{{ route('library.books.destroy', $book) }}" method="POST">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-xs btn-danger" title="Delete"
                                                                onclick="return confirm('Delete this book?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center text-muted" style="padding:40px;">
                                                    <i class="fa fa-book fa-3x" style="color:#ddd;"></i>
                                                    <br><br>No books in the catalog yet.
                                                    <br><a href="{{ route('library.books.create') }}">Add the first book</a>
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

<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/data-table/bootstrap-table.css') }}">
        <style>
            .info-box { background:#fff; border:1px solid #e0e0e0; border-radius:6px; padding:18px 20px; margin-bottom:20px; }
            .info-box h4 { margin:0 0 12px; font-size:15px; font-weight:700; border-bottom:1px solid #f0f0f0; padding-bottom:8px; }
            .info-row { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #f8f8f8; font-size:13px; }
            .info-row:last-child { border-bottom:none; }
            .info-row span:first-child { color:#888; }
            .info-row span:last-child  { font-weight:600; }
            .stock-bar { height:8px; border-radius:4px; background:#ecf0f1; margin-top:6px; }
            .stock-fill { height:8px; border-radius:4px; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                <x-page-header title="{{ $book->title }}">
                    <a href="{{ route('library.issues.create') }}?book_id={{ $book->id }}" style="color:#333;"><i class="fa fa-share"></i> Issue This Book</a>
                    <a href="{{ route('library.books.edit', $book) }}" style="color:#333;"><i class="fa fa-edit"></i> Edit Book</a>
                </x-page-header>

                <div class="col-lg-4 col-md-5 col-xs-12">
                    <div class="info-box">
                        <h4><i class="fa fa-book"></i> Book Details</h4>
                        <div class="info-row"><span>Title</span><span>{{ $book->title }}</span></div>
                        <div class="info-row"><span>Author</span><span>{{ $book->author ?? '—' }}</span></div>
                        <div class="info-row"><span>ISBN</span><span>{{ $book->isbn ?? '—' }}</span></div>
                        <div class="info-row"><span>Publisher</span><span>{{ $book->publisher ?? '—' }}</span></div>
                        <div class="info-row"><span>Edition</span><span>{{ $book->edition ?? '—' }}</span></div>
                        <div class="info-row"><span>Category</span><span>{{ $book->category ?? '—' }}</span></div>
                        <div class="info-row"><span>Shelf</span><span>{{ $book->shelf_number ?? '—' }}</span></div>
                        <div class="info-row"><span>Price</span><span>{{ $book->price ? 'PKR '.number_format($book->price,2) : '—' }}</span></div>
                    </div>

                    <div class="info-box">
                        <h4><i class="fa fa-cubes"></i> Stock Status</h4>
                        @php
                            $pct = $book->quantity > 0 ? round(($book->available / $book->quantity) * 100) : 0;
                            $color = $pct > 50 ? '#27ae60' : ($pct > 20 ? '#f39c12' : '#e74c3c');
                        @endphp
                        <div class="info-row"><span>Total Copies</span><span>{{ $book->quantity }}</span></div>
                        <div class="info-row"><span>Available</span><span style="color:{{ $color }}; font-weight:700;">{{ $book->available }}</span></div>
                        <div class="info-row"><span>Issued</span><span>{{ $book->quantity - $book->available }}</span></div>
                        <div class="stock-bar">
                            <div class="stock-fill" style="width:{{ $pct }}%; background:{{ $color }};"></div>
                        </div>
                        <small class="text-muted">{{ $pct }}% available</small>
                    </div>

                    <div style="display:flex; gap:8px;">
                        <a href="{{ route('library.books.edit', $book) }}" class="btn btn-primary btn-sm btn-block">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('library.books.destroy', $book) }}" method="POST" style="flex:1;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm btn-block"
                                onclick="return confirm('Delete this book from catalog?')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Issue History for this book --}}
                <div class="col-lg-8 col-md-7 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd" style="display:flex;justify-content:space-between;align-items:center;">
                                <h1>Issue History</h1>
                                <a href="{{ route('library.issues.create') }}?book_id={{ $book->id }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="fa fa-share"></i> Issue Book
                                </a>
                            </div>
                        </div>
                        <div class="sparkline13-graph">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Issued To</th>
                                            <th>Issue Date</th>
                                            <th>Due Date</th>
                                            <th>Return Date</th>
                                            <th>Status</th>
                                            <th>Fine</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($book->issues as $i => $issue)
                                            @php $isOverdue = $issue->status === 'issued' && $issue->due_date < now()->format('Y-m-d'); @endphp
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $issue->user?->name ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($issue->due_date)->format('d M Y') }}</td>
                                                <td>{{ $issue->return_date ? \Carbon\Carbon::parse($issue->return_date)->format('d M Y') : '—' }}</td>
                                                <td>
                                                    @if($issue->status === 'returned')
                                                        <span class="label label-success">Returned</span>
                                                    @elseif($issue->status === 'lost')
                                                        <span class="label label-default">Lost</span>
                                                    @elseif($issue->status === 'damaged')
                                                        <span class="label label-warning">Damaged</span>
                                                    @elseif($isOverdue)
                                                        <span class="label label-danger">Overdue</span>
                                                    @else
                                                        <span class="label label-info">Issued</span>
                                                    @endif
                                                </td>
                                                <td>{{ $issue->fine_amount > 0 ? 'PKR '.number_format($issue->fine_amount,2) : '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted" style="padding:30px;">
                                                    <i class="fa fa-history fa-2x" style="color:#ddd;"></i>
                                                    <br>No issue history for this book.
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
</x-tenant-app-layout>

<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Issue Record" :back-route="route('library.issues.index')" />

            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">

                        {{-- Status Banner --}}
                        @php
                            $statusColors = [
                                'issued'   => ['bg'=>'#e8f4fd','color'=>'#3498db','label'=>'Currently Issued'],
                                'returned' => ['bg'=>'#e6f9ee','color'=>'#27ae60','label'=>'Returned'],
                                'lost'     => ['bg'=>'#f5f5f5','color'=>'#7f8c8d','label'=>'Reported Lost'],
                                'damaged'  => ['bg'=>'#fff8e1','color'=>'#f39c12','label'=>'Damaged'],
                            ];
                            $sc = $statusColors[$issue->status] ?? $statusColors['issued'];
                            $isOverdue = $issue->status === 'issued' && $issue->due_date < now()->format('Y-m-d');
                        @endphp
                        <div style="background:{{ $isOverdue ? '#fdecea' : $sc['bg'] }}; color:{{ $isOverdue ? '#e74c3c' : $sc['color'] }}; padding:12px 20px; border-radius:6px; margin-bottom:20px; font-weight:700; font-size:15px;">
                            <i class="fa fa-{{ $isOverdue ? 'exclamation-triangle' : 'info-circle' }}"></i>
                            {{ $isOverdue ? 'OVERDUE — Return immediately' : $sc['label'] }}
                        </div>

                        {{-- Details --}}
                        <table class="table table-bordered table-condensed">
                            <tr><th style="width:35%">Book</th><td>{{ $issue->book?->title ?? 'N/A' }}</td></tr>
                            <tr><th>Author</th><td>{{ $issue->book?->author ?? '—' }}</td></tr>
                            <tr><th>Issued To</th><td>{{ $issue->user?->name ?? 'N/A' }}</td></tr>
                            <tr><th>Issue Date</th><td>{{ \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') }}</td></tr>
                            <tr><th>Due Date</th><td>{{ \Carbon\Carbon::parse($issue->due_date)->format('d M Y') }}</td></tr>
                            <tr><th>Return Date</th><td>{{ $issue->return_date ? \Carbon\Carbon::parse($issue->return_date)->format('d M Y') : '—' }}</td></tr>
                            <tr><th>Fine</th><td>{{ $issue->fine_amount > 0 ? 'PKR '.number_format($issue->fine_amount,2) : '—' }}</td></tr>
                            <tr><th>Notes</th><td>{{ $issue->notes ?? '—' }}</td></tr>
                        </table>

                        {{-- Actions --}}
                        <div style="display:flex; gap:10px; margin-top:15px;">
                            @if($issue->status === 'issued')
                                <form action="{{ route('library.issues.return', $issue) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button class="btn btn-success btn-sm"
                                        onclick="return confirm('Mark this book as returned?')">
                                        <i class="fa fa-check"></i> Mark as Returned
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('library.books.show', $issue->book_id) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-book"></i> View Book
                            </a>
                            <a href="{{ route('library.issues.index') }}" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-tenant-app-layout>

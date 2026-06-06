<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        {{-- Header --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-book"></i> Book Issues
                </h3>
                <small class="text-muted">Your library borrowing history</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- Summary cards --}}
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-info" style="margin:0;">{{ $summary['active'] }}</h2>
                    <small class="text-muted">Currently Issued</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="{{ $summary['overdue'] > 0 ? 'text-danger' : 'text-success' }}" style="margin:0;">{{ $summary['overdue'] }}</h2>
                    <small class="text-muted">Overdue</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-success" style="margin:0;">{{ $summary['returned'] }}</h2>
                    <small class="text-muted">Returned</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="{{ $summary['fine_due'] > 0 ? 'text-danger' : 'text-success' }}" style="margin:0;">
                        {{ $currency }}{{ number_format($summary['fine_due'], 2) }}
                    </h2>
                    <small class="text-muted">Fine Due</small>
                </div>
            </div>
        </div>

        {{-- Issues table --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-list"></i> Borrowing History</h3>

                    @if($issues->isEmpty())
                        <p class="text-muted text-center" style="padding: 30px 0;">
                            <i class="fa fa-inbox fa-3x" style="display:block; margin-bottom:12px;"></i>
                            You have not borrowed any books yet.
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Book Title</th>
                                        <th>Author</th>
                                        <th>Issue Date</th>
                                        <th>Due Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                        <th>Fine</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($issues as $index => $issue)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $issue->book->title ?? '—' }}</td>
                                            <td>{{ $issue->book->author ?? '—' }}</td>
                                            <td>{{ $issue->issue_date ? \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') : '—' }}</td>
                                            <td>
                                                {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('d M Y') : '—' }}
                                                @if($issue->is_overdue)
                                                    <br><small class="text-danger"><i class="fa fa-exclamation-circle"></i> {{ $issue->days_overdue }} day(s) late</small>
                                                @endif
                                            </td>
                                            <td>{{ $issue->return_date ? \Carbon\Carbon::parse($issue->return_date)->format('d M Y') : '—' }}</td>
                                            <td>
                                                @if($issue->status === 'returned')
                                                    <span class="label label-success">Returned</span>
                                                @elseif($issue->is_overdue)
                                                    <span class="label label-danger">Overdue</span>
                                                @else
                                                    <span class="label label-info">Issued</span>
                                                @endif
                                            </td>
                                            <td class="{{ $issue->display_fine > 0 ? 'text-danger' : '' }}">
                                                {{ $currency }}{{ number_format($issue->display_fine, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <small class="text-muted">
                            <i class="fa fa-info-circle"></i>
                            Fines for overdue books are estimated and accrue daily until the book is returned.
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>

<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    <div class="container-fluid" style="margin-top: 20px;">

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-bar-chart"></i> Fee Collection Reports
                </h3>
                <small class="text-muted">Branch fee statistics</small>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-info" style="margin:0;">{{ $currency }}{{ number_format($totalBilled, 2) }}</h2>
                    <small class="text-muted">Total Billed</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-success" style="margin:0;">{{ $currency }}{{ number_format($totalCollected, 2) }}</h2>
                    <small class="text-muted">Total Collected</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="{{ $outstanding > 0 ? 'text-danger' : 'text-success' }}" style="margin:0;">
                        {{ $currency }}{{ number_format($outstanding, 2) }}
                    </h2>
                    <small class="text-muted">Outstanding</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-primary" style="margin:0;">{{ $collectionRate }}%</h2>
                    <small class="text-muted">Collection Rate</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-pie-chart"></i> Fees by Status</h3>
                    @if($byStatus->isEmpty())
                        <p class="text-muted">No fee data available.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Count</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($byStatus as $row)
                                        <tr>
                                            <td>{{ ucfirst($row->status) }}</td>
                                            <td>{{ $row->count }}</td>
                                            <td>{{ $currency }}{{ number_format($row->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="white-box">
                    <h3 class="box-title"><i class="fa fa-line-chart"></i> Monthly Collection (Last 6 Months)</h3>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Collected</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyCollection as $month)
                                    <tr>
                                        <td>{{ $month['label'] }}</td>
                                        <td>{{ $currency }}{{ number_format($month['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>

<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Payment Invoice" :back-route="route('fees.payments.index')" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">

                        {{-- Invoice Header --}}
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; padding:20px; border-bottom:2px solid #eee; margin-bottom:20px;">
                            <div>
                                <h2 style="margin:0; color:#2c3e50;">FEE INVOICE</h2>
                                <p style="margin:4px 0; color:#777; font-size:13px;">Invoice #{{ $payment->invoice_number ?? 'N/A' }}</p>
                            </div>
                            <div style="text-align:right;">
                                @php $status = $payment->status ?? 'pending'; @endphp
                                <span class="label label-{{ $status === 'paid' ? 'success' : ($status === 'pending' ? 'warning' : ($status === 'partial' ? 'info' : 'danger')) }}"
                                    style="font-size:14px; padding:6px 14px;">
                                    {{ strtoupper($status) }}
                                </span>
                                <p style="margin:6px 0 0; font-size:12px; color:#999;">
                                    Due: {{ $payment->due_date ? \Carbon\Carbon::parse($payment->due_date)->format('d M Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>

                        {{-- Student & Fee Info --}}
                        <div class="row" style="padding:0 20px 20px;">
                            <div class="col-lg-6">
                                <h5 style="color:#555; margin-bottom:10px;">Student Information</h5>
                                <table class="table table-bordered table-condensed">
                                    <tr><th style="width:40%">Name</th><td>{{ $payment->student?->name ?? 'N/A' }}</td></tr>
                                    <tr><th>Class</th><td>{{ $payment->structure?->schoolClass?->name ?? 'N/A' }}</td></tr>
                                    <tr><th>Admission No</th><td>{{ $payment->student?->studentProfile?->admission_no ?? 'N/A' }}</td></tr>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <h5 style="color:#555; margin-bottom:10px;">Fee Details</h5>
                                <table class="table table-bordered table-condensed">
                                    <tr><th style="width:45%">Fee Type</th><td>{{ $payment->structure?->name ?? 'N/A' }}</td></tr>
                                    <tr><th>Category</th><td>{{ $payment->structure?->category?->name ?? 'N/A' }}</td></tr>
                                    <tr><th>Frequency</th><td>{{ ucfirst(str_replace('_',' ', $payment->structure?->frequency ?? '')) ?: 'N/A' }}</td></tr>
                                </table>
                            </div>
                        </div>

                        {{-- Amount Breakdown --}}
                        <div style="padding:0 20px 20px;">
                            <h5 style="color:#555; margin-bottom:10px;">Amount Breakdown</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Fee Amount</th>
                                    <td class="text-right">PKR {{ number_format($payment->amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Discount</th>
                                    <td class="text-right" style="color:#e74c3c;">- PKR {{ number_format($payment->discount ?? 0, 2) }}</td>
                                </tr>
                                <tr style="background:#f8f8f8; font-weight:700;">
                                    <th>Net Payable</th>
                                    <td class="text-right">PKR {{ number_format(($payment->amount ?? 0) - ($payment->discount ?? 0), 2) }}</td>
                                </tr>
                            </table>
                        </div>

                        {{-- Payment Info --}}
                        @if($payment->payment_date)
                        <div style="padding:0 20px 20px;">
                            <h5 style="color:#555; margin-bottom:10px;">Payment Information</h5>
                            <table class="table table-bordered table-condensed">
                                <tr><th style="width:35%">Payment Date</th><td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td></tr>
                                <tr><th>Method</th><td>{{ ucfirst(str_replace('_',' ', $payment->payment_method ?? '')) ?: 'N/A' }}</td></tr>
                                <tr><th>Transaction Ref</th><td>{{ $payment->transaction_reference ?? 'N/A' }}</td></tr>
                            </table>
                        </div>
                        @endif

                        {{-- Actions --}}
                        <div style="padding:0 20px 20px; display:flex; gap:10px;">
                            <button onclick="window.print()" class="btn btn-primary">
                                <i class="fa fa-print"></i> Print Invoice
                            </button>
                            <a href="{{ route('fees.payments.index') }}" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Back to Payments
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-tenant-app-layout>

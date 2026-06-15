<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @php $currency = 'PKR '; @endphp

    @push('css')
        <x-accountant-styles />
    @endpush

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-money"></i> Collect Payment
                </h3>
                <small class="text-muted">Invoice {{ $fee->invoice_number }} — {{ $fee->student->name ?? 'Student' }}</small>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
                <a href="{{ route('accountant.fees.show', $fee) }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Invoice
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <form action="{{ route('accountant.fees.collect.store', $fee) }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Outstanding Balance</label>
                                    <input type="text" class="form-control" value="{{ $currency }}{{ number_format($fee->balance, 2) }}" readonly style="background:#f8f8f8; font-weight:700;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount Received <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" id="collect_amount" class="form-control"
                                        step="0.01" min="0.01" max="{{ $fee->balance }}"
                                        value="{{ old('amount', $fee->balance) }}" required>
                                    @error('amount')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Date <span class="text-danger">*</span></label>
                                    <input type="date" name="payment_date" class="form-control"
                                        value="{{ old('payment_date', now()->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" class="form-control" required>
                                        @foreach(['cash','cheque','card','bank_transfer','online'] as $method)
                                            <option value="{{ $method }}" {{ old('payment_method', 'cash') === $method ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $method)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Transaction Reference</label>
                                    <input type="text" name="transaction_reference" class="form-control"
                                        placeholder="Cheque no / TXN ID" value="{{ old('transaction_reference') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-default btn-sm" id="pay_full_btn">
                                    Pay full balance
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-check"></i> Record Payment & Print Receipt
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-accountant-guide screen="fees-collect" />

                <div class="white-box">
                    <h5 style="margin-top:0;">Invoice Summary</h5>
                    <table class="table table-condensed table-bordered" style="font-size:13px;">
                        <tr><th>Student</th><td>{{ $fee->student->name ?? '—' }}</td></tr>
                        <tr><th>Fee Type</th><td>{{ $fee->structure->name ?? '—' }}</td></tr>
                        <tr><th>Net Payable</th><td>{{ $currency }}{{ number_format($fee->net_payable, 2) }}</td></tr>
                        <tr><th>Already Paid</th><td>{{ $currency }}{{ number_format($fee->paid, 2) }}</td></tr>
                        <tr><th>Balance Due</th><td class="text-danger"><strong>{{ $currency }}{{ number_format($fee->balance, 2) }}</strong></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
            document.getElementById('pay_full_btn').addEventListener('click', function () {
                document.getElementById('collect_amount').value = {{ json_encode(number_format($fee->balance, 2, '.', '')) }};
            });
        </script>
    @endpush
</x-tenant-app-layout>

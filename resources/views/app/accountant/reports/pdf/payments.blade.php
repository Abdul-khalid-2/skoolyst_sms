<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payments Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .meta { color: #666; font-size: 10px; margin-bottom: 14px; }
        .filters { margin-bottom: 12px; font-size: 10px; }
        .filters span { display: inline-block; margin-right: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 5px 6px; text-align: left; }
        th { background: #f0f0f0; font-weight: bold; }
        .text-right { text-align: right; }
        .summary { margin-top: 12px; font-size: 11px; }
        .summary strong { margin-right: 18px; }
    </style>
</head>
<body>
    <h1>Payments Report</h1>
    <div class="meta">{{ config('app.name') }} &mdash; Generated {{ now()->format('d M Y, h:i A') }}</div>

    @if(!empty($filters))
        <div class="filters">
            <strong>Filters:</strong>
            @foreach($filters as $label => $value)
                <span>{{ $label }}: {{ $value }}</span>
            @endforeach
        </div>
    @else
        <div class="filters"><strong>Filters:</strong> All records</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Student</th>
                <th>Invoice</th>
                <th class="text-right">Amount</th>
                <th>Method</th>
                <th>Received By</th>
                <th>Reference</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $i => $payment)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '—' }}</td>
                    <td>{{ $payment->fee->student->name ?? '—' }}</td>
                    <td>{{ $payment->fee->invoice_number ?? '—' }}</td>
                    <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? '—')) }}</td>
                    <td>{{ $payment->receivedBy->name ?? '—' }}</td>
                    <td>{{ $payment->transaction_reference ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center;">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Collected: PKR {{ number_format($totalAmount, 2) }}</strong>
        <strong>Records: {{ $payments->count() }}</strong>
    </div>
</body>
</html>

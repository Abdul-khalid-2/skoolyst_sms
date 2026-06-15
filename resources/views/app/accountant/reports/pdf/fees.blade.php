<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fees Report</title>
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
    <h1>Fee Invoices Report</h1>
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
                <th>Invoice</th>
                <th>Student</th>
                <th>Fee Type</th>
                <th>Due Date</th>
                <th class="text-right">Payable</th>
                <th class="text-right">Paid</th>
                <th class="text-right">Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fees as $i => $fee)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $fee->invoice_number ?? '—' }}</td>
                    <td>{{ $fee->student->name ?? '—' }}</td>
                    <td>{{ $fee->structure->name ?? 'Fee' }}</td>
                    <td>{{ $fee->due_date ? \Carbon\Carbon::parse($fee->due_date)->format('d M Y') : '—' }}</td>
                    <td class="text-right">{{ number_format($fee->net_payable, 2) }}</td>
                    <td class="text-right">{{ number_format($fee->paid, 2) }}</td>
                    <td class="text-right">{{ number_format($fee->balance, 2) }}</td>
                    <td>{{ ucfirst($fee->status ?? '—') }}</td>
                </tr>
            @empty
                <tr><td colspan="9" style="text-align:center;">No records found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <strong>Total Payable: PKR {{ number_format($totals['payable'], 2) }}</strong>
        <strong>Total Paid: PKR {{ number_format($totals['paid'], 2) }}</strong>
        <strong>Total Balance: PKR {{ number_format($totals['balance'], 2) }}</strong>
        <strong>Records: {{ $fees->count() }}</strong>
    </div>
</body>
</html>

@props(['screen' => 'dashboard'])

<div class="white-box accountant-guide-box" style="margin-bottom: 20px;">
    <h5 style="margin-top:0; color:#3c8dbc;">
        <i class="fa fa-lightbulb-o"></i>
        @switch($screen)
            @case('dashboard') How to use the Accountant Dashboard @break
            @case('fees-index') How to manage fee invoices @break
            @case('fees-show') Understanding an invoice @break
            @case('fees-collect') How to collect payment @break
            @case('payments-index') How to use payment history @break
            @case('payments-create') How to record a payment @break
            @case('payments-show') Payment details @break
            @case('payments-receipt') Payment receipt @break
            @default Accountant guide
        @endswitch
    </h5>
    <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
        @if($screen === 'dashboard')
            <li>Review <strong>Total Billed</strong>, <strong>Collected</strong>, <strong>Outstanding</strong>, and <strong>Collection Rate</strong> at a glance.</li>
            <li>Use <strong>Record Payment</strong> to create a new invoice or collect fee immediately.</li>
            <li>Check <strong>Pending Overview</strong> for unpaid or overdue invoices.</li>
            <li>Click any recent payment’s print icon to open its receipt.</li>
        @elseif($screen === 'fees-index')
            <li>Filter by <strong>student name</strong>, <strong>status</strong> (pending/partial/paid/cancelled), or <strong>due date range</strong>.</li>
            <li>Click <strong>View</strong> (<i class="fa fa-eye"></i>) to open invoice details and payment history.</li>
            <li>Click <strong>Collect</strong> (<i class="fa fa-money"></i>) to record payment against an unpaid invoice.</li>
            <li>Use <strong>Generate PDF Report</strong> to download a filtered fees report.</li>
            <li>Red balance amounts indicate money still owed; overdue invoices show an <em>Overdue</em> label.</li>
        @elseif($screen === 'fees-show')
            <li>This page shows the full invoice breakdown: student, fee type, amounts, and status.</li>
            <li><strong>Payment History</strong> lists every collection made against this invoice.</li>
            <li>Use <strong>Collect Payment</strong> if a balance remains.</li>
            <li>Click <strong>Receipt</strong> on any past payment to print it.</li>
        @elseif($screen === 'fees-collect')
            <li>Enter the <strong>Amount Received</strong> — it cannot exceed the outstanding balance.</li>
            <li>Click <strong>Pay full balance</strong> to auto-fill the remaining amount.</li>
            <li>Select the <strong>Payment Method</strong> and add a <strong>Transaction Reference</strong> (cheque no., TXN ID).</li>
            <li>After saving, you are redirected to a printable receipt.</li>
            <li>Partial payments update the invoice status to <em>Partial</em>; full payment marks it <em>Paid</em>.</li>
        @elseif($screen === 'payments-index')
            <li>Filter by <strong>student</strong>, <strong>date range</strong>, or <strong>payment method</strong>.</li>
            <li>The header shows the <strong>filtered total</strong> of all matching payments.</li>
            <li>Click <strong>View</strong> for payment details or <strong>Print</strong> for the receipt.</li>
            <li>Use <strong>Generate PDF Report</strong> to download a filtered payments report.</li>
        @elseif($screen === 'payments-create')
            <li>Select <strong>Class</strong> first, then pick the <strong>Student</strong>.</li>
            <li>Choose a <strong>Fee Structure</strong> — the amount fills in automatically.</li>
            <li>Apply a <strong>Discount</strong> if needed; net payable updates instantly.</li>
            <li>Leave <strong>Amount Received</strong> empty to create a pending invoice only.</li>
            <li>Fill in amount received and payment details to collect immediately and print a receipt.</li>
        @elseif($screen === 'payments-show')
            <li>Review payment amount, method, reference, and who received it.</li>
            <li>See the invoice balance after this payment was applied.</li>
            <li>Use <strong>Print Receipt</strong> or <strong>Collect Remaining</strong> if balance is still due.</li>
        @elseif($screen === 'payments-receipt')
            <li>This is the official payment receipt — use <strong>Print Receipt</strong> to print or save as PDF.</li>
            <li>Receipt shows student details, invoice number, amount paid, and remaining balance.</li>
            <li>Share this receipt with the parent or student as proof of payment.</li>
        @endif
    </ol>
</div>

@if(in_array($screen, ['fees-index', 'payments-index', 'fees-collect', 'payments-create']))
    <div class="white-box accountant-guide-box" style="margin-bottom: 20px;">
        <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-info-circle"></i> Status guide</h5>
        <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
            <tbody>
                <tr><td style="width:28%"><span class="label label-default">Pending</span></td><td>Invoice created, no payment received yet.</td></tr>
                <tr><td><span class="label label-warning">Partial</span></td><td>Some payment received, balance still due.</td></tr>
                <tr><td><span class="label label-success">Paid</span></td><td>Full amount collected.</td></tr>
                <tr><td><span class="label label-danger">Cancelled</span></td><td>Invoice voided — excluded from collection.</td></tr>
            </tbody>
        </table>
    </div>
@endif

@props(['screen' => 'structures-index'])

{{-- How-to --}}
<div class="sparkline12-list" style="margin-bottom: 20px;">
    <div class="sparkline12-graph">
        <div class="basic-login-form-ad">
            <h5 style="margin-top:0; color:#3c8dbc;">
                <i class="fa fa-lightbulb-o"></i>
                @switch($screen)
                    @case('categories-index') How to manage fee categories @break
                    @case('structures-index') How to manage fee structures @break
                    @case('structures-create') How to create a fee structure @break
                    @case('structures-edit') How to edit a fee structure @break
                    @case('payments-show') Understanding this invoice @break
                    @case('payments-create') How to record a payment @break
                    @default Fees guide
                @endswitch
            </h5>
            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                @if($screen === 'categories-index')
                    <li>Fee <strong>categories</strong> group related charges — e.g. Tuition, Transport, Lab, Admission.</li>
                    <li>Create categories <strong>before</strong> adding fee structures; every structure must belong to one category.</li>
                    <li>Click <strong>Add Category</strong> to create a new type with a name and optional description.</li>
                    <li>The <strong>Structures</strong> column shows how many fee structures use each category.</li>
                    <li>Use <strong>Edit</strong> (<i class="fa fa-edit"></i>) to rename or update a category; use search to find one quickly.</li>
                    <li>Do not delete a category that still has structures linked — remove or reassign structures first.</li>
                @elseif($screen === 'structures-index')
                    <li>Fee <strong>structures</strong> define the actual amounts charged — name, class, amount, and billing frequency.</li>
                    <li>Click <strong>Add Structure</strong> to create a new fee template for a category and class.</li>
                    <li><strong>Class</strong> shows which grade the fee applies to; <em>All Classes</em> means school-wide.</li>
                    <li><strong>Amount</strong> and <strong>Frequency</strong> tell accountants how much to bill and how often.</li>
                    <li>Use <strong>Edit</strong> to update a structure — amount changes apply to new invoices only.</li>
                    <li>Accountants pick structures when recording payments or generating student invoices.</li>
                @elseif($screen === 'structures-create')
                    <li>Give the structure a clear <strong>name</strong> (e.g. Monthly Tuition — Class 5).</li>
                    <li>Select the <strong>Fee Category</strong> it belongs to (Tuition, Transport, etc.).</li>
                    <li>Choose a <strong>Class</strong>, or leave as <em>All Classes</em> for school-wide fees.</li>
                    <li>Enter the <strong>Amount</strong> in PKR and set <strong>Frequency</strong> + optional <strong>Due Date</strong>.</li>
                    <li>Click <strong>Save Structure</strong> — it becomes available when recording student payments.</li>
                @elseif($screen === 'structures-edit')
                    <li>Update the structure <strong>name</strong>, <strong>category</strong>, or <strong>class</strong> if the fee type changed.</li>
                    <li>Changing the <strong>amount</strong> affects new invoices only — existing student invoices keep their original amounts.</li>
                    <li>Set <strong>Frequency</strong> to match how often this fee is charged (monthly tuition, one-time admission, etc.).</li>
                    <li>Use <strong>Due Date</strong> as the default deadline when this structure is used for billing.</li>
                    <li>Click <strong>Update Structure</strong> to save. Cancel returns to the structures list without saving.</li>
                @elseif($screen === 'payments-show')
                    <li>This page shows the full <strong>fee invoice</strong> for a student — status, amounts, and payment details.</li>
                    <li>Check the <strong>status badge</strong>: Pending, Partial, Paid, or Cancelled.</li>
                    <li><strong>Amount Breakdown</strong> shows fee amount, discount, and net payable.</li>
                    <li>If payment was received, the <strong>Payment Information</strong> section shows date, method, and reference.</li>
                    <li>Use <strong>Print Invoice</strong> to save or share a copy with the parent or accounts office.</li>
                @elseif($screen === 'payments-create')
                    <li>Select class and student, then pick the fee structure — amount fills automatically.</li>
                    <li>Apply a discount if needed; set status to Pending, Paid, or Partial.</li>
                    <li>Add payment method and transaction reference when money is collected.</li>
                @endif
            </ol>
        </div>
    </div>
</div>

@if($screen === 'categories-index')
    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-file-text-o"></i> Common categories</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:42%; background:#f5f5f5;">Tuition Fee</th><td>Monthly or term-wise class fees</td></tr>
                        <tr><th style="background:#f5f5f5;">Transport Fee</th><td>Bus or van charges</td></tr>
                        <tr><th style="background:#f5f5f5;">Admission Fee</th><td>One-time enrollment charge</td></tr>
                        <tr><th style="background:#f5f5f5;">Lab / Activity</th><td>Science lab, sports, or club fees</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="sparkline12-list">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#e08e0b;"><i class="fa fa-exclamation-triangle"></i> Setup order</h5>
                <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                    <li>Step 1 — Create <strong>Categories</strong> (this page).</li>
                    <li>Step 2 — Create <strong>Fee Structures</strong> under each category.</li>
                    <li>Step 3 — Accountants record payments using those structures.</li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if($screen === 'structures-index')
    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-info-circle"></i> Frequency guide</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:35%; background:#f5f5f5;">One Time</th><td>Charged once (e.g. admission).</td></tr>
                        <tr><th style="background:#f5f5f5;">Monthly</th><td>Recurs every month.</td></tr>
                        <tr><th style="background:#f5f5f5;">Quarterly</th><td>Every three months.</td></tr>
                        <tr><th style="background:#f5f5f5;">Yearly</th><td>Once per academic year.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="sparkline12-list">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#e08e0b;"><i class="fa fa-exclamation-triangle"></i> Things to keep in mind</h5>
                <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                    <li>Ensure fee categories exist before creating structures.</li>
                    <li>Class-specific structures take priority when billing that class.</li>
                    <li>Deleting a structure does not remove past invoices already created from it.</li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if(in_array($screen, ['structures-create', 'structures-edit']))
    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-file-text-o"></i> Example</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:42%; background:#f5f5f5;">Name</th><td>Monthly Tuition — Class 5</td></tr>
                        <tr><th style="background:#f5f5f5;">Category</th><td>Tuition Fee</td></tr>
                        <tr><th style="background:#f5f5f5;">Class</th><td>Class 5</td></tr>
                        <tr><th style="background:#f5f5f5;">Amount</th><td>PKR 5,000.00</td></tr>
                        <tr><th style="background:#f5f5f5;">Frequency</th><td>Monthly</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-info-circle"></i> Frequency guide</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><th style="width:35%; background:#f5f5f5;">One Time</th><td>Charged once (e.g. admission).</td></tr>
                        <tr><th style="background:#f5f5f5;">Monthly</th><td>Recurs every month.</td></tr>
                        <tr><th style="background:#f5f5f5;">Quarterly</th><td>Every three months.</td></tr>
                        <tr><th style="background:#f5f5f5;">Yearly</th><td>Once per academic year.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@if($screen === 'structures-edit')
    <div class="sparkline12-list">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#e08e0b;"><i class="fa fa-exclamation-triangle"></i> Things to keep in mind</h5>
                <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                    <li>Do not delete a structure that is already linked to active invoices — edit amount carefully instead.</li>
                    <li>Class-specific structures override general ones when billing that class.</li>
                    <li>Accountants use structures when creating invoices and collecting payments.</li>
                </ul>
            </div>
        </div>
    </div>
@endif

@if($screen === 'payments-show')
    <div class="sparkline12-list" style="margin-bottom: 20px;">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#3c8dbc;"><i class="fa fa-info-circle"></i> Status guide</h5>
                <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                    <tbody>
                        <tr><td style="width:28%"><span class="label label-warning">Pending</span></td><td>No payment received yet.</td></tr>
                        <tr><td><span class="label label-info">Partial</span></td><td>Some amount paid; balance remains.</td></tr>
                        <tr><td><span class="label label-success">Paid</span></td><td>Fully settled.</td></tr>
                        <tr><td><span class="label label-danger">Cancelled</span></td><td>Invoice voided.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="sparkline12-list">
        <div class="sparkline12-graph">
            <div class="basic-login-form-ad">
                <h5 style="margin-top:0; color:#e08e0b;"><i class="fa fa-exclamation-triangle"></i> Things to keep in mind</h5>
                <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom: 0;">
                    <li>To collect more payment on a pending/partial invoice, use the accountant <strong>Collect Payment</strong> flow.</li>
                    <li>Print this page before handing a receipt to the parent if no separate receipt was generated.</li>
                    <li>Net Payable = Fee Amount minus Discount.</li>
                </ul>
            </div>
        </div>
    </div>
@endif

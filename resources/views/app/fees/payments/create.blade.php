<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
    @endpush
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Record Fee Payment" :back-route="route('fees.payments.index')" />

            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('fees.payments.store') }}" method="POST">
                                @csrf

                                <div class="row">

                                    {{-- Student & Fee Section --}}
                                    <div class="col-lg-12">
                                        <h4 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                                            <i class="fa fa-user"></i> Student & Fee Details
                                        </h4>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Class</label>
                                            <select id="pay_class_id" class="form-control">
                                                <option value="">-- Select Class --</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Student <span class="text-danger">*</span></label>
                                            <select name="student_id" id="pay_student_id" class="form-control" required>
                                                <option value="">-- Select Student --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Fee Structure <span class="text-danger">*</span></label>
                                            <select name="structure_id" id="pay_structure_id" class="form-control" required>
                                                <option value="">-- Select Fee Structure --</option>
                                                @foreach($structures as $s)
                                                    <option value="{{ $s->id }}" data-amount="{{ $s->amount }}">
                                                        {{ $s->name }} — PKR {{ number_format($s->amount, 2) }}
                                                        @if($s->schoolClass) ({{ $s->schoolClass->name }}) @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Amount Details --}}
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <h4 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                                            <i class="fa fa-money"></i> Amount Details
                                        </h4>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Fee Amount (PKR)</label>
                                            <input type="number" name="amount" id="pay_amount" class="form-control"
                                                placeholder="0.00" step="0.01" min="0" value="{{ old('amount') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Discount (PKR)</label>
                                            <input type="number" name="discount" id="pay_discount" class="form-control"
                                                placeholder="0.00" step="0.01" min="0" value="{{ old('discount', 0) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Net Payable (PKR)</label>
                                            <input type="number" id="pay_net" class="form-control" placeholder="0.00" readonly
                                                style="background:#f8f8f8; font-weight:700;">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label>Due Date <span class="text-danger">*</span></label>
                                            <input type="date" name="due_date" class="form-control"
                                                value="{{ old('due_date', now()->format('Y-m-d')) }}" required>
                                        </div>
                                    </div>

                                    {{-- Payment Info --}}
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <h4 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                                            <i class="fa fa-credit-card"></i> Payment Information
                                        </h4>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="pending"  {{ old('status') === 'pending'  ? 'selected' : '' }}>Pending</option>
                                                <option value="paid"     {{ old('status') === 'paid'     ? 'selected' : '' }}>Paid</option>
                                                <option value="partial"  {{ old('status') === 'partial'  ? 'selected' : '' }}>Partial</option>
                                                <option value="cancelled"{{ old('status') === 'cancelled'? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                            <select name="payment_method" class="form-control">
                                                <option value="">-- Select --</option>
                                                <option value="cash"         {{ old('payment_method') === 'cash'          ? 'selected' : '' }}>Cash</option>
                                                <option value="cheque"       {{ old('payment_method') === 'cheque'        ? 'selected' : '' }}>Cheque</option>
                                                <option value="card"         {{ old('payment_method') === 'card'          ? 'selected' : '' }}>Card</option>
                                                <option value="bank_transfer"{{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                <option value="online"       {{ old('payment_method') === 'online'        ? 'selected' : '' }}>Online</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Transaction Reference</label>
                                            <input type="text" name="transaction_reference" class="form-control"
                                                placeholder="Cheque no / TXN ID"
                                                value="{{ old('transaction_reference') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Notes</label>
                                            <textarea name="notes" class="form-control" rows="2"
                                                placeholder="Optional notes">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Payment
                                        </button>
                                        <a href="{{ route('fees.payments.index') }}" class="btn btn-default" style="margin-left:8px;">
                                            Cancel
                                        </a>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">

                {{-- Steps card --}}
                <div class="sparkline12-list" style="margin-bottom: 20px;">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-lightbulb-o"></i> How to record a payment
                            </h5>
                            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px;">
                                <li>Select the <strong>Class</strong> to filter students, then pick the <strong>Student</strong>.</li>
                                <li>Choose the <strong>Fee Structure</strong> — the amount fills in automatically.</li>
                                <li>Apply a <strong>Discount</strong> if applicable; the <em>Net Payable</em> updates instantly.</li>
                                <li>Set the <strong>Due Date</strong> for this invoice.</li>
                                <li>Set the <strong>Status</strong>: <em>Pending</em> for an unpaid invoice, <em>Paid</em> once settled, <em>Partial</em> if only part was paid.</li>
                                <li>Select the <strong>Payment Method</strong> and enter a <strong>Transaction Reference</strong> (cheque no., TXN ID, etc.).</li>
                                <li>Add optional <strong>Notes</strong>, then click <strong>Save Payment</strong>.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- Example card --}}
                <div class="sparkline12-list" style="margin-bottom: 20px;">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-file-text-o"></i> Example
                            </h5>
                            <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <th style="width:45%; background:#f5f5f5;">Student</th>
                                        <td>Ahmed Raza — Class 8</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Fee Structure</th>
                                        <td>Monthly Tuition Fee</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Amount</th>
                                        <td>PKR 5,000.00</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Discount</th>
                                        <td>PKR 500.00</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Net Payable</th>
                                        <td><strong>PKR 4,500.00</strong></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Status</th>
                                        <td><span class="label label-success">Paid</span></td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Method</th>
                                        <td>Bank Transfer</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Reference</th>
                                        <td>TXN-20260601-001</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Status guide --}}
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-info-circle"></i> Status guide
                            </h5>
                            <table class="table table-condensed" style="font-size: 12px; margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <td><span class="label label-warning">Pending</span></td>
                                        <td style="color:#555;">Invoice created, payment not yet received.</td>
                                    </tr>
                                    <tr>
                                        <td><span class="label label-success">Paid</span></td>
                                        <td style="color:#555;">Full amount has been collected.</td>
                                    </tr>
                                    <tr>
                                        <td><span class="label label-info">Partial</span></td>
                                        <td style="color:#555;">Only part of the fee has been paid.</td>
                                    </tr>
                                    <tr>
                                        <td><span class="label label-danger">Cancelled</span></td>
                                        <td style="color:#555;">Invoice voided — excluded from reports.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {

            // Load students when class changes
            $('#pay_class_id').on('change', function () {
                var classId = $(this).val();
                var $student = $('#pay_student_id');
                $student.html('<option value="">Loading...</option>').prop('disabled', true);

                if (!classId) {
                    $student.html('<option value="">-- Select Student --</option>').prop('disabled', false);
                    return;
                }

                $.ajax({
                    url: '{{ route('fees.payments.students') }}',
                    data: { class_id: classId },
                    success: function (res) {
                        var opts = '<option value="">-- Select Student --</option>';
                        $.each(res.students, function (i, s) {
                            opts += '<option value="' + s.id + '">' + s.name + '</option>';
                        });
                        $student.html(opts).prop('disabled', false);
                    },
                    error: function () {
                        $student.html('<option value="">-- Select Student --</option>').prop('disabled', false);
                    }
                });
            });

            // Auto-fill amount when structure selected
            $('#pay_structure_id').on('change', function () {
                var amount = $(this).find(':selected').data('amount') || 0;
                $('#pay_amount').val(amount);
                calcNet();
            });

            $('#pay_discount').on('input', calcNet);

            function calcNet() {
                var amount   = parseFloat($('#pay_amount').val())  || 0;
                var discount = parseFloat($('#pay_discount').val()) || 0;
                $('#pay_net').val(Math.max(0, amount - discount).toFixed(2));
            }
        });
        </script>
    @endpush
</x-tenant-app-layout>

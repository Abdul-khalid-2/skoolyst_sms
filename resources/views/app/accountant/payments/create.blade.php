<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    @push('css')
        <x-accountant-styles />
    @endpush

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <h3 style="margin: 0; line-height: 34px;">
                    <i class="fa fa-plus-circle"></i> Record Payment
                </h3>
                <small class="text-muted">Create a new fee invoice and optionally collect payment now</small>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
                <a href="{{ route('accountant.payments') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <form action="{{ route('accountant.payments.store') }}" method="POST">
                        @csrf

                        <h5 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                            <i class="fa fa-user"></i> Student & Fee
                        </h5>
                        <div class="row">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Student <span class="text-danger">*</span></label>
                                    <select name="student_id" id="pay_student_id" class="form-control" required>
                                        <option value="">-- Select Student --</option>
                                    </select>
                                    @error('student_id')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
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
                        </div>

                        <h5 style="border-bottom:1px solid #eee; padding-bottom:8px; margin:20px 0 15px;">
                            <i class="fa fa-money"></i> Invoice Amount
                        </h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fee Amount (PKR) <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" id="pay_amount" class="form-control"
                                        step="0.01" min="0" value="{{ old('amount') }}" required readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Discount (PKR)</label>
                                    <input type="number" name="discount" id="pay_discount" class="form-control"
                                        step="0.01" min="0" value="{{ old('discount', 0) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Net Payable (PKR)</label>
                                    <input type="number" id="pay_net" class="form-control" readonly style="background:#f8f8f8; font-weight:700;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Due Date <span class="text-danger">*</span></label>
                                    <input type="date" name="due_date" class="form-control"
                                        value="{{ old('due_date', now()->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <h5 style="border-bottom:1px solid #eee; padding-bottom:8px; margin:20px 0 15px;">
                            <i class="fa fa-credit-card"></i> Payment (optional)
                        </h5>
                        <p class="text-muted" style="font-size:13px; margin-bottom:15px;">
                            Leave amount received empty to create a pending invoice only. Fill it in to record payment immediately.
                        </p>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Amount Received (PKR)</label>
                                    <input type="number" name="amount_received" id="pay_received" class="form-control"
                                        step="0.01" min="0" value="{{ old('amount_received') }}" placeholder="0.00">
                                    @error('amount_received')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Payment Date</label>
                                    <input type="date" name="payment_date" class="form-control"
                                        value="{{ old('payment_date', now()->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select name="payment_method" class="form-control">
                                        <option value="">-- Select --</option>
                                        @foreach(['cash','cheque','card','bank_transfer','online'] as $method)
                                            <option value="{{ $method }}" {{ old('payment_method') === $method ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $method)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                <a href="{{ route('accountant.payments') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-accountant-guide screen="payments-create" />
            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(document).ready(function () {
                $('#pay_class_id').on('change', function () {
                    var classId = $(this).val();
                    var $student = $('#pay_student_id');
                    $student.html('<option value="">Loading...</option>').prop('disabled', true);

                    if (!classId) {
                        $student.html('<option value="">-- Select Student --</option>').prop('disabled', false);
                        return;
                    }

                    $.ajax({
                        url: '{{ route('accountant.payments.students') }}',
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

                $('#pay_structure_id').on('change', function () {
                    var amount = $(this).find(':selected').data('amount') || 0;
                    $('#pay_amount').val(amount);
                    calcNet();
                });

                $('#pay_discount, #pay_received').on('input', calcNet);

                function calcNet() {
                    var amount = parseFloat($('#pay_amount').val()) || 0;
                    var discount = parseFloat($('#pay_discount').val()) || 0;
                    var net = Math.max(0, amount - discount);
                    $('#pay_net').val(net.toFixed(2));
                    $('#pay_received').attr('max', net.toFixed(2));
                }
            });
        </script>
    @endpush
</x-tenant-app-layout>

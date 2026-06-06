<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Create Fee Structure" :back-route="route('fees.structures.index')" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('fees.structures.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Structure Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                placeholder="e.g. Monthly Tuition - Class 5"
                                                value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Fee Category <span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Class</label>
                                            <select name="class_id" class="form-control">
                                                <option value="">All Classes</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Amount (PKR) <span class="text-danger">*</span></label>
                                            <input type="number" name="amount" class="form-control"
                                                placeholder="0.00" step="0.01" min="0"
                                                value="{{ old('amount') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Frequency</label>
                                            <select name="frequency" class="form-control">
                                                <option value="">-- Select --</option>
                                                <option value="one_time"   {{ old('frequency') === 'one_time'   ? 'selected' : '' }}>One Time</option>
                                                <option value="monthly"    {{ old('frequency') === 'monthly'    ? 'selected' : '' }}>Monthly</option>
                                                <option value="quarterly"  {{ old('frequency') === 'quarterly'  ? 'selected' : '' }}>Quarterly</option>
                                                <option value="yearly"     {{ old('frequency') === 'yearly'     ? 'selected' : '' }}>Yearly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Due Date</label>
                                            <input type="date" name="due_date" class="form-control"
                                                value="{{ old('due_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Structure
                                        </button>
                                        <a href="{{ route('fees.structures.index') }}" class="btn btn-default" style="margin-left:8px;">
                                            Cancel
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-10 col-sm-12 col-xs-12">

                {{-- Tips card --}}
                <div class="sparkline12-list" style="margin-bottom: 20px;">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-lightbulb-o"></i> What is a fee structure?
                            </h5>
                            <p style="color:#555; font-size:13px; line-height:1.7;">
                                A fee structure attaches an <strong>amount</strong> to a fee category for a
                                particular class. It's the template used when recording student payments.
                            </p>
                            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px;">
                                <li>Give it a clear <strong>name</strong> (e.g. Monthly Tuition - Class 5).</li>
                                <li>Pick the <strong>Fee Category</strong> it belongs to.</li>
                                <li>Choose a <strong>Class</strong>, or leave as <em>All Classes</em> to apply school-wide.</li>
                                <li>Enter the <strong>Amount</strong> in PKR.</li>
                                <li>Set the <strong>Frequency</strong> (one-time, monthly, etc.) and optional <strong>Due Date</strong>.</li>
                                <li>Click <strong>Save Structure</strong>.</li>
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
                                        <th style="width:42%; background:#f5f5f5;">Name</th>
                                        <td>Monthly Tuition - Class 5</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Category</th>
                                        <td>Tuition Fee</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Class</th>
                                        <td>Class 5</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Amount</th>
                                        <td>PKR 5,000.00</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Frequency</th>
                                        <td>Monthly</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Due Date</th>
                                        <td>5th of each month</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Frequency guide --}}
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-info-circle"></i> Frequency guide
                            </h5>
                            <table class="table table-condensed" style="font-size: 12px; margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <th style="width:35%; background:#f5f5f5;">One Time</th>
                                        <td style="color:#555;">Charged once (e.g. admission).</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Monthly</th>
                                        <td style="color:#555;">Recurs every month.</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Quarterly</th>
                                        <td style="color:#555;">Every three months.</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Yearly</th>
                                        <td style="color:#555;">Once per academic year.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-tenant-app-layout>

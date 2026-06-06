<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Add Fee Category" :back-route="route('fees.categories.index')" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('fees.categories.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Category Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" placeholder="e.g. Tuition Fee, Transport Fee"
                                                value="{{ old('name') }}" required>
                                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3"
                                                placeholder="Optional description">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Category
                                        </button>
                                        <a href="{{ route('fees.categories.index') }}" class="btn btn-default" style="margin-left:8px;">
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
                                <i class="fa fa-lightbulb-o"></i> What is a fee category?
                            </h5>
                            <p style="color:#555; font-size:13px; line-height:1.7;">
                                A fee category is a <strong>type of charge</strong> your school collects.
                                Categories are the building blocks you later attach amounts to when
                                creating <strong>fee structures</strong>.
                            </p>
                            <ol style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px;">
                                <li>Give the category a clear <strong>name</strong> (e.g. Tuition Fee).</li>
                                <li>Add an optional <strong>description</strong> to explain what it covers.</li>
                                <li>Click <strong>Save Category</strong>.</li>
                                <li>Next, create a <strong>Fee Structure</strong> that assigns an amount to this category for a class.</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- Example card --}}
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#3c8dbc;">
                                <i class="fa fa-list-ul"></i> Common examples
                            </h5>
                            <table class="table table-condensed table-bordered" style="font-size: 12px; margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <th style="width:42%; background:#f5f5f5;">Tuition Fee</th>
                                        <td>Monthly / term teaching charges.</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Transport Fee</th>
                                        <td>School bus / van service.</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Admission Fee</th>
                                        <td>One-time enrolment charge.</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Exam Fee</th>
                                        <td>Per-exam assessment charge.</td>
                                    </tr>
                                    <tr>
                                        <th style="background:#f5f5f5;">Library Fee</th>
                                        <td>Library membership / books.</td>
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

<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Edit Fee Category" :back-route="route('fees.categories.index')" />

            <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('fees.categories.update', $category) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Category Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $category->name) }}" required>
                                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update Category
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
                                <i class="fa fa-lightbulb-o"></i> Editing this category
                            </h5>
                            <p style="color:#555; font-size:13px; line-height:1.7;">
                                Update the <strong>name</strong> or <strong>description</strong> of this fee category.
                                Changes apply everywhere this category is used.
                            </p>
                            <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom:0;">
                                <li>Renaming does <strong>not</strong> affect existing fee structures already linked to it.</li>
                                <li>Keep names short and recognisable for staff.</li>
                                <li>To change an <em>amount</em>, edit the related <strong>Fee Structure</strong> instead — categories carry no amount.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Note card --}}
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <h5 style="margin-top:0; color:#e08e0b;">
                                <i class="fa fa-exclamation-triangle"></i> Good to know
                            </h5>
                            <ul style="padding-left: 18px; line-height: 1.9; color: #555; font-size: 13px; margin-bottom:0;">
                                <li>A category can be tied to multiple fee structures across different classes.</li>
                                <li>Deleting a category may be blocked if structures still reference it.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-tenant-app-layout>

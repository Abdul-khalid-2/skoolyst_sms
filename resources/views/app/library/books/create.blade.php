<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/select2/select2.min.css') }}">
        <style>
            /* Make select2 match the Bootstrap form-control height */
            .select2-container .select2-selection--single { height: 34px; }
            .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 34px; }
            .select2-container--default .select2-selection--single .select2-selection__arrow { height: 32px; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Add New Book" :back-route="route('library.books.index')" />

            <div class="col-lg-8 col-md-11 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('library.books.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                                            <i class="fa fa-book"></i> Book Information
                                        </h4>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Book title" value="{{ old('title') }}" required>
                                            @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>ISBN</label>
                                            <input type="text" name="isbn" class="form-control"
                                                placeholder="978-XXXXXXXXXX" value="{{ old('isbn') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Author</label>
                                            <input type="text" name="author" class="form-control"
                                                placeholder="Author name" value="{{ old('author') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Publisher</label>
                                            <input type="text" name="publisher" class="form-control"
                                                placeholder="Publisher name" value="{{ old('publisher') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Edition</label>
                                            <input type="text" name="edition" class="form-control"
                                                placeholder="e.g. 3rd" value="{{ old('edition') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <div style="display:flex; gap:6px; align-items:flex-start;">
                                                <div style="flex:1; min-width:0;">
                                                    <select name="category" id="book_category" class="form-control">
                                                        <option value="">-- Select Category --</option>
                                                        @foreach(['Science','Mathematics','English','Urdu','Social Studies','Islamic Studies','Computer','History','Geography','Arts','Sports','Reference','Fiction','Non-Fiction','Other'] as $cat)
                                                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="button" id="add_category_btn" class="btn btn-primary"
                                                    title="Add a new category">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                            <small class="text-muted">Search the list, type a new name, or click <strong>+</strong> to add one.</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Shelf / Location</label>
                                            <input type="text" name="shelf_number" class="form-control"
                                                placeholder="e.g. A-12" value="{{ old('shelf_number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Price (PKR)</label>
                                            <input type="number" name="price" class="form-control"
                                                placeholder="0.00" step="0.01" min="0" value="{{ old('price') }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:5px;">
                                        <h4 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                                            <i class="fa fa-cubes"></i> Stock
                                        </h4>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Total Quantity <span class="text-danger">*</span></label>
                                            <input type="number" name="quantity" class="form-control"
                                                placeholder="1" min="1" value="{{ old('quantity', 1) }}" required id="qty_total">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Available Copies <span class="text-danger">*</span></label>
                                            <input type="number" name="available" class="form-control"
                                                placeholder="1" min="0" value="{{ old('available', 1) }}" required id="qty_avail">
                                            <small class="text-muted">Must be ≤ Total Quantity</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save Book
                                        </button>
                                        <a href="{{ route('library.books.index') }}" class="btn btn-default" style="margin-left:8px;">
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
                <x-library-guide screen="books-create" />
            </div>

        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/select2/select2.full.min.js') }}"></script>
        <script>
        $(document).ready(function () {
            $('#qty_total').on('input', function () {
                var max = parseInt($(this).val()) || 0;
                var avail = parseInt($('#qty_avail').val()) || 0;
                if (avail > max) $('#qty_avail').val(max);
                $('#qty_avail').attr('max', max);
            });

            // Searchable category dropdown that also lets you type a brand-new category.
            var $category = $('#book_category');
            $category.select2({
                width: '100%',
                tags: true,
                placeholder: '-- Select Category --',
                allowClear: true
            });

            // "+" button: prompt for a new category, add it if missing, then select it.
            $('#add_category_btn').on('click', function () {
                var name = (prompt('Enter new category name:') || '').trim();
                if (name === '') {
                    return;
                }

                var existing = $category.find('option').filter(function () {
                    return $(this).val().toLowerCase() === name.toLowerCase();
                }).first();

                if (existing.length) {
                    $category.val(existing.val()).trigger('change');
                } else {
                    $category.append(new Option(name, name, true, true)).trigger('change');
                }
            });
        });
        </script>
    @endpush
</x-tenant-app-layout>

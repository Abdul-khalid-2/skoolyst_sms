<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Edit Book" :back-route="route('library.books.show', $book)" />

            <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('library.books.update', $book) }}" method="POST">
                                @csrf
                                @method('PUT')

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
                                                value="{{ old('title', $book->title) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>ISBN</label>
                                            <input type="text" name="isbn" class="form-control"
                                                value="{{ old('isbn', $book->isbn) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Author</label>
                                            <input type="text" name="author" class="form-control"
                                                value="{{ old('author', $book->author) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Publisher</label>
                                            <input type="text" name="publisher" class="form-control"
                                                value="{{ old('publisher', $book->publisher) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Edition</label>
                                            <input type="text" name="edition" class="form-control"
                                                value="{{ old('edition', $book->edition) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select name="category" class="form-control">
                                                <option value="">-- Select Category --</option>
                                                @foreach(['Science','Mathematics','English','Urdu','Social Studies','Islamic Studies','Computer','History','Geography','Arts','Sports','Reference','Fiction','Non-Fiction','Other'] as $cat)
                                                    <option value="{{ $cat }}" {{ old('category', $book->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Shelf / Location</label>
                                            <input type="text" name="shelf_number" class="form-control"
                                                value="{{ old('shelf_number', $book->shelf_number) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Price (PKR)</label>
                                            <input type="number" name="price" class="form-control"
                                                step="0.01" min="0" value="{{ old('price', $book->price) }}">
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
                                                min="1" value="{{ old('quantity', $book->quantity) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Available Copies <span class="text-danger">*</span></label>
                                            <input type="number" name="available" class="form-control"
                                                min="0" value="{{ old('available', $book->available) }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update Book
                                        </button>
                                        <a href="{{ route('library.books.show', $book) }}" class="btn btn-default" style="margin-left:8px;">
                                            Cancel
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-tenant-app-layout>

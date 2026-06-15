<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Issue a Book" :back-route="route('library.issues.index')" />

            <div class="col-lg-8 col-md-11 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('library.issues.store') }}" method="POST">
                                @csrf

                                <div class="row">

                                    {{-- Book Selection --}}
                                    <div class="col-lg-12">
                                        <h4 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                                            <i class="fa fa-book"></i> Select Book
                                        </h4>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Book <span class="text-danger">*</span></label>
                                            <select name="book_id" class="form-control" required id="book_select">
                                                <option value="">-- Select Book --</option>
                                                @foreach($books as $book)
                                                    <option value="{{ $book->id }}"
                                                        data-available="{{ $book->available }}"
                                                        {{ (request('book_id') == $book->id || old('book_id') == $book->id) ? 'selected' : '' }}>
                                                        {{ $book->title }}
                                                        @if($book->author) — {{ $book->author }} @endif
                                                        ({{ $book->available }} available)
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('book_id')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Available Copies</label>
                                            <input type="text" id="book_available" class="form-control" readonly
                                                style="background:#f8f8f8; font-weight:700;" placeholder="Select a book">
                                        </div>
                                    </div>

                                    {{-- Member Selection --}}
                                    <div class="col-lg-12" style="margin-top:5px;">
                                        <h4 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                                            <i class="fa fa-user"></i> Member Details
                                        </h4>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Class (for students)</label>
                                            <select id="issue_class_id" class="form-control">
                                                <option value="">-- All Members --</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label>Issue To (Student / Teacher) <span class="text-danger">*</span></label>
                                            <select name="user_id" id="issue_user_id" class="form-control" required>
                                                <option value="">-- Select Member --</option>
                                            </select>
                                            @error('user_id')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>

                                    {{-- Dates --}}
                                    <div class="col-lg-12" style="margin-top:5px;">
                                        <h4 style="border-bottom:1px solid #eee; padding-bottom:8px; margin-bottom:15px;">
                                            <i class="fa fa-calendar"></i> Issue Details
                                        </h4>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Issue Date <span class="text-danger">*</span></label>
                                            <input type="date" name="issue_date" class="form-control"
                                                value="{{ old('issue_date', now()->format('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Due Date <span class="text-danger">*</span></label>
                                            <input type="date" name="due_date" class="form-control"
                                                value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}" required>
                                            <small class="text-muted">Default: 14 days</small>
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
                                            <i class="fa fa-share"></i> Issue Book
                                        </button>
                                        <a href="{{ route('library.issues.index') }}" class="btn btn-default" style="margin-left:8px;">
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
                <x-library-guide screen="issues-create" />
            </div>

        </div>
    </div>

    @push('js')
        <script>
        $(document).ready(function () {

            // Show available count when book selected
            $('#book_select').on('change', function () {
                var avail = $(this).find(':selected').data('available') ?? '';
                $('#book_available').val(avail !== '' ? avail + ' copies' : '');
            }).trigger('change');

            // Load members by class (students) or all teachers
            function loadMembers(classId) {
                var $user = $('#issue_user_id');
                $user.html('<option value="">Loading...</option>').prop('disabled', true);

                $.ajax({
                    url: '{{ route('fees.payments.students') }}',
                    data: { class_id: classId || 0 },
                    success: function (res) {
                        var opts = '<option value="">-- Select Member --</option>';
                        $.each(res.students, function (i, s) {
                            opts += '<option value="' + s.id + '">' + s.name + '</option>';
                        });
                        $user.html(opts).prop('disabled', false);
                    },
                    error: function () {
                        $user.html('<option value="">-- Select Member --</option>').prop('disabled', false);
                    }
                });
            }

            $('#issue_class_id').on('change', function () {
                loadMembers($(this).val());
            });
        });
        </script>
    @endpush
</x-tenant-app-layout>

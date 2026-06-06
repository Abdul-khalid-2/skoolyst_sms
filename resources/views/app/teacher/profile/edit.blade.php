<x-tenant-app-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('backend/css/datapicker/datepicker3.css') }}">
    @endpush

    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-lg-6">
                <h3 style="margin:0;"><i class="fa fa-user"></i> Edit My Profile</h3>
                <small class="text-muted">Update your personal account details</small>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('teacher.profile') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="white-box">
            <form method="POST" action="{{ route('teacher.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="section-headline"><h3>Personal Information</h3></div>
                @include('app.profile.partials.user-edit-fields')
                <div class="text-right" style="margin-top: 15px;">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('backend/js/datapicker/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('backend/js/datapicker/datepicker-active.js') }}"></script>
    @endpush
</x-tenant-app-layout>

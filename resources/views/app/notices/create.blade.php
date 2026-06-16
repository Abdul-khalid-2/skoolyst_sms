<x-tenant-app-layout>
    @push('css')
        <style>
            .check-grid { display:flex; flex-wrap:wrap; gap:8px; }
            .check-pill { border:1px solid #d8dee6; border-radius:6px; padding:7px 12px; font-size:13px; cursor:pointer; user-select:none; }
            .check-pill input { margin-right:6px; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Create Notice" :back-route="route('notices.index')" />

            <div class="col-lg-8 col-md-11 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('notices.store') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="Notice title" value="{{ old('title') }}" required>
                                            @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Content <span class="text-danger">*</span></label>
                                            <textarea name="content" class="form-control" rows="6"
                                                placeholder="Write the announcement here..." required>{{ old('content') }}</textarea>
                                            @error('content')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>

                                    {{-- Target Roles --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Target Audience (Roles)</label>
                                            <div class="check-grid">
                                                @foreach($roles as $role)
                                                    <label class="check-pill">
                                                        <input type="checkbox" name="target_roles[]" value="{{ $role }}"
                                                            {{ in_array($role, old('target_roles', [])) ? 'checked' : '' }}>
                                                        {{ ucfirst($role) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">Leave all unchecked to target everyone.</small>
                                        </div>
                                    </div>

                                    {{-- Target Classes --}}
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Target Classes <small class="text-muted">(optional)</small></label>
                                            <div class="check-grid">
                                                @foreach($classes as $class)
                                                    <label class="check-pill">
                                                        <input type="checkbox" name="target_classes[]" value="{{ $class->id }}"
                                                            {{ in_array($class->id, old('target_classes', [])) ? 'checked' : '' }}>
                                                        {{ $class->name }}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">Leave all unchecked to target all classes.</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ old('start_date', now()->format('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ old('end_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Publish</label>
                                            <div style="padding-top:8px;">
                                                <label style="font-weight:normal;">
                                                    <input type="checkbox" name="is_published" value="1"
                                                        {{ old('is_published', true) ? 'checked' : '' }}>
                                                    Publish immediately
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-bullhorn"></i> Publish Notice
                                        </button>
                                        <a href="{{ route('notices.index') }}" class="btn btn-default" style="margin-left:8px;">
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
                <x-notices-guide screen="create" />
            </div>

        </div>
    </div>
</x-tenant-app-layout>

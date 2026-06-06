<x-tenant-app-layout>
    @push('css')
        <style>
            .check-grid { display:flex; flex-wrap:wrap; gap:8px; }
            .check-pill { border:1px solid #d8dee6; border-radius:6px; padding:7px 12px; font-size:13px; cursor:pointer; user-select:none; }
            .check-pill input { margin-right:6px; }
        </style>
    @endpush
    <x-slot name="header"></x-slot>

    @php
        $selRoles   = old('target_roles', $notice->target_roles ?? []);
        $selClasses = old('target_classes', $notice->target_classes ?? []);
    @endphp

    <div class="container-fluid">
        <div class="row">

            <x-page-header title="Edit Notice" :back-route="route('notices.show', $notice)" />

            <div class="col-lg-9 col-md-11 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                            <form action="{{ route('notices.update', $notice) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control"
                                                value="{{ old('title', $notice->title) }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Content <span class="text-danger">*</span></label>
                                            <textarea name="content" class="form-control" rows="6" required>{{ old('content', $notice->content) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Target Audience (Roles)</label>
                                            <div class="check-grid">
                                                @foreach($roles as $role)
                                                    <label class="check-pill">
                                                        <input type="checkbox" name="target_roles[]" value="{{ $role }}"
                                                            {{ in_array($role, $selRoles) ? 'checked' : '' }}>
                                                        {{ ucfirst($role) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <small class="text-muted">Leave all unchecked to target everyone.</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Target Classes <small class="text-muted">(optional)</small></label>
                                            <div class="check-grid">
                                                @foreach($classes as $class)
                                                    <label class="check-pill">
                                                        <input type="checkbox" name="target_classes[]" value="{{ $class->id }}"
                                                            {{ in_array($class->id, $selClasses) ? 'checked' : '' }}>
                                                        {{ $class->name }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ old('start_date', $notice->start_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ old('end_date', $notice->end_date) }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Publish</label>
                                            <div style="padding-top:8px;">
                                                <label style="font-weight:normal;">
                                                    <input type="checkbox" name="is_published" value="1"
                                                        {{ old('is_published', $notice->is_published) ? 'checked' : '' }}>
                                                    Published
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="margin-top:10px;">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update Notice
                                        </button>
                                        <a href="{{ route('notices.show', $notice) }}" class="btn btn-default" style="margin-left:8px;">
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

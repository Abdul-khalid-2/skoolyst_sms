<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <x-page-header title="School Branches">
            <a href="{{ route('admin.branches.create') }}" style="color:#333;"><i class="fa fa-plus"></i> Add Branch</a>
        </x-page-header>

        @if(session('status'))
            <div class="alert alert-{{ session('status-type', 'success') }}">{{ session('status') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-info" style="margin:0;">{{ $stats['total'] }}</h2>
                    <small class="text-muted">Total Branches</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="white-box text-center">
                    <h2 class="text-success" style="margin:0;">{{ $stats['active'] }}</h2>
                    <small class="text-muted">Active</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Users</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($branches as $index => $branch)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $branch->name }}</td>
                                        <td>{{ $branch->email ?? '—' }}</td>
                                        <td>{{ $branch->phone ?? '—' }}</td>
                                        <td>{{ $branch->users_count }}</td>
                                        <td>
                                            @if($branch->is_active)
                                                <span class="label label-success">Active</span>
                                            @else
                                                <span class="label label-default">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.branches.edit', $branch) }}" class="btn btn-xs btn-info">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" style="display:inline;"
                                                onsubmit="return confirm('Delete this branch?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" {{ $branch->users_count > 0 ? 'disabled title=Has assigned users' : '' }}>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No branches found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>

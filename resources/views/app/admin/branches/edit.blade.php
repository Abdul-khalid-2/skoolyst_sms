<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <x-page-header title="Edit Branch" :back-route="route('admin.branches.index')" />

        @if(session('status'))
            <div class="alert alert-{{ session('status-type', 'success') }}">{{ session('status') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="white-box">
                    <form action="{{ route('admin.branches.update', $branch) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h4 class="box-title"><i class="fa fa-building"></i> Branch Details</h4>
                        @include('app.admin.branches._form', ['branch' => $branch, 'showStatus' => true])

                        @include('app.admin.branches._admin-form')

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Branch</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="white-box">
                    <h4 class="box-title"><i class="fa fa-users"></i> Branch Admins</h4>
                    @if($admins->isEmpty())
                        <p class="text-muted">No branch admin assigned yet.</p>
                    @else
                        <ul class="list-unstyled">
                            @foreach($admins as $admin)
                                <li style="margin-bottom:8px;">
                                    <strong>{{ $admin->name }}</strong><br>
                                    <small class="text-muted">{{ $admin->email }}</small>
                                    @if($admin->status === 'active')
                                        <span class="label label-success">Active</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    <p class="text-muted"><small>{{ $branch->users_count }} total user(s) in this branch.</small></p>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>

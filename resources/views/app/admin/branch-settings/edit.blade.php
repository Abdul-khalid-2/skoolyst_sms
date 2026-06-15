<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <x-page-header title="Branch Settings" :back-route="route('dashboard')" />

        @if(session('status'))
            <div class="alert alert-{{ session('status-type', 'success') }}">{{ session('status') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="white-box">
                    <p class="text-muted">Manage your branch contact and location details.</p>
                    <form action="{{ route('branch.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('app.admin.branches._form', ['branch' => $branch])
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-branch-settings-guide />
            </div>
        </div>
    </div>
</x-tenant-app-layout>

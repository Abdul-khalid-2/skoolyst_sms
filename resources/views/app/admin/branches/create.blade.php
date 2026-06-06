<x-tenant-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <x-page-header title="Add Branch" :back-route="route('admin.branches.index')" />

        <div class="row">
            <div class="col-lg-8">
                <div class="white-box">
                    <form action="{{ route('admin.branches.store') }}" method="POST">
                        @csrf
                        <h4 class="box-title"><i class="fa fa-building"></i> Branch Details</h4>
                        @include('app.admin.branches._form', ['showStatus' => true])

                        @include('app.admin.branches._admin-form')

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Create Branch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-tenant-app-layout>

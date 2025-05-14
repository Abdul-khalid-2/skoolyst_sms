<x-tenant-app-layout>

    @push('css')
        <link rel="stylesheet" href="css/table.css">
    @endpush

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Users') }}
            </h2>
            <x-link-button href="{{ route('user.create') }}">Create User</x-link-button>
        </div>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-sm sm:rounded-lg">
                
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Name</th>
                                    <th style="width: 25%;">Email</th>
                                    
                                    <th style="width: 20%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
   
                                @foreach ($users as $tenant)
                                    <tr>
                                        <td>{{ $tenant->name }}</td>
                                        <td>{{ $tenant->email }}</td>
                                       
                                        <td class="action-buttons">Edit | Delete</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Name</th>
                                    <th style="width: 25%;">Email</th>
                                    <th style="width: 20%; text-align: center;">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-tenant-app-layout>

<x-tenant-app-layout>
    <x-slot name="header"></x-slot>
    
    <div class="data-table-area mg-b-15">
       <div class="container-fluid">
           <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>All Teachers</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <ul class="breadcome-menu">
                                    <li>
                                        <a href="{{ route('dashboard.add.teacher') }}" class="btn btn-primary btn-sm" style="color: white">
                                            <i class="fa fa-user-plus"></i> Add Teacher
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="sparkline13-list">
                       
                       <div class="sparkline13-graph">
                           <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <select class="form-control dt-tb">
                                    <option value="">Excel</option>
                                    <option value="">PDF</option>
                                    <option value="">CSV</option>
                                </select>
                            </div>
                            <table id="timetable-table" 
                                class="table hover-table timetable-datatable"
                                data-toggle="table" 
                                data-pagination="true" 
                                data-search="true"
                                data-show-columns="true" 
                                data-resizable="true"
                                data-cookie-id-table="teacher"
                                data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">ID</th>
                                        <th data-field="name" data-sortable="true">Name</th>
                                        <th data-field="employee_id" data-sortable="true">Employee ID</th>
                                        <th data-field="email">Email</th>
                                        <th data-field="phone">Phone</th>
                                        <th data-field="specialization">Specialization</th>
                                        <th data-field="class_teacher" data-sortable="true">Status</th>
                                        <th data-field="action">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teachers as $key => $teacher)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>
                                            @if(isset($teacher->profile_pic))
                                                <img src="{{ asset('tenancy/assets/'. $teacher->profile_pic) }}" 
                                                    alt="{{ $teacher->name }}" 
                                                    class="rounded-circle" 
                                                    width="30" 
                                                    height="30">
                                                @else
                                                    <img src="{{ asset('backend/img/profile/1.jpg') }}" 
                                                        alt="{{ $teacher->name }}" 
                                                        class="rounded-circle" 
                                                        width="30" 
                                                        height="30">
                                            @endif
                                            {{ $teacher->name }}
                                        </td>
                                        <td>{{ $teacher->teacherProfile->employee_id ?? 'N/A' }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->phone }}</td>
                                        <td>{{ $teacher->teacherProfile->specialization ?? 'N/A' }}</td>
                                        <td>
                                            <div class="status-wrapper">
                                                <select class="form-control input-sm change-status" data-id="{{ $teacher->id }}">
                                                    <option value="active" {{ $teacher->status == 'active' ? 'selected' : '' }}>
                                                        ✅ Active
                                                    </option>
                                                    <option value="inactive" {{ $teacher->status == 'inactive' ? 'selected' : '' }}>
                                                        ❌ Inactive
                                                    </option>
                                                    <option value="pending" {{ $teacher->status == 'pending' ? 'selected' : '' }}>
                                                        ⏳ Pending
                                                    </option>
                                                </select>
                                                <small class="text-muted saving-status" style="display:none;">Saving...</small>
                                                <span class="label label-success status-label" style="display:none;">Updated</span>
                                            </div>
                                        </td>

                                        <td>
                                            <div style="display: flex; align-items: center; gap: 4px;">
                                                <a href="{{ route('admin.show.teacher', encrypt($teacher->id)) }}"
                                                class="btn btn-xs btn-success" 
                                                title="Edit">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.edit.teacher', encrypt($teacher->id)) }}" 
                                                class="btn btn-xs btn-primary" 
                                                title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                        
                                                <form action="{{ route('admin.destroy.teacher', encrypt($teacher->id)) }}" 
                                                    method="POST" 
                                                    class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-xs btn-danger" 
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this Teacher?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
    </div>



   @push('js')

    <script>
        $(document).on('change', '.change-status', function () {
            var $this = $(this);
            var teacherId = $this.data('id');
            var status = $this.val();
            var wrapper = $this.closest('.status-wrapper');
            var savingMsg = wrapper.find('.saving-status');
            var updatedLabel = wrapper.find('.status-label');

            // Show "saving" message
            savingMsg.show();
            updatedLabel.hide();

            $.ajax({
                url: '{{ route("teacher.update.status") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: teacherId,
                    status: status
                },
                success: function (response) {
                    savingMsg.hide();
                    updatedLabel.show().delay(1500).fadeOut();
                },
                error: function () {
                    savingMsg.hide();
                    alert('❌ Failed to update status');
                }
            });
        });
    </script>
   @endpush

    
</x-tenant-app-layout>

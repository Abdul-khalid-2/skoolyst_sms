<hr>
<h4 class="box-title">
    <i class="fa fa-user"></i> Branch Admin
    <small class="text-muted">(optional — create login for this branch)</small>
</h4>
<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label>Admin Name</label>
            <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name') }}">
            @error('admin_name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Admin Email</label>
            <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email') }}">
            @error('admin_email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Admin Password</label>
            <input type="password" name="admin_password" class="form-control">
            @error('admin_password')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="admin_password_confirmation" class="form-control">
        </div>
    </div>
</div>

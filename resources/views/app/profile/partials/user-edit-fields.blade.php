@php
    $picUrl = $user->profile_pic
        ? asset('assets/' . ltrim($user->profile_pic, '/'))
        : asset('backend/img/profile/1.jpg');
@endphp

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Current Profile</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <img src="{{ $picUrl }}" style="max-height: 100px; margin-bottom: 10px; border-radius: 4px;" alt="{{ $user->name }}">
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Profile Image</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="file" class="form-control" name="profile_pic" accept="image/*">
        </div>
    </div>
</div>

<div class="form-group-inner @error('name') has-error @enderror">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Full Name*</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')<span class="help-block text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group-inner @error('email') has-error @enderror">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Email*</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')<span class="help-block text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group-inner @error('phone') has-error @enderror">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Phone Number</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
            @error('phone')<span class="help-block text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group-inner @error('address') has-error @enderror">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Address</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <textarea class="form-control" name="address">{{ old('address', $user->address) }}</textarea>
            @error('address')<span class="help-block text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group-inner @error('gender') has-error @enderror">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Gender*</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <select class="form-control" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender')<span class="help-block text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group-inner @error('dob') has-error @enderror">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Date of Birth*</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="sparkline16-graph">
                <div class="date-picker-inner">
                    <div class="form-group data-custon-pick" id="data_1">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" name="dob" readonly class="form-control"
                                value="{{ old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y/m/d') : '') }}" required>
                        </div>
                        @error('dob')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!empty($showRoles) && $roles->isNotEmpty())
<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Select Role*</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            @php $userRoles = old('roles', $user->getRoleNames()->toArray()); @endphp
            <select name="roles[]" data-placeholder="Select role..." class="chosen-select" multiple tabindex="-1">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ in_array($role->name, (array) $userRoles) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@endif

<div class="form-group-inner @error('current_password') has-error @enderror">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Current Password</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="password" class="form-control" name="current_password">
            @error('current_password')<span class="help-block text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group-inner @error('password') has-error @enderror">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">New Password</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="password" class="form-control" name="password">
            @error('password')<span class="help-block text-danger">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<div class="form-group-inner">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label class="login2">Confirm Password</label>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <input type="password" class="form-control" name="password_confirmation">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label>Branch Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $branch->name ?? '') }}" required>
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="2">{{ old('address', $branch->address ?? '') }}</textarea>
            @error('address')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $branch->phone ?? '') }}">
            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $branch->email ?? '') }}">
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>

    @if(!empty($showStatus))
    <div class="col-lg-12">
        <div class="form-group">
            <label style="font-weight:normal;">
                <input type="checkbox" name="is_active" value="1"
                    {{ old('is_active', $branch->is_active ?? true) ? 'checked' : '' }}>
                Active branch
            </label>
        </div>
    </div>
    @endif
</div>

<x-tenant-app-layout>
    @push('css')
        <style>
            .logo-preview {
                max-width: 200px;
                max-height: 200px;
                margin-bottom: 15px;
            }
            .form-section {
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }
            .form-section h3 {
                margin-bottom: 20px;
                color: #333;
            }
        </style>
    @endpush

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit School Profile') }}
        </h2>
    </x-slot>

    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">

            <x-page-header title="Edit School Profile">
                <a href="{{ route('schools.show') }}" style="color: #333;"><i class="fa fa-building"></i> Profile</a>
                <a href="{{ route('schools.cms') }}" style="color: #333;"><i class="fa fa-paint-brush"></i> CMS</a>
                <a href="{{ route('schools.edit') }}" style="color: #333;"><i class="fa fa-edit"></i> Edit Profile</a>
                <a href="{{ route('schools.settings') }}" style="color: #333;"><i class="fa fa-cog"></i> Settings</a>
            </x-page-header>

            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline12-list">
                    <div class="sparkline12-graph">
                        <div class="basic-login-form-ad">
                        <form action="{{ route('schools.update', $school->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Display general form errors at the top -->
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <div class="form-section">
                                <h3>Basic Information</h3>
                                <div class="settings-group">
                                    <label class="settings-label">School Logo</label>
                                    @if($school->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('assets/' .$school->logo)  }}" alt="School Logo" style="max-height: 100px;">
                                    </div>
                                    @endif
                                    <input type="file" name="logo" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>School Name *</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $school->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Academic Session *</label>
                                            <input type="text" name="session_year" class="form-control @error('session_year') is-invalid @enderror" value="{{ old('session_year', $school->session_year) }}" required>
                                            @error('session_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>School Type</label>
                                            <select name="type" class="form-control @error('type') is-invalid @enderror">
                                                <option value="">Select Type</option>
                                                <option value="public" {{ old('type', $school->type) == 'public' ? 'selected' : '' }}>Public School</option>
                                                <option value="private" {{ old('type', $school->type) == 'private' ? 'selected' : '' }}>Private School</option>
                                                <option value="international" {{ old('type', $school->type) == 'international' ? 'selected' : '' }}>International School</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Affiliation Number</label>
                                            <input type="text" name="affiliation" class="form-control @error('affiliation') is-invalid @enderror" value="{{ old('affiliation', $school->affiliation) }}">
                                            @error('affiliation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>About School</label>
                                    <textarea name="about" class="form-control @error('about') is-invalid @enderror" rows="3">{{ old('about', $school->about) }}</textarea>
                                    @error('about')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3>Contact Information</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address *</label>
                                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address', $school->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number *</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $school->phone) }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Email Address *</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $school->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input type="url" name="website" class="form-control @error('website') is-invalid @enderror" value="{{ old('website', $school->website) }}" placeholder="https://">
                                            @error('website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Principal Name</label>
                                            <input type="text" name="principal" class="form-control @error('principal') is-invalid @enderror" value="{{ old('principal', $school->principal) }}">
                                            @error('principal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Social Media Links</label>
                                @php
                                    $socialLinks = is_array($school->social_links) ? $school->social_links : (json_decode($school->social_links ?? '[]', true) ?? []);
                                @endphp
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[facebook]" class="form-control mb-2 @error('social_links.facebook') is-invalid @enderror" 
                                                value="{{ old('social_links.facebook', $socialLinks['facebook'] ?? '') }}" 
                                                placeholder="Facebook URL">
                                        @error('social_links.facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[twitter]" class="form-control mb-2 @error('social_links.twitter') is-invalid @enderror" 
                                                value="{{ old('social_links.twitter', $socialLinks['twitter'] ?? '') }}" 
                                                placeholder="Twitter URL">
                                        @error('social_links.twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[instagram]" class="form-control mb-2 @error('social_links.instagram') is-invalid @enderror" 
                                                value="{{ old('social_links.instagram', $socialLinks['instagram'] ?? '') }}" 
                                                placeholder="Instagram URL">
                                        @error('social_links.instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input type="url" name="social_links[youtube]" class="form-control mb-2 @error('social_links.youtube') is-invalid @enderror" 
                                                value="{{ old('social_links.youtube', $socialLinks['youtube'] ?? '') }}" 
                                                placeholder="YouTube URL">
                                        @error('social_links.youtube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>                                        
                            
                            <div class="form-section">
                                <h3>Additional Information</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Established Year</label>
                                            <input type="number" name="established_year" class="form-control @error('established_year') is-invalid @enderror" value="{{ old('established_year', $school->established_year) }}" min="1900" max="{{ date('Y') }}">
                                            @error('established_year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Working Hours</label>
                                            <input type="text" name="working_hours" class="form-control @error('working_hours') is-invalid @enderror" value="{{ old('working_hours', $school->working_hours) }}" placeholder="e.g. 8:00 AM - 3:00 PM">
                                            @error('working_hours')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <button type="reset" class="btn btn-default">Reset</button>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <x-school-profile-guide screen="edit-profile" />
            </div>

        </div>
    </div>

    @push('js')
    
    <script>
        $(document).ready(function() {
            // Preview logo before upload
            $('input[name="logo"]').change(function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        if ($('.current-logo').length) {
                            $('.current-logo img').attr('src', e.target.result);
                        } else {
                            $('input[name="logo"]').before('<div class="current-logo"><p>New Logo Preview:</p><img src="'+e.target.result+'" class="logo-preview"></div>');
                        }
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
    @endpush
</x-tenant-app-layout>
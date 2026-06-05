<x-tenant-app-layout>
    @push('css')
        <style>
            .cms-tab-content { padding: 24px; border: 1px solid #ddd; border-top: none; background: #fff; }
            .program-item, .testimonial-item {
                border: 1px solid #dce1e7;
                border-radius: 4px;
                padding: 15px;
                margin-bottom: 12px;
                background: #f9fafb;
                position: relative;
            }
            .program-item .remove-btn, .testimonial-item .remove-btn {
                position: absolute;
                top: 10px;
                right: 10px;
            }
            .color-swatch {
                width: 34px;
                height: 34px;
                border-radius: 4px;
                display: inline-block;
                vertical-align: middle;
                border: 1px solid #ccc;
                margin-left: 8px;
            }
            .section-tip {
                font-size: 12px;
                color: #888;
                margin-bottom: 16px;
            }
            .cms-nav-tabs > li > a { font-size: 13px; }
        </style>
    @endpush

    <x-slot name="header"></x-slot>
    <!-- Advanced Form Start -->
    <div class="advanced-form-area mg-b-15">
       
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top: 10px">
                                    <h3>School Landing Page CMS</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="action-buttons">
                                    <a href="{{ route('schools.show') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-building"></i>  Profile
                                    </a>
                                    <a href="{{ route('schools.cms') }}" class="btn btn-primary btn-sm" style="color: white">
                                        CMS
                                    </a>
                                    <a href="{{ route('schools.edit') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-graduation-cap"></i> Profile Edit
                                    </a>
                                    <a href="{{ route('schools.settings') }}" class="btn btn-primary btn-sm" style="color: white">
                                        <i class="fa fa-cog"></i> Setting
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list">
                        <div class="sparkline12-graph">
                            <form method="POST" action="{{ route('schools.cms.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Tab Navigation --}}
                                <ul class="nav nav-tabs cms-nav-tabs">
                                    <li class="active">
                                        <a href="#cms-basic" data-toggle="tab"><i class="fa fa-info-circle"></i> Basic Info</a>
                                    </li>
                                    <li>
                                        <a href="#cms-stats" data-toggle="tab"><i class="fa fa-bar-chart"></i> Statistics</a>
                                    </li>
                                    <li>
                                        <a href="#cms-contact" data-toggle="tab"><i class="fa fa-phone"></i> Contact</a>
                                    </li>
                                    <li>
                                        <a href="#cms-programs" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Programs</a>
                                    </li>
                                    <li>
                                        <a href="#cms-testimonials" data-toggle="tab"><i class="fa fa-comments"></i> Testimonials</a>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    {{-- Tab 1: Basic Info --}}
                                    <div class="tab-pane active cms-tab-content" id="cms-basic">
                                        <p class="section-tip">These fields appear on the school landing page header and branding.</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>School Name</strong> <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" value="{{ $school->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>School Motto</strong></label>
                                                    <input type="text" name="motto" class="form-control" value="{{ $school->motto }}" placeholder="e.g. Learn, Grow, Lead">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><strong>Primary Color</strong></label>
                                                    <div style="display:flex; align-items:center; gap:8px;">
                                                        <input type="color" name="primary_color" class="form-control color-input" value="{{ $school->primary_color }}" style="width:60px; height:38px; padding:2px;">
                                                        <span class="color-swatch" id="primary-swatch" style="background-color:{{ $school->primary_color }};"></span>
                                                        <small class="text-muted">{{ $school->primary_color }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><strong>Secondary Color</strong></label>
                                                    <div style="display:flex; align-items:center; gap:8px;">
                                                        <input type="color" name="secondary_color" class="form-control color-input" value="{{ $school->secondary_color }}" style="width:60px; height:38px; padding:2px;">
                                                        <span class="color-swatch" id="secondary-swatch" style="background-color:{{ $school->secondary_color }};"></span>
                                                        <small class="text-muted">{{ $school->secondary_color }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>School Logo</strong></label>
                                                    <input type="file" name="logo" class="form-control" accept="image/*">
                                                    @if($school->logo)
                                                        <div style="margin-top:8px; display:flex; align-items:center; gap:10px;">
                                                            <img src="{{ asset('assets/' . $school->logo) }}" alt="Logo" style="max-height:60px; border:1px solid #ddd; border-radius:4px; padding:4px;">
                                                            <label style="margin:0; font-weight:normal;">
                                                                <input type="checkbox" name="remove_logo"> Remove logo
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Hero Image</strong> <small class="text-muted">(landing page banner)</small></label>
                                                    <input type="file" name="hero_image" class="form-control" accept="image/*">
                                                    @if($school->hero_image)
                                                        <div style="margin-top:8px; display:flex; align-items:center; gap:10px;">
                                                            <img src="{{ asset('assets/' . $school->hero_image) }}" alt="Hero" style="max-height:60px; border:1px solid #ddd; border-radius:4px; padding:4px;">
                                                            <label style="margin:0; font-weight:normal;">
                                                                <input type="checkbox" name="remove_hero_image"> Remove hero image
                                                            </label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right" style="margin-top:20px;">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                                        </div>
                                    </div>

                                    {{-- Tab 2: Statistics --}}
                                    <div class="tab-pane cms-tab-content" id="cms-stats">
                                        <p class="section-tip">Numbers displayed on the landing page stats section (e.g. "1200+ Students").</p>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><strong>Established Year</strong></label>
                                                    <input type="text" name="established_year" class="form-control" value="{{ $school->established_year }}" placeholder="e.g. 2005">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><strong>Student Count Display</strong></label>
                                                    <input type="text" name="student_count" class="form-control" value="{{ $school->student_count }}" placeholder="e.g. 1200+">
                                                    <small class="text-muted">Shown as-is on the landing page</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><strong>Teacher Count Display</strong></label>
                                                    <input type="text" name="teacher_count" class="form-control" value="{{ $school->teacher_count }}" placeholder="e.g. 85+">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><strong>Facility Count Display</strong></label>
                                                    <input type="text" name="facility_count" class="form-control" value="{{ $school->facility_count }}" placeholder="e.g. 30+">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right" style="margin-top:20px;">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                                        </div>
                                    </div>

                                    {{-- Tab 3: Contact --}}
                                    <div class="tab-pane cms-tab-content" id="cms-contact">
                                        <p class="section-tip">Displayed in the footer and contact section of the landing page.</p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><strong>Address</strong></label>
                                                    <textarea name="address" class="form-control" rows="3" placeholder="Full school address">{{ $school->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><strong>Phone Number</strong></label>
                                                    <input type="text" name="phone" class="form-control" value="{{ $school->phone }}" placeholder="+1 234 567 8900">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><strong>Email</strong></label>
                                                    <input type="email" name="email" class="form-control" value="{{ $school->email }}" placeholder="info@school.com">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:15px;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><strong>Short Description</strong> <small class="text-muted">(shown in footer)</small></label>
                                                    <textarea name="short_description" class="form-control" rows="3" placeholder="A brief description of your school...">{{ $school->short_description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right" style="margin-top:20px;">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                                        </div>
                                    </div>

                                    {{-- Tab 4: Academic Programs --}}
                                    <div class="tab-pane cms-tab-content" id="cms-programs">
                                        <p class="section-tip">Add the academic programs shown on your landing page. Click <strong>+ Add Program</strong> to add more.</p>
                                        <div id="programs-container">
                                            @foreach($school->programs as $index => $program)
                                                <div class="program-item" data-index="{{ $index }}">
                                                    <button type="button" class="btn btn-xs btn-danger remove-btn remove-program" data-index="{{ $index }}">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Program Name <span class="text-danger">*</span></label>
                                                                <input type="text" name="programs[{{ $index }}][name]" class="form-control" value="{{ $program->name }}" placeholder="e.g. Science" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label>Description <span class="text-danger">*</span></label>
                                                                <textarea name="programs[{{ $index }}][description]" class="form-control" rows="2" placeholder="Brief description of this program..." required>{{ $program->description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="programs[{{ $index }}][id]" value="{{ $program->id }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" id="add-program" class="btn btn-default" style="margin-top:8px;">
                                            <i class="fa fa-plus"></i> Add Program
                                        </button>
                                        <div class="text-right" style="margin-top:20px;">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                                        </div>
                                    </div>

                                    {{-- Tab 5: Testimonials --}}
                                    <div class="tab-pane cms-tab-content" id="cms-testimonials">
                                        <p class="section-tip">Add parent or student testimonials displayed on the landing page.</p>
                                        <div id="testimonials-container">
                                            @foreach($school->testimonials as $index => $testimonial)
                                                <div class="testimonial-item" data-index="{{ $index }}">
                                                    <button type="button" class="btn btn-xs btn-danger remove-btn remove-testimonial" data-index="{{ $index }}">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Author Name <span class="text-danger">*</span></label>
                                                                <input type="text" name="testimonials[{{ $index }}][author]" class="form-control" value="{{ $testimonial->author }}" placeholder="e.g. Ahmed Ali" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Role <span class="text-danger">*</span></label>
                                                                <input type="text" name="testimonials[{{ $index }}][role]" class="form-control" value="{{ $testimonial->role }}" placeholder="e.g. Parent" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Rating</label>
                                                                <select name="testimonials[{{ $index }}][rating]" class="form-control" required>
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <option value="{{ $i }}" {{ $testimonial->rating == $i ? 'selected' : '' }}>
                                                                            {{ $i }} {{ $i == 5 ? '★ (Best)' : '★' }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Avatar Photo</label>
                                                                <input type="file" name="testimonials[{{ $index }}][avatar]" class="form-control" accept="image/*">
                                                                @if($testimonial->avatar)
                                                                    <img src="{{ asset($testimonial->avatar) }}" alt="Avatar"
                                                                         style="margin-top:6px; width:40px; height:40px; border-radius:50%; object-fit:cover; border:1px solid #ddd;">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Testimonial Content <span class="text-danger">*</span></label>
                                                        <textarea name="testimonials[{{ $index }}][content]" class="form-control" rows="2" placeholder="What did they say about the school?" required>{{ $testimonial->content }}</textarea>
                                                    </div>
                                                    <input type="hidden" name="testimonials[{{ $index }}][id]" value="{{ $testimonial->id }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" id="add-testimonial" class="btn btn-default" style="margin-top:8px;">
                                            <i class="fa fa-plus"></i> Add Testimonial
                                        </button>
                                        <div class="text-right" style="margin-top:20px;">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                                        </div>
                                    </div>

                                </div>{{-- /tab-content --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Advanced Form End-->
    </div>

    @push('js')

        <script>
            $(document).ready(function() {
                // Add new program
                let programIndex = {{ count($school->programs) }};
                $('#add-program').click(function() {
                    const template = `
                        <div class="program-item" data-index="${programIndex}">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Program Name</label>
                                        <input type="text" name="programs[${programIndex}][name]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="programs[${programIndex}][description]" class="form-control" rows="2" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-program" data-index="${programIndex}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#programs-container').append(template);
                    programIndex++;
                });

                // Remove program
                $(document).on('click', '.remove-program', function() {
                    const index = $(this).data('index');
                    $(`[data-index="${index}"]`).remove();
                });

                // Add new testimonial
                let testimonialIndex = {{ count($school->testimonials) }};
                $('#add-testimonial').click(function() {
                    const template = `
                        <div class="testimonial-item" data-index="${testimonialIndex}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Author Name</label>
                                        <input type="text" name="testimonials[${testimonialIndex}][author]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Role</label>
                                        <input type="text" name="testimonials[${testimonialIndex}][role]" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Rating (1-5)</label>
                                        <select name="testimonials[${testimonialIndex}][rating]" class="form-control" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5" selected>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Avatar</label>
                                        <input type="file" name="testimonials[${testimonialIndex}][avatar]" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-testimonial" data-index="${testimonialIndex}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Content</label>
                                        <textarea name="testimonials[${testimonialIndex}][content]" class="form-control" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#testimonials-container').append(template);
                    testimonialIndex++;
                });

                // Remove testimonial
                $(document).on('click', '.remove-testimonial', function() {
                    const index = $(this).data('index');
                    $(`[data-index="${index}"]`).remove();
                });

                // Color preview update
                $('input[name="primary_color"], input[name="secondary_color"]').on('change', function() {
                    const color = $(this).val();
                    const preview = $(this).closest('.form-group').find('.color-preview');
                    preview.css('background-color', color);
                });
            });
        </script>
    @endpush
</x-tenant-app-layout>
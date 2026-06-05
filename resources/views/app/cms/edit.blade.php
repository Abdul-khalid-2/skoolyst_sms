<x-tenant-app-layout>
    @push('css')
        <style>
            /* ── Tab panel ─────────────────────────────── */
            .cms-tab-content { padding: 24px; border: 1px solid #ddd; border-top: none; background: #fff; }
            .cms-nav-tabs > li > a { font-size: 13px; padding: 8px 14px; }
            .section-tip { font-size: 12px; color: #888; margin-bottom: 16px; }

            /* ── Repeatable items ───────────────────────── */
            .cms-item {
                border: 1px solid #dce1e7;
                border-radius: 4px;
                padding: 16px 16px 10px;
                margin-bottom: 12px;
                background: #f9fafb;
                position: relative;
            }
            .cms-item .remove-btn { position: absolute; top: 10px; right: 10px; }

            /* ── Color swatch ───────────────────────────── */
            .color-swatch {
                width: 34px; height: 34px; border-radius: 4px;
                display: inline-block; vertical-align: middle;
                border: 1px solid #ccc; margin-left: 8px;
            }

            /* ── Section visibility toggles ─────────────── */
            .section-toggle-grid { display: flex; flex-wrap: wrap; gap: 12px; }
            .section-toggle-card {
                border: 1px solid #ddd;
                border-radius: 6px;
                padding: 14px 16px;
                background: #fff;
                min-width: 200px;
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
            }
            .section-toggle-card .label-group { display: flex; align-items: center; gap: 8px; }
            .section-toggle-card .fa { font-size: 18px; color: #aaa; }
            .section-toggle-card span { font-weight: 600; font-size: 13px; }

            /* Toggle switch */
            .toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; }
            .toggle-switch input { opacity: 0; width: 0; height: 0; }
            .toggle-slider {
                position: absolute; cursor: pointer;
                top: 0; left: 0; right: 0; bottom: 0;
                background-color: #ccc; border-radius: 24px;
                transition: .3s;
            }
            .toggle-slider:before {
                position: absolute; content: "";
                height: 18px; width: 18px; left: 3px; bottom: 3px;
                background-color: white; border-radius: 50%; transition: .3s;
            }
            .toggle-switch input:checked + .toggle-slider { background-color: #2980b9; }
            .toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); }

            /* Feature items */
            .feature-item { border: 1px solid #dce1e7; border-radius: 4px; padding: 12px 16px; margin-bottom: 10px; background: #f9fafb; position: relative; }
            .feature-item .remove-btn { position: absolute; top: 8px; right: 8px; }

            /* Social link row */
            .social-row { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
            .social-row .social-icon { width: 36px; text-align: center; font-size: 18px; }
        </style>
    @endpush

    <x-slot name="header"></x-slot>

    <div class="advanced-form-area mg-b-15">
        <div class="container-fluid">
            <div class="row">

                {{-- Page Header --}}
                <div class="col-lg-12">
                    <div class="breadcome-list">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="breadcome-heading" style="margin-top:10px;">
                                    <h3><i class="fa fa-paint-brush"></i> Landing Page CMS</h3>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="action-buttons">
                                    <a href="{{ route('schools.show') }}" class="btn btn-default btn-sm"><i class="fa fa-building"></i> Profile</a>
                                    <a href="{{ route('schools.edit') }}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i> Edit Profile</a>
                                    <a href="{{ route('schools.settings') }}" class="btn btn-default btn-sm"><i class="fa fa-cog"></i> Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <form method="POST" action="{{ route('schools.cms.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- ══ Tab Navigation ══════════════════════════════════════ --}}
                        <ul class="nav nav-tabs cms-nav-tabs">
                            <li class="active"><a href="#cms-sections" data-toggle="tab"><i class="fa fa-th-large"></i> Page Sections</a></li>
                            <li><a href="#cms-branding" data-toggle="tab"><i class="fa fa-paint-brush"></i> Branding</a></li>
                            <li><a href="#cms-hero" data-toggle="tab"><i class="fa fa-home"></i> Hero</a></li>
                            <li><a href="#cms-about" data-toggle="tab"><i class="fa fa-info-circle"></i> About</a></li>
                            <li><a href="#cms-stats" data-toggle="tab"><i class="fa fa-bar-chart"></i> Statistics</a></li>
                            <li><a href="#cms-programs" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Programs</a></li>
                            <li><a href="#cms-features" data-toggle="tab"><i class="fa fa-star"></i> Features</a></li>
                            <li><a href="#cms-testimonials" data-toggle="tab"><i class="fa fa-comments"></i> Testimonials</a></li>
                            <li><a href="#cms-social" data-toggle="tab"><i class="fa fa-share-alt"></i> Social &amp; Contact</a></li>
                        </ul>

                        <div class="tab-content">

                            {{-- ══ Tab 1: Page Sections (visibility toggles) ════════ --}}
                            <div class="tab-pane active cms-tab-content" id="cms-sections">
                                <p class="section-tip">Turn each landing page section on or off. Disabled sections will be hidden from visitors.</p>

                                <div class="section-toggle-grid">
                                    @php
                                        $sections = [
                                            ['key' => 'show_hero',         'label' => 'Hero Banner',       'icon' => 'fa-home'],
                                            ['key' => 'show_about',        'label' => 'About School',      'icon' => 'fa-info-circle'],
                                            ['key' => 'show_stats',        'label' => 'Statistics',        'icon' => 'fa-bar-chart'],
                                            ['key' => 'show_programs',     'label' => 'Programs',          'icon' => 'fa-graduation-cap'],
                                            ['key' => 'show_features',     'label' => 'Why Choose Us',     'icon' => 'fa-star'],
                                            ['key' => 'show_testimonials', 'label' => 'Testimonials',      'icon' => 'fa-comments'],
                                            ['key' => 'show_gallery',      'label' => 'Gallery',           'icon' => 'fa-photo'],
                                            ['key' => 'show_contact',      'label' => 'Contact Section',   'icon' => 'fa-phone'],
                                            ['key' => 'show_social',       'label' => 'Social Links',      'icon' => 'fa-share-alt'],
                                            ['key' => 'show_news',         'label' => 'News & Events',     'icon' => 'fa-newspaper-o'],
                                        ];
                                    @endphp

                                    @foreach($sections as $sec)
                                        <div class="section-toggle-card">
                                            <div class="label-group">
                                                <i class="fa {{ $sec['icon'] }}"></i>
                                                <span>{{ $sec['label'] }}</span>
                                            </div>
                                            <label class="toggle-switch" title="Toggle {{ $sec['label'] }}">
                                                <input type="checkbox" name="{{ $sec['key'] }}" value="1"
                                                    {{ ($school->{$sec['key']} ?? true) ? 'checked' : '' }}>
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="text-right" style="margin-top:24px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Visibility Settings</button>
                                </div>
                            </div>

                            {{-- ══ Tab 2: Branding ══════════════════════════════════ --}}
                            <div class="tab-pane cms-tab-content" id="cms-branding">
                                <p class="section-tip">School identity — name, motto, colors, and images used across the entire landing page.</p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>School Name</strong> <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="{{ $school->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>School Motto / Tagline</strong></label>
                                            <input type="text" name="motto" class="form-control" value="{{ $school->motto }}" placeholder="e.g. Learn, Grow, Lead">
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top:12px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Primary Color</strong></label>
                                            <div style="display:flex;align-items:center;gap:8px;">
                                                <input type="color" name="primary_color" id="primary_color" class="form-control"
                                                       value="{{ $school->primary_color }}" style="width:60px;height:38px;padding:2px;">
                                                <span class="color-swatch" id="primary-swatch" style="background:{{ $school->primary_color }};"></span>
                                                <small class="text-muted" id="primary-hex">{{ $school->primary_color }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Secondary Color</strong></label>
                                            <div style="display:flex;align-items:center;gap:8px;">
                                                <input type="color" name="secondary_color" id="secondary_color" class="form-control"
                                                       value="{{ $school->secondary_color }}" style="width:60px;height:38px;padding:2px;">
                                                <span class="color-swatch" id="secondary-swatch" style="background:{{ $school->secondary_color }};"></span>
                                                <small class="text-muted" id="secondary-hex">{{ $school->secondary_color }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top:12px;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>School Logo</strong></label>
                                            <input type="file" name="logo" class="form-control" accept="image/*">
                                            @if($school->logo)
                                                <div style="margin-top:8px;display:flex;align-items:center;gap:10px;">
                                                    <img src="{{ asset('assets/'.$school->logo) }}" style="max-height:60px;border:1px solid #ddd;border-radius:4px;padding:4px;">
                                                    <label style="margin:0;font-weight:normal;"><input type="checkbox" name="remove_logo"> Remove logo</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Favicon</strong> <small class="text-muted">(browser tab icon, .ico or .png)</small></label>
                                            <input type="file" name="favicon" class="form-control" accept="image/*,.ico">
                                            @if($school->favicon ?? false)
                                                <div style="margin-top:8px;display:flex;align-items:center;gap:10px;">
                                                    <img src="{{ asset('assets/'.$school->favicon) }}" style="max-height:32px;">
                                                    <label style="margin:0;font-weight:normal;"><input type="checkbox" name="remove_favicon"> Remove favicon</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right" style="margin-top:20px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Branding</button>
                                </div>
                            </div>

                            {{-- ══ Tab 3: Hero Section ══════════════════════════════ --}}
                            <div class="tab-pane cms-tab-content" id="cms-hero">
                                <p class="section-tip">The first thing visitors see — the banner at the top of the landing page.</p>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label><strong>Hero Headline</strong></label>
                                            <input type="text" name="hero_title" class="form-control" value="{{ $school->hero_title ?? '' }}" placeholder="e.g. Welcome to Skoolyst School">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>CTA Button Text</strong></label>
                                            <input type="text" name="hero_cta_text" class="form-control" value="{{ $school->hero_cta_text ?? '' }}" placeholder="e.g. Apply Now">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Hero Sub-Headline</strong></label>
                                    <input type="text" name="hero_subtitle" class="form-control" value="{{ $school->hero_subtitle ?? '' }}" placeholder="e.g. Empowering students through quality education">
                                </div>
                                <div class="form-group">
                                    <label><strong>Hero Description</strong> <small class="text-muted">(optional short paragraph)</small></label>
                                    <textarea name="hero_description" class="form-control" rows="3" placeholder="A brief welcome paragraph shown below the headline...">{{ $school->hero_description ?? '' }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Hero Background Image</strong></label>
                                            <input type="file" name="hero_image" class="form-control" accept="image/*">
                                            @if($school->hero_image ?? false)
                                                <div style="margin-top:8px;display:flex;align-items:center;gap:10px;">
                                                    <img src="{{ asset('assets/'.$school->hero_image) }}" style="max-height:60px;border-radius:4px;border:1px solid #ddd;">
                                                    <label style="margin:0;font-weight:normal;"><input type="checkbox" name="remove_hero_image"> Remove image</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>CTA Button Link</strong></label>
                                            <input type="text" name="hero_cta_link" class="form-control" value="{{ $school->hero_cta_link ?? '#contact' }}" placeholder="e.g. #contact or /apply">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right" style="margin-top:20px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Hero Section</button>
                                </div>
                            </div>

                            {{-- ══ Tab 4: About Section ═════════════════════════════ --}}
                            <div class="tab-pane cms-tab-content" id="cms-about">
                                <p class="section-tip">Tell visitors about your school — mission, vision, and the principal's message.</p>

                                <div class="form-group">
                                    <label><strong>About the School</strong></label>
                                    <textarea name="about" class="form-control" rows="5" placeholder="Describe your school, its history, achievements, and values...">{{ $school->about ?? '' }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Our Mission</strong></label>
                                            <textarea name="mission" class="form-control" rows="3" placeholder="Our mission is to...">{{ $school->mission ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Our Vision</strong></label>
                                            <textarea name="vision" class="form-control" rows="3" placeholder="We envision a future where...">{{ $school->vision ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Principal's Message</strong></label>
                                    <textarea name="principal_message" class="form-control" rows="4" placeholder="A personal message from the principal...">{{ $school->principal_message ?? '' }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Principal Name</strong></label>
                                            <input type="text" name="principal_name" class="form-control" value="{{ $school->principal_name ?? '' }}" placeholder="Mr. / Ms. Full Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Principal Photo</strong></label>
                                            <input type="file" name="principal_photo" class="form-control" accept="image/*">
                                            @if($school->principal_photo ?? false)
                                                <div style="margin-top:8px;">
                                                    <img src="{{ asset('assets/'.$school->principal_photo) }}" style="max-height:60px;border-radius:50%;border:1px solid #ddd;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right" style="margin-top:20px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save About Section</button>
                                </div>
                            </div>

                            {{-- ══ Tab 5: Statistics ════════════════════════════════ --}}
                            <div class="tab-pane cms-tab-content" id="cms-stats">
                                <p class="section-tip">Numbers shown in the stats counter section of the landing page (displayed as-is, e.g. "1200+").</p>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Established Year</strong></label>
                                            <input type="text" name="established_year" class="form-control" value="{{ $school->established_year ?? '' }}" placeholder="e.g. 2005">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Students</strong></label>
                                            <input type="text" name="student_count" class="form-control" value="{{ $school->student_count ?? '' }}" placeholder="e.g. 1200+">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Teachers</strong></label>
                                            <input type="text" name="teacher_count" class="form-control" value="{{ $school->teacher_count ?? '' }}" placeholder="e.g. 85+">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Facilities</strong></label>
                                            <input type="text" name="facility_count" class="form-control" value="{{ $school->facility_count ?? '' }}" placeholder="e.g. 30+">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Awards Won</strong></label>
                                            <input type="text" name="awards_count" class="form-control" value="{{ $school->awards_count ?? '' }}" placeholder="e.g. 50+">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Courses Offered</strong></label>
                                            <input type="text" name="courses_count" class="form-control" value="{{ $school->courses_count ?? '' }}" placeholder="e.g. 40+">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Pass Rate</strong></label>
                                            <input type="text" name="pass_rate" class="form-control" value="{{ $school->pass_rate ?? '' }}" placeholder="e.g. 98%">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right" style="margin-top:20px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Statistics</button>
                                </div>
                            </div>

                            {{-- ══ Tab 6: Academic Programs ═════════════════════════ --}}
                            <div class="tab-pane cms-tab-content" id="cms-programs">
                                <p class="section-tip">Academic programs displayed on the landing page. Click <strong>+ Add Program</strong> to add more.</p>

                                <div id="programs-container">
                                    @foreach($school->programs as $index => $program)
                                        <div class="cms-item" data-index="{{ $index }}">
                                            <button type="button" class="btn btn-xs btn-danger remove-btn remove-program" data-index="{{ $index }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Program Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="programs[{{ $index }}][name]" class="form-control" value="{{ $program->name }}" placeholder="e.g. Science" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>Icon <small class="text-muted">(FA)</small></label>
                                                        <input type="text" name="programs[{{ $index }}][icon]" class="form-control" value="{{ $program->icon ?? 'fa-book' }}" placeholder="fa-book">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Description <span class="text-danger">*</span></label>
                                                        <textarea name="programs[{{ $index }}][description]" class="form-control" rows="2" required>{{ $program->description }}</textarea>
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
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Programs</button>
                                </div>
                            </div>

                            {{-- ══ Tab 7: Why Choose Us (Features) ═════════════════ --}}
                            <div class="tab-pane cms-tab-content" id="cms-features">
                                <p class="section-tip">Highlight the key benefits of your school — displayed as feature cards on the landing page.</p>

                                <div id="features-container">
                                    @foreach($school->features ?? [] as $index => $feature)
                                        <div class="feature-item" data-findex="{{ $index }}">
                                            <button type="button" class="btn btn-xs btn-danger remove-btn remove-feature" data-findex="{{ $index }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>FA Icon</label>
                                                        <input type="text" name="features[{{ $index }}][icon]" class="form-control" value="{{ $feature->icon ?? 'fa-check' }}" placeholder="fa-check">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Title <span class="text-danger">*</span></label>
                                                        <input type="text" name="features[{{ $index }}][title]" class="form-control" value="{{ $feature->title ?? '' }}" placeholder="e.g. Expert Teachers" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <input type="text" name="features[{{ $index }}][description]" class="form-control" value="{{ $feature->description ?? '' }}" placeholder="Brief explanation...">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-feature" class="btn btn-default" style="margin-top:8px;">
                                    <i class="fa fa-plus"></i> Add Feature
                                </button>

                                <div class="text-right" style="margin-top:20px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Features</button>
                                </div>
                            </div>

                            {{-- ══ Tab 8: Testimonials ══════════════════════════════ --}}
                            <div class="tab-pane cms-tab-content" id="cms-testimonials">
                                <p class="section-tip">Student or parent reviews shown on the landing page.</p>

                                <div id="testimonials-container">
                                    @foreach($school->testimonials as $index => $testimonial)
                                        <div class="cms-item" data-index="{{ $index }}">
                                            <button type="button" class="btn btn-xs btn-danger remove-btn remove-testimonial" data-index="{{ $index }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="testimonials[{{ $index }}][author]" class="form-control" value="{{ $testimonial->author }}" placeholder="e.g. Ahmed Ali" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Role <span class="text-danger">*</span></label>
                                                        <input type="text" name="testimonials[{{ $index }}][role]" class="form-control" value="{{ $testimonial->role }}" placeholder="Parent / Student" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Rating</label>
                                                        <select name="testimonials[{{ $index }}][rating]" class="form-control">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <option value="{{ $i }}" {{ ($testimonial->rating ?? 5) == $i ? 'selected' : '' }}>
                                                                    {{ str_repeat('★', $i) }} {{ $i }}/5
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Avatar Photo</label>
                                                        <input type="file" name="testimonials[{{ $index }}][avatar]" class="form-control" accept="image/*">
                                                        @if($testimonial->avatar ?? false)
                                                            <img src="{{ asset($testimonial->avatar) }}" style="margin-top:6px;width:36px;height:36px;border-radius:50%;object-fit:cover;border:1px solid #ddd;">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Testimonial Text <span class="text-danger">*</span></label>
                                                <textarea name="testimonials[{{ $index }}][content]" class="form-control" rows="2" placeholder="What they said about the school..." required>{{ $testimonial->content }}</textarea>
                                            </div>
                                            <input type="hidden" name="testimonials[{{ $index }}][id]" value="{{ $testimonial->id }}">
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="add-testimonial" class="btn btn-default" style="margin-top:8px;">
                                    <i class="fa fa-plus"></i> Add Testimonial
                                </button>

                                <div class="text-right" style="margin-top:20px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Testimonials</button>
                                </div>
                            </div>

                            {{-- ══ Tab 9: Social & Contact ══════════════════════════ --}}
                            <div class="tab-pane cms-tab-content" id="cms-social">
                                <p class="section-tip">Contact details and social media links shown in the footer and contact section.</p>

                                <h5 style="margin-bottom:12px;"><i class="fa fa-phone"></i> Contact Information</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong>Address</strong></label>
                                            <textarea name="address" class="form-control" rows="3" placeholder="Full school address">{{ $school->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Phone</strong></label>
                                            <input type="text" name="phone" class="form-control" value="{{ $school->phone ?? '' }}" placeholder="+92 300 1234567">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" value="{{ $school->email ?? '' }}" placeholder="info@school.com">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label><strong>Website</strong></label>
                                            <input type="text" name="website" class="form-control" value="{{ $school->website ?? '' }}" placeholder="https://www.school.com">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Google Maps Embed URL</strong></label>
                                            <input type="text" name="map_url" class="form-control" value="{{ $school->map_url ?? '' }}" placeholder="https://maps.google.com/...">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Footer Short Description</strong></label>
                                    <textarea name="short_description" class="form-control" rows="2" placeholder="Brief school description shown in the footer...">{{ $school->short_description ?? '' }}</textarea>
                                </div>

                                <hr>
                                <h5 style="margin:16px 0 12px;"><i class="fa fa-share-alt"></i> Social Media Links</h5>
                                @php
                                    $socials = [
                                        ['key' => 'facebook',  'label' => 'Facebook',  'icon' => 'fa-facebook',  'color' => '#3b5998', 'ph' => 'https://facebook.com/yourschool'],
                                        ['key' => 'twitter',   'label' => 'X / Twitter','icon' => 'fa-twitter',  'color' => '#1da1f2', 'ph' => 'https://twitter.com/yourschool'],
                                        ['key' => 'instagram', 'label' => 'Instagram', 'icon' => 'fa-instagram', 'color' => '#e1306c', 'ph' => 'https://instagram.com/yourschool'],
                                        ['key' => 'youtube',   'label' => 'YouTube',   'icon' => 'fa-youtube',   'color' => '#ff0000', 'ph' => 'https://youtube.com/@yourschool'],
                                        ['key' => 'linkedin',  'label' => 'LinkedIn',  'icon' => 'fa-linkedin',  'color' => '#0077b5', 'ph' => 'https://linkedin.com/company/yourschool'],
                                        ['key' => 'whatsapp',  'label' => 'WhatsApp',  'icon' => 'fa-whatsapp',  'color' => '#25d366', 'ph' => 'https://wa.me/92300000000'],
                                    ];
                                    $socialLinks = is_array($school->social_links) ? $school->social_links : (json_decode($school->social_links ?? '{}', true) ?? []);
                                @endphp

                                @foreach($socials as $s)
                                    <div class="social-row">
                                        <span class="social-icon"><i class="fa {{ $s['icon'] }}" style="color:{{ $s['color'] }};"></i></span>
                                        <label style="width:90px;margin:0;font-weight:600;">{{ $s['label'] }}</label>
                                        <input type="text" name="social_links[{{ $s['key'] }}]" class="form-control"
                                               value="{{ $socialLinks[$s['key']] ?? '' }}" placeholder="{{ $s['ph'] }}">
                                    </div>
                                @endforeach

                                <div class="text-right" style="margin-top:20px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Contact &amp; Social</button>
                                </div>
                            </div>

                        </div>{{-- /tab-content --}}
                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script>
            $(document).ready(function() {

                // ── Color swatches ─────────────────────────────────────────
                $('#primary_color').on('input', function() {
                    var c = $(this).val();
                    $('#primary-swatch').css('background', c);
                    $('#primary-hex').text(c);
                });
                $('#secondary_color').on('input', function() {
                    var c = $(this).val();
                    $('#secondary-swatch').css('background', c);
                    $('#secondary-hex').text(c);
                });

                // ── Programs ───────────────────────────────────────────────
                var programIndex = {{ count($school->programs) }};
                $('#add-program').click(function() {
                    $('#programs-container').append(`
                        <div class="cms-item" data-index="${programIndex}">
                            <button type="button" class="btn btn-xs btn-danger remove-btn remove-program" data-index="${programIndex}">
                                <i class="fa fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Program Name <span class="text-danger">*</span></label>
                                        <input type="text" name="programs[${programIndex}][name]" class="form-control" placeholder="e.g. Science" required>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Icon</label>
                                        <input type="text" name="programs[${programIndex}][icon]" class="form-control" placeholder="fa-book" value="fa-book">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Description <span class="text-danger">*</span></label>
                                        <textarea name="programs[${programIndex}][description]" class="form-control" rows="2" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>`);
                    programIndex++;
                });
                $(document).on('click', '.remove-program', function() {
                    $(this).closest('.cms-item').remove();
                });

                // ── Features ───────────────────────────────────────────────
                var featureIndex = {{ count($school->features ?? []) }};
                $('#add-feature').click(function() {
                    $('#features-container').append(`
                        <div class="feature-item" data-findex="${featureIndex}">
                            <button type="button" class="btn btn-xs btn-danger remove-btn remove-feature" data-findex="${featureIndex}">
                                <i class="fa fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>FA Icon</label>
                                        <input type="text" name="features[${featureIndex}][icon]" class="form-control" placeholder="fa-check" value="fa-check">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" name="features[${featureIndex}][title]" class="form-control" placeholder="e.g. Expert Teachers" required>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" name="features[${featureIndex}][description]" class="form-control" placeholder="Brief explanation...">
                                    </div>
                                </div>
                            </div>
                        </div>`);
                    featureIndex++;
                });
                $(document).on('click', '.remove-feature', function() {
                    $(this).closest('.feature-item').remove();
                });

                // ── Testimonials ───────────────────────────────────────────
                var testimonialIndex = {{ count($school->testimonials) }};
                $('#add-testimonial').click(function() {
                    $('#testimonials-container').append(`
                        <div class="cms-item" data-index="${testimonialIndex}">
                            <button type="button" class="btn btn-xs btn-danger remove-btn remove-testimonial" data-index="${testimonialIndex}">
                                <i class="fa fa-times"></i>
                            </button>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="testimonials[${testimonialIndex}][author]" class="form-control" placeholder="e.g. Ahmed Ali" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Role <span class="text-danger">*</span></label>
                                        <input type="text" name="testimonials[${testimonialIndex}][role]" class="form-control" placeholder="Parent / Student" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Rating</label>
                                        <select name="testimonials[${testimonialIndex}][rating]" class="form-control">
                                            <option value="5" selected>★★★★★ 5/5</option>
                                            <option value="4">★★★★ 4/5</option>
                                            <option value="3">★★★ 3/5</option>
                                            <option value="2">★★ 2/5</option>
                                            <option value="1">★ 1/5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Avatar Photo</label>
                                        <input type="file" name="testimonials[${testimonialIndex}][avatar]" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Testimonial Text <span class="text-danger">*</span></label>
                                <textarea name="testimonials[${testimonialIndex}][content]" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>`);
                    testimonialIndex++;
                });
                $(document).on('click', '.remove-testimonial', function() {
                    $(this).closest('.cms-item').remove();
                });

            });
        </script>
    @endpush
</x-tenant-app-layout>

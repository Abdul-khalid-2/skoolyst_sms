<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Program;
use App\Models\School;
use App\Models\Subject;
use App\Models\SystemSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolProfileController extends Controller
{
    /**
     * Display a listing of the classes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $school = School::first();
        $stats = [
            'students' => User::role('student')->count(),
            'teachers' => User::role('teacher')->count(),
            'classes' => Classes::count(),
        ];

        $classes = Classes::with(['sections', 'classTeachersSubjects.subject'])
            ->orderBy('numeric_value')
            ->get();

        $subjects = Subject::with(['teacherSubjects.class', 'teacherSubjects.teacher'])
            ->orderBy('name')
            ->get();


        return view('app.admin.schoo_profile.school_profile', compact('school', 'stats', 'classes', 'subjects'));
    }

    // SchoolController.php

    public function edit(School $school)
    {
        $school = School::first();
        return view('app.admin.schoo_profile.edit_profile', compact('school'));
    }

    public function update(Request $request, School $school)
    {
        $school = School::first();
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'session_year'  => 'required|string|max:20',
            'address'       => 'required|string',
            'phone'         => 'required|string|max:20',
            'email'         => 'required|email|unique:schools,email,' . $school->id,
            'logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'website'       => 'nullable|url',
            'type'          => 'nullable|string',
            'affiliation'   => 'nullable|string',
            'principal'     => 'nullable|string',
            'about'         => 'nullable|string',
            'established_year'       => 'nullable|integer|min:1900|max:' . date('Y'),
            'working_hours'          => 'nullable|string',
            'social_links'           => 'nullable|array',
            'social_links.facebook'  => 'nullable|url',
            'social_links.twitter'   => 'nullable|url',
            'social_links.instagram' => 'nullable|url',
            'social_links.youtube'   => 'nullable|url',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($school->logo && Storage::disk('website')->exists($school->logo)) {
                Storage::disk('website')->delete($school->logo);
            }

            // Store new logo
            $logoPath = $request->file('logo')
                ->store("tenants/" . tenant('id') . "/school/profile", 'website');

            $validated['logo'] = $logoPath;
        }

        // Process social links - filter out empty values and convert to JSON
        if (isset($validated['social_links'])) {
            $validated['social_links'] = json_encode(
                array_filter($validated['social_links'], function ($value) {
                    return !empty($value);
                })
            );
        } else {
            $validated['social_links'] = null;
        }

        // Update the school record
        $school->update($validated);

        return redirect()->route('schools.show')
            ->with('success', 'School profile updated successfully');
    }

    public function showSettings(School $school)
    {
        $school = School::first();
        $settings = SystemSetting::where('school_id', $school->id)
            ->pluck('setting_value', 'setting_key')
            ->toArray();

        return view('app.admin.schoo_profile.settings', compact('school', 'settings'));
    }

    public function updateSettings(Request $request, School $school)
    {
        $school = School::first();
        $settings = $request->except(['_token', '_method']);

        foreach ($settings as $key => $value) {
            SystemSetting::updateOrCreate(
                ['school_id' => $school->id, 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return back()->with('success', 'Settings updated successfully');
    }

    // app/Http/Controllers/SchoolController.php

    public function updateAcademicSettings(Request $request, School $school)
    {
        $school = School::first();
        $validated = $request->validate([
            'working_hours_start'    => 'required|date_format:H:i',
            'working_hours_end'      => 'required|date_format:H:i|after:working_hours_start',
            'working_days_start'     => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'working_days_end'       => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'grading_system'         => 'required|in:percentage,letter,gpa',
            'default_class_capacity' => 'required|integer|min:10|max:60',
            'auto_promotion'         => 'nullable',
        ]);

        // Convert checkbox value to boolean
        $validated['auto_promotion'] = $request->has('auto_promotion');

        foreach ($validated as $key => $value) {
            SystemSetting::updateOrCreate(
                ['school_id' => $school->id, 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return back()->with('success', 'Academic settings updated successfully');
    }

    public function updateAttendanceSettings(Request $request, School $school)
    {
        $school = School::first();
        $validated = $request->validate([
            'attendance_method'             => 'required|in:daily,session',
            'late_threshold'                => 'required|integer|min:1|max:60',
            'send_absence_notifications'    => 'nullable',
            'absence_notification_method'   => 'required|in:email,sms,both',
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::updateOrCreate(
                ['school_id' => $school->id, 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return back()->with('success', 'Attendance settings updated successfully');
    }

    public function cms()
    {
        $school = School::with(['programs', 'testimonials'])->first();

        // If no school exists, create a default one
        if (!$school) {
            $school = School::create([
                'name' => 'Your School Name',
                'primary_color' => '#2563eb',
                'secondary_color' => '#1e40af'
            ]);
        }

        return view('app.cms.edit', compact('school'));
    }

    public function cmsUpdate(Request $request)
    {
        $school = School::firstOrFail();

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'motto' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'established_year' => 'nullable|string|max:50',
            'student_count' => 'nullable|string|max:50',
            'teacher_count' => 'nullable|string|max:50',
            'facility_count' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'short_description' => 'nullable|string',
            'programs' => 'nullable|array',
            'programs.*.name' => 'required_with:programs|string|max:255',
            'programs.*.description' => 'required_with:programs|string',
            'testimonials' => 'nullable|array',
            'testimonials.*.author' => 'required_with:testimonials|string|max:255',
            'testimonials.*.role' => 'required_with:testimonials|string|max:255',
            'testimonials.*.content' => 'required_with:testimonials|string',
            'testimonials.*.rating' => 'required_with:testimonials|integer|between:1,5',
            'testimonials.*.avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($school->logo) {
                Storage::delete($school->logo);
            }
            $path = $request->file('logo')->store('public/school');
            $school->logo = str_replace('public/', '', $path);
        } elseif ($request->has('remove_logo')) {
            if ($school->logo) {
                Storage::delete($school->logo);
                $school->logo = null;
            }
        }

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            // Delete old hero image if exists
            if ($school->hero_image) {
                Storage::delete($school->hero_image);
            }
            $path = $request->file('hero_image')->store('public/school');
            $school->hero_image = str_replace('public/', '', $path);
        } elseif ($request->has('remove_hero_image')) {
            if ($school->hero_image) {
                Storage::delete($school->hero_image);
                $school->hero_image = null;
            }
        }

        // Update school information
        $school->update($request->only([
            'name',
            'motto',
            'primary_color',
            'secondary_color',
            'established_year',
            'student_count',
            'teacher_count',
            'facility_count',
            'address',
            'phone',
            'email',
            'short_description'
        ]));

        // Handle programs
        $existingProgramIds = [];
        if ($request->has('programs')) {
            foreach ($request->programs as $programData) {
                if (isset($programData['id'])) {
                    // Update existing program
                    $program = Program::find($programData['id']);
                    if ($program) {
                        $program->update([
                            'name' => $programData['name'],
                            'description' => $programData['description']
                        ]);
                        $existingProgramIds[] = $program->id;
                    }
                } else {
                    // Create new program
                    $program = $school->programs()->create([
                        'name' => $programData['name'],
                        'description' => $programData['description']
                    ]);
                    $existingProgramIds[] = $program->id;
                }
            }
        }

        // Delete programs not in the request
        $school->programs()->whereNotIn('id', $existingProgramIds)->delete();

        // Handle testimonials
        $existingTestimonialIds = [];
        if ($request->has('testimonials')) {
            foreach ($request->testimonials as $testimonialData) {
                $avatarPath = null;

                // Handle avatar upload
                if (isset($testimonialData['avatar']) && $testimonialData['avatar'] instanceof \Illuminate\Http\UploadedFile) {
                    $path = $testimonialData['avatar']->store('public/testimonials');
                    $avatarPath = str_replace('public/', '', $path);
                }

                if (isset($testimonialData['id'])) {
                    // Update existing testimonial
                    $testimonial = Testimonial::find($testimonialData['id']);
                    if ($testimonial) {
                        $updateData = [
                            'author' => $testimonialData['author'],
                            'role' => $testimonialData['role'],
                            'content' => $testimonialData['content'],
                            'rating' => $testimonialData['rating']
                        ];

                        if ($avatarPath) {
                            // Delete old avatar if exists
                            if ($testimonial->avatar) {
                                Storage::delete($testimonial->avatar);
                            }
                            $updateData['avatar'] = $avatarPath;
                        }

                        $testimonial->update($updateData);
                        $existingTestimonialIds[] = $testimonial->id;
                    }
                } else {
                    // Create new testimonial
                    $testimonial = $school->testimonials()->create([
                        'author' => $testimonialData['author'],
                        'role' => $testimonialData['role'],
                        'content' => $testimonialData['content'],
                        'rating' => $testimonialData['rating'],
                        'avatar' => $avatarPath
                    ]);
                    $existingTestimonialIds[] = $testimonial->id;
                }
            }
        }

        // Delete testimonials not in the request
        $school->testimonials()->whereNotIn('id', $existingTestimonialIds)->delete();

        return redirect()->route('schools.cms')->with('success', 'Landing page updated successfully!');
    }
}

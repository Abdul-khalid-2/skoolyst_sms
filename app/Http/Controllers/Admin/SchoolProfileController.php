<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Classes;
use App\Models\Program;
use App\Models\Setting;
use App\Models\Subject;
use App\Models\SystemSetting;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SchoolProfileController extends Controller
{
    private function settings()
    {
        return Setting::get();
    }

    private function branchId(): ?int
    {
        return Auth::user()?->branch_id ?? Branch::query()->value('id');
    }

    public function index()
    {
        $school = $this->settings();
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

    public function edit()
    {
        $school = $this->settings();

        return view('app.admin.schoo_profile.edit_profile', compact('school'));
    }

    public function update(Request $request)
    {
        $setting = $this->settings();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'session_year' => 'required|string|max:20',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'nullable|string',
            'affiliation' => 'nullable|string',
            'principal' => 'nullable|string',
            'about' => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'social_links' => 'nullable|array',
        ]);

        $payload = [
            'school_name' => $validated['name'],
            'session_year' => $validated['session_year'],
            'school_address' => $validated['address'],
            'school_phone' => $validated['phone'],
            'school_email' => $validated['email'],
            'school_type' => $validated['type'] ?? null,
            'affiliation_no' => $validated['affiliation'] ?? null,
            'principal_name' => $validated['principal'] ?? null,
            'about' => $validated['about'] ?? null,
            'established_year' => $validated['established_year'] ?? null,
            'social_links' => isset($validated['social_links'])
                ? array_filter($validated['social_links'])
                : $setting->social_links,
        ];

        if ($request->hasFile('logo')) {
            if ($setting->school_logo && Storage::disk('website')->exists($setting->school_logo)) {
                Storage::disk('website')->delete($setting->school_logo);
            }
            $payload['school_logo'] = $request->file('logo')->store('school/profile', 'website');
        }

        $setting->update($payload);

        return redirect()->route('schools.show')->with('success', 'School profile updated successfully');
    }

    public function showSettings()
    {
        $school = $this->settings();
        $branchId = $this->branchId();

        $settings = SystemSetting::where('branch_id', $branchId)
            ->pluck('setting_value', 'setting_key')
            ->toArray();

        return view('app.admin.schoo_profile.settings', compact('school', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $branchId = $this->branchId();
        $settings = $request->except(['_token', '_method']);

        foreach ($settings as $key => $value) {
            SystemSetting::updateOrCreate(
                ['branch_id' => $branchId, 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return back()->with('success', 'Settings updated successfully');
    }

    public function updateAcademicSettings(Request $request)
    {
        $branchId = $this->branchId();
        $validated = $request->validate([
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i|after:working_hours_start',
            'working_days_start' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'working_days_end' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'grading_system' => 'required|in:percentage,letter,gpa',
            'default_class_capacity' => 'required|integer|min:10|max:60',
            'auto_promotion' => 'nullable',
        ]);

        $validated['auto_promotion'] = $request->has('auto_promotion');

        foreach ($validated as $key => $value) {
            SystemSetting::updateOrCreate(
                ['branch_id' => $branchId, 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return back()->with('success', 'Academic settings updated successfully');
    }

    public function updateAttendanceSettings(Request $request)
    {
        $branchId = $this->branchId();
        $validated = $request->validate([
            'attendance_method' => 'required|in:daily,session',
            'late_threshold' => 'required|integer|min:1|max:60',
            'send_absence_notifications' => 'nullable',
            'absence_notification_method' => 'required|in:email,sms,both',
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::updateOrCreate(
                ['branch_id' => $branchId, 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }

        return back()->with('success', 'Attendance settings updated successfully');
    }

    public function cms()
    {
        $school = $this->settings();

        return view('app.cms.edit', [
            'school' => $school,
            'programs' => Program::all(),
            'testimonials' => Testimonial::all(),
        ]);
    }

    public function cmsUpdate(Request $request)
    {
        $setting = $this->settings();
        $branchId = $this->branchId();

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
        ]);

        $payload = [
            'school_name' => $request->input('name'),
            'motto' => $request->input('motto'),
            'primary_color' => $request->input('primary_color'),
            'secondary_color' => $request->input('secondary_color'),
            'established_year' => $request->input('established_year'),
            'student_count_display' => $request->input('student_count'),
            'teacher_count_display' => $request->input('teacher_count'),
            'facility_count_display' => $request->input('facility_count'),
            'school_address' => $request->input('address'),
            'school_phone' => $request->input('phone'),
            'school_email' => $request->input('email'),
            'short_description' => $request->input('short_description'),
        ];

        if ($request->hasFile('logo')) {
            if ($setting->school_logo) {
                Storage::disk('website')->delete($setting->school_logo);
            }
            $payload['school_logo'] = $request->file('logo')->store('school/logo', 'website');
        }

        if ($request->hasFile('hero_image')) {
            if ($setting->hero_image) {
                Storage::disk('website')->delete($setting->hero_image);
            }
            $payload['hero_image'] = $request->file('hero_image')->store('school/hero', 'website');
        }

        $setting->update($payload);

        if ($request->has('programs')) {
            foreach ($request->input('programs', []) as $programData) {
                if (! empty($programData['id'])) {
                    Program::where('id', $programData['id'])->update([
                        'name' => $programData['name'],
                        'description' => $programData['description'],
                    ]);
                } else {
                    Program::create([
                        'branch_id' => $branchId,
                        'name' => $programData['name'],
                        'description' => $programData['description'],
                    ]);
                }
            }
        }

        if ($request->has('testimonials')) {
            foreach ($request->input('testimonials', []) as $testimonialData) {
                if (! empty($testimonialData['id'])) {
                    Testimonial::where('id', $testimonialData['id'])->update([
                        'author' => $testimonialData['author'],
                        'role' => $testimonialData['role'],
                        'content' => $testimonialData['content'],
                        'rating' => $testimonialData['rating'],
                    ]);
                } else {
                    Testimonial::create([
                        'branch_id' => $branchId,
                        'author' => $testimonialData['author'],
                        'role' => $testimonialData['role'],
                        'content' => $testimonialData['content'],
                        'rating' => $testimonialData['rating'],
                    ]);
                }
            }
        }

        return redirect()->route('schools.cms')->with('success', 'Landing page updated successfully!');
    }
}

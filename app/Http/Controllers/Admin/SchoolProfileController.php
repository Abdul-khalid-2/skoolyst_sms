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

    private function branchSettings(): array
    {
        $branchId = $this->branchId();

        if (! $branchId) {
            return [];
        }

        $jsonKeys = [
            'payment_gateways',
            'event_notifications',
            'exam_result_notifications',
            'homework_notifications',
            'selected_grades',
            'selected_subjects',
        ];

        $booleanKeys = [
            'dark_mode',
            'auto_promotion',
            'send_absence_notifications',
            'biometric_attendance',
            'mobile_checkin',
            'online_payments',
            'partial_payments',
            'payment_reminders',
            'two_factor_auth',
            'concurrent_logins',
            'gdpr_compliance',
            'data_encryption',
        ];

        $settings = SystemSetting::where('branch_id', $branchId)
            ->pluck('setting_value', 'setting_key')
            ->toArray();

        foreach ($settings as $key => $value) {
            if (in_array($key, $jsonKeys, true)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $settings[$key] = $decoded;
                }

                continue;
            }

            if (in_array($key, $booleanKeys, true)) {
                $settings[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }

        return $settings;
    }

    private function saveBranchSettings(array $settings): void
    {
        $branchId = $this->branchId();

        if (! $branchId) {
            return;
        }

        $jsonKeys = [
            'payment_gateways',
            'event_notifications',
            'exam_result_notifications',
            'homework_notifications',
            'selected_grades',
            'selected_subjects',
        ];

        foreach ($settings as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            } elseif (is_array($value)) {
                $value = json_encode($value);
            }

            SystemSetting::updateOrCreate(
                ['branch_id' => $branchId, 'setting_key' => $key],
                ['setting_value' => $value]
            );
        }
    }

    private function countries(): array
    {
        return [
            (object) ['code' => 'US', 'name' => 'United States'],
            (object) ['code' => 'GB', 'name' => 'United Kingdom'],
            (object) ['code' => 'CA', 'name' => 'Canada'],
            (object) ['code' => 'AU', 'name' => 'Australia'],
            (object) ['code' => 'IN', 'name' => 'India'],
            (object) ['code' => 'PK', 'name' => 'Pakistan'],
            (object) ['code' => 'AE', 'name' => 'United Arab Emirates'],
            (object) ['code' => 'SA', 'name' => 'Saudi Arabia'],
            (object) ['code' => 'BD', 'name' => 'Bangladesh'],
            (object) ['code' => 'NG', 'name' => 'Nigeria'],
        ];
    }

    private function schoolForSettings(Setting $setting, array $branchSettings): Setting
    {
        $profileKeys = [
            'academic_section',
            'address_line1',
            'address_line2',
            'city',
            'state',
            'postal_code',
            'country',
            'alt_phone',
            'website',
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'linkedin_url',
            'opening_time',
            'closing_time',
            'education_system',
            'academic_year_structure',
        ];

        foreach ($profileKeys as $key) {
            if (array_key_exists($key, $branchSettings)) {
                $setting->setAttribute($key, $branchSettings[$key]);
            }
        }

        $socialLinks = $setting->social_links ?? [];
        $socialMap = [
            'facebook_url' => 'facebook',
            'twitter_url' => 'twitter',
            'instagram_url' => 'instagram',
            'linkedin_url' => 'linkedin',
        ];

        foreach ($socialMap as $field => $platform) {
            if (empty($setting->{$field}) && ! empty($socialLinks[$platform])) {
                $setting->setAttribute($field, $socialLinks[$platform]);
            }
        }

        return $setting;
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

        $teachers = User::role('teacher')
            ->with(['teacherProfile.classTeacherOf', 'teacherSubjects'])
            ->orderBy('name')
            ->get();

        return view('app.admin.schoo_profile.school_profile', compact('school', 'stats', 'classes', 'subjects', 'teachers'));
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
        $setting = $this->settings();
        $settings = $this->branchSettings();
        $school = $this->schoolForSettings($setting, $settings);
        $countries = $this->countries();

        $availableGrades = Classes::query()->orderBy('numeric_value')->get();
        $availableSubjects = Subject::query()->orderBy('name')->get();
        $schoolGrades = array_map('intval', $settings['selected_grades'] ?? $availableGrades->pluck('id')->all());
        $schoolSubjects = array_map('intval', $settings['selected_subjects'] ?? $availableSubjects->pluck('id')->all());

        return view('app.admin.schoo_profile.settings', compact(
            'school',
            'settings',
            'countries',
            'availableGrades',
            'availableSubjects',
            'schoolGrades',
            'schoolSubjects'
        ));
    }

    public function updateBasicInfo(Request $request)
    {
        $setting = $this->settings();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_section' => 'required|in:primary,secondary,both',
            'established_year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'school_type' => 'required|in:public,private,international',
            'affiliation_number' => 'nullable|string|max:255',
            'principal' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $payload = [
            'school_name' => $validated['name'],
            'established_year' => $validated['established_year'] ?? null,
            'school_type' => $validated['school_type'],
            'affiliation_no' => $validated['affiliation_number'] ?? null,
            'principal_name' => $validated['principal'] ?? null,
            'about' => $validated['about'] ?? null,
        ];

        if ($request->hasFile('logo')) {
            if ($setting->school_logo && Storage::disk('website')->exists($setting->school_logo)) {
                Storage::disk('website')->delete($setting->school_logo);
            }
            $payload['school_logo'] = $request->file('logo')->store('school/profile', 'website');
        }

        $setting->update($payload);

        $this->saveBranchSettings([
            'academic_section' => $validated['academic_section'],
        ]);

        return back()->with('success', 'Basic information updated successfully');
    }

    public function updateContactDetails(Request $request)
    {
        $setting = $this->settings();

        $validated = $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:2',
            'phone' => 'required|string|max:20',
            'alt_phone' => 'nullable|string|max:20',
            'email' => 'required|email',
            'website' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
        ]);

        $addressParts = array_filter([
            $validated['address_line1'],
            $validated['address_line2'] ?? null,
            $validated['city'],
            $validated['state'],
            $validated['postal_code'] ?? null,
            $validated['country'],
        ]);

        $setting->update([
            'school_phone' => $validated['phone'],
            'school_email' => $validated['email'],
            'school_address' => implode(', ', $addressParts),
            'social_links' => array_filter([
                'facebook' => $validated['facebook_url'] ?? null,
                'twitter' => $validated['twitter_url'] ?? null,
                'instagram' => $validated['instagram_url'] ?? null,
                'linkedin' => $validated['linkedin_url'] ?? null,
            ]),
        ]);

        $this->saveBranchSettings([
            'address_line1' => $validated['address_line1'],
            'address_line2' => $validated['address_line2'] ?? null,
            'city' => $validated['city'],
            'state' => $validated['state'],
            'postal_code' => $validated['postal_code'] ?? null,
            'country' => $validated['country'],
            'alt_phone' => $validated['alt_phone'] ?? null,
            'website' => $validated['website'] ?? null,
            'facebook_url' => $validated['facebook_url'] ?? null,
            'twitter_url' => $validated['twitter_url'] ?? null,
            'instagram_url' => $validated['instagram_url'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'opening_time' => $validated['opening_time'] ?? null,
            'closing_time' => $validated['closing_time'] ?? null,
        ]);

        return back()->with('success', 'Contact details updated successfully');
    }

    public function updateAcademicStructure(Request $request)
    {
        $validated = $request->validate([
            'education_system' => 'required|in:american,british,ib,cbse,icse,other',
            'academic_year_structure' => 'required|in:semester,trimester,quarter',
            'grades' => 'nullable|array',
            'grades.*' => 'integer|exists:classes,id',
            'subjects' => 'nullable|array',
            'subjects.*' => 'integer|exists:subjects,id',
        ]);

        $this->saveBranchSettings([
            'education_system' => $validated['education_system'],
            'academic_year_structure' => $validated['academic_year_structure'],
            'selected_grades' => $validated['grades'] ?? [],
            'selected_subjects' => $validated['subjects'] ?? [],
        ]);

        return back()->with('success', 'Academic structure updated successfully');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'timezone' => 'required|string|max:50',
            'date_format' => 'required|string|max:20',
            'language' => 'required|string|max:5',
            'dark_mode' => 'nullable',
        ]);

        $this->saveBranchSettings([
            'timezone' => $validated['timezone'],
            'date_format' => $validated['date_format'],
            'language' => $validated['language'],
            'dark_mode' => $request->has('dark_mode'),
        ]);

        return back()->with('success', 'Settings updated successfully');
    }

    public function updateAcademicSettings(Request $request)
    {
        $validated = $request->validate([
            'working_hours_start' => 'required|date_format:H:i',
            'working_hours_end' => 'required|date_format:H:i|after:working_hours_start',
            'working_days_start' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'working_days_end' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'grading_system' => 'required|in:percentage,letter,gpa',
            'default_class_capacity' => 'required|integer|min:10|max:60',
            'auto_promotion' => 'nullable',
            'min_attendance_percentage' => 'nullable|integer|min:50|max:100',
            'passing_percentage' => 'nullable|integer|min:30|max:100',
        ]);

        $validated['auto_promotion'] = $request->has('auto_promotion');

        $this->saveBranchSettings($validated);

        return back()->with('success', 'Academic settings updated successfully');
    }

    public function updateAttendanceSettings(Request $request)
    {
        $validated = $request->validate([
            'attendance_method' => 'required|in:daily,session',
            'late_threshold' => 'required|integer|min:1|max:60',
            'send_absence_notifications' => 'nullable',
            'absence_notification_method' => 'required|in:email,sms,both',
            'biometric_attendance' => 'nullable',
            'mobile_checkin' => 'nullable',
        ]);

        $validated['send_absence_notifications'] = $request->has('send_absence_notifications');
        $validated['biometric_attendance'] = $request->has('biometric_attendance');
        $validated['mobile_checkin'] = $request->has('mobile_checkin');

        $this->saveBranchSettings($validated);

        return back()->with('success', 'Attendance settings updated successfully');
    }

    public function updateFeeSettings(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|string|max:10',
            'fee_due_day' => 'required|integer|min:1|max:28',
            'late_fee_percentage' => 'nullable|numeric|min:0|max:20',
            'online_payments' => 'nullable',
            'payment_gateways' => 'nullable|array',
            'payment_gateways.*' => 'in:stripe,paypal,razorpay',
            'partial_payments' => 'nullable',
            'payment_reminders' => 'nullable',
        ]);

        $this->saveBranchSettings([
            'currency' => $validated['currency'],
            'fee_due_day' => $validated['fee_due_day'],
            'late_fee_percentage' => $validated['late_fee_percentage'] ?? 5,
            'online_payments' => $request->has('online_payments'),
            'payment_gateways' => $validated['payment_gateways'] ?? [],
            'partial_payments' => $request->has('partial_payments'),
            'payment_reminders' => $request->has('payment_reminders'),
        ]);

        $this->settings()->update(['currency' => $validated['currency']]);

        return back()->with('success', 'Fee settings updated successfully');
    }

    public function updateNotificationSettings(Request $request)
    {
        $validated = $request->validate([
            'default_notification_method' => 'required|in:email,sms,push,both',
            'notification_email' => 'required|email',
            'notification_sender_name' => 'required|string|max:255',
            'event_notifications' => 'nullable|array',
            'event_notifications.*' => 'in:email,sms',
            'event_notification_days' => 'nullable|integer|min:0|max:7',
            'exam_result_notifications' => 'nullable|array',
            'exam_result_notifications.*' => 'in:email,sms,app',
            'homework_notifications' => 'nullable|array',
            'homework_notifications.*' => 'in:email,sms,app',
        ]);

        $this->saveBranchSettings([
            'default_notification_method' => $validated['default_notification_method'],
            'notification_email' => $validated['notification_email'],
            'notification_sender_name' => $validated['notification_sender_name'],
            'event_notifications' => $validated['event_notifications'] ?? [],
            'event_notification_days' => $validated['event_notification_days'] ?? 1,
            'exam_result_notifications' => $validated['exam_result_notifications'] ?? [],
            'homework_notifications' => $validated['homework_notifications'] ?? [],
        ]);

        return back()->with('success', 'Notification settings updated successfully');
    }

    public function updateSecuritySettings(Request $request)
    {
        $validated = $request->validate([
            'two_factor_auth' => 'nullable',
            'password_policy' => 'required|in:basic,medium,strong',
            'password_expiration' => 'required|integer|min:0|max:180',
            'failed_login_attempts' => 'required|integer|min:1|max:10',
            'lockout_duration' => 'required|integer|min:1|max:1440',
            'session_timeout' => 'required|integer|min:0|max:120',
            'concurrent_logins' => 'nullable',
            'gdpr_compliance' => 'nullable',
            'data_retention_period' => 'nullable|integer|min:6|max:120',
            'data_encryption' => 'nullable',
        ]);

        $this->saveBranchSettings([
            'two_factor_auth' => $request->has('two_factor_auth'),
            'password_policy' => $validated['password_policy'],
            'password_expiration' => $validated['password_expiration'],
            'failed_login_attempts' => $validated['failed_login_attempts'],
            'lockout_duration' => $validated['lockout_duration'],
            'session_timeout' => $validated['session_timeout'],
            'concurrent_logins' => $request->has('concurrent_logins'),
            'gdpr_compliance' => $request->has('gdpr_compliance'),
            'data_retention_period' => $validated['data_retention_period'] ?? 36,
            'data_encryption' => $request->has('data_encryption'),
        ]);

        return back()->with('success', 'Security settings updated successfully');
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

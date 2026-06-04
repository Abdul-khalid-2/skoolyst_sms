<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Setting::get());
    }

    public function update(Request $request): JsonResponse
    {
        $setting = Setting::get();

        $data = $request->validate([
            'app_name' => ['sometimes', 'string', 'max:255'],
            'school_name' => ['nullable', 'string', 'max:255'],
            'school_email' => ['nullable', 'email'],
            'school_phone' => ['nullable', 'string', 'max:30'],
            'school_address' => ['nullable', 'string'],
            'school_logo' => ['nullable', 'string'],
            'school_favicon' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'string'],
            'established_year' => ['nullable', 'integer'],
            'principal_name' => ['nullable', 'string', 'max:255'],
            'affiliation_no' => ['nullable', 'string', 'max:255'],
            'school_type' => ['nullable', 'string', 'max:50'],
            'session_year' => ['nullable', 'string', 'max:20'],
            'about' => ['nullable', 'string'],
            'motto' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'primary_color' => ['nullable', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
            'student_count_display' => ['nullable', 'string', 'max:50'],
            'teacher_count_display' => ['nullable', 'string', 'max:50'],
            'facility_count_display' => ['nullable', 'string', 'max:50'],
            'social_links' => ['nullable', 'array'],
            'currency' => ['nullable', 'string', 'max:10'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'date_format' => ['nullable', 'string', 'max:20'],
            'academic_year_start' => ['nullable', 'string', 'max:20'],
            'late_fine_per_day' => ['nullable', 'numeric'],
            'attendance_type' => ['nullable', 'in:daily,period'],
        ]);

        $setting->update($data);

        return response()->json($setting->fresh());
    }
}

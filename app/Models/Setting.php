<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'app_name',
        'school_name',
        'school_email',
        'school_phone',
        'school_address',
        'school_logo',
        'school_favicon',
        'hero_image',
        'hero_title',
        'hero_subtitle',
        'hero_description',
        'hero_cta_text',
        'hero_cta_link',
        'established_year',
        'principal_name',
        'principal_photo',
        'principal_message',
        'affiliation_no',
        'school_type',
        'session_year',
        'about',
        'mission',
        'vision',
        'motto',
        'short_description',
        'website',
        'map_url',
        'primary_color',
        'secondary_color',
        'student_count_display',
        'teacher_count_display',
        'facility_count_display',
        'awards_count',
        'courses_count',
        'pass_rate',
        'social_links',
        'features',
        'show_hero',
        'show_about',
        'show_stats',
        'show_programs',
        'show_features',
        'show_testimonials',
        'show_gallery',
        'show_contact',
        'show_social',
        'show_news',
        'currency',
        'timezone',
        'date_format',
        'academic_year_start',
        'late_fine_per_day',
        'attendance_type',
    ];

    protected $casts = [
        'social_links'     => 'array',
        'features'         => 'array',
        'late_fine_per_day'=> 'decimal:2',
        'established_year' => 'integer',
        'show_hero'        => 'boolean',
        'show_about'       => 'boolean',
        'show_stats'       => 'boolean',
        'show_programs'    => 'boolean',
        'show_features'    => 'boolean',
        'show_testimonials'=> 'boolean',
        'show_gallery'     => 'boolean',
        'show_contact'     => 'boolean',
        'show_social'      => 'boolean',
        'show_news'        => 'boolean',
    ];

    public function getNameAttribute(): ?string
    {
        return $this->school_name;
    }

    public function getLogoAttribute(): ?string
    {
        return $this->school_logo;
    }

    public function getLogoUrlAttribute(): string
    {
        if (! $this->school_logo) {
            return asset('backend/img/logo/logo.png');
        }

        if (str_starts_with($this->school_logo, 'http://') || str_starts_with($this->school_logo, 'https://')) {
            return $this->school_logo;
        }

        if (str_starts_with($this->school_logo, 'tenancy/')) {
            return asset($this->school_logo);
        }

        return asset('assets/'.$this->school_logo);
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        if (! $this->hero_image) {
            return null;
        }

        if (str_starts_with($this->hero_image, 'http://') || str_starts_with($this->hero_image, 'https://')) {
            return $this->hero_image;
        }

        if (str_starts_with($this->hero_image, 'tenancy/')) {
            return asset($this->hero_image);
        }

        return asset('assets/'.$this->hero_image);
    }

    public function getEmailAttribute(): ?string
    {
        return $this->school_email;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->school_phone;
    }

    public function getAddressAttribute(): ?string
    {
        return $this->school_address;
    }

    public function getAffiliationNumberAttribute(): ?string
    {
        return $this->affiliation_no;
    }

    public function getPrincipalAttribute(): ?string
    {
        return $this->principal_name;
    }

    public function getTypeAttribute(): ?string
    {
        return $this->school_type;
    }

    public function getStudentCountAttribute(): ?string
    {
        return $this->student_count_display;
    }

    public function getTeacherCountAttribute(): ?string
    {
        return $this->teacher_count_display;
    }

    public function getFacilityCountAttribute(): ?string
    {
        return $this->facility_count_display;
    }

    public function getProgramsAttribute(): Collection
    {
        return Program::query()
            ->withoutGlobalScope('branch_id')
            ->orderBy('order')
            ->get();
    }

    public function getTestimonialsAttribute(): Collection
    {
        return Testimonial::query()
            ->withoutGlobalScope('branch_id')
            ->orderBy('order')
            ->get();
    }

    public static function get(): self
    {
        return Cache::rememberForever('app.settings', function () {
            return static::query()->firstOrCreate([], [
                'app_name' => 'Skoolyst',
                'school_name' => 'Skoolyst',
            ]);
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('app.settings');
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }
}

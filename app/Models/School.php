<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'logo',
        'session_year',
        'type',
        'affiliation',
        'principal',
        'about',
        'established_year',
        'social_links',

        'motto',
        'hero_image',
        'student_count',
        'teacher_count',
        'facility_count',
        'primary_color',
        'secondary_color',
        'short_description',

    ];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }



    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'title',
        'author',
        'isbn',
        'publisher',
        'edition',
        'category',
        'price',
        'quantity',
        'available',
        'shelf_number'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function issues()
    {
        return $this->hasMany(BookIssue::class);
    }
}

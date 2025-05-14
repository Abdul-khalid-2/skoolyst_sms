<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookIssue extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'school_id',
        'book_id',
        'user_id',
        'issue_date',
        'return_date',
        'due_date',
        'status',
        'fine_amount',
        'notes'
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\BelongsToSchoolBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes, BelongsToSchoolBranch;

    protected $fillable = [
        'branch_id',
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
    public function issues()
    {
        return $this->hasMany(BookIssue::class);
    }
}


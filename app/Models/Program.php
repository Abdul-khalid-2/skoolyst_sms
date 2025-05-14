<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $guarded = [];
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}

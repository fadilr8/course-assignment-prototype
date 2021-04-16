<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $guarded = [];
    public $timestamps = false;
    
    public function courses() {
        return $this->belongsToMany(Course::class);
    }
}

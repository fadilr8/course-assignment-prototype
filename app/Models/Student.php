<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;

    public function courses() {
        return $this->belongsToMany(Course::class);
    }
    
    public function filterCourses($course) {
        return $this->belongsToMany(Course::class)->wherePivot('id', $course);
    }
}

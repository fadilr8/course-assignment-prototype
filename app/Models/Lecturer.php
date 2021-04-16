<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    public $timestamps = false;
    public $guarded = [];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function courses() {
        return $this->belongsToMany(Course::class)
            ->withTimestamps()
            ->withPivot(['schedule_id']);
    }

    public function assignCourses($courses) {
        $this->courses()->attach($courses);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $guarded = []; 

    public function schedules() {
        return $this->belongsToMany(Schedule::class);
    }

    public function students() {
        return $this->belongsToMany(Student::class)->withPivot(['id']);
    }

    public function lecturers() {
        return $this->belongsToMany(Lecturer::class)
            ->withTimestamps()
            ->withPivot(['schedule_id'])
            ->using(CourseLecturer::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    // public function lecturerSchedule() {
    //     return $this->belongsToMany(Lecturer::class)
    //         ->withTimestamps()
    //         ->withPivot(['schedule_id']);
    //         // ->using(CourseLecturer::class);
    // }
}

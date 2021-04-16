<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $fillable = ['room'];
    public $timestamps = false;

    public function course() {
        return $this->hasMany(Course::class);
    }
}

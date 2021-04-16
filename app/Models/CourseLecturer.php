<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseLecturer extends Pivot
{
    public function schedule() {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}

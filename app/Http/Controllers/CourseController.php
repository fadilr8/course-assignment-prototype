<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Schedule;

class CourseController extends Controller
{
    public function index(Request $request) {
        $course = Course::find($request->id);
        
        foreach ($course->lecturers as $lecturer) {
            $lecturersData = [
                'nip' => $lecturer->employee_id_number,
                'name' => $lecturer->user->name,
                'schedule' => [
                    'day' => $lecturer->pivot->schedule->day,
                    'session_start' => $lecturer->pivot->schedule->start,
                    'session_end' => $lecturer->pivot->schedule->end
                ]
            ];
        }

        $data = [
            'id' => $course->id,
            'code' => $course->code,
            'course' => $course->name,
            'lecturers' => $lecturersData,
        ];

        $status = 'Success';

        return response()->json(compact('data', 'status'), 200);
    }

    public function create(Request $request) {
        $day = Schedule::where('day', $request->day)->get();
        $schedule = $day[$request->course_session-1];

        $course = Course::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        $course->schedules()->attach($schedule);
        foreach ($course->schedules as $value) {
            $course_schedules = [
                'course_session' => "{$value->day}, {$value->start} - {$value->end}",
            ];
        }

        $data = [
            'id' => $course->id,
            'code' => $course->code,
            'course' => $course->name,
            'schedules' => $course_schedules
        ];
        $status = 'Success';

        return response()->json(compact('data', 'status'), 200);
    }

    public function update(Request $request) {
        $course = Course::find($request->id);
        
        $course->update([
            'code' => $request->code,
            'name' => $request->name
        ]);
            
        if ($request->day && $request->course_session) {
            $day = Schedule::where('day', $request->day)->get();
            $schedule = $day[$request->course_session-1];
            
            $course->schedules()->sync($schedule);
        }

        foreach ($course->schedules as $value) {
            $course_schedules = [
                'course_session' => "{$value->day}, {$value->start} - {$value->end}",
            ];
        }

        $data = [
            'id' => $course->id,
            'code' => $course->code,
            'course' => $course->name,
            'schedules' => $course_schedules
        ];
        $status = 'Success';
        
        return response()->json(compact('data', 'status'), 200);
    }

    public function delete(Request $request) {
        $course = Course::findOrFail($request->id);

        $course->students()->detach();
        $course->lecturers()->detach();
        $course->schedules()->detach();

        $course->delete();
        $status = 'Success';

        return response()->json(compact('status'), 204);
    }
}

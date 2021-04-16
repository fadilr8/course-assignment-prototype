<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;

class StudentController extends Controller
{
    public function index(Request $request) {
        $student = Student::find($request->id);

        $coursesData = [];
        foreach ($student->courses as $course) {
            $lecturers = $course->lecturers;
            foreach ($lecturers as $lecturer) {
                $lecturerData = [
                    'nip' => $lecturer->employee_id_number,
                    'name' => $lecturer->user->name,
                ];
            }
            $coursesData = [
                'code' => $course->code,
                'course' => $course->name,
                'lecturers' => $lecturerData
            ];
        }
        $data = [
            'id' => $student->id,
            'name' => $student->name,
            'nim' => $student->student_id_number,
            'course' => $coursesData

        ];
        $status = 'Success';

        return response()->json(compact('data', 'status'), 200);
    }

    public function addCourse(Request $request) {
        $student = Student::find($request->id);
        $course = Course::find($request->course);
        
        $student->courses()->attach($course);
        foreach ($student->courses as $value) {
            foreach ($value->schedules as $schedule) {
                $courseData[] = [
                    'code' => $value->code,
                    'name' => $value->name,
                    'schedule' => "{$schedule->day}, {$schedule->start} - {$schedule->end}"
                ];
            }
        }
        
        $data = [
            'id' => $student->id,
            'name' => $student->name,
            'nim' => $student->student_id_number,
            'courses' => $courseData
        ];

        return response()->json($data, 200);
    }

    public function updateCourse(Request $request) {
        $student = Student::find($request->id);
        $course = $student->filterCourses($request->course_id)->first();         
        $newCourse = Course::find($request->course);
        
        $student->courses()->detach($request->course_id);
        $student->courses()->attach($newCourse);
        
        $courseData = [];
        foreach ($student->courses as $value) {
            foreach ($value->schedules as $schedule) {
                $courseData[] = [
                    'code' => $value->code,
                    'name' => $value->name,
                    'schedule' => "{$schedule->day}, {$schedule->start} - {$schedule->end}"
                ];
            }
        }

        $data = [
            'id' => $student->id,
            'name' => $student->name,
            'nim' => $student->student_id_number,
            'courses' => $courseData
        ];

        $status = 'Success';

        return response()->json(compact('data', 'status'), 200);
    }

    public function deleteCourse(Request $request) {
        $student = Student::findOrFail($request->id);

        $student->courses()->detach($request->course_id);

        return response()->json([], 204);
    }
}

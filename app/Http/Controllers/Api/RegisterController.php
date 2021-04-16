<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Models\Course;
use App\Models\Lecturer;
use App\Rules\Lowercase;

class RegisterController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => ['required'],
            'nip' => ['required'],
            'course' => ['required'],
            'username' => ['required', new Lowercase],
            'password' => ['required', 'min:8', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],
        ], [
            'password.regex' => 'Password must have uppercase, number, and special characters!'
        ]);
        // dd($course = Course::find($request->course[0]['course']) . '\n' . $course->schedules[$request->course[$i]['session']);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->username . '@puti.com',
                'username' => $request->username,
                'password' => bcrypt($request->password),
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Error'], 500);
        }

        $user->assignRole(Role::find(2));

        $lecturer = Lecturer::create([
            'employee_id_number' => $request->nip,
            'user_id' => $user->id
        ]);

        $courses = $request->course;
        foreach ($courses as $course) {
            $input = Course::find($course['course']);
            $schedule = $input->schedules[$course['session']-1];
            // dd($input);
            $lecturer->courses()->attach($input, ['schedule_id' => $schedule->id]);
        }
        
        $coursesData = [];
        foreach ($lecturer->courses as $lecturerCourse) {
            array_push($coursesData, [
                'course_code' => $lecturerCourse->code,
                'course_name' => $lecturerCourse->name
            ]);
        }

        $data = [
            'name' => $user->name,
            'nip' => $lecturer->employee_id_number,
            'username' => $user->username,
            'courses' => $coursesData,
        ];
        $status = 'Success';

        return response()->json(compact('data', 'status'), 200);
    }
}

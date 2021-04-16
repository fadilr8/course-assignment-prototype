<?php

use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = [
            [
                'code' => 'LUH1B2',
                'name' => 'Bahasa Inggris I'
            ],
            [
                'code' => 'LUH1A2',
                'name' => 'Bahasa Indonesia I'
            ],
            [
                'code' => 'HUH1A2',
                'name' => 'Pendidikan Agama Islam dan Etika'
            ],
            [
                'code' => 'MUH1B3',
                'name' => 'Kalkulus 1 B'
            ],
            [
                'code' => 'KUH1A3',
                'name' => 'Kimia'
            ],
            [
                'code' => 'FUH1A3',
                'name' => 'Fisika 1 A'
            ],
            [
                'code' => 'HUH1G3',
                'name' => 'Pancasila dan Kewarganegaraan'
            ],
        ];

        foreach ($courses as $data) {
            $course = App\Models\Course::create($data);

            for ($i=0; $i < rand(1,2); $i++) { 
                $course->schedules()->syncWithoutDetaching(App\Models\Schedule::find(rand(1, 30)));
            }
            
            for ($i=0; $i < rand(1,2); $i++) { 
                $lecturer = \App\Models\Lecturer::inRandomOrder()->first();
                $course->lecturers()->attach($lecturer, ['schedule_id' => $course->schedules()->inRandomOrder()->first()->id]);
            }
        }
    }
}

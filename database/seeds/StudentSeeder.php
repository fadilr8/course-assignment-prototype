<?php

use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = factory(App\Models\Student::class, 50)->create();

        foreach ($students as $student) {
            $courses = App\Models\Course::inRandomOrder()->limit(5)->get();

            $student->courses()->attach($courses);
        }
    }
}

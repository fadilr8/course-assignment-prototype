<?php

use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $sessions = [
            [
                'start' => '07:30',
                'end' => '09:30',
            ],
            [
                'start' => '09:30',
                'end' => '11:30',
            ],
            [
                'start' => '11:30',
                'end' => '13:30',
            ],
            [
                'start' => '13:30',
                'end' => '15:30',
            ],
            [
                'start' => '15:30',
                'end' => '17:30',
            ],
        ];

        foreach ($days as $day) {
            foreach ($sessions as $session) {
                \App\Models\Schedule::create([
                    'day' => $day,
                    'start' => $session['start'],
                    'end' => $session['end'],
                ]);
            }
        }
    }
}

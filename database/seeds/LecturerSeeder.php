<?php

use Illuminate\Database\Seeder;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = App\Role::find(2);

        $users = factory(App\User::class, 10)->create();

        foreach ($users as $user) {
            $lecturer = App\Models\Lecturer::create([
                'employee_id_number' => 198503302003121000 + rand(1,100),
                'user_id' => $user->id,
            ]);

            $user->assignRole($role);
        }
    }
}

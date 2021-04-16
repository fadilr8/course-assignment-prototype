<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = App\User::create([
            'name' => 'Administrator',
            'email' => 'admin@puti.com',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $role = App\Role::find(1);

        $admin->assignRole($role);
    }
}

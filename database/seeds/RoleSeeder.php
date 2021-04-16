<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'role' => 'admin',
                'description' => 'Administrator'
            ],
            [
                'role' => 'lecturer',
                'description' => 'Dosen'
            ]
        ];

        foreach ($roles as $role) {
            App\Role::create([
                'role' => $role['role'],
                'description' => $role['description'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->firstOrFail();
        $managerRole = Role::where('name', 'manager')->firstOrFail();
        $userRole = Role::where('name', 'user')->firstOrFail();

        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        User::create([
            'role_id' => $managerRole->id,
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'password',
        ]);

        User::create([
            'role_id' => $userRole->id,
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password',
        ]);
    }
}

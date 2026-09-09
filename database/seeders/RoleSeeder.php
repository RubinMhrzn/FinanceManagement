<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
            'description' => 'Full system access',
        ]);

        Role::create([
            'name' => 'manager',
            'description' => 'can manage and improve transactions',
        ]);
        Role::create([
            'name' => 'user',
            'description' => 'can manage their own finances'
        ]);
    }
}

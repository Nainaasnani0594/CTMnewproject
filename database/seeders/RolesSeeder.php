<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Create Project',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Manage Users',
            'guard_name' => 'web',
        ]);

    }
}

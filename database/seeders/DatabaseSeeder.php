<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $super_admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@seyom.in',
        ]);

        $roles = ['Super Admin', 'Admin', 'Manager', 'Executive'];
        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create(['name' => $role]);
        }

        // add super admin role to admin
        $super_admin->assignRole('Super Admin');
    }
}

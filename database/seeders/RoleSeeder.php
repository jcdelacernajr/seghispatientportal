<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $roles = ['admin', 'doctor', 'patient'];
        $roleObjects = [];

        foreach ($roles as $roleName) {
            $roleObjects[$roleName] = Role::firstOrCreate(['name' => $roleName]);
        }

        // Create default admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['password' => Hash::make('password')]
        );

        // Assign admin role
        $user->roles()->syncWithoutDetaching([$roleObjects['admin']->id]);
    }
}

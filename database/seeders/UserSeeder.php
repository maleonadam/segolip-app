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
        $adminRole = Role::whereName('admin')->first();

        $userRole = Role::whereName('user')->first();

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('secret123')
        ]);

        $user->assignRole($adminRole);
        $user->assignRole($userRole);

        $user = User::create([
            'name' => 'Adam',
            'email' => 'adam@gmail.com',
            'password' => bcrypt('secret123')
        ]);

        $user->assignRole($userRole);

        $user = User::create([
            'name' => 'Lalo',
            'email' => 'lalo@gmail.com',
            'password' => bcrypt('secret123')
        ]);

        $user->assignRole($userRole);
    }
}

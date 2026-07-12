<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $admin->syncRoles(['super_admin', 'admin']);

        $user = User::updateOrCreate(
            ['email' => 'user@admin.com'],
            [
                'name' => 'User Account',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $user->syncRoles(['user']);

        $recruiter = User::updateOrCreate(
            ['email' => 'recruiter@demo.com'],
            [
                'name' => 'Recruiter Account',
                'password' => Hash::make('password'),
                'recruiter_status' => 'verified',
                'is_active' => true,
            ]
        );

        $recruiter->syncRoles(['recruiter']);

        $pelamar = User::updateOrCreate(
            ['email' => 'pelamar@demo.com'],
            [
                'name' => 'Pelamar Account',
                'password' => Hash::make('password'),
                'recruiter_status' => null,
                'is_active' => true,
            ]
        );

        $pelamar->syncRoles(['pelamar']);
    }
}
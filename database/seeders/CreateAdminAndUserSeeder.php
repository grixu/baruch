<?php

namespace Database\Seeders;

use Domain\Auth\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminAndUserSeeder extends Seeder
{
    public function run()
    {
        if (env('CREATE_ADMIN', true)) {
            $admin = User::firstOrCreate(
                [
                    'email' => 'admin@admin.pl',
                ],
                [
                    'name' => 'Admin',
                    'password' => Hash::make('admin'),
                ]
            );
            $admin->email_verified_at = now();
            $admin->save();
        }

        if (app()->environment() === 'local') {
            $user = User::firstOrCreate(
                [
                    'email' => 'user@user.pl',
                ],
                [
                    'name' => 'User',
                    'password' => Hash::make('password'),
                ]
            );
            $user->email_verified_at = now();
            $user->save();
        }
    }
}

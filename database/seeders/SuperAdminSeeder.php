<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@qadra.com.mx'],
            [
                'name' => 'Super Admin Qadra',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Pa$$w0rd')),
                'is_super_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}

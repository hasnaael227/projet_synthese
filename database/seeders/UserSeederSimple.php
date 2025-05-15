<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeederSimple extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'matricule' => 'ADM001',
                'name' => 'Super',
                'prename' => 'Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('admin2025'),
                'role' => 'admin',
                'image' => 'default.png',
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'matricule' => 'EMP001',
                'name' => 'John',
                'prename' => 'Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('john2025'),
                'role' => 'formateur',
                'image' => 'default.png',
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'matricule' => 'EMP002',
                'name' => 'Jane',
                'prename' => 'Doe',
                'email' => 'jane.doe@example.com',
                'password' => Hash::make('jane2025'),
                'role' => 'formateur',
                'image' => 'default.png',
                'email_verified_at' => Carbon::now(),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

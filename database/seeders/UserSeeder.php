<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'matricule' => 'ADM001',
                'name' => 'Super',
                'prename' => 'Admin',
                'email' => 'superadmin@example.com',
                'image' => null,
                'role' => 'admin',
                'password' => Hash::make('superadmin123'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'matricule' => 'EMP001',
                'name' => 'John',
                'prename' => 'Doe',
                'email' => 'john.doe@example.com',
                'image' => null,
                'role' => 'formateur',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'matricule' => 'EMP002',
                'name' => 'Jane',
                'prename' => 'Doe',
                'email' => 'jane.doe@example.com',
                'image' => null,
                'role' => 'formateur',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

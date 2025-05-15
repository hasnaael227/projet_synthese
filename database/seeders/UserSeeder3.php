<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder3 extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'matricule' => 'ADM003',  // Change to unique matricule
                'name' => 'Super',
                'prename' => 'Admin',
                'email' => 'superadmin@example.com',
                'image' => null,
                'role' => 'admin',
                'password' => Hash::make('admin2025'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'matricule' => 'EMP003',  // Change to unique matricule
                'name' => 'John',
                'prename' => 'Doe',
                'email' => 'john.doe@example.com',
                'image' => null,
                'role' => 'formateur',
                'password' => Hash::make('john2025'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'matricule' => 'EMP004',  // Change to unique matricule
                'name' => 'Jane',
                'prename' => 'Doe',
                'email' => 'jane.doe@example.com',
                'image' => null,
                'role' => 'formateur',
                'password' => Hash::make('jane2025'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        
    }
}

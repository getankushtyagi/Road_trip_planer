<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'Ankush Tyagi',
                'email' => 'getankushtyagi@yopmail.com',
                'password' => Hash::make('Test@12345'),
                'confirm_password' => Hash::make('Test@12345'),
                'role' => 0,
                'phone' => 8979149318,
                'dob' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'kulli',
                'email' => 'kulli@yopmail.com',
                'password' => Hash::make('Test@12345'),
                'confirm_password' => Hash::make('Test@12345'),
                'role' => 0,
                'phone' => 7060727481,
                'dob' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        );
    }
}

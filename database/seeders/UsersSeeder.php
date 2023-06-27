<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'teacher',
                'email' => 'teacher@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'teacher',
            ],
            [
                'name' => 'student',
                'email' => 'student@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'student'
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lessons')->insert([
            [
                'student_id' => 2,
                'date' => '2023-04-20',
                'time' => '12:00:00',
            ],
            [
                'student_id' => 2,
                'date' => '2023-04-25',
                'time' => '11:00:00',
            ],
            [
                'student_id' => 2,
                'date' => '2023-05-10',
                'time' => '10:00:00',
            ],
            [
                'student_id' => 2,
                'date' => '2023-05-20',
                'time' => '10:00:00',
            ],
            [
                'student_id' => 2,
                'date' => '2023-06-10',
                'time' => '10:00:00',
            ],
            [
                'student_id' => 2,
                'date' => '2023-06-20',
                'time' => '10:00:00',
            ],
            ]);
    }
}

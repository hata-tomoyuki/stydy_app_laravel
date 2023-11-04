<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudySessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('study_session')->insert([
            [
                'user_id' => '1',
                'subject' => 'WordPress',
                'duration' => 50,
                'memo' => 'WordPressの勉強',
                'study_date' => '2023-11-01',
            ],
            [
                'user_id' => '2',
                'subject' => 'Laravel',
                'duration' => 100,
                'memo' => 'Laravelの勉強',
                'study_date' => '2023-11-12',
            ],
            [
                'user_id' => '3',
                'subject' => 'PHP',
                'duration' => 150,
                'memo' => 'PHPの勉強',
                'study_date' => '2023-11-20',
            ]
        ]);
    }
}

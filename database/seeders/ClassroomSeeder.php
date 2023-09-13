<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->insert([
            'name' => 'Android',
            'code' => 'WERDSAA',
            'section' => 'Android',
            'subject' => 'java',
            'room' => 'tornto' ,
            'user_id' => '1',
        ]);

        DB::table('classrooms')->insert([
            'name' => 'Flutter',
            'code' => 'WERDYIUA',
            'section' => 'flutter',
            'subject' => 'flutter subject',
            'room' => 'quds' ,
            'user_id' => '1',
        ]);
    }
}
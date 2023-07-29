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
            'name' => 'TT9-laravel',
            'code' => 'laravel9',
            'section' => 'LARAVEL',
            'subject' => 'php',
            'room' => 'quads' ,
            'user_id' => '1',
        ]);
    }
}
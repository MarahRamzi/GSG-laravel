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
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Marah Ramzi',
            'email' => 'marahramzi@example',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'Manar Ahmed',
            'email' => 'manarahmed@example ',
            'password' => Hash::make('passwordManar'),
        ]);
    }
}
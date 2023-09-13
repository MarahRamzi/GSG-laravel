<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

    //    Topic::factory(3)->create();

        // Admin::factory(4)->create();



     Topic::factory(3)->create([
         'classroom_id' => 1,
         'user_id' => 1,
         ]);

    }
}
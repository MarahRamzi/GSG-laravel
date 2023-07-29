<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

       Topic::factory(3)->create();


    //  Topic::factory()->create([
    //      'classroom_id' => 2,
    //      'user_id' => 1,
    //      ]);
    }
}
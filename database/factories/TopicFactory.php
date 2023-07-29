<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::pluck('id')->toArray();
        $classrooms = Classroom::pluck('id')->toArray();

        return [
            'name' => fake()->word(),
            'classroom_id'=> fake()->randomElement($classrooms),
            'user_id'=> fake()->randomElement($users),
        ];

   }
}
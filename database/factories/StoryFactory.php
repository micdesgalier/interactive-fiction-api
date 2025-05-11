<?php

namespace Database\Factories;

use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoryFactory extends Factory
{
    protected $model = Story::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'created_by' => User::factory(),
        ];
    }
}
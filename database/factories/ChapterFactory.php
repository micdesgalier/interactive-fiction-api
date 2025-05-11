<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    protected $model = Chapter::class;

    public function definition(): array
    {
        return [
            'story_id' => Story::factory(),
            'title' => $this->faker->sentence(3),
            'content' => $this->faker->paragraphs(4, true),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
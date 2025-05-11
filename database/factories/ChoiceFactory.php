<?php

namespace Database\Factories;

use App\Models\Choice;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChoiceFactory extends Factory
{
    protected $model = Choice::class;

    public function definition(): array
    {
        return [
            'chapter_id'        => Chapter::factory(),
            'text'              => $this->faker->sentence(6),
            'target_chapter_id' => Chapter::factory(),
            'impact'            => $this->faker->numberBetween(-5, 5),
        ];
    }
}
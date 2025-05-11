<?php

namespace Database\Factories;

use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoryFactory extends Factory
{
    // Déclare que cette factory est liée au modèle Story
    protected $model = Story::class;

    // Définir les données fictives à générer pour une histoire
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),  // Génère un titre de l'histoire de 4 mots
            'description' => $this->faker->paragraph(3),  // Génère une description aléatoire de 3 paragraphes
            'created_by' => User::factory(),  // Associe un utilisateur à cette histoire en générant un utilisateur via la factory User
        ];
    }
}
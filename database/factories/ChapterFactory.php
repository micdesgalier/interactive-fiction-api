<?php

namespace Database\Factories;

use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    // Déclare le modèle associé à la factory
    protected $model = Chapter::class;

    // Définition des données factices pour la table 'chapters'
    public function definition(): array
    {
        return [
            'story_id' => Story::factory(),  // Associe un chapitre à une histoire créée par la factory Story
            'title' => $this->faker->sentence(3),  // Crée un titre de chapitre de 3 mots
            'content' => $this->faker->paragraphs(4, true),  // Crée un contenu de chapitre avec 4 paragraphes
            'order' => $this->faker->numberBetween(1, 10),  // Crée un numéro d'ordre de chapitre entre 1 et 10
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Choice;
use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChoiceFactory extends Factory
{
    // Déclare que cette factory est liée au modèle Choice
    protected $model = Choice::class;

    // Définir les données fictives à générer
    public function definition(): array
    {
        return [
            'chapter_id'        => Chapter::factory(),  // Associe ce choix à un chapitre, généré avec la factory Chapter
            'text'              => $this->faker->sentence(6),  // Génère un texte aléatoire (6 mots)
            'target_chapter_id' => Chapter::factory(),  // Associe un chapitre cible aléatoire
            'impact'            => $this->faker->numberBetween(-5, 5),  // Impact aléatoire entre -5 et 5
        ];
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chapter extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'story_id', // Identifiant de l'histoire à laquelle appartient ce chapitre
        'title',    // Titre du chapitre
        'content',  // Contenu du chapitre
        'order',    // Ordre du chapitre (si plusieurs chapitres existent pour l'histoire)
    ];

    /**
     * La relation "Appartient à" avec le modèle Story.
     *
     * Cette méthode définit une relation où chaque chapitre appartient à une histoire spécifique.
     * Elle est utilisée pour accéder à l'histoire (parent) d'un chapitre.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * La relation "A plusieurs" avec le modèle Choice.
     *
     * Cette méthode définit une relation où un chapitre peut avoir plusieurs choix.
     * Elle est utilisée pour récupérer tous les choix associés à un chapitre.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }
}

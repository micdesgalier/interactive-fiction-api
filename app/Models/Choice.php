<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Choice extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'chapter_id',        // Identifiant du chapitre auquel ce choix appartient
        'text',              // Texte du choix (ce que l'utilisateur verra)
        'target_chapter_id', // Identifiant du chapitre vers lequel ce choix dirige (nullable)
        'impact',            // L'impact de ce choix (peut être utilisé pour calculer les effets du choix)
    ];

    /**
     * La relation "Appartient à" avec le modèle Chapter (Chapitre source).
     *
     * Cette méthode définit une relation où chaque choix appartient à un chapitre spécifique.
     * Elle est utilisée pour accéder au chapitre parent (source) d'un choix.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    /**
     * La relation "Appartient à" avec le modèle Chapter (Chapitre cible).
     *
     * Cette méthode définit une relation où un choix peut diriger l'utilisateur vers un autre chapitre.
     * Si ce choix a un chapitre cible (`target_chapter_id`), cette relation permet d'y accéder.
     * Si `target_chapter_id` est `null`, la relation sera vide.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function target(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'target_chapter_id');
    }
}
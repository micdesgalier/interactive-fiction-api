<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',      // Titre de l'histoire
        'description',// Description de l'histoire
        'created_by', // ID de l'utilisateur qui a créé l'histoire
    ];

    /**
     * La relation "Appartient à" avec le modèle User (Auteur de l'histoire).
     *
     * Cette méthode définit une relation où chaque histoire appartient à un utilisateur (créateur).
     * Elle est utilisée pour accéder à l'utilisateur qui a créé l'histoire.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * La relation "A plusieurs" avec le modèle Chapter (Chapitres de l'histoire).
     *
     * Cette méthode définit une relation où une histoire a plusieurs chapitres.
     * Elle permet de récupérer tous les chapitres de l'histoire.
     * Les chapitres seront retournés dans un ordre spécifique (défini par l'attribut `order`).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)
                    ->orderBy('order'); // Les chapitres seront triés par l'ordre défini dans la base de données
    }
}
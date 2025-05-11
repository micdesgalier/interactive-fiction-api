<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs qui peuvent être assignés en masse (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',     // Le nom de l'utilisateur
        'email',    // L'email de l'utilisateur
        'password', // Le mot de passe de l'utilisateur
    ];

    /**
     * Les attributs qui doivent être masqués lors de la conversion en tableau ou JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',        // Le mot de passe ne doit pas être exposé
        'remember_token',  // Le token de "souvenir" ne doit pas être exposé
    ];

    /**
     * Les attributs qui doivent être castés en types spécifiques lors de leur récupération ou mise à jour.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Le champ 'email_verified_at' est casté en objet datetime
    ];

    /**
     * La relation "A plusieurs" avec le modèle Story (Histoires créées par l'utilisateur).
     *
     * Cette méthode définit une relation où un utilisateur peut créer plusieurs histoires.
     * Elle permet de récupérer toutes les histoires créées par l'utilisateur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stories(): HasMany
    {
        return $this->hasMany(Story::class, 'created_by'); // Relation avec l'histoire, basée sur la colonne 'created_by'
    }
}
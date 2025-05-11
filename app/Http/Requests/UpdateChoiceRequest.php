<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe de requête dédiée à la validation des données
 * lors de la mise à jour d’un choix (Choice).
 * Elle est utilisée dans le ChoiceController pour l'action update().
 */
class UpdateChoiceRequest extends FormRequest
{
    /**
     * Autorise l'exécution de cette requête.
     * Ici, on retourne `true` pour ne pas restreindre l'accès.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Règles de validation appliquées uniquement aux champs présents.
     * Utilisation de "sometimes" pour permettre la mise à jour partielle.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Si présent, le texte doit être une chaîne et ne pas dépasser 255 caractères
            'text'             => 'sometimes|required|string|max:255',

            // Si présent, l'ID du chapitre cible doit être valide et exister dans la table des chapitres
            'target_chapter_id'=> 'sometimes|nullable|exists:chapters,id',

            // Si présent, l'impact doit être un entier
            'impact'           => 'sometimes|required|integer',
        ];
    }
}
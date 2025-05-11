<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe de requête dédiée à la validation des données
 * lors de la mise à jour d'une histoire (Story).
 * Elle est utilisée dans le StoryController pour l'action update().
 */
class UpdateStoryRequest extends FormRequest
{
    /**
     * Définition des règles de validation.
     * Utilisation de "sometimes" pour permettre la mise à jour partielle.
     * Les champs non spécifiés ne seront pas pris en compte pour la validation.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Si présent, le titre doit être une chaîne et ne pas dépasser 255 caractères
            'title' => 'sometimes|required|string|max:255',

            // La description est optionnelle et si fournie, elle doit être une chaîne
            'description' => 'nullable|string',
        ];
    }

    /**
     * Autorise l'exécution de la requête.
     * Retourne true pour ne pas restreindre l'accès à cette requête.
     *
     * @return bool
     */
    public function authorize() { return true; }
}
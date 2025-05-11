<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe de requête dédiée à la validation des données
 * lors de la mise à jour d’un chapitre (Chapter).
 * Elle est utilisée dans le ChapterController pour l'action update().
 */
class UpdateChapterRequest extends FormRequest
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
            // Si présent, le titre est requis, doit être une chaîne et max 255 caractères
            'title'   => 'sometimes|required|string|max:255',

            // Si présent, le contenu doit être une chaîne non vide
            'content' => 'sometimes|required|string',

            // Si présent, l'ordre doit être un entier positif ou nul
            'order'   => 'sometimes|required|integer|min:0',
        ];
    }
}
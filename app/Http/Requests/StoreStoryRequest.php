<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe de validation pour la création d'une histoire (Story).
 * Cette requête permet de centraliser les règles de validation
 * pour la méthode store() du StoryController.
 */
class StoreStoryRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     * Ici, on autorise tous les utilisateurs authentifiés (ou non si pas restreint).
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Règles de validation pour créer une histoire.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Le titre est requis, doit être une chaîne de caractères de 255 caractères max
            'title'       => 'required|string|max:255',

            // La description est facultative, mais si elle est présente, elle doit être une chaîne
            'description' => 'nullable|string',
        ];
    }
}
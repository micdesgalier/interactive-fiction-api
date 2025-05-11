<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Requête personnalisée pour valider la création d’un chapitre.
 */
class StoreChapterRequest extends FormRequest
{
    /**
     * Autorise la requête.
     * Ici, on permet à tout utilisateur authentifié (ou pas, selon middleware) d'effectuer la requête.
     * Tu peux ajouter une logique d'autorisation plus fine si nécessaire.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Règles de validation pour la création d’un chapitre.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Le chapitre doit être lié à une histoire existante
            'story_id' => 'required|exists:stories,id',

            // Le titre est obligatoire, doit être une chaîne de caractères et avoir une longueur maximale de 255
            'title'    => 'required|string|max:255',

            // Le contenu du chapitre est requis et doit être une chaîne
            'content'  => 'required|string',

            // L'ordre (position dans l'histoire) est requis et doit être un entier ≥ 0
            'order'    => 'required|integer|min:0',
        ];
    }
}
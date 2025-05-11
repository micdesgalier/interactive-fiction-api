<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Requête personnalisée pour valider la création d’un choix dans un chapitre.
 */
class StoreChoiceRequest extends FormRequest
{
    /**
     * Autorise l'exécution de la requête.
     * Ici, elle est autorisée pour tous les utilisateurs.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Règles de validation pour la création d’un choix.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Le choix doit appartenir à un chapitre existant
            'chapter_id'        => 'required|exists:chapters,id',

            // Le texte du choix est obligatoire, chaîne de caractères avec 255 caractères max
            'text'              => 'required|string|max:255',

            // Le chapitre cible peut être nul (cas de fin d’histoire), mais s’il est fourni, il doit exister
            'target_chapter_id' => 'nullable|exists:chapters,id',

            // Impact du choix sur le déroulement ou les stats (interprétation libre), entier requis
            'impact'            => 'required|integer',
        ];
    }
}
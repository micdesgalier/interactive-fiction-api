<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ressource de transformation d'un objet 'Choice' pour l'API.
 * Cette classe transforme un modèle 'Choice' en une structure de données
 * adaptée à la réponse JSON.
 */
class ChoiceResource extends JsonResource
{
    /**
     * Transforme l'instance du modèle 'Choice' en un tableau de données.
     * Cette méthode est utilisée pour définir le format de la réponse
     * lorsque nous retournons un choix à partir d'une API.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // L'ID unique du choix
            'id' => $this->id,

            // L'ID du chapitre auquel ce choix appartient
            'chapter_id' => $this->chapter_id,

            // Le texte associé à ce choix (ce que l'utilisateur voit)
            'text' => $this->text,

            // L'ID du chapitre cible, qui est lié à ce choix, s'il existe
            'target_chapter_id' => $this->target_chapter_id,

            // L'impact de ce choix, utilisé pour calculer les effets du choix
            'impact' => $this->impact,

            // Date de création du choix
            'created_at' => $this->created_at,

            // Date de mise à jour du choix
            'updated_at' => $this->updated_at,
        ];
    }
}
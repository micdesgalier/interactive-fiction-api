<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ressource de transformation d'un objet 'Chapter' pour l'API.
 * Cette classe transforme un modèle 'Chapter' en une structure de données
 * adaptée à la réponse JSON.
 */
class ChapterResource extends JsonResource
{
    /**
     * Transforme l'instance du modèle 'Chapter' en un tableau de données.
     * Cette méthode est utilisée pour définir le format de la réponse
     * lorsque nous retournons un chapitre à partir d'une API.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // L'ID unique du chapitre
            'id' => $this->id,

            // L'ID de l'histoire à laquelle appartient ce chapitre
            'story_id' => $this->story_id,

            // Le titre du chapitre
            'title' => $this->title,

            // Le contenu du chapitre
            'content' => $this->content,

            // L'ordre du chapitre dans la série de chapitres
            'order' => $this->order,

            // Liste des choix associés à ce chapitre
            // Si les choix ont été chargés, ils sont transformés à l'aide de ChoiceResource
            'choices' => ChoiceResource::collection($this->whenLoaded('choices')),

            // Date de création du chapitre
            'created_at' => $this->created_at,

            // Date de mise à jour du chapitre
            'updated_at' => $this->updated_at,
        ];
    }
}
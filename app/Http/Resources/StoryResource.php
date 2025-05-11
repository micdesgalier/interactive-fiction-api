<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ressource de transformation d'un objet 'Story' pour l'API.
 * Cette classe transforme un modèle 'Story' en une structure de données
 * adaptée à la réponse JSON.
 */
class StoryResource extends JsonResource
{
    /**
     * Transforme l'instance du modèle 'Story' en un tableau de données.
     * Cette méthode est utilisée pour définir le format de la réponse
     * lorsqu'une histoire est retournée à partir d'une API.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // L'ID unique de l'histoire
            'id' => $this->id,

            // Le titre de l'histoire
            'title' => $this->title,

            // La description de l'histoire, qui peut être nulle
            'description' => $this->description,

            // Le nom du créateur de l'histoire, en accédant à l'utilisateur associé au champ 'creator'
            'creator' => $this->creator->name,

            // La liste des chapitres associés à cette histoire
            // Utilise la méthode 'whenLoaded' pour ne charger les chapitres que si c'est nécessaire (optimisation des requêtes)
            'chapters' => ChapterResource::collection($this->whenLoaded('chapters')),

            // Date de création de l'histoire
            'created_at' => $this->created_at,
        ];
    }
}
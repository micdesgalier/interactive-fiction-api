<?php
// app/Http/Controllers/Api/V1/ChapterController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\ChapterResource;

/**
 * Contrôleur API pour gérer les chapitres d'une histoire.
 * Permet la création, l'affichage, la modification et la suppression de chapitres,
 * tout en respectant l'association avec une histoire donnée.
 */
class ChapterController extends Controller
{
    /**
     * Liste tous les chapitres d'une histoire spécifique.
     *
     * @param int $storyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($storyId)
    {
        // Récupère tous les chapitres liés à une histoire, avec leurs choix associés
        $chapters = Chapter::where('story_id', $storyId)
                           ->with('choices')
                           ->get();

        // Retourne la liste sous forme de collection de ressources
        return response()->json(['data' => ChapterResource::collection($chapters)], 200);
    }

    /**
     * Crée un nouveau chapitre à partir des données validées.
     *
     * @param \App\Http\Requests\StoreChapterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChapterRequest $request)
    {
        // Crée un chapitre avec les données validées du formulaire
        $chapter = Chapter::create($request->validated());

        // Retourne le chapitre nouvellement créé
        return response()->json(['data' => new ChapterResource($chapter)], 201); // 201 = Created
    }

    /**
     * Affiche un chapitre spécifique d'une histoire donnée.
     *
     * @param int $storyId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($storyId, $id)
    {
        // Récupère le chapitre avec ses choix, lié à une histoire spécifique
        $chapter = Chapter::where('story_id', $storyId)
                          ->with('choices')
                          ->findOrFail($id);

        return response()->json(['data' => new ChapterResource($chapter)], 200);
    }

    /**
     * Met à jour un chapitre existant avec des données validées.
     *
     * @param \App\Http\Requests\UpdateChapterRequest $request
     * @param int $storyId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChapterRequest $request, $storyId, $id)
    {
        // Vérifie que le chapitre appartient bien à l'histoire spécifiée
        $chapter = Chapter::where('story_id', $storyId)->findOrFail($id);

        // Met à jour le chapitre avec les données validées
        $chapter->update($request->validated());

        return response()->json(['data' => new ChapterResource($chapter)], 200);
    }

    /**
     * Supprime un chapitre d'une histoire spécifique.
     *
     * @param int $storyId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($storyId, $id)
    {
        // Recherche le chapitre dans le contexte de l'histoire
        $chapter = Chapter::where('story_id', $storyId)->findOrFail($id);

        // Supprime le chapitre de la base de données
        $chapter->delete();

        return response()->json(null, 204); // 204 = No Content
    }
}
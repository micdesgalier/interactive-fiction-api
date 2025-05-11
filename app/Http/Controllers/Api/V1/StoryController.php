<?php
// app/Http/Controllers/Api/V1/StoryController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use App\Http\Resources\StoryResource;
use Illuminate\Http\Request;

/**
 * Contrôleur API pour gérer les histoires.
 * Fournit les opérations CRUD sur les ressources Story.
 */
class StoryController extends Controller
{
    /**
     * Affiche toutes les histoires, avec leurs chapitres associés.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Récupère toutes les histoires avec les chapitres associés
        $stories = Story::with('chapters')->get();

        // Retourne la collection formatée des histoires
        return response()->json(['data' => StoryResource::collection($stories)], 200);
    }

    /**
     * Crée une nouvelle histoire pour l'utilisateur authentifié.
     *
     * @param \App\Http\Requests\StoreStoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreStoryRequest $request)
    {
        // Fusionne les données validées avec l'ID de l'utilisateur
        $story = Story::create(array_merge(
            $request->validated(),
            ['created_by' => $request->user()->id]
        ));

        // Retourne la ressource de la nouvelle histoire
        return response()->json(['data' => new StoryResource($story)], 201); // 201 = Created
    }

    /**
     * Affiche une histoire spécifique avec ses chapitres.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Recherche de l'histoire avec les chapitres associés
        $story = Story::with('chapters')->findOrFail($id);

        // Retourne la ressource formatée de l'histoire
        return response()->json(['data' => new StoryResource($story)], 200);
    }

    /**
     * Met à jour une histoire existante avec les données validées.
     *
     * @param \App\Http\Requests\UpdateStoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateStoryRequest $request, $id)
    {
        // Recherche de l'histoire à modifier
        $story = Story::findOrFail($id);

        // Mise à jour des champs avec les données validées
        $story->update($request->validated());

        return response()->json(['data' => new StoryResource($story)], 200);
    }

    /**
     * Supprime une histoire spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Recherche de l'histoire à supprimer
        $story = Story::findOrFail($id);

        // Suppression de l'histoire
        $story->delete();

        return response()->json(null, 204); // 204 = No Content
    }
}
<?php
// app/Http/Controllers/Api/V1/ChoiceController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Http\Requests\StoreChoiceRequest;
use App\Http\Requests\UpdateChoiceRequest;
use App\Http\Resources\ChoiceResource;

/**
 * Contrôleur API pour la gestion des choix associés à un chapitre.
 * Chaque choix représente une option dans la narration interactive.
 */
class ChoiceController extends Controller
{
    /**
     * Affiche tous les choix pour un chapitre donné.
     *
     * @param int $chapterId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($chapterId)
    {
        // Récupère les choix liés à un chapitre spécifique
        $choices = Choice::where('chapter_id', $chapterId)->get();

        // Retourne une collection de ressources de choix
        return response()->json(['data' => ChoiceResource::collection($choices)], 200);
    }

    /**
     * Crée un nouveau choix à partir des données validées.
     *
     * @param \App\Http\Requests\StoreChoiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChoiceRequest $request)
    {
        // Création du choix avec les données validées du formulaire
        $choice = Choice::create($request->validated());

        // Retourne le nouveau choix créé
        return response()->json(['data' => new ChoiceResource($choice)], 201); // 201 = Created
    }

    /**
     * Affiche un choix spécifique pour un chapitre donné.
     *
     * @param int $chapterId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($chapterId, $id)
    {
        // Recherche du choix dans le contexte du chapitre
        $choice = Choice::where('chapter_id', $chapterId)->findOrFail($id);

        // Retourne la ressource du choix
        return response()->json(['data' => new ChoiceResource($choice)], 200);
    }

    /**
     * Met à jour un choix existant avec des données validées.
     *
     * @param \App\Http\Requests\UpdateChoiceRequest $request
     * @param int $chapterId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChoiceRequest $request, $chapterId, $id)
    {
        // Vérifie que le choix appartient au bon chapitre
        $choice = Choice::where('chapter_id', $chapterId)->findOrFail($id);

        // Met à jour le choix avec les nouvelles données
        $choice->update($request->validated());

        return response()->json(['data' => new ChoiceResource($choice)], 200);
    }

    /**
     * Supprime un choix spécifique d'un chapitre.
     *
     * @param int $chapterId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($chapterId, $id)
    {
        // Recherche du choix à supprimer dans le contexte du chapitre
        $choice = Choice::where('chapter_id', $chapterId)->findOrFail($id);

        // Suppression du choix
        $choice->delete();

        return response()->json(null, 204); // 204 = No Content
    }
}
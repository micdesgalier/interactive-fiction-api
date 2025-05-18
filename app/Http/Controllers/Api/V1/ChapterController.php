<?php
// app/Http/Controllers/Api/V1/ChapterController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\Chapter;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\ChapterResource;

/**
 * Contrôleur API pour gérer les chapitres d'une histoire.
 */
class ChapterController extends Controller
{
    /**
     * Liste tous les chapitres d'une histoire spécifique.
     */
    public function index(Story $story)
    {
        $chapters = $story->chapters()->with('choices')->get();

        return response()->json(['data' => ChapterResource::collection($chapters)], 200);
    }

    /**
     * Crée un nouveau chapitre pour une histoire donnée.
     */
    public function store(StoreChapterRequest $request, Story $story)
    {
        $validated = $request->validated();
        $validated['story_id'] = $story->id;

        $chapter = Chapter::create($validated);

        return response()->json(['data' => new ChapterResource($chapter)], 201);
    }

    /**
     * Affiche un chapitre spécifique d'une histoire.
     */
    public function show(Story $story, Chapter $chapter)
    {
        if ($chapter->story_id !== $story->id) {
            return response()->json(['error' => 'Chapter not found in this story'], 404);
        }

        $chapter->load('choices');

        return response()->json(['data' => new ChapterResource($chapter)], 200);
    }

    /**
     * Affiche un chapitre spécifique d'une histoire en fonction de son ordre.
     */
    public function showByOrder(Story $story, $order)
    {
        $chapter = $story->chapters()->where('order', $order)->first();
        
        if (!$chapter) {
            return response()->json(['error' => 'Chapter not found with this order'], 404);
        }
        
        $chapter->load('choices');
        
        return response()->json(['data' => new ChapterResource($chapter)], 200);
    }

    /**
     * Met à jour un chapitre spécifique d'une histoire.
     */
    public function update(UpdateChapterRequest $request, Story $story, Chapter $chapter)
    {
        if ($chapter->story_id !== $story->id) {
            return response()->json(['error' => 'Chapter not found in this story'], 404);
        }

        $chapter->update($request->validated());

        return response()->json(['data' => new ChapterResource($chapter)], 200);
    }

    /**
     * Supprime un chapitre d'une histoire.
     */
    public function destroy(Story $story, Chapter $chapter)
    {
        if ($chapter->story_id !== $story->id) {
            return response()->json(['error' => 'Chapter not found in this story'], 404);
        }

        $chapter->delete();

        return response()->json(null, 204);
    }
}
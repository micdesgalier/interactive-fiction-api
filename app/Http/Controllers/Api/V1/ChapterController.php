<?php
// app/Http/Controllers/Api/V1/ChapterController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\ChapterResource;

class ChapterController extends Controller
{
    public function index($storyId)
    {
        $chapters = Chapter::where('story_id', $storyId)
                           ->with('choices')
                           ->get();
        return response()->json(['data' => ChapterResource::collection($chapters)], 200);
    }

    public function store(StoreChapterRequest $request)
    {
        $chapter = Chapter::create($request->validated());
        return response()->json(['data' => new ChapterResource($chapter)], 201);
    }

    public function show($storyId, $id)
    {
        $chapter = Chapter::where('story_id', $storyId)
                          ->with('choices')
                          ->findOrFail($id);
        return response()->json(['data' => new ChapterResource($chapter)], 200);
    }

    public function update(UpdateChapterRequest $request, $storyId, $id)
    {
        $chapter = Chapter::where('story_id', $storyId)->findOrFail($id);
        $chapter->update($request->validated());
        return response()->json(['data' => new ChapterResource($chapter)], 200);
    }

    public function destroy($storyId, $id)
    {
        $chapter = Chapter::where('story_id', $storyId)->findOrFail($id);
        $chapter->delete();
        return response()->json(null, 204);
    }
}
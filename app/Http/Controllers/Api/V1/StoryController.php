<?php
// app/Http/Controllers/Api/V1/StoryController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use App\Http\Resources\StoryResource;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::with('chapters')->get();
        return response()->json(['data' => StoryResource::collection($stories)], 200);
    }

    public function store(StoreStoryRequest $request)
    {
        $story = Story::create(array_merge(
            $request->validated(),
            ['created_by' => $request->user()->id]
        ));
        return response()->json(['data' => new StoryResource($story)], 201);
    }

    public function show($id)
    {
        $story = Story::with('chapters')->findOrFail($id);
        return response()->json(['data' => new StoryResource($story)], 200);
    }

    public function update(UpdateStoryRequest $request, $id)
    {
        $story = Story::findOrFail($id);
        $story->update($request->validated());
        return response()->json(['data' => new StoryResource($story)], 200);
    }

    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        $story->delete();
        return response()->json(null, 204);
    }
}
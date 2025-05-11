<?php
// app/Http/Controllers/Api/V1/ChoiceController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Choice;
use App\Http\Requests\StoreChoiceRequest;
use App\Http\Requests\UpdateChoiceRequest;
use App\Http\Resources\ChoiceResource;

class ChoiceController extends Controller
{
    public function index($chapterId)
    {
        $choices = Choice::where('chapter_id', $chapterId)->get();
        return response()->json(['data' => ChoiceResource::collection($choices)], 200);
    }

    public function store(StoreChoiceRequest $request)
    {
        $choice = Choice::create($request->validated());
        return response()->json(['data' => new ChoiceResource($choice)], 201);
    }

    public function show($chapterId, $id)
    {
        $choice = Choice::where('chapter_id', $chapterId)->findOrFail($id);
        return response()->json(['data' => new ChoiceResource($choice)], 200);
    }

    public function update(UpdateChoiceRequest $request, $chapterId, $id)
    {
        $choice = Choice::where('chapter_id', $chapterId)->findOrFail($id);
        $choice->update($request->validated());
        return response()->json(['data' => new ChoiceResource($choice)], 200);
    }

    public function destroy($chapterId, $id)
    {
        $choice = Choice::where('chapter_id', $chapterId)->findOrFail($id);
        $choice->delete();
        return response()->json(null, 204);
    }
}
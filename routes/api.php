<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\V1\{
    AuthController,
    StoryController,
    ChapterController,
    ChoiceController
};

Route::prefix('v1')->group(function () {

    // 1) AUTH PUBLIC
    Route::post('register', [AuthController::class, 'register']);

    // Login via Sanctum avec token (pas cookie)
    Route::post('login', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    });

    // 2) ROUTES PUBLIQUES (READ ONLY)
    Route::get('stories',                            [StoryController::class, 'index']);
    Route::get('stories/{story}',                    [StoryController::class, 'show']);
    Route::get('stories/{story}/chapters',           [ChapterController::class, 'index']);
    Route::get('stories/{story}/chapters/{chapter}', [ChapterController::class, 'show']);
    Route::get('chapters/{chapter}/choices',         [ChoiceController::class, 'index']);
    Route::get('chapters/{chapter}/choices/{choice}',[ChoiceController::class, 'show']);

    // 3) ROUTES PROTÉGÉES PAR TOKEN (auth:sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        // Stories
        Route::post  ('stories',                        [StoryController::class, 'store']);
        Route::patch ('stories/{story}',                [StoryController::class, 'update']);
        Route::delete('stories/{story}',                [StoryController::class, 'destroy']);

        // Chapters
        Route::post  ('stories/{story}/chapters',           [ChapterController::class, 'store']);
        Route::patch ('stories/{story}/chapters/{chapter}', [ChapterController::class, 'update']);
        Route::delete('stories/{story}/chapters/{chapter}', [ChapterController::class, 'destroy']);

        // Choices
        Route::post  ('chapters/{chapter}/choices',          [ChoiceController::class, 'store']);
        Route::patch ('chapters/{chapter}/choices/{choice}', [ChoiceController::class, 'update']);
        Route::delete('chapters/{chapter}/choices/{choice}', [ChoiceController::class, 'destroy']);

        // Auth
        Route::post('logout', function (Request $request) {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Déconnecté']);
        });

        Route::get('user', [AuthController::class, 'user']);
    });
});
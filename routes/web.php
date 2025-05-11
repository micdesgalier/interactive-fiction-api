<?php

use Illuminate\Support\Facades\Route;

// Route racine pour satisfaire ExampleTest
Route::get('/', function () {
    return response()->json(['message' => 'API is up and running'], 200);
});

// Endpoint CSRF pour Sanctum
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['csrf' => true]);
})->middleware('web');
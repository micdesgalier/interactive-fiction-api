<?php
// app/Http/Controllers/Api/V1/AuthController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Contrôleur d'authentification pour l'API.
 * Gère l'enregistrement, la connexion, la déconnexion et l'accès aux informations de l'utilisateur connecté.
 */
class AuthController extends Controller
{
    /**
     * Enregistre un nouvel utilisateur et retourne un token d'authentification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // Valide les données envoyées dans la requête
        $credentials = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users', // email unique obligatoire
            'password' => 'required|string|min:6',       // mot de passe d'au moins 6 caractères
        ]);

        // Crée un nouvel utilisateur avec un mot de passe haché
        $user = User::create([
            'name'     => $credentials['name'],
            'email'    => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);

        // Retourne l'utilisateur et un token d'accès
        return response()->json([
            'data'  => $user,
            'token' => $user->createToken('api')->plainTextToken,
        ], 201); // 201 = Created
    }

    /**
     * Connecte un utilisateur existant et retourne un token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Valide les informations d'identification
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Recherche l'utilisateur via son email
        $user = User::where('email', $credentials['email'])->firstOrFail();

        // Vérifie que le mot de passe est correct
        if (! Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401); // 401 = Unauthorized
        }

        // Crée un token d'accès pour l'utilisateur
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user,
        ], 200);
    }

    /**
     * Déconnecte l'utilisateur en supprimant son token actif.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Supprime le token courant de l'utilisateur
        $request->user()->currentAccessToken()->delete();

        // Réponse sans contenu (204 = No Content)
        return response()->json(null, 204);
    }

    /**
     * Retourne les informations de l'utilisateur actuellement authentifié.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function user(Request $request)
    {
        return response()->json(['data' => $request->user()], 200);
    }
}
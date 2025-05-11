<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoryApiTest extends TestCase
{
    use RefreshDatabase; // Cette ligne permet de rafraîchir la base de données pour chaque test, assurant une base propre à chaque exécution.

    // Fonction qui génère un header d'authentification avec un token valide
    protected function authHeaders(User $user = null)
    {
        $user = $user ?? User::factory()->create(); // Si aucun utilisateur n'est passé, on en crée un nouveau
        $token = $user->createToken('test')->plainTextToken; // Création du token pour l'utilisateur
        return ['Authorization' => "Bearer $token"]; // Retourne un tableau avec le token dans le header Authorization
    }

    // Test pour vérifier que toutes les histoires sont retournées
    public function test_index_returns_all_stories()
    {
        Story::factory()->count(3)->create(); // Crée 3 histoires fictives

        // Envoie une requête GET et vérifie que la réponse contient bien 3 histoires
        $this->getJson('/api/v1/stories')
             ->assertStatus(200) // Statut 200 indique que la requête a été traitée correctement
             ->assertJsonCount(3, 'data'); // Vérifie que la réponse contient 3 éléments dans le champ 'data'
    }

    // Test pour vérifier qu'une histoire retournée contient bien ses chapitres
    public function test_show_returns_story_with_chapters()
    {
        $story = Story::factory()->create(); // Crée une histoire
        Chapter::factory()->count(2)->create(['story_id' => $story->id]); // Crée 2 chapitres associés à cette histoire

        // Envoie une requête GET pour récupérer l'histoire et ses chapitres
        $this->getJson("/api/v1/stories/{$story->id}")
             ->assertStatus(200) // Vérifie que la requête est réussie
             ->assertJsonPath('data.id', $story->id) // Vérifie que l'ID de l'histoire correspond
             ->assertJsonCount(2, 'data.chapters'); // Vérifie qu'il y a bien 2 chapitres dans la réponse
    }

    // Test pour vérifier qu'une histoire inexistante renvoie une erreur 404
    public function test_show_nonexistent_story_returns_404()
    {
        $response = $this->getJson('/api/v1/stories/9999'); // Tente de récupérer une histoire avec un ID inexistant
        
        $response->assertStatus(404); // Vérifie que le statut de la réponse est 404 (ressource non trouvée)
        
        // Vérifie que le message d'erreur est présent
        $jsonResponse = $response->json();
        $this->assertArrayHasKey('message', $jsonResponse);
        
        // Vérifie que le message d'erreur est dans un format acceptable
        $this->assertTrue(
            $jsonResponse['message'] === 'Resource not found' || 
            strpos($jsonResponse['message'], 'could not be found') !== false ||
            strpos($jsonResponse['message'], 'No query results') !== false ||  // Message d'erreur de Laravel
            strpos($jsonResponse['message'], 'not found') !== false,           // Message d'erreur plus général
            'Le message d\'erreur n\'a pas le format attendu'
        );
    }

    // Test pour vérifier qu'une authentification est requise pour créer une histoire
    public function test_store_requires_authentication()
    {
        $payload = ['title' => 'My Story', 'description' => 'Desc', 'created_by' => 1]; // Données à envoyer pour créer une histoire

        // Tente de créer une histoire sans authentification et vérifie que la réponse est 401 (non autorisé)
        $this->postJson('/api/v1/stories', $payload)
             ->assertStatus(401); // Statut 401 attendu pour une requête non authentifiée
    }

    // Test pour vérifier que la création d'une histoire fonctionne avec des données valides
    public function test_store_creates_story_with_valid_data()
    {
        $user = User::factory()->create(); // Crée un utilisateur
        $payload = [
            'title'       => 'My Story', // Titre de l'histoire
            'description' => 'Desc', // Description de l'histoire
            'created_by'  => $user->id, // L'ID de l'utilisateur créant l'histoire
        ];

        // Envoie une requête POST pour créer l'histoire avec authentification et vérifie la réponse
        $this->postJson('/api/v1/stories', $payload, $this->authHeaders($user))
             ->assertStatus(201) // Statut 201 pour une création réussie
             ->assertJsonPath('data.title', 'My Story'); // Vérifie que le titre de l'histoire dans la réponse est correct

        // Vérifie que l'histoire a bien été enregistrée dans la base de données
        $this->assertDatabaseHas('stories', ['title' => 'My Story']);
    }

    // Test pour vérifier les erreurs de validation lors de la création d'une histoire
    public function test_store_validation_errors()
    {
        // Envoie une requête POST avec un payload vide, et vérifie que des erreurs de validation sont retournées
        $this->postJson('/api/v1/stories', [], $this->authHeaders())
             ->assertStatus(422) // Statut 422 pour des erreurs de validation
             ->assertJsonValidationErrors(['title']); // Vérifie que le champ 'title' manque et génère une erreur
    }

    // Test pour vérifier qu'une authentification est requise pour mettre à jour une histoire
    public function test_update_requires_authentication()
    {
        $story = Story::factory()->create(); // Crée une histoire

        // Tente de mettre à jour l'histoire sans authentification et vérifie que la réponse est 401 (non autorisé)
        $this->patchJson("/api/v1/stories/{$story->id}", ['title'=>'X'])
             ->assertStatus(401); // Statut 401 attendu
    }

    // Test pour vérifier que la mise à jour d'une histoire fonctionne avec des données valides
    public function test_update_modifies_story()
    {
        $user = User::factory()->create(); // Crée un utilisateur
        $story = Story::factory()->create(['created_by' => $user->id]); // Crée une histoire liée à l'utilisateur
        $payload = ['description' => 'New desc']; // Données à modifier

        // Envoie une requête PATCH pour modifier l'histoire et vérifie la réponse
        $this->patchJson("/api/v1/stories/{$story->id}", $payload, $this->authHeaders($user))
             ->assertStatus(200) // Statut 200 pour une mise à jour réussie
             ->assertJsonPath('data.description', 'New desc'); // Vérifie que la description a bien été mise à jour

        // Vérifie que l'histoire a bien été mise à jour dans la base de données
        $this->assertDatabaseHas('stories', ['id' => $story->id, 'description' => 'New desc']);
    }

    // Test pour vérifier qu'une mise à jour d'une histoire inexistante renvoie une erreur 404
    public function test_update_nonexistent_story_returns_404()
    {
        // Tente de mettre à jour une histoire inexistante et vérifie que la réponse est 404
        $this->patchJson('/api/v1/stories/9999', ['title'=>'X'], $this->authHeaders())
             ->assertStatus(404); // Statut 404 attendu
    }

    // Test pour vérifier qu'une authentification est requise pour supprimer une histoire
    public function test_destroy_requires_authentication()
    {
        $story = Story::factory()->create(); // Crée une histoire

        // Tente de supprimer l'histoire sans authentification et vérifie que la réponse est 401 (non autorisé)
        $this->deleteJson("/api/v1/stories/{$story->id}")
             ->assertStatus(401); // Statut 401 attendu
    }

    // Test pour vérifier que la suppression d'une histoire fonctionne correctement
    public function test_destroy_deletes_story()
    {
        $user = User::factory()->create(); // Crée un utilisateur
        $story = Story::factory()->create(['created_by' => $user->id]); // Crée une histoire liée à cet utilisateur

        // Envoie une requête DELETE pour supprimer l'histoire et vérifie la réponse
        $this->deleteJson("/api/v1/stories/{$story->id}", [], $this->authHeaders($user))
             ->assertStatus(204); // Statut 204 pour une suppression réussie (sans contenu)

        // Vérifie que l'histoire a bien été supprimée de la base de données
        $this->assertDatabaseMissing('stories', ['id' => $story->id]); // Vérifie que l'histoire n'existe plus
    }
}
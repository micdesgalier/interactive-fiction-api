<?php

namespace Tests\Feature;

// Importation des classes nécessaires pour les tests
use Tests\TestCase;
use App\Models\User; // Modèle User, pour la gestion des utilisateurs
use App\Models\Story; // Modèle Story, pour les histoires
use App\Models\Chapter; // Modèle Chapter, pour les chapitres d'une histoire
use App\Models\Choice; // Modèle Choice, pour les choix liés aux chapitres
use Illuminate\Foundation\Testing\RefreshDatabase; // Trait pour réinitialiser la base de données après chaque test

class ChoiceApiTest extends TestCase
{
    // Utilisation du trait RefreshDatabase pour réinitialiser la base de données entre chaque test
    use RefreshDatabase;

    /**
     * Génère un en-tête d'authentification pour l'utilisateur
     * Si aucun utilisateur n'est fourni, un utilisateur par défaut est créé
     */
    protected function authHeaders(User $user = null)
    {
        $user = $user ?? User::factory()->create(); // Crée un utilisateur si aucun n'est fourni
        $token = $user->createToken('test')->plainTextToken; // Création d'un token d'authentification
        return ['Authorization' => "Bearer $token"]; // Retourne l'en-tête avec le token
    }

    /** 
     * Teste la récupération des choix pour un chapitre donné
     * Vérifie que l'API retourne bien tous les choix associés à un chapitre
     */
    public function test_index_returns_choices_for_chapter()
    {
        // Création d'un chapitre fictif
        $chapter = Chapter::factory()->create();
        // Création de 2 choix associés à ce chapitre
        Choice::factory()->count(2)->create(['chapter_id' => $chapter->id]);

        // Envoie d'une requête GET pour récupérer les choix du chapitre
        $this->getJson("/api/v1/chapters/{$chapter->id}/choices")
             ->assertStatus(200) // Vérifie que la réponse a un statut 200 (OK)
             ->assertJsonCount(2, 'data'); // Vérifie que la réponse contient 2 choix
    }

    /** 
     * Teste la récupération d'un choix spécifique
     * Vérifie que l'API retourne un choix en particulier avec son ID
     */
    public function test_show_returns_choice()
    {
        // Création d'un choix fictif
        $choice = Choice::factory()->create();

        // Envoie d'une requête GET pour récupérer ce choix par son ID
        $this->getJson("/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}")
             ->assertStatus(200) // Vérifie que la réponse a un statut 200 (OK)
             ->assertJsonPath('data.id', $choice->id); // Vérifie que l'ID du choix correspond à celui attendu
    }

    /** 
     * Teste la récupération d'un choix inexistant
     * Vérifie que l'API retourne une erreur 404 si le choix n'existe pas
     */
    public function test_show_nonexistent_choice_returns_404()
    {
        // Envoie d'une requête GET pour récupérer un choix inexistant
        $response = $this->getJson('/api/v1/choices/9999');
        
        $response->assertStatus(404); // Vérifie que la réponse a un statut 404 (not found)
        
        // Vérifie que le message d'erreur existe dans la réponse JSON
        $jsonResponse = $response->json();
        $this->assertArrayHasKey('message', $jsonResponse);

        // Vérifie que le message d'erreur correspond au format attendu
        $this->assertTrue(
            $jsonResponse['message'] === 'Resource not found' || 
            strpos($jsonResponse['message'], 'could not be found') !== false,
            'Le message d\'erreur n\'a pas le format attendu'
        );
    }

    /** 
     * Teste la création d'un choix sans authentification
     * Vérifie que l'API retourne une erreur 401 si l'utilisateur n'est pas authentifié
     */
    public function test_store_requires_authentication()
    {
        // Création d'un chapitre fictif
        $chapter = Chapter::factory()->create();
        // Données pour le choix à créer
        $payload = ['chapter_id'=>$chapter->id, 'text'=>'X', 'target_chapter_id'=>null, 'impact'=>1];

        // Envoie d'une requête POST pour créer un choix sans authentification
        $this->postJson("/api/v1/chapters/{$chapter->id}/choices", $payload)
             ->assertStatus(401); // Vérifie que la réponse a un statut 401 (non autorisé)
    }

    /** 
     * Teste la création d'un choix avec des données valides
     * Vérifie que l'API crée un choix et retourne les bonnes données
     */
    public function test_store_creates_choice_with_valid_data()
    {
        // Création d'un utilisateur, d'un chapitre et d'un chapitre cible fictifs
        $user = User::factory()->create();
        $chapter = Chapter::factory()->create();
        $target = Chapter::factory()->create();

        // Données valides pour le choix à créer
        $payload = [
            'chapter_id' => $chapter->id,
            'text' => 'Choice text',
            'target_chapter_id' => $target->id,
            'impact' => 5,
        ];

        // Envoie d'une requête POST pour créer un choix avec authentification
        $this->postJson("/api/v1/chapters/{$chapter->id}/choices", $payload, $this->authHeaders($user))
             ->assertStatus(201) // Vérifie que le choix a été créé avec succès (statut 201)
             ->assertJsonPath('data.text', 'Choice text'); // Vérifie que le texte du choix est correct

        // Vérifie que le choix a bien été ajouté à la base de données
        $this->assertDatabaseHas('choices', ['text' => 'Choice text']);
    }

    /** 
     * Teste les erreurs de validation lors de la création d'un choix
     * Vérifie que l'API retourne des erreurs si des champs nécessaires sont manquants
     */
    public function test_store_validation_errors()
    {
        // Création d'un chapitre fictif
        $chapter = Chapter::factory()->create();

        // Envoie d'une requête POST avec un payload vide (données manquantes : text, impact)
        $this->postJson("/api/v1/chapters/{$chapter->id}/choices", [], $this->authHeaders())
             ->assertStatus(422) // Vérifie que la réponse a un statut 422 (erreurs de validation)
             ->assertJsonValidationErrors(['text', 'impact']); // Vérifie que les erreurs de validation sont présentes pour les champs text et impact
    }

    /** 
     * Teste la mise à jour d'un choix sans authentification
     * Vérifie que l'API retourne une erreur 401 si l'utilisateur n'est pas authentifié
     */
    public function test_update_requires_authentication()
    {
        // Création d'un choix fictif
        $choice = Choice::factory()->create();

        // Envoie d'une requête PATCH pour mettre à jour le choix sans authentification
        $this->patchJson("/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}", ['impact' => 2])
             ->assertStatus(401); // Vérifie que la réponse a un statut 401 (non autorisé)
    }

    /** 
     * Teste la mise à jour d'un choix avec des données valides
     * Vérifie que l'API met à jour un choix et retourne les bonnes données
     */
    public function test_update_modifies_choice()
    {
        // Création d'un utilisateur et d'un choix fictif
        $user = User::factory()->create();
        $choice = Choice::factory()->create();

        // Envoie d'une requête PATCH pour mettre à jour le choix avec de nouvelles données
        $this->patchJson("/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}", ['impact' => 10], $this->authHeaders($user))
             ->assertStatus(200) // Vérifie que la réponse a un statut 200 (OK)
             ->assertJsonPath('data.impact', 10); // Vérifie que l'impact a été mis à jour correctement

        // Vérifie que la base de données a bien été mise à jour
        $this->assertDatabaseHas('choices', ['id' => $choice->id, 'impact' => 10]);
    }

    /** 
     * Teste la mise à jour d'un choix inexistant
     * Vérifie que l'API retourne une erreur 404 si le choix n'existe pas
     */
    public function test_update_nonexistent_choice_returns_404()
    {
        // Envoie d'une requête PATCH pour mettre à jour un choix inexistant
        $this->patchJson('/api/v1/chapters/1/choices/9999', ['impact' => 1], $this->authHeaders())
             ->assertStatus(404); // Vérifie que la réponse a un statut 404 (not found)
    }

    /** 
     * Teste la suppression d'un choix sans authentification
     * Vérifie que l'API retourne une erreur 401 si l'utilisateur n'est pas authentifié
     */
    public function test_destroy_requires_authentication()
    {
        // Création d'un choix fictif
        $choice = Choice::factory()->create();

        // Envoie d'une requête DELETE pour supprimer le choix sans authentification
        $this->deleteJson("/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}")
             ->assertStatus(401); // Vérifie que la réponse a un statut 401 (non autorisé)
    }

    /** 
     * Teste la suppression d'un choix
     * Vérifie que l'API supprime correctement le choix et qu'il est bien retiré de la base de données
    */
    public function test_destroy_deletes_choice()
    {
        // Création d'un utilisateur et d'un choix fictif
        $user   = User::factory()->create();
        $choice = Choice::factory()->create();

        // Envoie d'une requête DELETE pour supprimer le choix avec authentification
        $this->deleteJson(
            "/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}",
            [],
            $this->authHeaders($user)
        )->assertStatus(204); // Vérifie que la suppression a réussi (statut 204)

        // Vérifie que le choix a bien été supprimé de la base de données
        $this->assertDatabaseMissing('choices', ['id' => $choice->id]);
    }
}
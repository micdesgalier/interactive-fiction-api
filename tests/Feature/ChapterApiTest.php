<?php

namespace Tests\Feature;

// Importation des classes nécessaires pour les tests
use Tests\TestCase;
use App\Models\User; // Modèle User, pour la gestion des utilisateurs
use App\Models\Story; // Modèle Story, pour les histoires
use App\Models\Chapter; // Modèle Chapter, pour les chapitres d'une histoire
use Illuminate\Foundation\Testing\RefreshDatabase; // Trait pour réinitialiser la base de données après chaque test

class ChapterApiTest extends TestCase
{
    // Utilisation du trait RefreshDatabase pour réinitialiser la base de données entre chaque test
    use RefreshDatabase;

    /** 
     * Retourne un header Authorization avec un token valide
     * Utilisé pour inclure un token d'authentification dans les requêtes.
     */
    protected function authHeaders()
    {
        // Création d'un utilisateur fictif
        $user  = User::factory()->create();
        // Création d'un token pour cet utilisateur
        $token = $user->createToken('test')->plainTextToken;
        // Retourne l'en-tête Authorization avec le token créé
        return ['Authorization' => "Bearer $token"];
    }

    /** 
     * Teste la récupération des chapitres d'une histoire donnée
     * Vérifie que l'API retourne la bonne liste de chapitres.
     */
    public function test_list_chapters_for_story()
    {
        // Création d'une histoire fictive
        $story = Story::factory()->create();
        // Création de 3 chapitres associés à cette histoire
        Chapter::factory()->count(3)->create(['story_id' => $story->id]);

        // Envoie d'une requête GET pour récupérer les chapitres de l'histoire
        $this->getJson("/api/v1/stories/{$story->id}/chapters")
             ->assertStatus(200) // Vérifie que le statut HTTP est 200 (OK)
             ->assertJsonCount(3, 'data'); // Vérifie qu'il y a bien 3 chapitres dans la réponse
    }

    /** 
     * Teste la création d'un chapitre sans authentification
     * Vérifie que l'API retourne une erreur 401 si l'utilisateur n'est pas authentifié.
     */
    public function test_create_chapter_requires_authentication()
    {
        // Création d'une histoire fictive
        $story = Story::factory()->create();

        // Envoie d'une requête POST pour créer un chapitre, sans authentification
        $this->postJson("/api/v1/stories/{$story->id}/chapters", [])
             ->assertStatus(401); // Vérifie que la réponse a un statut 401 (non autorisé)
    }

    /** 
     * Teste la création d'un chapitre avec des données valides
     * Vérifie que l'API accepte la création d'un chapitre et retourne les bonnes données.
     */
    public function test_create_chapter_with_valid_data()
    {
        // Création d'une histoire fictive
        $story = Story::factory()->create();
        // Données valides pour le nouveau chapitre
        $payload = [
            'story_id' => $story->id,
            'title'    => 'Nouveau Chapitre', // Titre du chapitre
            'content'  => 'Du contenu passionnant...', // Contenu du chapitre
            'order'    => 2, // Ordre du chapitre dans l'histoire
        ];

        // Envoie d'une requête POST pour créer un chapitre avec les données valides et l'authentification
        $this->postJson("/api/v1/stories/{$story->id}/chapters", $payload, $this->authHeaders())
             ->assertStatus(201) // Vérifie que le chapitre a été créé avec succès (statut 201)
             ->assertJsonPath('data.title', 'Nouveau Chapitre'); // Vérifie que le titre du chapitre est correct

        // Vérifie que le chapitre a bien été ajouté à la base de données
        $this->assertDatabaseHas('chapters', ['title' => 'Nouveau Chapitre']);
    }

    /** 
     * Teste les erreurs de validation lors de la création d'un chapitre
     * Vérifie que l'API retourne une erreur de validation lorsque des champs obligatoires sont manquants.
     */
    public function test_validation_errors_on_create()
    {
        // Création d'une histoire fictive
        $story = Story::factory()->create();

        // Envoie d'une requête POST avec un payload vide (données manquantes : title, content, order)
        $this->postJson("/api/v1/stories/{$story->id}/chapters", [], $this->authHeaders())
             ->assertStatus(422) // Vérifie que la réponse a un statut 422 (erreurs de validation)
             ->assertJsonValidationErrors(['title', 'content', 'order']); // Vérifie que les erreurs de validation sont présentes pour les champs title, content et order
    }
}
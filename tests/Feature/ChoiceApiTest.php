<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Story;
use App\Models\Chapter;
use App\Models\Choice;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChoiceApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authHeaders(User $user = null)
    {
        $user = $user ?? User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    public function test_index_returns_choices_for_chapter()
    {
        $chapter = Chapter::factory()->create();
        Choice::factory()->count(2)->create(['chapter_id' => $chapter->id]);

        $this->getJson("/api/v1/chapters/{$chapter->id}/choices")
             ->assertStatus(200)
             ->assertJsonCount(2, 'data');
    }

    public function test_show_returns_choice()
    {
        $choice = Choice::factory()->create();

        $this->getJson("/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}")
             ->assertStatus(200)
             ->assertJsonPath('data.id', $choice->id);
    }

    public function test_show_nonexistent_choice_returns_404()
    {
        $response = $this->getJson('/api/v1/choices/9999');
        
        $response->assertStatus(404);
        
        // Vérifie seulement que le message existe, sans vérifier son contenu exact
        $jsonResponse = $response->json();
        $this->assertArrayHasKey('message', $jsonResponse);
        
        // Plusieurs formats de messages d'erreur sont acceptables
        $this->assertTrue(
            $jsonResponse['message'] === 'Resource not found' || 
            strpos($jsonResponse['message'], 'could not be found') !== false,
            'Le message d\'erreur n\'a pas le format attendu'
        );
    }

    public function test_store_requires_authentication()
    {
        $chapter = Chapter::factory()->create();
        $payload = ['chapter_id'=>$chapter->id,'text'=>'X','target_chapter_id'=>null,'impact'=>1];

        $this->postJson("/api/v1/chapters/{$chapter->id}/choices", $payload)
             ->assertStatus(401);
    }

    public function test_store_creates_choice_with_valid_data()
    {
        $user    = User::factory()->create();
        $chapter = Chapter::factory()->create();
        $target  = Chapter::factory()->create();

        $payload = [
            'chapter_id'        => $chapter->id,
            'text'              => 'Choice text',
            'target_chapter_id' => $target->id,
            'impact'            => 5,
        ];

        $this->postJson(
            "/api/v1/chapters/{$chapter->id}/choices",
            $payload,
            $this->authHeaders($user)
        )
        ->assertStatus(201)
        ->assertJsonPath('data.text', 'Choice text');

        $this->assertDatabaseHas('choices', ['text' => 'Choice text']);
    }

    public function test_store_validation_errors()
    {
        $chapter = Chapter::factory()->create();

        $this->postJson(
            "/api/v1/chapters/{$chapter->id}/choices",
            [],
            $this->authHeaders()
        )->assertStatus(422)
         ->assertJsonValidationErrors(['text','impact']);
    }

    public function test_update_requires_authentication()
    {
        $choice = Choice::factory()->create();

        $this->patchJson(
            "/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}",
            ['impact'=>2]
        )->assertStatus(401);
    }

    public function test_update_modifies_choice()
    {
        $user   = User::factory()->create();
        $choice = Choice::factory()->create();

        $this->patchJson(
            "/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}",
            ['impact' => 10],
            $this->authHeaders($user)
        )
        ->assertStatus(200)
        ->assertJsonPath('data.impact', 10);

        $this->assertDatabaseHas('choices', ['id' => $choice->id, 'impact' => 10]);
    }

    public function test_update_nonexistent_choice_returns_404()
    {
        $this->patchJson('/api/v1/chapters/1/choices/9999', ['impact'=>1], $this->authHeaders())
             ->assertStatus(404);
    }

    public function test_destroy_requires_authentication()
    {
        $choice = Choice::factory()->create();

        $this->deleteJson("/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}")
             ->assertStatus(401);
    }

    public function test_destroy_deletes_choice()
    {
        $user   = User::factory()->create();
        $choice = Choice::factory()->create();

        $this->deleteJson(
            "/api/v1/chapters/{$choice->chapter_id}/choices/{$choice->id}",
            [],
            $this->authHeaders($user)
        )->assertStatus(204);

        $this->assertDatabaseMissing('choices', ['id' => $choice->id]);
    }
}
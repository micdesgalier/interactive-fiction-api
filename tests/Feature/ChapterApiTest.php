<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChapterApiTest extends TestCase
{
    use RefreshDatabase;

    /** Retourne un header Authorization avec token valide */
    protected function authHeaders()
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return ['Authorization' => "Bearer $token"];
    }

    public function test_list_chapters_for_story()
    {
        $story    = Story::factory()->create();
        Chapter::factory()->count(3)->create(['story_id' => $story->id]);

        $this->getJson("/api/v1/stories/{$story->id}/chapters")
             ->assertStatus(200)
             ->assertJsonCount(3, 'data');
    }

    public function test_create_chapter_requires_authentication()
    {
        $story = Story::factory()->create();

        $this->postJson("/api/v1/stories/{$story->id}/chapters", [])
             ->assertStatus(401);
    }

    public function test_create_chapter_with_valid_data()
    {
        $story  = Story::factory()->create();
        $payload = [
            'story_id' => $story->id,
            'title'    => 'Nouveau Chapitre',
            'content'  => 'Du contenu passionnant...',
            'order'    => 2,
        ];

        $this->postJson("/api/v1/stories/{$story->id}/chapters", $payload, $this->authHeaders())
             ->assertStatus(201)
             ->assertJsonPath('data.title', 'Nouveau Chapitre');

        $this->assertDatabaseHas('chapters', ['title' => 'Nouveau Chapitre']);
    }

    public function test_validation_errors_on_create()
    {
        $story = Story::factory()->create();

        // payload vide → title, content, order manquants
        $this->postJson("/api/v1/stories/{$story->id}/chapters", [], $this->authHeaders())
             ->assertStatus(422)
             ->assertJsonValidationErrors(['title','content','order']);
    }
}
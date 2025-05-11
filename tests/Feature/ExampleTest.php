<?php

namespace Tests\Feature;

// Importation de la classe TestCase pour les tests de fonctionnalité
// (La ligne 'use Illuminate\Foundation\Testing\RefreshDatabase;' est commentée, donc non utilisée dans ce cas)
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Un test de base pour vérifier la réponse de l'application.
     * Ce test envoie une requête GET à l'URL principale ("/") et vérifie que la réponse est réussie.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Envoie une requête GET à la route principale de l'application ('/')
        $response = $this->get('/');

        // Vérifie que la réponse a un statut HTTP 200, ce qui indique une réponse réussie
        $response->assertStatus(200);
    }
}
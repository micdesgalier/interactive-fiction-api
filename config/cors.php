<?php

return [
    // Appliquer CORS seulement à tes routes API
    'paths' => ['api/*'],

    // Autoriser toutes les méthodes HTTP
    'allowed_methods' => ['*'],

    // Ton domaine frontend
    'allowed_origins' => [
        'http://localhost:5173',
    ],

    'allowed_origins_patterns' => [],

    // Autoriser tous les en-têtes
    'allowed_headers' => ['*'],

    // Optionnel : exposer l’en-tête Authorization si tu veux le lire côté client
    'exposed_headers' => ['Authorization'],

    'max_age' => 0,

    // Plus de cookies, on n’a plus besoin des credentials
    'supports_credentials' => false,
];
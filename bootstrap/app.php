<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Http\Middleware\HandleCors; 

// Crée et configure une nouvelle instance de l'application Laravel
return Application::configure(basePath: dirname(__DIR__)) // Configure le chemin de base de l'application
    // Configure les routes pour l'application
    ->withRouting(
        web: __DIR__.'/../routes/web.php',    // Fichier des routes web
        api: __DIR__.'/../routes/api.php',    // Fichier des routes API
        commands: __DIR__.'/../routes/console.php',  // Fichier des routes de commande
        health: '/up',  // URL de vérification de la santé de l'application (utile pour les outils de monitoring)
    )
    // Configuration des middleware
    ->withMiddleware(function (Middleware $middleware) {
        // Déclare des alias pour les middleware
        $middleware->alias([
            'stateful' => EnsureFrontendRequestsAreStateful::class, // Middleware pour garantir que les requêtes de l'interface frontend soient traitées comme étatful
            'cors' => HandleCors::class,  // Middleware pour la gestion des CORS (Cross-Origin Resource Sharing)
        ]);

        // Ajoute des middleware supplémentaires au groupe 'api'
        $middleware->appendToGroup('api', [
            'stateful',  // Ajoute le middleware 'stateful' pour les requêtes API
            'cors',  // Ajoute le middleware 'cors' pour les requêtes API
        ]);
    })
    // Gestion des exceptions personnalisées (pour l'instant, il n'y a pas de configuration spécifique)
    ->withExceptions(function (Exceptions $exceptions) {
        // Il est possible d'ajouter des configurations personnalisées pour les exceptions ici
        //
    })
    // Crée et retourne l'instance de l'application Laravel configurée
    ->create();
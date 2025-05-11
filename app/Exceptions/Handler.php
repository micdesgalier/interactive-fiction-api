<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Classe Handler responsable de la gestion centralisée des exceptions de l'application.
 */
class Handler extends ExceptionHandler
{
    /**
     * Liste des exceptions à ne pas enregistrer dans les logs.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // Ajouter ici les exceptions qu'on ne souhaite pas logguer (ex. : ValidationException)
    ];

    /**
     * Liste des champs sensibles à ne pas inclure dans les messages d'erreur de validation.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Méthode d'enregistrement des callbacks d'exception.
     * Utilisée pour ajouter une logique personnalisée pour certaines exceptions.
     */
    public function register(): void
    {
        // Cette méthode peut être utilisée pour enregistrer des gestionnaires personnalisés.
    }

    /**
     * Convertit une exception en une réponse HTTP compréhensible par le client.
     *
     * @param \Illuminate\Http\Request $request La requête HTTP
     * @param \Throwable $e L'exception levée
     * @return \Symfony\Component\HttpFoundation\Response La réponse à retourner
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // Si la requête est destinée à une API (via route ou en-tête)
        if ($request->expectsJson() || $request->is('api/*')) {

            // Si l'erreur concerne une ressource non trouvée (ex: modèle inexistant ou route inconnue)
            if (
                $e instanceof ModelNotFoundException ||
                $e instanceof NotFoundHttpException ||
                ($e instanceof HttpExceptionInterface && $e->getStatusCode() === 404)
            ) {
                return response()->json(
                    ['message' => 'Resource not found'], 
                    404
                );
            }

            // Si l'erreur est due à une validation des données
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors'  => $e->errors(),
                ], 422);
            }

            // Si c'est une autre erreur HTTP (ex: 403, 401, etc.)
            if ($e instanceof HttpExceptionInterface) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'HTTP error',
                ], $e->getStatusCode());
            }

            // Pour toute autre erreur non prévue → erreur serveur
            return response()->json([
                'message' => 'Server Error',
                // En mode debug, on expose le type d'exception pour faciliter le débogage
                'exception' => config('app.debug') ? get_class($e) : null,
            ], 500);
        }

        // Pour les requêtes non-API, utiliser le rendu par défaut de Laravel (HTML)
        return parent::render($request, $e);
    }
}
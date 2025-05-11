<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * Les exceptions à ne pas reporter.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Les champs à ne pas remonter lors d'une ValidationException.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Enregistrement des callbacks d'exception.
     */
    public function register(): void
    {
        // Laissons cette méthode vide
    }

    /**
     * Conversion d'une exception en réponse HTTP.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        // Vérifier si la requête concerne l'API
        if ($request->expectsJson() || $request->is('api/*')) {
            // Gestion des ModelNotFoundException et NotFoundHttpException
            if ($e instanceof ModelNotFoundException || 
                $e instanceof NotFoundHttpException ||
                ($e instanceof HttpExceptionInterface && $e->getStatusCode() === 404)) {
                
                return response()->json(
                    ['message' => 'Resource not found'], 
                    404
                );
            }

            // Gestion des erreurs de validation
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors'  => $e->errors(),
                ], 422);
            }

            // Gestion des autres exceptions HTTP
            if ($e instanceof HttpExceptionInterface) {
                return response()->json([
                    'message' => $e->getMessage() ?: 'HTTP error',
                ], $e->getStatusCode());
            }

            // Autres exceptions inattendues → 500
            return response()->json([
                'message' => 'Server Error',
                'exception' => config('app.debug') ? get_class($e) : null,
            ], 500);
        }

        return parent::render($request, $e);
    }
}
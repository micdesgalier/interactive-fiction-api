<?php
namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        //
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        if ($request->is('api/*')) {
            // Resource not found
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => 'Resource not found'
                ], 404);
            }

            // Validation errors
            if ($e instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors'  => $e->errors(),
                ], 422);
            }

            // Other exceptions: default to exception message and status code
            return response()->json([
                'message' => $e->getMessage(),
            ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
        }

        return parent::render($request, $e);
    }
}
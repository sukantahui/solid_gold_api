<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Str;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'http://localhost/solid_gold/solid_gold_api/public/api/*',
            'api/*'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (NotFoundHttpException $e, $request) {
            // Function to extract model name from exception message
            $extractModelName = function ($exception) {
                $message = $exception->getMessage();
                // Corrected regex with double backslashes
                if (preg_match('/No query results for model \[App\\\\Models\\\\(.+?)\]/', $message, $matches)) {
                    return $matches[1]; // Return model name, e.g., 'Employee'
                }
                return 'Resource'; // Default fallback
            };

            $modelName = $extractModelName($e);
            return response()->json([
                'status' => false,
                'message' => "this {$modelName} not found.",
                'data' => null,
            ], 404);
        });
    })
    ->create();

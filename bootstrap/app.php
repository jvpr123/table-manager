<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;
use Modules\Shared\Exceptions\EntityNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(fn (EntityNotFoundException $e) => response()->json(
            ['message' => $e->getMessage()],
            Response::HTTP_NOT_FOUND
        ));

        $exceptions->render(fn (Exception $e) => response()->json(
            ['message' => $e->getMessage()],
            Response::HTTP_INTERNAL_SERVER_ERROR
        ));
    })->create();

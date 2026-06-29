<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'IsAdmin' => \App\Http\Middleware\IsAdmin::class,
            'IsClient' => \App\Http\Middleware\IsClient::class,
             'IsSupAdmin' => \App\Http\Middleware\IsSupAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (TokenMismatchException $e) {
            $path = request()->is('admin/*') ? '/admin/login' : '/login';

            return redirect($path)->withErrors([
                'session' => 'Session expiree. Veuillez recommencer.',
            ]);
        });
    })->create();

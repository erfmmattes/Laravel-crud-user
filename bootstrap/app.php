<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Se não estiver logado e tentar acessar rota protegida → vai para /
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            return '/';
        });
        // Se logar → sempre vai para /home
        $middleware->redirectUsersTo(function (\Illuminate\Http\Request $request) {
            return '/home';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

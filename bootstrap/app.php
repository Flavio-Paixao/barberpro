<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'webhook/zapi',
        ]);
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('superadmin*')) {
                return route('superadmin.login');
            }
            if ($request->is('painel*')) {
                return route('login');
            }
            return route('filament.admin.auth.login');
        });
        $middleware->web(append: [
            \App\Http\Middleware\TenantMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();

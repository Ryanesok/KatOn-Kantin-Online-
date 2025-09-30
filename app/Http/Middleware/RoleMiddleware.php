<?php

// app/Http/Middleware/RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

// Tambahkan ke bootstrap/app.php di bagian middleware alias:
// ->withMiddleware(function (Middleware $middleware) {
//     $middleware->alias([
//         'role' => \App\Http\Middleware\RoleMiddleware::class,
//     ]);
// })
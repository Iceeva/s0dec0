<?php

// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

// class AuthenticatedSessionController extends Controller
// {
//     /**
//      * Display the login view.
//      */
//     public function create(): View
//     {
//         return view('auth.login');
//     }

//     protected function redirectTo() {
//         if (session('redirect')) {
//             return session('redirect');
//         }
//         return route('welcome');
//     }

//     /**
//      * Handle an incoming authentication request.
//      */
//     public function store(LoginRequest $request)
//     {
//         $request->authenticate();
//     $request->session()->regenerate();
//     dd(Auth::user()->role); // Vérifie le rôle avant redirection
//     if (Auth::user()->role === 'admin') {
//         return redirect('/dashboard/admin');
//     }

//         return redirect('/'); // Redirige les autres utilisateurs vers la racine
//     }

//     /**
//      * Destroy an authenticated session.
//      */
//     public function destroy(Request $request): RedirectResponse
//     {
//         Auth::guard('web')->logout();

//         $request->session()->invalidate();

//         $request->session()->regenerateToken();

//         return redirect('/');
//     }
// }

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    // app/Http/Controllers/Auth/AuthenticatedSessionController.php
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Redirection basée sur le rôle
        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->route('admin');
            case 'agent':
                return redirect()->route('agent');
            case 'buyer':
                return redirect()->route('home');
            default:
                return redirect()->route('home');
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

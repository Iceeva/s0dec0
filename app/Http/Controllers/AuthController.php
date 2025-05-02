<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{   /**
    * @var \App\Models\User
    */
   protected $user;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
  {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

         /** @var \App\Models\User $user */
         $user = Auth::user();

         if ($user->is_admin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isAgent()) {
            return redirect()->route('generate.qr_code');
        }

        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Identifiants invalides',
    ]);
  }

    public function login(Request $request)
  {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->is_admin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isAgent()) {
            return redirect()->route('generate.qr_code');
        }
        
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
  }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
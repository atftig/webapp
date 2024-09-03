<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Login;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     // Ottieni i dati dalla richiesta
    //     $name = $request->input('name');
    //     $password = $request->input('password');

    //     // Cerca l'utente nel database utilizzando il nome fornito
    //     $user = Login::where('name', $name)->first();

    //     if ($user && $user->password === $password) {
    //         // Autenticazione riuscita
    //         // Rigenera la sessione per motivi di sicurezza
    //         $request->session()->regenerate();

    //         // Reindirizza alla homepage
    //         return redirect()->to(route("homepage"));
    //     } else {
    //         // Autenticazione fallita
    //         return redirect()->back()->withErrors(['login' => 'Nome utente o password errati.'])
    //             ->onlyInput('name');
    //     }
    // }



    public function store(LoginRequest $request): RedirectResponse
    {
        return redirect()->to(route("homepage"));
    // $request->authenticate();

    // $request->session()->regenerate();

    // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

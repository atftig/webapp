<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()    //create() mostra la vista di login
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */


    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     // Ottiene i dati dalla richiesta
    //     $name = $request->input('name');
    //     $password = $request->input('password');

    //     // Cerca l'utente nel database utilizzando il nome fornito
    //     $user = User::where('name', $name)->first();

    //     if ($user && $user->password === $password) {
    //         // Autenticazione riuscita
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
    {        //store() gestisce la richiesta di autenticazione
        // Ottiene i dati dalla richiesta
        $name = trim($request->input('name'));
        $password = trim($request->input('password'));

        // Cerca l'utente nel database utilizzando il nome fornito
        $user = User::where('name', $name)->first();
        $userP = User::where('password', $password)->first();


        // Reindirizza in base al ruolo dell'utente
        // Salva i dati nella sessione
        session(['id_user' => $name]);

        if (is_null($user)) {
            return redirect()->to(route('error-page'));
        }

        if (is_null($userP)) {
            return redirect()->to(route('error-page'));
        }

        if ($user->ruolo === 'buyer') {
            return redirect()->to(route('homepage')); // Reindirizza alla pagina per gli utenti buyer
        } elseif ($user->ruolo === 'ispettore') {
            return redirect()->to(route('pv-page')); // Reindirizza alla homepage per gli ispettori
        }
    }


    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     return redirect()->to(route("homepage"));
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }

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
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Gebruiker;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Gebruikersnaam' => ['required', 'string', 'max:255', 'unique:Gebruiker,Gebruikersnaam'],
            'Wachtwoord' => ['required', 'confirmed', Rules\Password::defaults()],
            'Email'=> ['required', 'string','max:255'],
        ]);

        $user = Gebruiker::create([
            'Gebruikersnaam' => $request->Gebruikersnaam,
            'Wachtwoord' => Hash::make($request->Wachtwoord),
            'RolNaam' => 'Passagier',
            'Email' => $request->Email,
            'Isactief' => true,
            'Ingelogd' => now(),
            'Uitgelogd' => null,
            'Datumaangemaakt' => now(),
            'Datumgewijzigd' => null,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('welcome', absolute: false));
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule; // <-- PENTING: Import Rule
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // TAMBAHKAN VALIDASI UNTUK ROLE DI SINI
            'role' => ['required', Rule::in(['customer', 'mitra'])],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // SIMPAN ROLE YANG DIPILIH DARI REQUEST
            'role' => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Nanti kita bisa arahkan mitra ke halaman pembuatan profil
        if ($user->role === 'mitra') {
             // return redirect()->route('mitra.profile.create'); // Contoh redirect ke depan
        }

        return redirect(route('dashboard', absolute: false));
    }
}

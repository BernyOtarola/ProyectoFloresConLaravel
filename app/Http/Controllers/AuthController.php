<?php

namespace App\Http\Controllers;

use App\Models\Suscriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Login ────────────────────────────────────────────

    public function loginForm()
    {
        if (Auth::guard('admin')->check()) return redirect()->route('admin.dashboard');
        if (Auth::guard('web')->check())   return redirect()->route('home');

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $email    = strtolower(trim($request->input('email')));
        $password = $request->input('password');

        // 1️⃣ ¿Es administradora?
        // attempt() verifica contra password_hash (getAuthPasswordName),
        // regenera la sesión automáticamente → protección contra session fixation
        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // 2️⃣ ¿Es suscriptora con cuenta activa?
        // El campo 'activo' => 1 se agrega como WHERE adicional al query
        if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password, 'activo' => 1])) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()
            ->withInput(['email' => $email])
            ->withErrors(['email' => 'Correo o contraseña incorrectos.']);
    }

    // ── Registro ─────────────────────────────────────────

    public function registroForm()
    {
        if (Auth::guard('web')->check()) return redirect()->route('home');

        return view('auth.registro');
    }

    public function registro(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email|max:150',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $email = strtolower(trim($request->input('email')));
        $hash  = Hash::make($request->input('password'));

        $existente = Suscriptor::where('email', $email)->first();

        if ($existente) {
            if ($existente->password_hash) {
                return back()->withErrors([
                    'email' => 'Ese correo ya tiene cuenta. Iniciá sesión.'
                ]);
            }
            // Suscriptora sin contraseña → activar cuenta
            $existente->update(['password_hash' => $hash]);
            $user = $existente;
        } else {
            $user = Suscriptor::create([
                'nombre'        => trim($request->input('nombre')),
                'email'         => $email,
                'password_hash' => $hash,
                'activo'        => true,
            ]);
        }

        // Login automático + regeneración de sesión
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', '¡Bienvenida, ' . $user->nombre . '! 🌺');
    }

    // ── Logout ───────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
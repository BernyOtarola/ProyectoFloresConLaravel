<?php

namespace App\Http\Controllers;

use App\Models\Suscriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ══════════════════════════════════════════════════════
    // ADMIN
    // ══════════════════════════════════════════════════════

    public function loginForm()
    {
        // Si ya está logueado redirigir directo
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login-admin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email'         => $request->input('email'),
            'password'      => $request->input('password'),
            // Auth usará getAuthPasswordName() → 'password_hash' automáticamente
        ];

        if (Auth::guard('admin')->attempt($credentials)) {
            // Protección contra session fixation
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withInput(['email' => $request->input('email')])
            ->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.admin');
    }

    // ══════════════════════════════════════════════════════
    // CLIENTE (suscriptor con cuenta)
    // ══════════════════════════════════════════════════════

    public function registroForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }
        return view('auth.registro');
    }

    public function registro(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'email'    => 'required|email|unique:suscriptores,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $suscriptor = Suscriptor::create([
            'nombre'        => trim($request->input('nombre')),
            'email'         => strtolower(trim($request->input('email'))),
            'password_hash' => Hash::make($request->input('password')),
            'activo'        => true,
        ]);

        // Login automático tras registro
        Auth::guard('web')->login($suscriptor);
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', '¡Bienvenida, ' . $suscriptor->nombre . '! Tu cuenta fue creada exitosamente.');
    }

    public function loginClienteForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }
        return view('auth.login-cliente');
    }

    public function loginCliente(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt([
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()
            ->withInput(['email' => $request->input('email')])
            ->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Suscriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Login ────────────────────────────────────────────────

    public function loginForm()
    {
        // Si ya tiene sesión activa, redirigir
        if (session('admin_id'))  return redirect()->route('admin.dashboard');
        if (session('user_id'))   return redirect()->route('home');

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

        // 1️⃣ ¿Es administrador?
        $admin = Admin::where('email', $email)->first();
        if ($admin && Hash::check($password, $admin->password_hash)) {
            session([
                'admin_id'     => $admin->id,
                'admin_email'  => $admin->email,
                'admin_nombre' => $admin->nombre,
            ]);
            return redirect()->route('admin.dashboard');
        }

        // 2️⃣ ¿Es suscriptor con cuenta?
        $user = Suscriptor::where('email', $email)->where('activo', true)->first();
        if ($user && $user->password_hash && Hash::check($password, $user->password_hash)) {
            session([
                'user_id'     => $user->id,
                'user_nombre' => $user->nombre,
                'user_email'  => $user->email,
            ]);
            return redirect()->route('home');
        }

        return back()
            ->withInput(['email' => $email])
            ->withErrors(['email' => 'Correo o contraseña incorrectos.']);
    }

    // ── Registro ─────────────────────────────────────────────

    public function registroForm()
    {
        if (session('user_id')) return redirect()->route('home');

        return view('auth.registro');
    }

    public function registro(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'email'     => 'required|email|max:150',
            'password'  => 'required|string|min:6|confirmed',
            // 'password_confirmation' se valida automáticamente con |confirmed
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
            // Suscriptor sin contraseña → activar cuenta
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

        // Loguearlo automáticamente
        session([
            'user_id'     => $user->id,
            'user_nombre' => $user->nombre,
            'user_email'  => $user->email,
        ]);

        return redirect()->route('home')
            ->with('success', '¡Bienvenida, ' . $user->nombre . '! 🌺');
    }

    // ── Logout ───────────────────────────────────────────────

    public function logout()
    {
        session()->forget(['user_id', 'user_nombre', 'user_email']);
        return redirect()->route('home');
    }

    public function logoutAdmin()
    {
        session()->forget(['admin_id', 'admin_email', 'admin_nombre']);
        return redirect()->route('home');
    }
}

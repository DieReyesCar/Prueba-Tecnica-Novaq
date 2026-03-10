<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesar el login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->withInput();
    }

    // Mostrar formulario de recuperación
    public function showRecover()
    {
        return view('auth.recover');
    }

    // Procesar recuperación de contraseña
    public function recover(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    // Verificar si el email existe en la base de datos
    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'No encontramos una cuenta con ese correo.']);
    }
 
    // Generar el token manualmente sin enviar correo
    $token = app('auth.password.broker')->createToken($user);

    $resetUrl = url(route('password.reset', [
        'token' => $token,
        'email' => $request->email,
    ], false));

    return back()->with([
        'status'    => 'Enlace de recuperación generado exitosamente.',
        'reset_url' => $resetUrl,
    ]);
}

    // Mostrar formulario de nueva contraseña
    public function showReset(string $token)
    {
        return view('auth.reset', ['token' => $token]);
    }

    // Procesar nueva contraseña
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Dashboard
    public function dashboard()
    {
        return view('dashboard');
    }
}
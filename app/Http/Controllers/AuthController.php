<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $data = $request->validate([
        'email'    => ['required','email'],
        'password' => ['required'],
    ]);

    // Cari user berdasarkan email
    $user = User::where('email', $data['email'])->first();
    if (! $user) {
        return back()->withErrors(['email' => 'Email tidak terdaftar.'])->onlyInput('email');
    }

    // Cocokkan hash password
    if (! Hash::check($data['password'], $user->password)) {
        return back()->withErrors(['email' => 'Kredensial tidak valid.'])->onlyInput('email');
    }

    // Login eksplisit + remember
    Auth::login($user, $request->boolean('remember'));
    $request->session()->regenerate();

    // Redirect sesuai role
    return match ($user->role) {
        'admin'     => redirect()->intended('/admin/dashboard'),
        'guru_wali' => redirect()->intended('/guru/dashboard'),
        default     => redirect()->intended('/dashboard'),
    };
}



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

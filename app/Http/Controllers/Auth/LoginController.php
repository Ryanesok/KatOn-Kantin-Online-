<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        // Hanya tamu yang bisa mengakses halaman login
        $this->middleware('guest')->except('logout');
    }

    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah login menggunakan email atau NIM
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        // Coba lakukan autentikasi
        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Arahkan berdasarkan role
            if ($user->role == 'admin_kantin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role == 'pembeli') {
                return redirect()->intended('/menu');
            }
        }

        // Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'login' => 'NIM/Email atau Password salah.',
        ])->onlyInput('login');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
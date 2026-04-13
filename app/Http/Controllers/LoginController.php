<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        // login dengan guard 'web' (tabel users)
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::user();
            if ($user->validasi == "Menunggu") {
                Auth::guard('web')->logout();
                return back()->with('validasi_menunggu', 'Akun Anda belum divalidasi oleh admin');
            }
            if ($user->validasi == "Ditolak") { 
                Auth::guard('web')->logout();
                return back()->with('validasi_ditolak', 'Akun Anda Ditolak oleh admin.');
            }
    
            switch ($user->role) {
                case 'Admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!');
                case 'Pengguna Utama':
                    return redirect()->route('pengguna_utama.dashboard')->with('success', 'Selamat datang Pengguna Utama!');
                default:
                    return redirect()->route('home')->with('success', 'Login berhasil!');
            }
        }

        // login dengan guard (tabel anggota)
        if (Auth::guard('web2')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('pengguna.dashboard')->with('success', 'Selamat datang Anggota!');
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
    
        if (Auth::guard('web2')->check()) {
            Auth::guard('web2')->logout();
        }
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}
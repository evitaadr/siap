<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login pengguna dengan validasi status aktif
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // kondisi untuk memeriksa status aktif pada proses autentikasi
        $credentials["status"] = 'aktif';

        // Cek kredensial dan status aktif
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect ke dashboard superadmin jika pengguna memiliki peran superadmin
        if ($user->hasRole('superadmin')) {
            return redirect()->intended(route('superadmin.dashboard'));
        }

        // Redirect ke dashboard admin jika pengguna memiliki peran admin
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Redirect ke dashboard karyawan jika pengguna memiliki peran karyawan
        if ($user->hasRole('karyawan')) {
            return redirect()->intended(route('karyawan.dashboard'));
        }

        // Jika pengguna tidak memiliki peran yang sesuai, logout dan tampilkan pesan error
        Auth::logout();
        return back()->withErrors([
            'username' => 'Username anda belum terdaftar.',
        ]);
    }

        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }

}

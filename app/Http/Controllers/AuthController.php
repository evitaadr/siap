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

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Tambahkan kondisi untuk memeriksa status aktif pada proses autentikasi
        $credentials["status"] = 'aktif';

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            return redirect()->intended(route('superadmin.dashboard'));
        }

        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->hasRole('karyawan')) {
            return redirect()->intended(route('karyawan.dashboard'));
        }

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

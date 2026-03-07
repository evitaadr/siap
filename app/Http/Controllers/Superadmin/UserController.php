<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{

    public function daftarPengguna()
    {
        $users = User::with('roles')->paginate(5);
        return view('layouts.superadmin.pengguna.data_pengguna', compact('users'));
    }

    public function tambahPengguna()
    {
        $roles = Role::whereNotIn('nama', ['superadmin'])->get(); // Ambil semua role kecuali superadmin
        return view('layouts.superadmin.pengguna.tambah', compact('roles'));
    }

    public function simpanPengguna(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'username' => 'required|string|max:20|unique:users,username',
            'divisi' => 'required|in:HRGA,FINANCE,CRO&LEGAL,MARKETING,TEKNISI,NOC,LOGISTIC&PROJECT',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['username'] . '123'), // Set password default sebagai username + "123"
            'divisi' => $validatedData['divisi'],
            'status' => 'aktif',
        ]);

        if ($request->filled('roles')) {
            $user->roles()->sync($request['roles']);
        }

        Alert::success('Sukses', 'Data pengguna berhasil ditambahkan.');
        return redirect()->route('superadmin.daftarPengguna');
    }

    public function editPengguna($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::whereNotIn('nama', ['superadmin'])->get(); // Ambil semua role kecuali superadmin
        return view('layouts.superadmin.pengguna.edit', compact('user', 'roles'));
    }

    public function updatePengguna(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'username' => 'required|string|max:20|unique:users,username,' . $id,
            'divisi' => 'required|in:HRGA,FINANCE,CRO&LEGAL,MARKETING,TEKNISI,NOC,LOGISTIC&PROJECT',
            'status' => 'required|in:aktif,resign',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'nama_lengkap' => $validatedData['nama_lengkap'],
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'divisi' => $validatedData['divisi'],
            'status' => $validatedData['status'],
        ]);

        if ($request->filled('roles')) {
            $user->roles()->sync($request['roles']);
        } else {
            $user->roles()->detach();
        }

        Alert::success('Sukses', 'Data pengguna berhasil diperbarui.');
        return redirect()->route('superadmin.daftarPengguna');
    }

    public function lihatPengguna($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('layouts.superadmin.pengguna.lihat', compact('user'));
    }
}

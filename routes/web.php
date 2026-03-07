<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Superadmin\UserController as SuperadminUserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('layouts.superadmin.dashboard');
        })->name('dashboard');

        Route::get('/daftar-pengguna', [SuperadminUserController::class, 'daftarPengguna'])->name('daftarPengguna');
        Route::get('/tambah-pengguna', [SuperadminUserController::class, 'tambahPengguna'])->name('tambahPengguna');
        Route::post('/simpan-pengguna', [SuperadminUserController::class, 'simpanPengguna'])->name('simpanPengguna');

        Route::get('/edit-pengguna/{id}', [SuperadminUserController::class, 'editPengguna'])->name('editPengguna');
        Route::put('/update-pengguna/{id}', [SuperadminUserController::class, 'updatePengguna'])->name('updatePengguna');
        Route::get('/lihat-pengguna/{id}', [SuperadminUserController::class, 'lihatPengguna'])->name('lihatPengguna');

        Route::get('/riwayat_presensi', function () {
            return view('layouts.superadmin.presensi.riwayat_presensi');
        })->name('riwayat_presensi');

        Route::post('/absen-masuk', [App\Http\Controllers\Superadmin\PresensiController::class, 'absenMasuk'])->name('absenMasuk');
        Route::post('/absen-pulang', [App\Http\Controllers\Superadmin\PresensiController::class, 'absenPulang'])->name('absenPulang');

        Route::get('/verifikasi_perizinan', [App\Http\Controllers\Superadmin\PerizinanController::class, 'verifikasiPerizinan'])->name('verifikasi_perizinan');
        Route::get('/get-verifikasi-by-id/{id}', [App\Http\Controllers\Superadmin\PerizinanController::class, 'getVerifikasiById'])->name('getVerifikasiById');
        Route::post('/verifikasi-perizinan/{id}', [App\Http\Controllers\Superadmin\PerizinanController::class, 'updateVerifikasiPerizinan'])->name('updateVerifikasiPerizinan');


    });

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('layouts.admin.dashboard');
        })->name('dashboard');

        Route::get('/presensi', [App\Http\Controllers\Admin\PresensiController::class, 'riwayatPresensi'])->name('presensi');
        Route::post('/absen-masuk', [App\Http\Controllers\Admin\PresensiController::class, 'absenMasuk'])->name('absenMasuk');
        Route::post('/absen-pulang', [App\Http\Controllers\Admin\PresensiController::class, 'absenPulang'])->name('absenPulang');

        Route::get('daftar-perizinan', [App\Http\Controllers\Admin\PerizinanController::class, 'daftarPerizinan'])->name('daftarPerizinan');
        Route::get('tambah-perizinan', [App\Http\Controllers\Admin\PerizinanController::class, 'tambahPerizinan'])->name('tambahPerizinan');
        Route::post('simpan-perizinan', [App\Http\Controllers\Admin\PerizinanController::class, 'simpanPerizinan'])->name('simpanPerizinan');





        Route::get('/verifikasi_perizinan', [App\Http\Controllers\Admin\PerizinanController::class, 'daftarVerifikasiPerizinan'])->name('daftarVerifikasiPerizinan');

        Route::get('/get-verifikasi-by-id/{id}', [App\Http\Controllers\Admin\PerizinanController::class, 'getVerifikasiById'])->name('getVerifikasiById');

        Route::post('verifikasi-perizinan/{id}', [App\Http\Controllers\Admin\PerizinanController::class, 'updateVerifikasiPerizinan'])->name('updateVerifikasiPerizinan');
    });

Route::middleware(['auth', 'role:karyawan'])
    ->prefix('karyawan')
    ->name('karyawan.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('layouts.karyawan.dashboard');
        })->name('dashboard');

        Route::get('/presensi', [App\Http\Controllers\Karyawan\PresensiController::class, 'riwayatPresensi'])->name('presensi');
        Route::post('/absen-masuk', [App\Http\Controllers\Karyawan\PresensiController::class, 'absenMasuk'])->name('absenMasuk');
        Route::post('/absen-pulang', [App\Http\Controllers\Karyawan\PresensiController::class, 'absenPulang'])->name('absenPulang');

        Route::get('daftar-perizinan', [App\Http\Controllers\Karyawan\PerizinanController::class, 'daftarPerizinan'])->name('daftarPerizinan');
        Route::get('tambah-perizinan', [App\Http\Controllers\Karyawan\PerizinanController::class, 'tambahPerizinan'])->name('tambahPerizinan');
        Route::post('simpan-perizinan', [App\Http\Controllers\Karyawan\PerizinanController::class, 'simpanPerizinan'])->name('simpanPerizinan');
    });

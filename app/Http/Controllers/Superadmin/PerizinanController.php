<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perizinan;
use App\Models\VerifikasiPerizinan;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;

class PerizinanController extends Controller
{
    public function verifikasiPerizinan()
{
    // Pending untuk superadmin
    // admin sudah verifikasi tapi superadmin belum
    $perizinanPending = Perizinan::with(['user','verifikasi'])
        ->whereHas('verifikasi', function ($p) {
            $p->whereNotNull('admin_verified_at') // Sudah diverifikasi admin
              ->whereNull('superadmin_verified_at'); // Belum diverifikasi superadmin
        })
        ->where('status', '!=', 'ditolak') // Hanya tampilkan yang tidak ditolak
        ->orderBy('created_at','desc')
        ->paginate(10);


    // Riwayat verifikasi superadmin
    $perizinanRiwayat = Perizinan::with(['user','verifikasi'])
        ->whereHas('verifikasi', function ($q) {
            $q->whereNotNull('superadmin_verified_at');
        })
        ->orderBy('created_at','desc')
        ->paginate(10);

    return view('layouts.superadmin.perizinan.verifikasi_perizinan',
        compact('perizinanPending','perizinanRiwayat'));
}

    public function updateVerifikasiPerizinan(Request $request, $id)
    {
        $verifikasi = VerifikasiPerizinan::where('perizinan_id', $id)->firstOrFail();

        // Cek apakah admin sudah memverifikasi
        if (!$verifikasi->admin_verified_at) {
            Alert::warning('Peringatan', 'Kepala divisi belum memverifikasi perizinan ini.');
            return redirect()->route('superadmin.verifikasi_perizinan');
        }

        $perizinan = Perizinan::findOrFail($id);

        // Simpan verifikasi superadmin
        $verifikasi->status_superadmin = $request->status;
        $verifikasi->catatan_superadmin = $request->catatan;
        $verifikasi->superadmin_id = auth()->id();
        $verifikasi->superadmin_verified_at = now();
        $verifikasi->save();

        if ($request->status == 'disetujui' && $perizinan->status != 'disetujui') {
            $perizinan->status = 'disetujui';
            $perizinan->save();

            // kurangi token cuti jika jenisnya CUTI
        // if ($perizinan->jenis_perizinan != 'Sakit') {
        if (strtolower(trim($perizinan->jenis_perizinan)) != 'sakit') {

            // $user = User::find($perizinan->user_id);
            $user = \App\Models\User::find($perizinan->user_id);

            $jumlahHari = Carbon::parse($perizinan->tanggal_mulai)
                ->diffInDays(Carbon::parse($perizinan->tanggal_selesai)) + 1; // Tambahkan 1 untuk menghitung hari pertama

            if ($user->token_cuti >= $jumlahHari) {
                $user->decrement('token_cuti', $jumlahHari);
            } else {
                Alert::warning('Peringatan', 'Token cuti tidak mencukupi untuk perizinan ini.');
                return redirect()->back();
            }

            // $jumlahHari = \Carbon\Carbon::parse($perizinan->tanggal_mulai)
            //     ->diffInDays(\Carbon\Carbon::parse($perizinan->tanggal_selesai)) + 1; // Tambahkan 1 untuk menghitung hari pertama

            // dd('jumlahHari: '.$jumlahHari, 'user token cuti sebelum: '.$user->token_cuti);

            // User::where('id', $perizinan->user_id)->decrement('token_cuti', $jumlahHari);
            // $user->decrement('token_cuti', $jumlahHari);
            }

        } else {
            $perizinan->status = 'ditolak';
            $perizinan->save();
        }

        Alert::success('Sukses', 'Status perizinan berhasil diperbarui.');
        return redirect()->route('superadmin.verifikasi_perizinan');
    }

    public function getVerifikasiById($id)
    {
        $perizinan = Perizinan::with('user')->findOrFail($id);

        return response()->json([ 'perizinan' => $perizinan, 'user' => $perizinan->user ]);
    }
}

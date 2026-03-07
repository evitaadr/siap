<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perizinan;
use App\Models\VerifikasiPerizinan;
use RealRashid\SweetAlert\Facades\Alert;

class PerizinanController extends Controller
{
    public function verifikasiPerizinan()
{
    // Pending untuk superadmin
    // admin sudah verifikasi tapi superadmin belum
    $perizinanPending = Perizinan::with(['user','verifikasi'])
        ->whereHas('verifikasi', function ($p) {
            $p->whereNotNull('admin_verified_at')
              ->whereNull('superadmin_verified_at');
        })
        ->where('status', '!=', 'ditolak')
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
            Alert::warning('Peringatan', 'Admin belum memverifikasi perizinan ini.');
            return redirect()->route('superadmin.verifikasi_perizinan');
        }

        // Simpan verifikasi superadmin
        $verifikasi->status_superadmin = $request->status;
        $verifikasi->catatan_superadmin = $request->catatan;
        $verifikasi->superadmin_id = auth()->id();
        $verifikasi->superadmin_verified_at = now();
        $verifikasi->save();

        // Update status di tabel perizinans
        $perizinan = Perizinan::findOrFail($id);

        if ($request->status == 'disetujui') {
            $perizinan->status = 'disetujui';
        } else {
            $perizinan->status = 'ditolak';
        }

        $perizinan->save();

        Alert::success('Sukses', 'Status perizinan berhasil diperbarui.');

        return redirect()->route('superadmin.verifikasi_perizinan');
    }

    public function getVerifikasiById($id)
    {
        $perizinan = Perizinan::with('user')->findOrFail($id);

        return response()->json([ 'perizinan' => $perizinan, 'user' => $perizinan->user ]);
    }
}

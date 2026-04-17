<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perizinan;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\VerifikasiPerizinan;

class PerizinanController extends Controller
{
    public function daftarPerizinan()
    {
        $perizinan = Perizinan::with('verifikasi')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(10);
        return view('layouts.admin.perizinan.daftar', compact('perizinan'));
    }

    public function tambahPerizinan()
    {
        $userTokenCuti = auth()->user()->token_cuti;

        $jenisPerizinan = ['Cuti', 'Sakit', 'Izin', 'lainnya'];
        return view('layouts.admin.perizinan.tambah', compact('userTokenCuti', 'jenisPerizinan'));
    }

    public function simpanPerizinan(Request $request)
    {

        $validatedData = $request->validate([
            'jenis_perizinan' => 'required|in:Cuti,Sakit,Izin,lainnya',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'bukti_file' => 'nullable|file|mimes:jpg,png|max:3072',
        ]);


        if ($validatedData['jenis_perizinan'] === 'Cuti' && auth()->user()->token_cuti <= 0) {
            return back()->withErrors([
                'jenis_perizinan' => 'Anda tidak memiliki token cuti yang cukup.'
            ]);
        }

        // Handle upload file
        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('perizinan_files', $filename, 'public');

            $validatedData['bukti_file'] = $filename;
        }

        $validatedData['user_id'] = auth()->id();
        $validatedData['status'] = 'pending';

        Perizinan::create($validatedData);

        Alert::success('Sukses', 'Data perizinan berhasil diajukan.');
        return redirect()->route('admin.daftarPerizinan');
    }


    public function daftarVerifikasiPerizinan()
    {;
        $perizinanPending = Perizinan::whereHas('verifikasi', function ($q) {
            $q->whereNull('admin_verified_at');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $perizinanRiwayat = Perizinan::whereIn('status', ['disetujui', 'ditolak'])->orderBy('created_at', 'desc')->paginate(10);

        return view('layouts.admin.perizinan.verifikasi_perizinan', compact('perizinanPending', 'perizinanRiwayat'));
    }


    public function updateVerifikasiPerizinan(Request $request, $id)
    {
        $verifikasi = VerifikasiPerizinan::where('perizinan_id', $id)->firstOrFail();

        $verifikasi->status_admin = $request->status;
        $verifikasi->catatan_admin = $request->catatan; // Menyimpan catatan admin
        $verifikasi->admin_id = auth()->id(); // Menyimpan ID admin yang memverifikasi
        $verifikasi->admin_verified_at = now(); // Menyimpan waktu verifikasi
        $verifikasi->save();

          // Update status di tabel perizinans
        $perizinan = Perizinan::findOrFail($id);

        if ($request->status == 'ditolak') {
            $perizinan->status = 'ditolak';
        } else if ($request->status == 'disetujui') {
            $perizinan->status = 'disetujui';
        }

        $perizinan->save();

        Alert::success('Sukses', 'Status perizinan berhasil diperbarui.');
        return redirect()->route('admin.daftarVerifikasiPerizinan');
    }

    public function getVerifikasiById($id)
    {
        $perizinan = Perizinan::with('user')->findOrFail($id);

        return response()->json([ 'perizinan' => $perizinan, 'user' => $perizinan->user ]);
    }
}

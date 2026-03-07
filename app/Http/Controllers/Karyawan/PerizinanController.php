<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perizinan;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\VerifikasiPerizinan;

class PerizinanController extends Controller
{
    public function daftarPerizinan()
    {
        $perizinan = Perizinan::where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(10);

        return view('layouts.karyawan.perizinan.daftar', compact('perizinan'));
    }

    public function tambahPerizinan()
    {
        $userTokenCuti = auth()->user()->token_cuti;

        $jenisPerizinan = ['Cuti', 'Sakit', 'Izin', 'lainnya'];
        return view('layouts.karyawan.perizinan.tambah', compact('userTokenCuti', 'jenisPerizinan'));
    }

    public function simpanPerizinan(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_perizinan' => 'required|in:Cuti,Sakit,Izin,lainnya',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'bukti_file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
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

        // Simpan data perizinan
        $perizinan = Perizinan::create($validatedData);

        // Simpan data verifikasi perizinan
        VerifikasiPerizinan::create([
            'perizinan_id' => $perizinan->id,
            'status_admin' => 'pending',
            'status_superadmin' => 'pending',
        ]);

        Alert::success('Sukses', 'Data perizinan berhasil diajukan.');
        return redirect()->route('karyawan.daftarPerizinan');
    }
}

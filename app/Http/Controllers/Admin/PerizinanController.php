<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perizinan;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\VerifikasiPerizinan;

class PerizinanController extends Controller
{
    // Menampilkan daftar perizinan yang diajukan oleh kepala divisi
    public function daftarPerizinan()
    {
        // Ambil perizinan yang diajukan oleh kepala divisi yang sedang login
        $perizinan = Perizinan::with('verifikasi')->where('user_id', auth()->id())->orderBy('created_at', 'desc')->paginate(10);
        return view('layouts.admin.perizinan.daftar', compact('perizinan'));
    }

    // Menampilkan form untuk mengajukan perizinan baru
    public function tambahPerizinan()
    {
        $userTokenCuti = auth()->user()->token_cuti; // Ambil token cuti dari user yang sedang login

        $jenisPerizinan = ['Cuti', 'Sakit', 'Izin', 'lainnya'];
        return view('layouts.admin.perizinan.tambah', compact('userTokenCuti', 'jenisPerizinan')); // Kirim data token cuti dan jenis perizinan ke view
    }

    // Menyimpan data perizinan yang diajukan oleh kepala divisi
    public function simpanPerizinan(Request $request)
    {
        // Validasi input dari form perizinan
        $validatedData = $request->validate([
            'jenis_perizinan' => 'required|in:Cuti,Sakit,Izin,lainnya',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'bukti_file' => 'nullable|file|mimes:jpg,png|max:2048',
        ]);

        // Cek jika jenis perizinan adalah 'Cuti' dan token cuti tidak mencukupi
        if ($validatedData['jenis_perizinan'] === 'Cuti' && auth()->user()->token_cuti <= 0) {
            return back()->withErrors([
                'jenis_perizinan' => 'Anda tidak memiliki token cuti yang cukup.'
            ]);
        }

        // Handle upload file jika ada
        if ($request->hasFile('bukti_file')) {
            $file = $request->file('bukti_file');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('perizinan_files', $filename, 'public');

            $validatedData['bukti_file'] = $filename;
        }

        // Tambahkan user_id dan status ke data yang akan disimpan
        $validatedData['user_id'] = auth()->id();
        $validatedData['status'] = 'pending';

        // Simpan data perizinan ke database
        $perizinan = Perizinan::create($validatedData);

        $user = auth()->user(); // Ambil data user yang sedang login

        // Simpan data verifikasi perizinan dengan status admin disetujui
        VerifikasiPerizinan::create([
            'perizinan_id' => $perizinan->id,
            'status_admin' => 'disetujui',
            'admin_verified_at' => now(),
            'admin_id' => $user->id,
            'status_superadmin' => 'pending',
        ]);

        Alert::success('Sukses', 'Data perizinan berhasil diajukan.');
        return redirect()->route('admin.daftarPerizinan');
    }

    // Menampilkan daftar perizinan yang diajukan oleh karyawan untuk diverifikasi oleh admin
    public function daftarVerifikasiPerizinan()
    {
        $perizinanPending = Perizinan::whereHas('verifikasi', function ($q) { // Hanya ambil perizinan yang belum diverifikasi oleh admin
            $q->whereNull('admin_verified_at');
        })
        ->whereHas('user.roles', function ($q) {
            $q->where('nama', 'karyawan');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $perizinanRiwayat = Perizinan::whereIn('status', ['disetujui', 'ditolak']) // Hanya ambil perizinan yang sudah disetujui atau ditolak
        ->whereHas('user.roles', function ($q) {
            $q->where('nama', 'karyawan');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('layouts.admin.perizinan.verifikasi_perizinan', compact('perizinanPending', 'perizinanRiwayat'));
    }


    // Menampilkan form untuk memverifikasi perizinan yang diajukan oleh karyawan
    public function updateVerifikasiPerizinan(Request $request, $id)
    {
        $verifikasi = VerifikasiPerizinan::where('perizinan_id', $id)->firstOrFail();

        $verifikasi->status_admin = $request->status;
        $verifikasi->catatan_admin = $request->catatan;
        $verifikasi->admin_id = auth()->id(); // Menyimpan ID admin yang memverifikasi
        $verifikasi->admin_verified_at = now(); // Menyimpan waktu verifikasi
        $verifikasi->save();

        // Update status perizinan berdasarkan hasil verifikasi admin
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

    // Menampilkan detail perizinan berdasarkan ID untuk keperluan verifikasi
    public function getVerifikasiById($id)
    {
        $perizinan = Perizinan::with('user')->findOrFail($id); // Ambil data perizinan beserta data user yang mengajukan perizinan

        return response()->json([ 'perizinan' => $perizinan, 'user' => $perizinan->user ]);
    }
}

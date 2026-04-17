<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PresensiController extends Controller
{
    public function absenMasuk()
    {
        $user = auth()->user();
        $today = Carbon::today();

        $presensi = Presensi::firstOrCreate(
            ['user_id' => $user->id, 'tanggal' => $today],
            ['jam_masuk' => Carbon::now()->format('H:i:s'), 'status' => Carbon::now()->format('H:i:s') > '10:40' ? 'terlambat' : 'hadir']
        );

        Alert::success('Sukses', 'Presensi masuk berhasil dicatat.');
        return back();
    }

    public function absenPulang()
    {
        $user = auth()->user();
        $today = Carbon::today();

        $presensi = Presensi::where('user_id', $user->id)->where('tanggal', $today)->first();

        if (!$presensi) {
            return back()->with(['error' => 'Anda belum melakukan presensi masuk hari ini.']);
        }

        $presensi->update(['jam_pulang' => Carbon::now()->format('H:i:s')]);

        Alert::success('Sukses', 'Presensi pulang berhasil dicatat.');
        return back();
    }

    // public function riwayatPresensi()
    // {
    //     $data = Presensi::with('user')->get();

    //     foreach ($data as $item) {

    //         if ($item->status == 'terlambat') {

    //             $batas = Carbon::parse($item->tanggal . ' 13:10:00');
    //             $jamMasuk = Carbon::parse($item->tanggal . ' ' . $item->jam_masuk);

    //             $item->terlambat_menit = (int) $jamMasuk->diffInMinutes($batas);
    //             $item->status_label = 'Terlambat';

    //         } elseif ($item->status == 'hadir') {

    //             $item->terlambat_menit = 0;
    //             $item->status_label = 'Hadir';

    //         } else {

    //             $item->status_label = 'Tidak Hadir';
    //             $item->terlambat_menit = 0;

    //         }
    //     }

    //     return view('layouts.superadmin.presensi.riwayat_presensi', compact('data'));
    // }

    public function riwayatPresensi()
    {
        $data = Presensi::with('user')->get();

        foreach ($data as $item) {

            // gabungkan tanggal + jam masuk
            $jamMasuk = Carbon::parse($item->tanggal . ' ' . $item->jam_masuk);

            // batas hadir = 19:00
            $batas = Carbon::parse($item->tanggal . ' 19:00:00');

            if ($item->status == 'terlambat') {

                if ($jamMasuk->gt($batas)) {
                    $item->terlambat_menit = (int) $jamMasuk->diffInMinutes($batas);
                } else {
                    $item->terlambat_menit = 0;
                }

                $item->status_label = 'Terlambat';

            } elseif ($item->status == 'hadir') {

                $item->terlambat_menit = 0;
                $item->status_label = 'Hadir';

            } else {

                $item->status_label = 'Tidak Hadir';
                $item->terlambat_menit = 0;
            }
        }

        return view('layouts.superadmin.presensi.riwayat_presensi', compact('data'));
    }
}

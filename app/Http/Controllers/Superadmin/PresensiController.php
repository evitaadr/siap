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
}

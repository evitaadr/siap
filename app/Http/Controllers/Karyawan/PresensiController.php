<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PresensiController extends Controller
{
    public function absenMasuk(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();
        $now = Carbon::now();

        $startAbsen = Carbon::createFromTime(12,30,0); // Jam masuk kantor
        $jamMasuk = Carbon::createFromTime(13,10,0); // Jam masuk kantor
        $endAbsen = Carbon::createFromTime(14,0,0); // Batas akhir absen masuk

        $officeLat = -7.6621772;
        $officeLng = 111.4888974;
        $radius = 200;

        $userLat = $request->latitude;
        $userLng = $request->longitude;

        $distance = $this->distance($officeLat,$officeLng,$userLat,$userLng);

        // dd('distance: '.$distance, 'radius: '.$radius, 'userLat: '.$userLat, 'userLng: '.$userLng);

        if($distance > $radius){

            Alert::error('Gagal','Anda berada di luar area kantor');

            return back();

        }

        // validasi waktu absen masuk
        if ($now->lt($startAbsen) || $now->gt($endAbsen)) {
            Alert::error('Error', 'Waktu absen masuk hanya bisa dilakukan antara pukul 00:00:00 hingga 01:00:00.');
            return back();
        }

        // Cek apakah sudah ada presensi masuk untuk hari ini
        $presensi = Presensi::where('user_id', $user->id)->where('tanggal', $today)->first();

        if ($presensi && $presensi->jam_masuk) {
            Alert::warning('Peringatan', 'Anda sudah melakukan presensi masuk hari ini.');
            return back();
        }

        // cek status terlambat
        // $status = $now->gt($jamMasuk) ? 'terlambat' : 'hadir';

        if ($now->between($startAbsen, $jamMasuk)) {
            $status = 'hadir';
        } else {
            $status = 'terlambat';
        }

        // dd('today: '.$today, 'now: '.$now, 'startAbsen: '.$startAbsen, 'jamMasuk: '.$jamMasuk, 'endAbsen: '.$endAbsen, 'status: '.$status, 'now->between(startAbsen, jamMasuk): '.$now->between($startAbsen, $jamMasuk));

        $presensi = Presensi::firstOrCreate(
            ['user_id' => $user->id, 'tanggal' => $today],
            ['jam_masuk' => $now->format('H:i:s'), 'status' => $status, 'latitude' => $userLat, 'longitude' => $userLng]
        );

        Alert::success('Sukses', 'Presensi masuk berhasil dicatat.');
        return back();
    }

    public function absenPulang()
    {
        $user = auth()->user();
        $today = Carbon::today();
        $now = Carbon::now();

        $jamPulang = Carbon::createFromTime(13,30,0); // Jam pulang kantor
        $batasPulang = Carbon::createFromTime(14,0,0); // Batas akhir absen pulang

        $presensi = Presensi::where('user_id', $user->id)->where('tanggal', $today)->first();

        if (!$presensi || !$presensi->jam_masuk) {
            Alert::error('Peringatan', 'Anda belum melakukan presensi masuk hari ini.');
            return back();
        }

        if ($presensi->jam_pulang) {
            Alert::warning('Peringatan', 'Anda sudah melakukan presensi pulang hari ini.');
            return back();
        }

        //validasi waktu absen pulang
        if ($now->lt($jamPulang)) {
            Alert::error('Gagal', 'Waktu absen pulang belum dimulai. Anda bisa melakukan absen pulang mulai pukul 01:30:00.');
            return back();
        }

        if ($now->gt($batasPulang)) {
            Alert::error('Gagal', 'Waktu absen pulang sudah berakhir. Anda tidak bisa melakukan absen pulang setelah pukul 02:00:00.');
            return back();
        }

        $presensi->update(['jam_pulang' => $now->format('H:i:s')]);

        Alert::success('Sukses', 'Presensi pulang berhasil dicatat.');
        return back();
    }

    function distance($lat1,$lon1,$lat2,$lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon/2) *
            sin($dLon/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    public function riwayatPresensi()
    {
        $presensi = \App\Models\Presensi::where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('layouts.karyawan.presensi.presensi', compact('presensi'));
    }
}

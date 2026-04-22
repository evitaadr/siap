<?php

namespace App\Http\Controllers\Superadmin;

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

        $startAbsen = Carbon::createFromTime(7,0,0); // Jam masuk kantor
        $endAbsen = Carbon::createFromTime(8,0,0); // Batas akhir absen masuk

        // kampus
        $officeLat = -7.6476731;
        $officeLng = 111.5265424;
        $radius = 200;

        // kantor
        // $officeLat = -7.6622185;
        // $officeLng = 111.4870806;
        // $radius = 200;

        // rumah
        // $officeLat = -7.6833838;
        // $officeLng = 111.4545241;
        // $radius = 200;

        // Ambil koordinat lokasi pengguna dari request
        $userLat = $request->latitude;
        $userLng = $request->longitude;

        $distance = $this->distance($officeLat,$officeLng,$userLat,$userLng); // Hitung jarak antara lokasi pengguna dan kantor

        // validasi lokasi pengguna
        if($distance > $radius){

            Alert::error('Gagal','Anda berada di luar area kantor');

            return back();

        }

        if ($now->lt($startAbsen)) {
            Alert::error('Error', 'Absen dimulai pukul 07:00');
            return back();
        }

        // Cek apakah sudah ada presensi masuk untuk hari ini
        $presensi = Presensi::where('user_id', $user->id)->where('tanggal', $today)->first();

        if ($presensi && $presensi->jam_masuk) {
            Alert::warning('Peringatan', 'Anda sudah melakukan presensi masuk hari ini.');
            return back();
        }

        if ($now->lte($endAbsen)) {
            $status = 'hadir';
        } else {
            $status = 'terlambat';
        }

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

        $jamPulang = Carbon::createFromTime(17,0,0); // Jam pulang kantor
        $batasPulang = Carbon::createFromTime(18,0,0); // Batas akhir absen pulang

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
            Alert::error('Gagal', 'Waktu absen pulang belum dimulai. Anda bisa melakukan absen pulang mulai pukul 17:00');
            return back();
        }

        if ($now->gt($batasPulang)) {
            Alert::error('Gagal', 'Waktu absen pulang sudah berakhir. Anda tidak bisa melakukan absen pulang setelah pukul 18:00');
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
        $data = Presensi::with('user')->get(); // Ambil semua data presensi beserta informasi user yang melakukan presensi

        foreach ($data as $item) {

            $jamMasuk = Carbon::parse($item->tanggal . ' ' . $item->jam_masuk); // Gabungkan tanggal dan jam masuk untuk mendapatkan waktu lengkap presensi masuk

            $batas = Carbon::parse($item->tanggal . ' 08:00:00'); //

            // Tentukan status kehadiran berdasarkan waktu absen
            if ($item->status == 'terlambat') {

                // Hitung keterlambatan dalam menit
                if ($jamMasuk->gt($batas)) {
                    $item->terlambat_menit = (int) $jamMasuk->diffInMinutes($batas);
                } else {
                    $item->terlambat_menit = 0;
                }

                $item->status_label = 'Terlambat';

            } elseif ($item->status == 'hadir') {

                // Jika status adalah 'hadir', maka keterlambatan adalah 0 menit
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

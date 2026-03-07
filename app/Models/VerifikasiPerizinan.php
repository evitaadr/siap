<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikasiPerizinan extends Model
{
    protected $table = 'verifikasi_perizinans';

    protected $fillable = [
        'perizinan_id',
        'admin_id',
        'superadmin_id',
        'status_admin',
        'status_superadmin',
        'admin_verified_at',
        'superadmin_verified_at',
        'catatan_admin',
        'catatan_superadmin',
    ];

    // Relasi dengan Perizinan
    public function perizinan()
    {
        return $this->belongsTo(Perizinan::class);
    }

    // Admin yang menyetujui
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Superadmin yang menyetujui
    public function superadmin()
    {
        return $this->belongsTo(User::class, 'superadmin_id');
    }
}

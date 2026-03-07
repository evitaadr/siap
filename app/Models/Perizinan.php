<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    protected $table = 'perizinans';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'jenis_perizinan',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'bukti_file',
        'status',
    ];

    // relasi perizinan dimiliki oleh user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiPerizinan::class,'perizinan_id');
    }


}

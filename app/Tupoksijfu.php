<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tupoksijfu extends Model
{
    //
    protected $table = 'tupoksijfu';

    protected $fillable = [
        'id_jabatan', 'uraian_tugas', 'satuan_hasil', 'waktu_penyelesaian', 'waktu_efektif', 'beban_kerja', 'pegawai_dibutuhkan'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}

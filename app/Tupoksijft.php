<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tupoksijft extends Model
{
    //
    protected $table = 'tupoksijft';

    protected $fillable = [
        'id_jabatan', 'butir_kegiatan', 'angka_kredit', 'satuan_hasil', 'konstanta', 'wpk', 'volume_kerja', 'beban_kerja', 'formasi', 'ket_hasil'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}

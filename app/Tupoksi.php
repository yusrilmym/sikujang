<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tupoksi extends Model
{
    //
    // protected $table = 'tupoksi';

    protected $fillable = [
        'id_jabatan', 'butir_kegiatan', 'angka_kredit', 'satuan_hasil', 'qty'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}

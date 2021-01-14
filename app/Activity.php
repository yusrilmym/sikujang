<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $table = 'activities';

    protected $fillable = [
        'id_user', 'kegiatan', 'jam', 'tanggal', 'status', 'mr', 'nama_pasien'
    ];
}

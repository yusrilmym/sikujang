<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Position extends Model
{
    //
    use HasApiTokens;

    protected $fillable = [
        'jabatan', 'kategori', 'shifting', 'jenis_jabatan'
    ];
}

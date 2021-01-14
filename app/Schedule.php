<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Schedule extends Model
{
    //
    use HasApiTokens;

    protected $fillable = [
        'id_user', 'id_shift', 'tanggal',
    ];
}

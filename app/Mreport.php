<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mreport extends Model
{
    //
    protected $table = 'mreports';

    protected $fillable = [
        'id_user', 'plan', 'do', 'check', 'action', 'date', 'status', 'catatan', 'checkdate', 'created_at'
    ];
}

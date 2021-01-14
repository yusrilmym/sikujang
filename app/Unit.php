<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Unit extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'nama_unit', 'bagian'
    ];

    public function user(){
        // return $this->hasMany(User::class);
        return $this->belongsTo('App\user');
    }
}

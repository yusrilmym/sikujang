<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'fullname', 'nip', 'nik', 'gol', 'email', 'tmt', 'id_alam',
        'id_jafung', 'id_jabpns', 'id_edu', 'id_unit', 'USERID', 'jenis_peg', 'agama',
        'tpt_lahir', 'tgl_lahir', 'gender', 'password', 'photo', 'status',
        'role', 'bio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit.nama_unit');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function alamat()
    {
        return $this->belongsTo(Alamat::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function finger()
    {
        return $this->belongsTo(Finger::class);
    }
}

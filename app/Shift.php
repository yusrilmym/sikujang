<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Shift extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'nama', 'in', 'out'
    ];

    public function in($value){
        return $this->attributes['in'] = substr($value, 0, 5);
    }
    public function isn(){
        return substr($this->in, 0, 5);
    }

    public function out(){
        return substr($this->out, 0, 5);
    }
}

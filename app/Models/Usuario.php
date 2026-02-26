<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $fillable = ['nome', 'email','senha','id_perfil'];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class, 'id_perfil', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfis';
    protected $fillable = ['perfil_nome'];

    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'id_perfil', 'id');
    }
}

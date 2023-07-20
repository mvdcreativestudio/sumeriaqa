<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'contabilidad_usuarios';


    public function contabilidad() 
    {
        return $this->hasMany(Contabilidad::class);
    }

}
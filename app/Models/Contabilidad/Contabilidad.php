<?php

namespace App\Models\Contabilidad;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contabilidad extends Model
{
    protected $fillable = ['nombre_cliente', 'concepto', 'fecha_vencimiento', 'estado', 'monto', 'estado_vencimiento'];
    protected $table = 'contabilidad';

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');

    }
}

<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrder extends Model
{
    use HasFactory;

    protected $table = 'posorders'; 

    protected $fillable = [
        'cliente',
        'direccion_entrega',
        'forma_entrega',
        'medio_pago',
        'total',
    ];

    public function productos()
    {
        return $this->hasMany(PosOrderProduct::class);
    }
}
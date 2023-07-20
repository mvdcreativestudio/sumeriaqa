<?php

namespace App\Models\POS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosOrderProduct extends Model
{
    use HasFactory;

    protected $table = 'posorderproducts';

    protected $fillable = [
        'pos_order_id',
        'product_id',
        'quantity',
        'price',
    ];

    public function posOrder()
    {
        return $this->belongsTo(PosOrder::class, 'pos_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

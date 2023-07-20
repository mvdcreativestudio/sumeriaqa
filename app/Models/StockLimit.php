<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLimit extends Model
{
    use HasFactory;

    protected $table = 'stock_limit';
    protected $fillable = ['product_id', /* other fillable fields */];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

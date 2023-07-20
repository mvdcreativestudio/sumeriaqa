<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StockLimit;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::all();
    
        foreach ($products as $product) {
            // Crear un nuevo registro en la tabla stock_limit para cada producto
            StockLimit::create([
                'product_id' => $product->id,
                // Agrega aquí las columnas adicionales necesarias para la tabla stock_limit
            ]);
        }
    
        return view('admin.stock.index', compact('products'));
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

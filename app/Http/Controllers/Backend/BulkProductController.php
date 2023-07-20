<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Backend\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BulkProductController extends Controller
{
    public function create()
    {
        return view('admin.product.quickLoadForm');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'productos.*.nombre' => 'required|string',
        'productos.*.precio' => 'required|numeric',
        'productos.*.descripcion' => 'nullable|string',
        // Agrega más validaciones para otros campos si es necesario
    ]);

    foreach ($data['products'] as $productoData) {
        $producto = new Product;
        $producto->name = $productoData['nombre'];
        $producto->price = $productoData['precio'];
        $producto->short_description = $productoData['descripcion'];
        // Completa con más campos si es necesario

        $producto->save();
    }

    return redirect()->route('admin.product.quickLoadForm')->with('success', 'Productos cargados exitosamente.');
}
}

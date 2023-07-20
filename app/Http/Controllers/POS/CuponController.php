<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    public function agregarCupon(Request $request)
    {
        // Lógica para agregar el cupón a la venta
        
        // Ejemplo de código para obtener el valor del cupón del formulario
        $cupon = $request->input('cupon');

        // Ejemplo de código para realizar acciones con el cupón (validación, descuento, etc.)
        
        // Redirigir a la página del POS o realizar cualquier otra acción necesaria
        return redirect()->route('nombre_de_la_ruta_del_POS')->with('success', 'Cupón agregado exitosamente');
    }

    public function agregarPorcentaje(Request $request)
    {
        // Lógica para agregar el descuento en porcentaje a la venta
        
        // Ejemplo de código para obtener el valor del descuento en porcentaje del formulario
        $porcentajeDescuento = $request->input('porcentaje_descuento');

        // Ejemplo de código para realizar acciones con el descuento en porcentaje
        
        // Redirigir a la página del POS o realizar cualquier otra acción necesaria
        return redirect()->route('nombre_de_la_ruta_del_POS')->with('success', 'Descuento en porcentaje agregado exitosamente');
    }

    public function agregarPrecio(Request $request)
    {
        // Lógica para agregar el descuento en precio fijo a la venta
        
        // Ejemplo de código para obtener el valor del descuento en precio fijo del formulario
        $precioDescuento = $request->input('precio_descuento');

        // Ejemplo de código para realizar acciones con el descuento en precio fijo
        
        // Redirigir a la página del POS o realizar cualquier otra acción necesaria
        return redirect()->route('nombre_de_la_ruta_del_POS')->with('success', 'Descuento en precio agregado exitosamente');
    }
}

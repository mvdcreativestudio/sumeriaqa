<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;

class ModuloController extends Controller
{
    /**
     * Muestra la lista de módulos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtiene todos los módulos de la base de datos
        $modulos = Modulo::all();

        // Muestra la vista de módulos con los módulos
        return view('admin.modulos.index', compact('modulos'));
    }

    /**
     * Actualiza el estado de un módulo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Encuentra el módulo en la base de datos
        $modulo = Modulo::findOrFail($id);
        
        // Actualiza el estado del módulo
        $modulo->enabled = $request->get('enabled');
        $modulo->save();
    
        // Redirige de vuelta a la vista de módulos con un mensaje de éxito
        return redirect()->route('admin.modulos.index')->with('success', 'El estado del módulo se ha actualizado correctamente.');
    }

    /**
     * Actualiza el estado de un módulo utilizando una solicitud POST.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request)
    {
        // Obtiene el ID del módulo desde la solicitud
        $id = $request->get('id');

        // Encuentra el módulo en la base de datos
        $modulo = Modulo::findOrFail($id);
        
        // Actualiza el estado del módulo
        $modulo->enabled = $request->get('enabled');
        $modulo->save();
    
        // Redirige de vuelta a la vista de módulos con un mensaje de éxito
        return redirect()->route('admin.modulos.index')->with('success', 'El estado del módulo se ha actualizado correctamente.');
    }
}

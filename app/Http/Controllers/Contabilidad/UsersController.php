<?php

namespace App\Http\Controllers\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movimientos\Usuario;

class UsersController extends Controller
{
    public function users()
    {
        $usuarios = Usuario::all();
        $clienteCount = $this->getClienteCount();
        $proveedoresCount = $this->getProveedoresCount();

        return view('admin.movimientos.users', compact('usuarios', 'clienteCount', 'proveedoresCount'));

    }

    public function getClienteCount()
    {
        $clienteCount = Usuario::where('tipo_usuario', 'cliente')->count();

        return $clienteCount;
    }

    public function getProveedoresCount()
    {
        $proveedoresCount = Usuario::where('tipo_usuario', 'proveedor')->count();

        return $proveedoresCount;
    }

    public function agregarUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'nullable',
            'apellido' => 'nullable',
            'empresa' => 'nullable',
            'rut' => 'nullable',
            'pais' => 'required',
            'departamento' => 'nullable',
            'direccion' => 'required',
            'telefono' => 'required',
            'email' => 'required|email|unique:cashflow_usuarios,email',
        ]);
    
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->empresa = $request->empresa;
        $usuario->rut = $request->rut;
        $usuario->tipo_usuario = $request->tipo_usuario;
        $usuario->pais = $request->pais;
        $usuario->departamento = $request->departamento;
        $usuario->direccion = $request->direccion;
        $usuario->telefono = $request->telefono;
        $usuario->email = $request->email;
        $usuario->status = 'activo';
        $usuario->save();
    
        return redirect()->route('admin.movimientos.users')->with('success', 'Usuario creado exitosamente');
    }

        // VER USUARIO
        public function verUsuario($id)
        {
            $usuario = Usuario::findOrFail($id);
            
            return view('admin.movimientos.usuario', compact('usuario'));
        }
    
    
    
}

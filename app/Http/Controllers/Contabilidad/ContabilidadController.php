<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Contabilidad\Contabilidad;
use App\Models\Contabilidad\Usuario;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

class ContabilidadController extends Controller

{
    // TODOS LOS contabilidad
    public function transactions()
    {
        $contabilidad = Contabilidad::orderBy('id', 'desc')->get();
        $usuariosCollection = Usuario::select('id', 'nombre', 'apellido')->get();
        $usuarios = $usuariosCollection->pluck('nombreCompleto', 'id');

        foreach ($usuariosCollection as $usuario) {
            $usuarios[$usuario->id] = $usuario->nombre . ' ' . $usuario->apellido;
        }

        return view('admin.contabilidad.transactions', compact('contabilidad', 'usuarios'));
    }

    // AGREGAR contabilidad
    public function agregar(Request $request, $accion)
    {
        // Obtener la lista de usuarios
        $usuariosCollection = Usuario::select('id', 'nombre', 'apellido')->get();
        $usuarios = $usuariosCollection->pluck('nombreCompleto', 'id');

        $usuarioId = $request->input('usuario_id'); // Obtener el ID del usuario seleccionado

        // Obtener el nombre completo del cliente seleccionado
        $usuario = $usuariosCollection->where('id', $usuarioId)->first();
        $nombreCliente = $usuario->nombre . ' ' . $usuario->apellido;

        $concepto = $request->input('concepto');
        $monto = $request->input('monto');
        $tipo = $request->input('tipo');
        $fechaVencimiento = $request->input('fecha_vencimiento');
        $estado = $request->input('estado');

        // Insertar el nuevo contabilidad en la base de datos "contabilidad"
        $contabilidad = new Contabilidad();
        $contabilidad->nombre_cliente = $nombreCliente;
        $contabilidad->concepto = $concepto;
        $contabilidad->monto = $monto;
        $contabilidad->tipo = $tipo;
        $contabilidad->fecha_vencimiento = $fechaVencimiento;
        $contabilidad->estado = $estado;
        $contabilidad->usuario_id = $usuarioId; // Asignar el ID del usuario al contabilidad

        // Obtener la fecha actual
        $fechaActual = Carbon::now();

        // Obtener la fecha de vencimiento del contabilidad
        $fechaVencimiento = Carbon::parse($contabilidad->fecha_vencimiento);

        // Obtener la diferencia en días entre la fecha de vencimiento y la fecha actual
        $diasRestantes = $fechaActual->diffInDays($fechaVencimiento, false);

        // Determinar el estado según los días restantes
        if ($diasRestantes >= 7) {
            $contabilidad->estado_vencimiento = 'Vigente';
        } elseif ($diasRestantes >= 0) {
            $contabilidad->estado_vencimiento = 'Por Vencer';
        } else {
            $contabilidad->estado_vencimiento = 'Vencida';
        }

        $contabilidad->save();

        $mensaje = ($tipo === 'cobro') ? 'Cobro' : 'Pago';
        return redirect()
            ->back()
            ->with(['success' => $mensaje . ' agregado exitosamente', 'usuarios' => $usuarios]);
    }


    public function editar(Request $request, $id)
    {
    // Obtener el contabilidad a editar
    $movimiento = Contabilidad::findOrFail($id);

    return view('admin.contabilidad.editar', compact('movimiento'));
    }


    public function actualizar(Request $request, $id)
    {
    // Validar los datos del formulario de edición si es necesario
    $request->validate([
        'nombre_cliente' => 'required',
        'concepto' => 'required',
        'monto' => 'required',
        'tipo' => 'required',
    ]);

    // Obtener el movimiento a actualizar
    $movimiento = Contabilidad::findOrFail($id);

    // Actualizar los campos del contabilidad con los datos del formulario
    $movimiento->nombre_cliente = $request->input('nombre_cliente');
    $movimiento->concepto = $request->input('concepto');
    $movimiento->monto = $request->input('monto');
    $movimiento->tipo = $request->input('tipo');

    // Guardar los cambios en la base de datos
    $movimiento->save();

    // Redirigir a la página de visualización del contabilidad o a donde desees
    return redirect()->route('admin.contabilidad.index')->with('success', 'contabilidad actualizado exitosamente');


    }

    
    // VER contabilidad
    public function ver($id)
    {
        $contabilidad = Contabilidad::findOrFail($id);
        
        return view('admin.contabilidad.ver', compact('contabilidad'));
    }
    
    // ELIMINAR contabilidad
    public function eliminar($id)
    {
        $contabilidad = Contabilidad::findOrFail($id);
        $contabilidad->delete();

        return redirect()->back()->with('success', 'contabilidad eliminado exitosamente');
    }
    
    // DASHBOARD DE contabilidad
    public function index()
    {
        $contabilidad = Contabilidad::with('usuario')->orderBy('id', 'desc')->get();
        $clienteCount = Usuario::where('tipo_usuario', 'cliente')->count();
        $proveedoresCount = Usuario::where('tipo_usuario', 'proveedor')->count();

        $totalTransacciones = Contabilidad::count();

        $cobradoHoy = Contabilidad::where('tipo', 'cobro')
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->sum('monto');

        $ingresosSemana = Contabilidad::where('tipo', 'cobro')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('monto');

        $ingresosMes = Contabilidad::where('tipo', 'cobro')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('monto');

        $ingresosAño = Contabilidad::where('tipo', 'cobro')
            ->whereYear('created_at', now()->year)
            ->sum('monto');

        $contabilidadVigentes = Contabilidad::where('estado_vencimiento', 'Vigente')
        ->where('estado', 'Impago')
        ->count();
        $contabilidadPorVencer = Contabilidad::where('estado_vencimiento', 'Por Vencer')
        ->where('estado', 'Impago')
        ->count();
        $contabilidadVencidos = Contabilidad::where('estado_vencimiento', 'Vencida')
            ->where('estado', 'Impago')
            ->count();
        
            return view('admin.contabilidad.index', compact('contabilidad', 'clienteCount', 'proveedoresCount', 'totalTransacciones', 'cobradoHoy', 'ingresosSemana', 'ingresosMes', 'ingresosAño', 'contabilidadVigentes', 'contabilidadPorVencer', 'contabilidadVencidos'));
        }
    
    // INGRESOS
    public function incomes()
    {
        $contabilidad = Contabilidad::where('tipo', 'cobro')
            ->orderBy('id', 'desc')
            ->get();
        
        return view('admin.contabilidad.incomes', compact('contabilidad'));
    }

    // TODOS LOS EGRESOS
    public function expenses()
    {
        $contabilidad = Contabilidad::where('tipo', 'pago')
            ->orderBy('id', 'desc')
            ->get();
        
        return view('admin.contabilidad.expenses', compact('contabilidad'));
    }

    // BUSCAR contabilidad
    public function search(Request $request)
    {
    $searchText = $request->input('search');

    // Realizar la búsqueda de contabilidad según el texto de búsqueda
    $contabilidad = Contabilidad::where('nombre_cliente', 'LIKE', "%{$searchText}%")
        ->orWhere('concepto', 'LIKE', "%{$searchText}%")
        ->orWhere('tipo', 'LIKE', "%{$searchText}%")
        ->orderBy('id', 'desc')
        ->get();

    // Renderizar las filas de la tabla como HTML
    $html = View::make('admin.contabilidad.table_rows', compact('contabilidad'))->render();

    // Retornar el HTML como respuesta AJAX
    return $html;
    }

    // VISTA AGREGAR USUARIO

    public function agregarUsuario()
    {
        return view('admin.contabilidad.agregar-usuario');
    }

    // Todas las ordenes - Dashboard

    public function ordenesDashboard()
    {
        return view('admin.contabilidad.ordenes-dashboard');
    }

    // Ordenes de cobro

    public function ordenesCobro() 
    {
        return view('admin.contabilidad.ordenes-cobro');
    }

    // Ordenes de cobro

    public function ordenesPago() 
    {
        return view('admin.contabilidad.ordenes-pago');
    }
}

<?php

namespace App\Http\Controllers\Contabilidad;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Contabilidad\Contabilidad;
use App\Models\Contabilidad\Usuario;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator; 


class ContabilidadController extends Controller
{
    public function __construct()
    {
        // Compartir variables a todas las vistas
        View::share([
            'contabilidad' => Contabilidad::with('usuario')->orderBy('id', 'desc')->get(),
            'clienteCount' => Usuario::where('tipo_usuario', 'cliente')->count(),
            'proveedoresCount' => Usuario::where('tipo_usuario', 'proveedor')->count(),
            'totalTransacciones' => Contabilidad::where('estado', 'Pago')->count(),
            'cobradoHoy' => Contabilidad::where('tipo', 'cobro')
                ->whereDate('created_at', now()->format('Y-m-d'))
                ->where('estado', 'Pago')
                ->sum('monto'),
            'ingresosSemana' => Contabilidad::where('tipo', 'cobro')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('monto'),
            'ingresosMes' => Contabilidad::where('tipo', 'cobro')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('monto'),
            'ingresosAño' => Contabilidad::where('tipo', 'cobro')
                ->whereYear('created_at', now()->year)
                ->sum('monto'),
            'contabilidadVigentes' => Contabilidad::where('estado_vencimiento', 'Vigente')
                ->where('estado', 'Impago')
                ->count(),
            'contabilidadPorVencer' => Contabilidad::where('estado_vencimiento', 'Por Vencer')
                ->where('estado', 'Impago')
                ->count(),
            'contabilidadVencidos' => Contabilidad::where('estado_vencimiento', 'Vencida')
                ->where('estado', 'Impago')
                ->count(),
        ]);
    }

    // TODOS LOS MOVIMIENTOS
    public function transactions()
    {
        $usuariosCollection = Usuario::select('id', 'nombre', 'apellido')->get();
        $usuarios = $usuariosCollection->pluck('nombreCompleto', 'id');

        foreach ($usuariosCollection as $usuario) {
            $usuarios[$usuario->id] = $usuario->nombre . ' ' . $usuario->apellido;
        }

        return view('admin.contabilidad.transactions', compact('usuarios'));
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

    // EDITAR contabilidad
    public function editar(Request $request, $id)
    {
        // Obtener el contabilidad a editar
        $movimiento = Contabilidad::findOrFail($id);

        return view('admin.contabilidad.editar', compact('movimiento'));
    }

    // ACTUALIZAR contabilidad
    public function actualizar(Request $request, $id)
    {
        // Validar los datos del formulario de edición si es necesario
        $request->validate([
            'nombre_cliente' => 'required',
            'concepto' => 'required',
            'monto' => 'required',
            'tipo' => 'required',
            'fecha_de_pago' => 'required',
        ]);

        // Obtener el movimiento a actualizar
        $movimiento = Contabilidad::findOrFail($id);

        // Actualizar los campos del contabilidad con los datos del formulario
        $movimiento->nombre_cliente = $request->input('nombre_cliente');
        $movimiento->concepto = $request->input('concepto');
        $movimiento->monto = $request->input('monto');
        $movimiento->tipo = $request->input('tipo');
        $movimiento->fecha_de_pago = input('fecha_de_pago');

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

    // Marcar como pago
    public function marcarComoPago($id)
    {
    // Obtener el movimiento a marcar como pago
    $movimiento = Contabilidad::findOrFail($id);

    // Verificar que el estado actual sea "Impago" antes de marcar como pago
    if ($movimiento->estado === 'Impago') {
        // Marcar el movimiento como pago
        $movimiento->estado = 'Pago';

        // Asignar la fecha y hora actual como fecha de pago
        $movimiento->fecha_de_pago = Carbon::now();

        // Guardar los cambios en la base de datos
        $movimiento->save();

        // Redirigir a la página de visualización del contabilidad o a donde desees
        return redirect()->route('admin.contabilidad.index')->with('success', 'Movimiento marcado como pago exitosamente');
    } else {
        // Si el movimiento ya está marcado como pago, redirigir sin hacer cambios
        return redirect()->route('admin.contabilidad.index')->with('error', 'El movimiento ya está marcado como pago');
    }
    }

    // DASHBOARD DE contabilidad
    public function index()
    {
        return view('admin.contabilidad.index');
    }

    // INGRESOS
    public function incomes()
    {
        return view('admin.contabilidad.incomes');
    }

    // TODOS LOS EGRESOS
    public function expenses()
    {
        return view('admin.contabilidad.expenses');
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

// Vista del formulario para crear una nueva orden
public function formularioCrearOrden()
{
    // Obtener la lista de usuarios con el atributo "nombreCompleto"
    $usuariosCollection = Usuario::select('id', DB::raw("CONCAT(nombre, ' ', apellido) AS nombreCompleto"))->get();
    $usuarios = $usuariosCollection->pluck('nombreCompleto', 'id');

    // Si es una llamada AJAX, responder con información JSON
    if (request()->ajax()) {
        return response()->json(['usuarios' => $usuarios]);
    }

    return view('admin.contabilidad.crear-orden', compact('usuarios'));
}

// Crear nueva orden
public function crearOrden(Request $request)
{
    if ($request->isMethod('post')) {
        // Si el tipo de usuario es "registrado", llamamos al método agregar pasando la solicitud y el tipo de acción ('cobro' o 'pago')
        // Si el tipo de usuario es "invitado", creamos una nueva entrada en la base de datos con los datos del formulario
        if ($request->input('tipoUsuario') === 'registrado') {
            return $this->agregar($request, $request->input('tipo'));
        } else {
            $this->validate($request, [
                'nombre' => 'required',
                'apellido' => 'required',
                'concepto' => 'required',
                'monto' => 'required',
                'tipo' => 'required',
                'fecha_vencimiento' => 'required',
                'estado' => 'required',
            ]);

            $nombreCliente = $request->input('nombre') . ' ' . $request->input('apellido');
            $usuarioId = null; // No asignamos a ningún usuario registrado en caso de invitado
        }

        // Insertar el nuevo contabilidad en la base de datos "contabilidad"
        $contabilidad = new Contabilidad();
        $contabilidad->nombre_cliente = $nombreCliente;
        $contabilidad->concepto = $request->input('concepto');
        $contabilidad->monto = $request->input('monto');
        $contabilidad->tipo = $request->input('tipo');
        $contabilidad->fecha_vencimiento = $request->input('fecha_vencimiento');
        $contabilidad->estado = $request->input('estado');
        $contabilidad->usuario_id = $usuarioId;

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

        $mensaje = ($request->input('tipo') === 'cobro') ? 'Cobro' : 'Pago';
        return redirect()->back()->with(['success' => $mensaje . ' agregado exitosamente']);
    }

    // Mostrar la vista del formulario para crear una nueva orden sin realizar validación
    return $this->formularioCrearOrden();
}


}

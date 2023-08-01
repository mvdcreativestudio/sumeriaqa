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
use LaravelDaily\LaravelCharts\Classes\LaravelChart;


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
                ->whereDate('fecha_de_pago', now()->format('Y-m-d'))
                ->where('estado', 'Pago')
                ->sum('monto'),
            'ingresosSemana' => Contabilidad::where('tipo', 'cobro')
                ->whereBetween('fecha_de_pago', [now()->startOfWeek(), now()->endOfWeek()])
                ->sum('monto'),
            'ingresosMes' => Contabilidad::where('tipo', 'cobro')
                ->whereYear('fecha_de_pago', now()->year)
                ->whereMonth('fecha_de_pago', now()->month)
                ->sum('monto'),
            'ingresosAño' => Contabilidad::where('tipo', 'cobro')
                ->whereYear('fecha_de_pago', now()->year)
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
            'montoVigentes' => Contabilidad::where('estado_vencimiento', 'Vigente')
                ->where('estado', 'Impago')
                ->sum('monto'),
            'montoPorVencer' => Contabilidad::where('estado_vencimiento', 'Por Vencer')
                ->where('estado', 'Impago')
                ->sum('monto'),
            'montoVencidos' => Contabilidad::where('estado_vencimiento', 'Vencida')
                ->where('estado', 'Impago')
                ->sum('monto'),


            // VARIABLES PARA GRÁFICAS
            'ingresos10dias' => $this->getMovimientos10Dias('cobro'),
            'egresos10dias' => $this->getMovimientos10Dias('pago'),
            'balance10dias' => $this->getBalance10Dias(),
        ]);
    }

    // FUNCIONES PARA LAS VISTAS

    public function index()
    {
        return view('admin.contabilidad.index');
    }

    public function getChartData()
    {
        // Obtiene la fecha de hace 10 días
        $tenDaysAgo = now()->subDays(10);
    
        // Obtiene los datos de ingresos, egresos y balance para los últimos 10 días
        $ingresos = $this->getMovimientos10Dias('cobro');
        $egresos = $this->getMovimientos10Dias('pago');
        $balance = $this->getBalance10Dias();

    
        // Prepara los datos para la respuesta JSON
        $chartData = [
            'labels' => array_keys($ingresos), 
            'datasets' => [
                [
                    'label' => 'Ingresos',
                    'data' => array_values($ingresos),
                    'backgroundColor' => 'rgb(99, 237, 122)',
                    'borderColor' => 'rgb(99, 237, 122)',
                ],
                [
                    'label' => 'Egresos',
                    'data' => array_values($egresos),
                    'backgroundColor' => 'rgb(252, 84, 75)',
                    'borderColor' => 'rgb(252, 84, 75)',
                ],
                [
                    'label' => 'Balance',
                    'data' => array_values($balance),
                    'backgroundColor' => 'rgb(57, 62, 70)',
                    'borderColor' => 'rgb(57, 62, 70)',
                ],
            ],
        ];
    
        // Devuelve los datos como una respuesta JSON
        
        return response()->json($chartData);
    }

    

    public function transactions()
    {
        $usuarios = $this->getUsuarios();
        return view('admin.contabilidad.transactions', compact('usuarios'));
    }

    public function editar(Request $request, $id)
    {
        // Obtener el contabilidad a editar
        $movimiento = Contabilidad::findOrFail($id);
        return view('admin.contabilidad.editar', compact('movimiento'));
    }

    public function ver($id)
    {
        $contabilidad = Contabilidad::findOrFail($id);
        return view('admin.contabilidad.ver', compact('contabilidad'));
    }

    public function incomes()
    {
        return view('admin.contabilidad.incomes');
    }

    public function expenses()
    {
        return view('admin.contabilidad.expenses');
    }

    public function agregarUsuario()
    {
        return view('admin.contabilidad.agregar-usuario');
    }

    public function ordenesDashboard()
    {
        return view('admin.contabilidad.ordenes-dashboard');
    }

    public function ordenesCobro() 
    {
        return view('admin.contabilidad.ordenes-cobro');
    }

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

    // FUNCIONES CRUD
    public function agregar(Request $request, $accion)
    {
        $usuariosCollection = Usuario::select('id', 'nombre', 'apellido')->get();
        $usuarios = $this->getUsuariosFromCollection($usuariosCollection);

        $usuarioId = $request->input('usuario_id'); // Obtener el ID del usuario seleccionado
        $usuario = $usuariosCollection->where('id', $usuarioId)->first();
        $nombreCliente = $usuario->nombre . ' ' . $usuario->apellido;

        $concepto = $request->input('concepto');
        $monto = $request->input('monto');
        $tipo = $request->input('tipo');
        $fechaVencimiento = $request->input('fecha_vencimiento');
        $estado = $request->input('estado');

        $contabilidad = $this->crearNuevoContabilidad($nombreCliente, $concepto, $monto, $tipo, $fechaVencimiento, $estado, $usuarioId);

        $mensaje = ($tipo === 'cobro') ? 'Cobro' : 'Pago';
        return redirect()
            ->back()
            ->with(['success' => $mensaje . ' agregado exitosamente', 'usuarios' => $usuarios]);
    }

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
        return redirect()->route('admin.contabilidad.index')->with('success', 'Movimiento actualizado exitosamente');
    }

    public function eliminar($id)
    {
        $contabilidad = Contabilidad::findOrFail($id);
        $contabilidad->delete();

        return redirect()->back()->with('success', 'Movimiento eliminado exitosamente');
    }

    public function marcarComoPago($id)
    {
        $movimiento = Contabilidad::findOrFail($id);

        if ($movimiento->estado === 'Impago') {
            $movimiento->estado = 'Pago';
            $movimiento->fecha_de_pago = Carbon::now();
            $movimiento->save();
            return redirect()->back()->with('success', 'Factura marcada como paga exitosamente');
        } else {
            return redirect()->back()->with('error', 'La factura ya está marcada como paga');
        }
    }

    public function search(Request $request)
    {
        $searchText = $request->input('search');

        $contabilidad = Contabilidad::where('nombre_cliente', 'LIKE', "%{$searchText}%")
            ->orWhere('concepto', 'LIKE', "%{$searchText}%")
            ->orWhere('tipo', 'LIKE', "%{$searchText}%")
            ->orderBy('id', 'desc')
            ->get();

        $html = View::make('admin.contabilidad.table_rows', compact('contabilidad'))->render();
        return $html;
    }



    // Crear nueva orden desde la vista
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
            $contabilidad->empresa = $request->input('empresa');
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

    // FUNCIONES AUXILIARES
    private function getUsuarios()
    {
        $usuariosCollection = Usuario::select('id', 'nombre', 'apellido')->get();
        $usuarios = [];
        foreach ($usuariosCollection as $usuario) {
            $usuarios[$usuario->id] = $usuario->nombre . ' ' . $usuario->apellido;
        }
        return $usuarios;
    }

    private function getUsuariosFromCollection($usuariosCollection)
    {
        $usuarios = [];
        foreach ($usuariosCollection as $usuario) {
            $usuarios[$usuario->id] = $usuario->nombre . ' ' . $usuario->apellido;
        }
        return $usuarios;
    }

    private function crearNuevoContabilidad($nombreCliente, $concepto, $monto, $tipo, $fechaVencimiento, $estado, $usuarioId)
    {
        $contabilidad = new Contabilidad();
        $contabilidad->nombre_cliente = $nombreCliente;
        $contabilidad->concepto = $concepto;
        $contabilidad->monto = $monto;
        $contabilidad->tipo = $tipo;
        $contabilidad->fecha_vencimiento = $fechaVencimiento;
        $contabilidad->estado = $estado;
        $contabilidad->usuario_id = $usuarioId;

        $this->setEstadoVencimiento($contabilidad);

        $contabilidad->save();

        return $contabilidad;
    }

    private function setEstadoVencimiento($contabilidad)
    {
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
    }
    
    // DATOS PARA GRÁFICAS

    private function getMovimientos10Dias($tipo)
    {
        $movimientos = Contabilidad::where('tipo', $tipo)
            ->whereBetween('fecha_de_pago', [now()->subDays(10), now()])
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->fecha_de_pago)->format('Y-m-d'); // agrupar por día
            });
    
        // Genera todas las fechas de los últimos 10 días
        $allDates = [];
        for ($i = 10; $i >= 0; $i--) {
            $allDates[now()->subDays($i)->format('Y-m-d')] = 0;
        }
    
        // Asigna los montos a las fechas correspondientes y conviértelos a números
        foreach ($movimientos as $key => $value) {
            $montoSum = $value->sum('monto'); // Sumar los montos
            if ($tipo == 'pago') { // Si es un egreso, hacer el monto negativo
                $montoSum *= -1;
            }
            $allDates[$key] = (float) $montoSum; // Convertir a número
        }
    
        return $allDates;
    }
    
    private function getBalance10Dias()
    {
        $ingresos = $this->getMovimientos10Dias('cobro');
        $egresos = $this->getMovimientos10Dias('pago');
        $balance = [];
    
        // Aquí, necesitas iterar sobre todas las fechas, no solo las fechas de ingresos
        foreach (array_keys($ingresos + $egresos) as $key) {
            $montoIngresos = isset($ingresos[$key]) ? $ingresos[$key] : 0;
            $montoEgresos = isset($egresos[$key]) ? $egresos[$key] : 0;
            $balance[$key] = (float) ($montoIngresos + $montoEgresos); // Convertir a número
        }
    
        return $balance;
    }
    

}

<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\POS\PosOrder;
use App\Models\POS\PosOrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class PosController extends Controller
{
    public function caja()
    {
        $products = Product::paginate(8);
        $productosOrden = Session::get('productosOrden', []);
        $total = $this->totalOrden($productosOrden);

        return view('admin.pos.caja', compact('products', 'productosOrden', 'total'));
    }

    public function agregarProducto(Request $request)
    {
        $productoId = $request->input('producto_id');
        $producto = Product::findOrFail($productoId);
        $productosOrden = Session::get('productosOrden', []);

        $indice = array_search($productoId, array_column($productosOrden, 'id'));

        if ($indice !== false) {
            $productosOrden[$indice]['cantidad']++;
        } else {
            $productosOrden[] = [
                'id' => $producto->id,
                'name' => $producto->name,
                'price' => $producto->price,
                'cantidad' => 1,
            ];
        }

        Session::put('productosOrden', $productosOrden);

        return Redirect::back();
    }

    public function actualizarCantidad(Request $request)
    {
        $productoId = $request->input('producto_id');
        $nuevaCantidad = $request->input('cantidad');
        $productosOrden = Session::get('productosOrden', []);
        $indice = array_search($productoId, array_column($productosOrden, 'id'));

        if ($indice !== false) {
            $productosOrden[$indice]['cantidad'] = $nuevaCantidad;
            Session::put('productosOrden', $productosOrden);
        }

        $total = $this->totalOrden($productosOrden);

        return response()->json([
            'success' => true,
            'total' => $total,
        ]);
    }

    public function eliminarProducto(Request $request)
    {
        $productoId = $request->input('producto_id');
        $productosOrden = session()->get('productosOrden', []);
        $productosOrden = collect($productosOrden);
        $indice = $productosOrden->pluck('id')->search($productoId);

        if ($indice !== false) {
            $productosOrden->splice($indice, 1);
            session()->put('productosOrden', $productosOrden->all());
        }

        return redirect()->route('admin.pos.caja');
    }

    public function vaciarProductos()
    {
        Session::forget('productosOrden');

        return Redirect::back();
    }

    public function finalizarCompra(Request $request)
{
    $productosOrden = Session::get('productosOrden', []);

    if (count($productosOrden) > 0) {
        $order = new PosOrder();
        $order->forma_entrega = $request->forma_entrega;
        $order->medio_pago = $request->medio_pago;
        $order->save();

        $totalOrden = $this->totalOrden($productosOrden); // Calcular el total de la orden

        foreach ($productosOrden as $producto) {
            $orderProduct = new PosOrderProduct();
            $orderProduct->pos_order_id = $order->id;
            $orderProduct->product_id = $producto['id'];
            $orderProduct->cantidad = $producto['cantidad'];
            $orderProduct->save();

            // Actualizar la cantidad disponible del producto
            $product = Product::find($producto['id']);
            $product->qty -= $producto['cantidad'];
            $product->save();
        }

        // Establecer el total de la orden en el campo "total" de la tabla PosOrder
        $order->total = $totalOrden;
        $order->save();

        Session::forget('productosOrden');

        return response()->json(['success' => 'El pedido se ha creado correctamente.', 'order' => $order]);
    } else {
        return response()->json(['error' => 'No hay productos en la orden.'], 400);
    }
}




    public function dashboard()
    {
        $today = Carbon::today();
        $domicilioHoy = PosOrder::where('forma_entrega', 'Entrega a domicilio')->get();
        $cantidadDomicilioHoy = count($domicilioHoy);
        $localHoy = PosOrder::where('forma_entrega', 'Retiro en el local')->get();
        $cantidadLocalHoy = count($localHoy);
        $pedidosHoy = PosOrder::whereDate('created_at', $today)->get();
        $cantidadPedidosHoy = count($pedidosHoy);
        $ingresosTotalesHoy = DB::table('posorders')->whereDate('created_at', $today)->sum('total');
        $ingresosEfectivoHoy = DB::table('posorders')->whereDate('created_at', $today)->where('medio_pago', 'efectivo')->sum('total');
        $ingresosTarjetasHoy = DB::table('posorders')->whereDate('created_at', $today)->where('medio_pago', 'Tarjeta Débito/Crédito')->sum('total');

        $ordenesHoy = PosOrder::whereDate('created_at', $today)->orderBy('id', 'desc')->take(5)->get();


    
        return view('admin.pos.dashboard', compact('cantidadPedidosHoy', 'ingresosTotalesHoy', 'cantidadDomicilioHoy', 'cantidadLocalHoy', 'ingresosEfectivoHoy', 'ingresosTarjetasHoy','ordenesHoy'));
    }

    private function totalOrden(array $productosOrden): float
    {
        $total = 0;

        foreach ($productosOrden as $producto) {
            $total += $producto['price'] * $producto['cantidad'];
        }

        return $total;
    }
}

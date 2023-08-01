@extends('admin.layouts.master')

@section('content')

<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        text-align: center;
    }
</style>

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1 class="mr-auto d-flex align-items-center">
            Point of Sale 
            <i class="fas fa-th ml-3 cursor-pointer" id="grid-view" onclick="changeView('grid')"></i>
            <i class="fas fa-list ml-1 cursor-pointer" id="list-view" onclick="changeView('list')"></i>
        </h1>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Productos</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-productos" data-toggle="tab" href="#productos">Productos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-categorias" data-toggle="tab" href="#categorias">Categorías</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3">
                            <div class="tab-pane fade show active" id="productos">
                                <div class="mb-3">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto...">
                                </div>
                                
                                <div id="list-view-container">
                                    <table class="table table-striped" id="productos-table">
                                        <thead class="thead-dark">
                                            <tr class="tr-light">
                                                <th>Nombre</th>
                                                <th class="text-center">Precio</th>
                                                <th class="col-1 text-right"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td class="text-center">${{ $product->price }}</td>
                                                    <td class="col-1 text-right">
                                                        <form action="{{ route('admin.pos.agregar-producto') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="producto_id" value="{{ $product->id }}">
                                                            <button type="submit" class="btn btn-primary btn-sm">Agregar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{-- {{ $products->links() }} --}}
                                </div>
                                <div id="grid-view-container" style="display: none;">
                                    <div class="row">
                                        @foreach($products as $product)
                                            <div class="col-md-3">
                                                <div class="card mb-4">
                                                    <img class="card-img-top mx-auto" src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}" style="width:100px; height:100px; object-fit:cover">
                                                    <div class="card-body d-flex flex-column">
                                                        <h6 class="card-title">{{ \Illuminate\Support\Str::limit($product->name, 20) }}</h6>
                                                        <p class="card-text">${{ $product->price }}</p>
                                                        <form action="{{ route('admin.pos.agregar-producto') }}" method="POST" class="mt-auto">
                                                            @csrf
                                                            <input type="hidden" name="producto_id" value="{{ $product->id }}">
                                                            <button type="submit" class="btn btn-primary">Agregar al Carrito</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4">
                                        {{-- {{ $products->links() }} --}}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="categorias">
                                <!-- Código de la vista de categorías -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Productos de la orden</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr class="tr-light text-center">
                                    <th class="col-6">Producto</th>
                                    <th class="col-1">Precio</th>
                                    <th class="col-3">Cantidad</th>
                                    <th class="col-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productosOrden as $productoOrden)
                                    <tr>
                                        <td class="col-6">{{ Str::limit($productoOrden['name'], 20) }}</td>
                                        <td class="col-1 precio-producto">${{ $productoOrden['price'] }}</td>
                                        <td class="col-3">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-primary btn-sm" type="button" onclick="decrementCantidad(this)">-</button>
                                                </div>
                                                <input type="number" class="form-control form-control-sm cantidad" name="cantidad" value="{{ $productoOrden['cantidad'] }}" data-producto-id="{{ $productoOrden['id'] }}" min="1" onchange="actualizarCantidadManual(this)">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary btn-sm" type="button" onclick="incrementCantidad(this); actualizarCantidadManual(this)">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-2">
                                            <form action="{{ route('admin.pos.eliminar-producto') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="producto_id" value="{{ $productoOrden['id'] }}">
                                                <button class="btn btn-danger btn-action btn-delete" data-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        
                        <button class="col-12 btn btn-danger" onclick="event.preventDefault(); document.getElementById('form-vaciar-productos').submit();">Vaciar productos</button>
                        <form id="form-vaciar-productos" action="{{ route('admin.pos.vaciar-productos') }}" method="POST" style="display: none;">
                            @csrf
                        </form>                    
                    </div>
                    
                    <div class="card-footer">
                        <div class="form-group">
                            <div class="btn-group mb-3 col-12 w-100 p-0">
                                <button class="btn btn-primary col-4" id="btn-agregar-cupon">Agregar Cupón</button>
                                <button class="btn btn-primary col-4" id="btn-agregar-porcentaje">Descuento en %</button>
                                <button class="btn btn-primary col-4" id="btn-agregar-precio">Descuento en $</button>
                            </div>
                            <div class="form-group" id="cupon-descuento-container" style="display: none;">
                                <label for="cupon-descuento">Cupón de Descuento</label>
                                <input type="text" class="form-control" id="cupon-descuento" name="cupon" placeholder="Ingrese el cupón">
                                <button class="btn btn-primary col-4 mt-3" id="btn-agregar-cupon" onclick="event.preventDefault(); document.getElementById('cupon-form').submit();">Agregar Cupón</button>
                            </div>
                    
                            <div class="form-group" id="descuento-porcentaje-container" style="display: none;">
                                <label for="descuento-porcentaje">Descuento (%)</label>
                                <input type="number" class="form-control" id="descuento-porcentaje" placeholder="Ingrese el porcentaje de descuento">
                            </div>
                    
                            <div class="form-group" id="descuento-precio-container" style="display: none;">
                                <label for="descuento-precio">Descuento (Precio)</label>
                                <input type="number" class="form-control" id="descuento-precio" placeholder="Ingrese el descuento en precio fijo">
                            </div>
                    
                            <form id="formFinalizarVenta" method="POST" action="{{ route('admin.pos.finalizar-compra') }}">
                                @csrf
                                <div class="form-group mt-3">
                                    <label for="medio_pago">Seleccione el medio de pago</label>
                                    <select class="form-control" id="medio_pago" name="medio_pago">
                                        <option>Tarjeta Débito/Crédito</option>
                                        <option>Efectivo</option>
                                    </select>
                                </div>

                                <div class="form-group" id="div_abono_cliente" style="display: none;">
                                    <label for="abono_cliente">Abono del Cliente</label>
                                    <input type="number" step="0.01" class="form-control" id="abono_cliente" name="abono_cliente" placeholder="Ingrese la cantidad que el cliente va a abonar">
                                </div>
                    
                                <div class="form-group">
                                    <label for="forma_entrega">Forma de Entrega</label>
                                    <select class="form-control" id="forma_entrega" name="forma_entrega">
                                        <option>Retiro en el Local</option>
                                        <option>Entrega a Domicilio</option>
                                    </select>
                                </div>
                       
                                <div class="d-flex justify-content-between mb-4">
                                    <h6>Total:</h6>
                                    <h6 id="total-venta" class="total-venta">${{ number_format($total, 2) }}</h6>
                                </div>
   
                                
                                <div class="d-flex btn-group w-100">
                                    <button class="btn btn-primary col-12" type="submit">Finalizar Venta</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Capturar el evento de cambio en el campo de búsqueda
        $('#searchInput').on('keyup', function() {
            var searchText = $(this).val().toLowerCase();
            searchText = normalizeText(searchText); // Normalizar el texto de búsqueda

            // Filtrar las filas de la tabla según el texto de búsqueda
            $("#productos-table tbody tr").filter(function() {
                var rowText = $(this).text().toLowerCase();
                rowText = normalizeText(rowText); // Normalizar el texto de la fila
                $(this).toggle(rowText.indexOf(searchText) > -1);
            });
        });

        // Función para normalizar un texto removiendo los tildes
        function normalizeText(text) {
            return text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }
    });
</script>


<script>
$(document).ready(function() {
    // Mostrar u ocultar el campo de "Abono del Cliente" basado en el valor de "medio_pago"
    $('#medio_pago').change(function() {
        if ($(this).val() == 'Efectivo') {
            $('#div_abono_cliente').show();
        } else {
            $('#div_abono_cliente').hide();
            $('#abono_cliente').val(''); // Limpiar el campo de abono del cliente cuando se oculta
        }
    });

    $('#formFinalizarVenta').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        var total_venta = parseFloat($("#total-venta").text().replace('$', ''));
        var abono_cliente = parseFloat($("#abono_cliente").val());

        // Verificar si el monto que abona el cliente es mayor o igual al total de la orden
        if ($('#medio_pago').val() == 'Efectivo' && (isNaN(abono_cliente) || abono_cliente < total_venta)) {
            Swal.fire({
                title: '¡Error!',
                text: 'El monto ingresado debe ser mayor al total de la venta',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                // Calcular el cambio
                var cambio = abono_cliente - total_venta;

                Swal.fire({
                    title: '¡Buen trabajo!',
                    html: response.success + '<br>El cambio es: $' + cambio.toFixed(2),
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    location.reload(); // recargar la página cuando el usuario haga clic en "Aceptar"
                });
            },
            error: function() {
                Swal.fire({
                    title: '¡Error!',
                    text: 'Ha ocurrido un error al procesar el pedido.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });
});
</script>





<script>
    document.addEventListener('DOMContentLoaded', function() {
        var btnAgregarCupon = document.getElementById('btn-agregar-cupon');
        var btnAgregarPorcentaje = document.getElementById('btn-agregar-porcentaje');
        var btnAgregarPrecio = document.getElementById('btn-agregar-precio');
        var cuponDescuentoContainer = document.getElementById('cupon-descuento-container');
        var descuentoPorcentajeContainer = document.getElementById('descuento-porcentaje-container');
        var descuentoPrecioContainer = document.getElementById('descuento-precio-container');
        
        btnAgregarCupon.addEventListener('click', function() {
            cuponDescuentoContainer.style.display = (cuponDescuentoContainer.style.display === 'none') ? 'block' : 'none';
            descuentoPorcentajeContainer.style.display = 'none';
            descuentoPrecioContainer.style.display = 'none';
        });
        
        btnAgregarPorcentaje.addEventListener('click', function() {
            cuponDescuentoContainer.style.display = 'none';
            descuentoPorcentajeContainer.style.display = (descuentoPorcentajeContainer.style.display === 'none') ? 'block' : 'none';
            descuentoPrecioContainer.style.display = 'none';
        });
        
        btnAgregarPrecio.addEventListener('click', function() {
            cuponDescuentoContainer.style.display = 'none';
            descuentoPorcentajeContainer.style.display = 'none';
            descuentoPrecioContainer.style.display = (descuentoPrecioContainer.style.display === 'none') ? 'block' : 'none';
        });
    });
</script>


<script>
        // JavaScript para cambiar las vistas
        function changeView(view) {
        var listView = document.getElementById('list-view-container');
        var gridView = document.getElementById('grid-view-container');
        
        if(view === 'grid') {
            listView.style.display = 'none';
            gridView.style.display = 'block';
        } else {
            listView.style.display = 'block';
            gridView.style.display = 'none';
        }
        
        // Guardamos la preferencia del usuario
        localStorage.setItem('productView', view);
    }

    // Cargamos la preferencia del usuario cuando el documento esté listo
    document.addEventListener('DOMContentLoaded', function() {
        var view = localStorage.getItem('productView') || 'list';
        changeView(view);
    });
</script>

<script>
    function incrementCantidad(input) {
        var cantidadInput = input.parentNode.parentNode.querySelector('.cantidad');
        var cantidad = parseInt(cantidadInput.value);
        cantidadInput.value = cantidad + 1;
        actualizarCantidad(cantidadInput);
    }

    function decrementCantidad(input) {
        var cantidadInput = input.parentNode.parentNode.querySelector('.cantidad');
        var cantidad = parseInt(cantidadInput.value);
        if (cantidad > 1) {
            cantidadInput.value = cantidad - 1;
            actualizarCantidad(cantidadInput);
        }
    }

    function actualizarCantidad(input) {
        var productoId = input.getAttribute('data-producto-id');
        var cantidad = input.value;

        // Realizar una solicitud POST para actualizar la cantidad del producto
        fetch('{{ route('admin.pos.actualizar-cantidad') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                producto_id: productoId,
                cantidad: cantidad
            })
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                // Actualiza el total en el cliente
                document.getElementById('total-venta').innerText = "$" + data.total.toFixed(2);

            }
        })
        .catch(function(error) {
            console.error('Error:', error);
        });
    }
</script>

@endsection

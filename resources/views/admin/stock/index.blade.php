@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1 class="mr-auto">Stock</h1>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1>Stock de Productos</h1>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Nuevo Producto</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="order-by">Ordenar por:</label>
                <select id="order-by" class="form-control">
                    <option value="name">A-Z (Nombre)</option>
                    <option value="lowest-qty" selected>Menor Cantidad</option>
                    <option value="highest-qty">Mayor Cantidad</option>
                </select>
            </div>
            
        </div>
        <table id="stock-table" class="table table-striped">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Producto</th>
                    <th>Cantidad en Stock</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products->sortBy('qty') as $product)
                    <tr>
                        <td>{{ Illuminate\Support\Str::limit($product->sku, 10) }}</td>
                        <td>{{ Illuminate\Support\Str::limit($product->name, 15) }}</td>
                        <td>
                            {{ $product->qty }}
                            @if ($product->stockLimit && $product->qty < $product->stockLimit->notify_quantity)
                                <span class="badge badge-warning">Poco stock</span>
                            @endif
                        </td>
                        <td>
                            @if ($product->stockLimit)
                                {{ $product->qty < $product->stockLimit->notify_quantity ? 'Poco stock' : 'Suficiente stock' }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <button class="btn btn-sm btn-danger delete-product" data-product-id="{{ $product->id }}">Borrar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.delete-product').on('click', function() {
                var productId = $(this).data('product-id');
                if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                    $.ajax({
                        url: 'products/' + productId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('El producto se ha eliminado exitosamente.');
                                location.reload();
                            } else {
                                alert('Hubo un error al eliminar el producto.');
                            }
                        },
                        error: function() {
                            alert('Hubo un error al procesar la solicitud.');
                        }
                    });
                }
            });

            var table = $('#stock-table').DataTable();

            $('#order-by').on('change', function() {
                var selectedValue = $(this).val();
                table.order([]);

                switch(selectedValue) {
                    case 'name':
                        table.order([1, 'asc']).draw();
                        break;
                    case 'lowest-qty':
                        table.order([2, 'asc']).draw();
                        break;
                    case 'highest-qty':
                        table.order([2, 'desc']).draw();
                        break;
                }
            });

            $('#search').on('keyup', function() {
                var searchTerm = $(this).val();
                table.search(searchTerm).draw();
            });

            $('#entries').on('change', function() {
                var entries = $(this).val();
                table.page.len(entries).draw();
            });
        });
    </script>
@endpush

@endsection

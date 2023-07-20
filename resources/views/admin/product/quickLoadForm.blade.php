@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Carga Masiva de Productos</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.products.massStore') }}" method="POST">

                            @csrf

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Descripción</th>
                                        <!-- Agrega más columnas para otros campos si es necesario -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 0; $i < 5; $i++) <!-- Cambia el número de filas según tus necesidades -->
                                        <tr>
                                            <td>
                                                <input type="text" name="products[{{ $i }}][name]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="number" name="products[{{ $i }}][price]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="products[{{ $i }}][description]" class="form-control">
                                            </td>
                                            <!-- Agrega más columnas para otros campos si es necesario -->
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary">Cargar Productos</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1 class="mr-auto">Todos los usuarios</h1>
        <div class="card-header-action text-right">
            <a href="{{ URL::previous() }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
    <div class="">
        <div class="text-right mb-4">
            <button type="button" class="btn btn-primary" id="crearUsuarioBtn">
                Crear Usuario
            </button>
            
        </div>

        <div id="crearUsuarioForm" class="mb-5" style="display: none;">
            <!-- Vista del formulario -->
            <form action="{{ route('users.agregarUsuario') }}" method="POST">

                @csrf

                <div class="form-group row">
                    <div class="col-lg-6 col-md-12">
                        <label for="nombre">Nombre <span class="required-field">*</span></label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <label for="apellido">Apellido <span class="required-field">*</span></label>
                        <input type="text" name="apellido" id="apellido" class="form-control" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6 col-md-12">
                        <label for="empresa">Empresa</label>
                        <input type="text" name="empresa" id="empresa" class="form-control">
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <label for="rut">RUT</label>
                        <input type="text" name="rut" id="rut" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="tipo_usuario">Tipo de usuario <span class="required-field">*</span></label>
                    <select name="tipo_usuario" class="form-control" required>
                        <option value="cliente">Cliente</option>
                        <option value="proveedor">Proveedor</option>
                    </select>
                </div>

                <div class="form-group row">
                    <div class="col-lg-6 col-md-12">
                        <label for="pais">Pais <span class="required-field">*</span></label>
                        <select name="pais" id="pais" class="form-control" required>
                            <option value="uruguay">Uruguay</option>
                            <option value="argentina">Argentina</option>
                            <option value="brasil">Brasil</option>
                            <option value="chile">Chile</option>
                            <option value="paraguay">Paraguay</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <label for="departamento">Departamento/Ciudad</label>
                        <input type="text" name="departamento" id="departamento" class="form-control">
                    </div>
                </div>

                <div class="form-group row">                    
                    <div class="col-lg-6 col-md-12">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control">
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control">
                    </div>
                </div>


                <div class="form-group">
                    <label for="email">Correo Electrónico <span class="required-field">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Agregar Usuario</button>
            </form>
        </div>

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr class="text-center tr-light">
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>País</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo electrónico</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr class="text-center">
                        <td>{{ ucwords($usuario->nombre . ' ' . $usuario->apellido) }}</td>
                        <td>{{ ucwords($usuario->empresa)}}</td>
                        <td>{{ ucwords($usuario->pais)}}</td>
                        <td>{{ ucwords($usuario->direccion) }}</td>
                        <td>{{ $usuario->telefono }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->tipo_usuario }}</td>
                        <td class="@if($usuario->status == 'activo') text-success font-weight-bold @else text-danger font-weight-bold @endif">{{ ucwords($usuario->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        

        
    </div>
</section>

@endsection

@push('scripts')

    <script>
        var crearUsuarioBtn = document.getElementById('crearUsuarioBtn');
        var crearUsuarioForm = document.getElementById('crearUsuarioForm');

        crearUsuarioBtn.addEventListener('click', function() {
            if (crearUsuarioForm.style.display === 'none') {
                crearUsuarioForm.style.display = 'block';
            } else {
                crearUsuarioForm.style.display = 'none';
            }
        });
    </script>

@endpush




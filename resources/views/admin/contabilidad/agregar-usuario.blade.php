@extends('admin.layouts.master')

@section('content')

<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1 class="mr-auto">Crear Usuario</h1>
        <div class="card-header-action text-right">
            <a href="{{ URL::previous() }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
    <div class="">

        <div id="crearUsuarioForm" class="mb-5">
            <!-- Vista del formulario -->
            <form action="{{ route('users.agregarUsuario') }}" method="POST">

                @csrf

                <div class="form-group row">
                    <div class="col-lg-6 col-md-12">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <label for="apellido">Apellido</label>
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

        
    </div>
</section>

@endsection

@extends('admin.layouts.master')

@section('content')
<section class="section">
    <div class="section-header d-flex justify-content-between align-items-center">
        <h1 class="mr-auto">Crear Orden</h1>
        <div class="card-header-action text-right">
            <a href="{{ URL::previous() }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
    <div class="">

        <div id="movimientoForm" class="mb-5">
            <!-- Vista del formulario -->
            <form action="{{ route('admin.contabilidad.crear-orden') }}" method="post">
                @csrf
                <div class="mb-3" role="group" aria-label="Tipo de usuario">
                    <input type="hidden" name="tipoUsuario" id="tipoUsuario" value="registrado"> <!-- Valor predeterminado -->
                    <button type="button" class="btn btn-primary mr-2" id="btnRegistrado">Usuario Registrado</button>
                    <button type="button" class="btn btn-primary" id="btnInvitado">Invitado</button>
                </div>
                
                
                <div class="mb-3" id="campoUsuarioRegistrado">
                    <label for="usuario_id" class="form-label">Nombre del Cliente:</label>
                    <select name="usuario_id" id="usuario_id" class="form-select form-control w-100" required>
                        @foreach($usuarios as $usuarioId => $nombreCompleto)
                            <option value="{{ $usuarioId }}">{{ $nombreCompleto }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3 campos-invitado" style="display: none;">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" id="nombreInvitado">
                </div>
                
                <div class="mb-3 campos-invitado" style="display: none;">
                    <label for="apellido" class="form-label">Apellido:</label>
                    <input type="text" class="form-control" name="apellido" id="apellidoInvitado">
                </div> 
                <div class="mb-3">
                    <label for="concepto" class="form-label">Concepto de la orden:</label>
                    <input type="text" class="form-control" name="concepto" required>
                </div>
                <div class="mb-3">
                    <label for="monto" class="form-label">Monto:</label>
                    <input type="number" class="form-control" name="monto" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <select name="tipo" class="form-select form-control w-100" required>
                        <option value="Cobro">Cobro</option>
                        <option value="Pago">Pago</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="fecha_vencimiento" class="form-label">Vencimiento:</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" class="form-select form-control w-100" required>
                        <option value="Impago">Impago</option>
                        <option value="Pago">Pago</option>
                    </select>
                </div>

                <!-- Nuevo campo para la fecha de pago si el estado es "Pago" -->
                <div class="mb-3" id="campo_fecha_de_pago" style="display: none;">
                    <label for="fecha_de_pago" class="form-label">Fecha de Pago:</label>
                    <input type="date" id="fecha_de_pago" name="fecha_de_pago" class="form-control" value="{{ old('fecha_de_pago', null) }}">
                </div>

                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>

        </div>


    </div>
</section>
@endsection

@push('scripts')

    <script>
        document.getElementById('formularioCrearOrden').addEventListener('submit', function (event) {
            event.preventDefault(); // Evita que el formulario realice la solicitud GET por defecto

            // Obtén los datos del formulario
            const form = event.target;
            const formData = new FormData(form);

            // Realiza una solicitud POST utilizando fetch API
            fetch(form.action, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    // Si la respuesta es exitosa, redirecciona o realiza otras acciones necesarias
                    window.location.href = '{{ route("admin.contabilidad.index") }}'; // Cambia la ruta a la que desees redirigir
                } else {
                    // Manejo de errores si la respuesta no es exitosa
                    console.error('Error al enviar el formulario');
                }
            }).catch(error => {
                console.error('Error al enviar el formulario:', error);
            });
        });
    </script>

    <script>
        // Obtener referencias a los elementos del DOM
        const btnRegistrado = document.getElementById('btnRegistrado');
        const btnInvitado = document.getElementById('btnInvitado');
        const campoUsuarioRegistrado = document.getElementById('campoUsuarioRegistrado');
        const camposUsuarioInvitado = document.getElementsByClassName('campos-invitado');

        // Escuchar eventos click en los botones para cambiar el tipo de usuario
        btnRegistrado.addEventListener('click', () => {
            document.getElementById('tipoUsuario').value = 'registrado';
            campoUsuarioRegistrado.style.display = 'block';
            for (const campo of camposUsuarioInvitado) {
                campo.style.display = 'none';
            }
        });

        btnInvitado.addEventListener('click', () => {
            document.getElementById('tipoUsuario').value = 'invitado';
            campoUsuarioRegistrado.style.display = 'none';
            for (const campo of camposUsuarioInvitado) {
                campo.style.display = 'block';
            }
        });

        // Escuchar cambios en el estado para mostrar/ocultar el campo de fecha de pago
        const estadoSelect = document.getElementById('estado');
        const campoFechaDePago = document.getElementById('campo_fecha_de_pago');

        estadoSelect.addEventListener('change', () => {
            const selectedOption = estadoSelect.options[estadoSelect.selectedIndex].value;
            if (selectedOption === 'Pago') {
                campoFechaDePago.style.display = 'block';
            } else {
                campoFechaDePago.style.display = 'none';
            }
        });
    </script>
    

@endpush

@extends('admin.layouts.master')

@section('content')
    <div id="app">
        <!-- Main Content -->
        <div class="">
            <section class="section">
                <div class="section-header d-flex justify-content-between align-items-center">
                    <h1 class="mr-auto">Módulos</h1>
                </div>
                <div class="container">
                    <div class="row">
                        @foreach ($modulos as $modulo)
                            <div class="col-sm-4 mt-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ str_replace('-', ' ', strtoupper($modulo->module)) }}</h5>
                                        <p class="card-text">{{ $modulo->descripcion }}</p>
                                        <div class="custom-control custom-switch mt-auto">
                                            <input type="checkbox" class="custom-control-input" id="moduleSwitch{{ $modulo->id }}" {{ $modulo->enabled ? 'checked' : '' }} onclick="toggleModule({{ $modulo->id }})">
                                            <label class="custom-control-label" for="moduleSwitch{{ $modulo->id }}">
                                                <span class="{{ $modulo->enabled ? '' : 'text-danger' }}">{{ $modulo->enabled ? 'Activado' : 'Desactivado' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>    
@endsection

@push('scripts')

    // Switch modulos activos
    <script>
        function toggleModule(id) {
            var checkbox = document.getElementById('moduleSwitch' + id);
            var enabled = checkbox.checked ? 1 : 0;

            fetch('{{ route('admin.modulos.update', ['id' => ':id']) }}'.replace(':id', id), {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    id: id,
                    enabled: enabled,
                })
            }).then(response => {
                if (!response.ok) {
                    // Si la respuesta no es ok, deshacemos el cambio en el checkbox
                    checkbox.checked = !checkbox.checked;
                    alert('No se pudo cambiar el estado del módulo.');
                } else {
                    // Recargamos la página para reflejar los cambios
                    location.reload();
                }
            });
        }
    </script>
@endpush

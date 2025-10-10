@extends('layouts.dashboard')

@section('title', 'Editar Cliente - ' . $cliente->nombre)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">
                    <i class="bi bi-person-gear me-2"></i>
                    Editar Cliente
                </h1>
                <p class="text-muted mb-0">Modificar información de {{ $cliente->nombre }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.clientes.show', $cliente) }}" class="btn btn-outline-info">
                    <i class="bi bi-eye me-1"></i> Ver Detalle
                </a>
                <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>

        <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST" id="clienteForm">
            @csrf
            @method('PUT')
            
            <!-- Información Básica -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person me-2"></i>
                        Información Básica
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-8">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">
                                    Nombre Completo <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre', $cliente->nombre) }}" 
                                       required
                                       maxlength="200"
                                       placeholder="Ej: Juan Pérez García">
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-4">
                            <div class="mb-3">
                                <label for="estado" class="form-label">
                                    Estado
                                </label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado">
                                    <option value="activo" {{ old('estado', $cliente->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado', $cliente->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($cliente->estado == 'inactivo')
                                <div class="form-text text-warning">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Este cliente está inactivo
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Contacto -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-envelope me-2"></i>
                        Información de Contacto
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $cliente->email) }}" 
                                           required
                                           maxlength="200"
                                           placeholder="cliente@ejemplo.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">
                                    Teléfono
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input type="tel" 
                                           class="form-control @error('telefono') is-invalid @enderror" 
                                           id="telefono" 
                                           name="telefono" 
                                           value="{{ old('telefono', $cliente->telefono) }}" 
                                           maxlength="20"
                                           placeholder="+57 300 123 4567">
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="direccion" class="form-label">
                                    Dirección
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                              id="direccion" 
                                              name="direccion" 
                                              rows="3"
                                              maxlength="500"
                                              placeholder="Dirección completa del cliente">{{ old('direccion', $cliente->direccion) }}</textarea>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <span id="direccion-count">{{ strlen($cliente->direccion) }}</span> / 500 caracteres
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Información Adicional
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="documento" class="form-label">
                                    Documento de Identidad
                                </label>
                                <input type="text" 
                                       class="form-control @error('documento') is-invalid @enderror" 
                                       id="documento" 
                                       name="documento" 
                                       value="{{ old('documento', $cliente->documento) }}" 
                                       maxlength="20"
                                       placeholder="CC, NIT, etc.">
                                @error('documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label">
                                    Fecha de Nacimiento
                                </label>
                                <input type="date" 
                                       class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                       id="fecha_nacimiento" 
                                       name="fecha_nacimiento" 
                                       value="{{ old('fecha_nacimiento', $cliente->fecha_nacimiento) }}">
                                @error('fecha_nacimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($cliente->fecha_nacimiento)
                                <div class="form-text">
                                    Edad actual: {{ \Carbon\Carbon::parse($cliente->fecha_nacimiento)->age }} años
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="notas" class="form-label">
                                    Notas Adicionales
                                </label>
                                <textarea class="form-control @error('notas') is-invalid @enderror" 
                                          id="notas" 
                                          name="notas" 
                                          rows="3"
                                          maxlength="1000"
                                          placeholder="Información adicional sobre el cliente...">{{ old('notas', $cliente->notas) }}</textarea>
                                @error('notas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <span id="notas-count">{{ strlen($cliente->notas) }}</span> / 1000 caracteres
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información de Registro (Solo lectura) -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Información de Registro
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small">CLIENTE DESDE</label>
                                <div class="fw-medium">{{ format_colombian_date($cliente->created_at, 'j F Y g:i A') }}</div>
                            </div>
                        </div>
                        @if($cliente->updated_at != $cliente->created_at)
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small">ÚLTIMA ACTUALIZACIÓN</label>
                                <div class="fw-medium">{{ format_colombian_date($cliente->updated_at, 'j F Y g:i A') }}</div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label text-muted small">ID DEL CLIENTE</label>
                                <div class="fw-medium">#{{ $cliente->id }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.clientes.show', $cliente) }}" class="btn btn-secondary">
                        <i class="bi bi-x-lg me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary-gold">
                        <i class="bi bi-check-lg me-1"></i> Actualizar Cliente
                    </button>
                </div>
                
                @if($cliente->ventasOnline->count() == 0)
                <button type="button" class="btn btn-outline-danger" onclick="confirmarEliminacion()">
                    <i class="bi bi-trash me-1"></i> Eliminar Cliente
                </button>
                @else
                <div class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i>
                    No se puede eliminar este cliente porque tiene ventas asociadas
                </div>
                @endif
            </div>
        </form>

        @if($cliente->ventasOnline->count() == 0)
        <!-- Formulario de eliminación oculto -->
        <form id="deleteForm" action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
        @endif
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Contador de caracteres para dirección
    $('#direccion').on('input', function() {
        const count = $(this).val().length;
        $('#direccion-count').text(count);
        
        if (count > 450) {
            $('#direccion-count').addClass('text-warning');
        } else if (count > 480) {
            $('#direccion-count').addClass('text-danger').removeClass('text-warning');
        } else {
            $('#direccion-count').removeClass('text-warning text-danger');
        }
    });

    // Contador de caracteres para notas
    $('#notas').on('input', function() {
        const count = $(this).val().length;
        $('#notas-count').text(count);
        
        if (count > 900) {
            $('#notas-count').addClass('text-warning');
        } else if (count > 950) {
            $('#notas-count').addClass('text-danger').removeClass('text-warning');
        } else {
            $('#notas-count').removeClass('text-warning text-danger');
        }
    });

    // Formatear teléfono automáticamente
    $('#telefono').on('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 0 && !value.startsWith('57')) {
            if (value.startsWith('3')) {
                value = '57' + value;
            }
        }
        
        if (value.startsWith('57') && value.length > 2) {
            const formatted = '+57 ' + value.substring(2, 5) + ' ' + value.substring(5, 8) + ' ' + value.substring(8, 12);
            e.target.value = formatted.trim();
        }
    });

    // Trigger inicial para contadores
    $('#direccion').trigger('input');
    $('#notas').trigger('input');
});

// Validación antes de enviar
$('#clienteForm').on('submit', function(e) {
    const email = $('#email').val();
    const nombre = $('#nombre').val();
    
    if (!email || !nombre) {
        e.preventDefault();
        Swal.fire({
            title: 'Campos requeridos',
            text: 'Por favor completa todos los campos obligatorios',
            icon: 'warning',
            confirmButtonColor: '#0d6efd'
        });
        return false;
    }
    
    // Validar formato de email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        Swal.fire({
            title: 'Email inválido',
            text: 'Por favor ingresa un email válido',
            icon: 'warning',
            confirmButtonColor: '#0d6efd'
        });
        return false;
    }
});

// Confirmar eliminación del cliente
function confirmarEliminacion() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer. Se eliminará permanentemente el cliente "{{ $cliente->nombre }}".',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Eliminando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Enviar formulario
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endpush
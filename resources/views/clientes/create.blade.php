@extends('layouts.dashboard')

@section('title', 'Nuevo Cliente')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-person-plus me-2"></i>
                Nuevo Cliente
            </h1>
            <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>

        <form action="{{ route('admin.clientes.store') }}" method="POST" id="clienteForm">
            @csrf
            
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
                                       value="{{ old('nombre') }}" 
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
                                    <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                           value="{{ old('email') }}" 
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
                                           value="{{ old('telefono') }}" 
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
                                              placeholder="Dirección completa del cliente">{{ old('direccion') }}</textarea>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <span id="direccion-count">0</span> / 500 caracteres
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
                                       value="{{ old('documento') }}" 
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
                                       value="{{ old('fecha_nacimiento') }}">
                                @error('fecha_nacimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                          placeholder="Información adicional sobre el cliente...">{{ old('notas') }}</textarea>
                                @error('notas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <span id="notas-count">0</span> / 1000 caracteres
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2 mb-4">
                <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-lg me-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary-gold">
                    <i class="bi bi-check-lg me-1"></i> Crear Cliente
                </button>
            </div>
        </form>
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
</script>
@endpush
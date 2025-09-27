@extends('admin.layout')

@section('title', 'Crear Administrador')
@section('page-title', 'Crear Nuevo Administrador')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.admins') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Volver a administradores
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-user-plus me-2"></i>
                Crear Nuevo Administrador
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.store-admin') }}">
                    @csrf

                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">
                            Nombre Completo <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input id="name" 
                                   type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus
                                   placeholder="Ej: Juan Carlos Pérez">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   placeholder="admin@ejemplo.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Este email se usará para acceder al panel de administración.</small>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">
                            Contraseña <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required
                                   placeholder="Mínimo 8 caracteres">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-bold">
                            Confirmar Contraseña <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input id="password_confirmation" 
                                   type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   required
                                   placeholder="Confirma la contraseña">
                        </div>
                    </div>

                    <!-- Información de permisos -->
                    <div class="alert alert-info d-flex align-items-start">
                        <i class="fas fa-info-circle me-2 mt-1"></i>
                        <div>
                            <strong>Permisos de Administrador</strong><br>
                            <small>
                                Este usuario tendrá acceso completo al panel de administración y podrá:
                            </small>
                            <ul class="small mb-0 mt-1">
                                <li>Ver y gestionar todos los usuarios del sistema</li>
                                <li>Crear y eliminar otros administradores</li>
                                <li>Acceder a todas las funciones administrativas</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.admins') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-admin-primary">
                            <i class="fas fa-user-plus me-1"></i>
                            Crear Administrador
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Información adicional -->
<div class="row justify-content-center mt-4">
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="card-body p-4">
                <h6 class="mb-3">
                    <i class="fas fa-shield-alt text-success me-2"></i>
                    Recomendaciones de Seguridad
                </h6>
                <ul class="small text-muted mb-0">
                    <li class="mb-1">
                        <strong>Contraseña segura:</strong> Usa al menos 8 caracteres con mayúsculas, minúsculas, números y símbolos.
                    </li>
                    <li class="mb-1">
                        <strong>Email único:</strong> Cada administrador debe tener un email único y válido.
                    </li>
                    <li class="mb-1">
                        <strong>Acceso limitado:</strong> Solo crea administradores para personal de confianza.
                    </li>
                    <li>
                        <strong>Revisión periódica:</strong> Revisa regularmente la lista de administradores activos.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
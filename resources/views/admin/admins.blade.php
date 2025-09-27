@extends('admin.layout')

@section('title', 'Gestión de Administradores')
@section('page-title', 'Gestión de Administradores')

@section('content')
<div class="admin-card">
    <div class="admin-card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="fas fa-user-shield me-2"></i>
            Lista de Administradores
        </span>
        <a href="{{ route('admin.create-admin') }}" class="btn btn-light btn-sm">
            <i class="fas fa-plus me-1"></i>
            Nuevo Administrador
        </a>
    </div>
    <div class="card-body p-0">
        @if($admins->count() > 0)
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Administrador</th>
                            <th>Email</th>
                            <th>Fecha de Creación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user-shield text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $admin->name }}</h6>
                                            @if($admin->id === Auth::id())
                                                <small class="text-muted">(Tú)</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <small>{{ $admin->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <span class="status-badge status-admin">Administrador</span>
                                </td>
                                <td>
                                    @if($admin->id !== Auth::id())
                                        <form method="POST" 
                                              action="{{ route('admin.delete-admin', $admin->id) }}" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este administrador?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-admin-danger btn-sm"
                                                    title="Eliminar administrador">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">No disponible</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($admins->hasPages())
                <div class="p-4 border-top">
                    {{ $admins->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-shield text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No hay administradores</h5>
                <p class="text-muted mb-4">Crea el primer administrador para comenzar.</p>
                <a href="{{ route('admin.create-admin') }}" class="btn btn-admin-primary">
                    <i class="fas fa-plus me-1"></i>
                    Crear Administrador
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Información adicional -->
<div class="mt-4">
    <div class="admin-card">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h6 class="mb-2">
                        <i class="fas fa-info-circle text-info me-2"></i>
                        Información sobre Administradores
                    </h6>
                    <p class="text-muted mb-0">
                        Los administradores tienen acceso completo al panel de administración y pueden gestionar todos los usuarios del sistema.
                        Se requiere al menos un administrador en el sistema.
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="text-center">
                            <h4 class="mb-0 text-primary">{{ $admins->total() }}</h4>
                            <small class="text-muted">Total Administradores</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
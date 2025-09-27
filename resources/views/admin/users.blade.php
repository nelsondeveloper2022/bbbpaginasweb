@extends('admin.layout')

@section('title', 'Gestión de Usuarios')
@section('page-title', 'Gestión de Usuarios')

@section('content')
<div class="admin-card">
    <div class="admin-card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="fas fa-users me-2"></i>
            Lista de Usuarios
        </span>
        <span class="badge bg-light text-dark">{{ $users->total() }} usuarios</span>
    </div>
    <div class="card-body p-0">
        <!-- Filtros -->
        <div class="p-4 border-bottom">
            <form method="GET" action="{{ route('admin.users') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Buscar por nombre, email o empresa..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="admin" {{ request('status') == 'admin' ? 'selected' : '' }}>Administradores</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activos</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expirados</option>
                        <option value="with_landing" {{ request('status') == 'with_landing' ? 'selected' : '' }}>Con Landing</option>
                        <option value="without_landing" {{ request('status') == 'without_landing' ? 'selected' : '' }}>Sin Landing</option>
                        <option value="not_configured" {{ request('status') == 'not_configured' ? 'selected' : '' }}>Sin Configurar</option>
                        <option value="construction" {{ request('status') == 'construction' ? 'selected' : '' }}>En Construcción</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicadas</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-admin-primary w-100">
                        <i class="fas fa-search me-1"></i>
                        Filtrar
                    </button>
                </div>
                <div class="col-md-3 text-end">
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabla de usuarios -->
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-admin mb-0">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Empresa</th>
                            <th>Plan</th>
                            <th>Estado</th>
                            <th>Landing</th>
                            <th>URL/Estado</th>
                            <th>Días Restantes</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($user->is_admin)
                                                <i class="fas fa-user-shield text-primary"></i>
                                            @else
                                                <i class="fas fa-user text-muted"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->empresa)
                                        <div>
                                            <strong>{{ $user->empresa->nombre }}</strong><br>
                                            <small class="text-muted">{{ $user->empresa->email }}</small>
                                        </div>
                                    @else
                                        <div>
                                            <strong>{{ $user->empresa_nombre ?? 'No especificada' }}</strong><br>
                                            <small class="text-muted">{{ $user->empresa_email ?? 'No especificado' }}</small>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($user->plan)
                                        <span class="badge bg-info">{{ $user->plan->nombre }}</span>
                                    @else
                                        <span class="text-muted">Sin plan</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = $user->subscription_status;
                                        $statusClass = '';
                                        switch($status) {
                                            case 'Administrador':
                                                $statusClass = 'status-admin';
                                                break;
                                            case 'Activa':
                                                $statusClass = 'status-active';
                                                break;
                                            case 'Trial':
                                                $statusClass = 'status-trial';
                                                break;
                                            case 'Expirada':
                                                $statusClass = 'status-expired';
                                                break;
                                        }
                                    @endphp
                                    <span class="status-badge {{ $statusClass }}">{{ $status }}</span>
                                </td>
                                <td>
                                    @if($user->landings_count > 0)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-globe text-success me-2"></i>
                                            <div>
                                                <small class="fw-bold">{{ $user->landings_count }} landing(s)</small><br>
                                                @php
                                                    $empresaEstado = $user->empresa->estado ?? null;
                                                @endphp
                                                @if($empresaEstado == 'en_construccion')
                                                    <span class="badge bg-warning text-dark">En Construcción</span>
                                                @elseif($empresaEstado == 'publicada')
                                                    <span class="badge bg-success">Publicada</span>
                                                @elseif($empresaEstado == 'sin_configurar' || is_null($empresaEstado))
                                                    <span class="badge bg-secondary">Sin Configurar</span>
                                                @else
                                                    <span class="badge bg-info">{{ ucfirst($empresaEstado) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-minus"></i> Sin landing
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->landings_count > 0 && $user->empresa)
                                        @php
                                            $slug = $user->empresa->slug ?: 'empresa-' . $user->empresa->idEmpresa;
                                            $landingUrl = config('app.url') . '/' . $slug;
                                        @endphp
                                        @if($user->empresa->estado === 'publicada')
                                            <a href="{{ $landingUrl }}" target="_blank" class="btn btn-sm btn-success" title="Ver Landing Publicada">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                Ver Landing
                                            </a>
                                        @elseif($user->empresa->estado === 'en_construccion')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-tools me-1"></i>
                                                En Construcción
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Sin Configurar</span>
                                        @endif
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-minus"></i> Sin Landing
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->days_remaining !== null)
                                        <span class="fw-bold {{ $user->days_remaining <= 7 ? 'text-danger' : ($user->days_remaining <= 30 ? 'text-warning' : 'text-success') }}">
                                            {{ $user->days_remaining }} días
                                        </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.user-detail', $user->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($user->landings_count > 0 && $user->empresa && $user->empresa->estado === 'en_construccion')
                                            <form method="POST" 
                                                  action="{{ route('admin.publish-landing', $user->id) }}" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de publicar esta landing page? Se enviará un email al cliente.')">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-success publish-button" 
                                                        title="Publicar Landing">
                                                    <i class="fas fa-rocket"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($users->hasPages())
                <div class="p-4 border-top">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                <h5 class="mt-3 text-muted">No se encontraron usuarios</h5>
                <p class="text-muted">
                    @if(request()->hasAny(['search', 'status']))
                        No hay usuarios que coincidan con los filtros aplicados.
                    @else
                        No hay usuarios registrados en el sistema.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
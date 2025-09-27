@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Usuarios -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon me-3" style="background: linear-gradient(45deg, #10b981, #059669);">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $totalUsers }}</h3>
                    <p class="text-muted mb-0">Total Usuarios</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Administradores -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon me-3" style="background: linear-gradient(45deg, #d22e23, #b01e1a);">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $totalAdmins }}</h3>
                    <p class="text-muted mb-0">Administradores</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Suscripciones Activas -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon me-3" style="background: linear-gradient(45deg, #2c3e50, #34495e);">
                    <i class="fas fa-crown"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $activeSubscriptions }}</h3>
                    <p class="text-muted mb-0">Suscripciones Activas</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Trials Activos -->
    <div class="col-xl-3 col-md-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon me-3" style="background: linear-gradient(45deg, #f0ac21, #d4941c);">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ $activTrials }}</h3>
                    <p class="text-muted mb-0">Trials Activos</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Acciones Rápidas -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-bolt me-2"></i>
                Acciones Rápidas
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-primary text-start">
                        <i class="fas fa-users me-2"></i>
                        Ver Todos los Usuarios
                    </a>
                    <a href="{{ route('admin.create-admin') }}" class="btn btn-outline-success text-start">
                        <i class="fas fa-user-plus me-2"></i>
                        Crear Nuevo Administrador
                    </a>
                    <a href="{{ route('admin.admins') }}" class="btn btn-outline-info text-start">
                        <i class="fas fa-user-shield me-2"></i>
                        Gestionar Administradores
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen del Sistema -->
    <div class="col-lg-6">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-chart-pie me-2"></i>
                Resumen del Sistema
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-center p-3 border rounded">
                            <h5 class="text-success mb-1">{{ $activeSubscriptions + $activTrials }}</h5>
                            <small class="text-muted">Cuentas Activas</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 border rounded">
                            <h5 class="text-danger mb-1">{{ $totalUsers - $activeSubscriptions - $activTrials }}</h5>
                            <small class="text-muted">Cuentas Expiradas</small>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress mt-3" style="height: 8px;">
                            @php
                                $activePercentage = $totalUsers > 0 ? (($activeSubscriptions + $activTrials) / $totalUsers) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-success" 
                                 style="width: {{ $activePercentage }}%" 
                                 title="{{ round($activePercentage, 1) }}% activos"></div>
                        </div>
                        <small class="text-muted">{{ round($activePercentage, 1) }}% de usuarios activos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Información adicional -->
<div class="row mt-4">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <i class="fas fa-info-circle me-2"></i>
                Información del Sistema
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Versión del Sistema</h6>
                        <p class="mb-0">BBB Páginas Web v2.0</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Laravel</h6>
                        <p class="mb-0">{{ app()->version() }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Última Actualización</h6>
                        <p class="mb-0">{{ now()->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
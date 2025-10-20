@extends('layouts.dashboard')

@section('title', 'Clientes')

@section('content')
    <div class="container-fluid">
    <!-- Header mejorado para móvil -->
    <div class="row mb-4 align-items-center g-3">
        <div class="col-12 col-md-6">
            <h1 class="h3 mb-0">
                <i class="bi bi-people me-2"></i>
                Clientes
            </h1>
        </div>
        <div class="col-12 col-md-6 text-md-end">
            <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary-gold w-100 w-md-auto">
                <i class="bi bi-plus-lg me-1"></i> Nuevo Cliente
            </a>
        </div>
    </div>

    <!-- Estadísticas mejoradas para móvil -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card bg-primary text-white h-100 stat-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-4 fw-bold text-black">{{ $stats['total_clientes'] ?? 0 }}</div>
                            <div class="stat-label text-black">Total Clientes</div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-people text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card bg-success text-white h-100 stat-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-4 fw-bold text-black">{{ $stats['clientes_activos'] ?? 0 }}</div>
                            <div class="stat-label text-black">Activos</div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-person-check text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card bg-info text-white h-100 stat-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-4 fw-bold text-black">{{ $stats['clientes_con_ventas'] ?? 0 }}</div>
                            <div class="stat-label text-black">Con Ventas</div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-cart-check text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-6 col-xl-3">
            <div class="card bg-warning text-white h-100 stat-card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fs-4 fw-bold text-black">{{ $stats['nuevos_este_mes'] ?? 0 }}</div>
                            <div class="stat-label text-black">Nuevos Este Mes</div>
                        </div>
                        <div class="stat-icon">
                            <i class="bi bi-person-plus text-black"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros mejorados para móvil -->
    <div class="card mb-4 filter-card">
        <div class="card-header bg-light">
            <h6 class="mb-0">
                <i class="bi bi-funnel me-2"></i>
                Filtros de Búsqueda
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-12 col-md-6 col-lg-4">
                    <label for="search" class="form-label fw-bold">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nombre, email, teléfono...">
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <label for="estado" class="form-label fw-bold">
                            <i class="bi bi-toggle-on me-1"></i>
                            Estado
                        </label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="">Todos</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2">
                        <label for="con_ventas" class="form-label fw-bold">
                            <i class="bi bi-cart me-1"></i>
                            Ventas
                        </label>
                        <select class="form-select" id="con_ventas" name="con_ventas">
                            <option value="">Todos</option>
                            <option value="1" {{ request('con_ventas') == '1' ? 'selected' : '' }}>Con ventas</option>
                            <option value="0" {{ request('con_ventas') == '0' ? 'selected' : '' }}>Sin ventas</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4">
                        <label class="form-label d-none d-lg-block">&nbsp;</label>
                        <div class="d-flex gap-2 flex-column flex-sm-row">
                            <button type="submit" class="btn btn-primary flex-fill flex-sm-grow-0">
                                <i class="bi bi-search me-1"></i> Filtrar
                            </button>
                            <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary flex-fill flex-sm-grow-0">
                                <i class="bi bi-x-lg me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Clientes -->
        <div class="card">
            <div class="card-body p-0 p-md-3">
                <!-- Vista de escritorio - Tabla normal -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0" id="clientesTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%"></th>
                                <th>Cliente</th>
                                <th>Contacto</th>
                                <th class="text-center">Ventas</th>
                                <th class="text-end">Total Comprado</th>
                                <th class="text-center">Estado</th>
                                <th>Registrado</th>
                                <th class="text-center" width="150">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se cargarán via AJAX -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Vista móvil - Tarjetas verticales -->
                <div id="clientesMobileView" style="display: none;">
                    <!-- Las tarjetas se generan dinámicamente -->
                </div>
                
                <!-- Estado vacío si no hay datos -->
                <div id="empty-state" class="text-center" style="display: none;">
                    <i class="bi bi-people text-muted mb-3" style="font-size: 3.5rem;"></i>
                    <h5 class="text-muted mb-3">No hay clientes registrados</h5>
                    <p class="text-muted mb-4">Comienza agregando tu primer cliente para gestionar tu base de datos</p>
                <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary-gold btn-lg">
                    <i class="bi bi-plus-circle me-2"></i> Crear Primer Cliente
                </a>
            </div>
        </div>
    </div>
    </div><!-- Cierre de container-fluid -->
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Clientes Index - Mobile Optimized - Version 4.0 */
    
    /* CRÍTICO: Eliminar padding del content-area para que container-fluid funcione */
    .content-area {
        padding: 0 !important;
    }
    
    /* Agregar el padding solo al container-fluid para controlar el espacio */
    .container-fluid {
        padding: 2rem 1.5rem !important;
    }
    
    /* CRÍTICO: Forzar que la tabla ocupe todo el ancho disponible */
    #clientesTable {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    #clientesTable_wrapper {
        width: 100% !important;
    }
    
    .table-responsive {
        width: 100% !important;
    }
    
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem !important;
        }
    }
    
    /* Mejoras generales para la tabla */
    .table th {
        background: linear-gradient(135deg, #2c3e50, #34495e) !important;
        color: white !important;
        border: none !important;
        font-weight: 600 !important;
        font-size: 0.9rem !important;
        padding: 1rem 0.75rem !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table tbody tr {
        background: white !important;
        border-bottom: 1px solid #e9ecef !important;
    }
    
    .table tbody tr:hover {
        background: #f8f9fa !important;
        transform: scale(1.005);
        transition: all 0.2s ease;
    }
    
    /* Texto en negro para mejor legibilidad - IMPORTANTE */
    .table tbody td {
        color: #212529 !important;
        vertical-align: middle !important;
        padding: 1rem 0.75rem !important;
        font-size: 0.9rem !important;
    }
    
    .table tbody td strong {
        color: #000 !important;
        font-weight: 700 !important;
    }
    
    .table tbody td small {
        color: #6c757d !important;
        font-size: 0.8rem !important;
    }
    
    /* Mejoras de botones en columna */
    .d-flex.flex-column .btn {
        white-space: nowrap;
        transition: all 0.2s;
    }
    
    .d-flex.flex-column .btn:hover {
        transform: translateX(2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    /* Estilos mejorados para estadísticas en móvil */
    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.25);
    }
    
    .stat-label {
        font-size: 0.85rem;
        opacity: 0.95;
        font-weight: 500;
    }
    
    .stat-icon {
        font-size: 2rem;
        opacity: 0.3;
    }
    
    /* Mejoras para filtros */
    .filter-card .card-header {
        border-bottom: 2px solid #dee2e6;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
    }
    
    .filter-card .card-header h6 {
        color: #2c3e50;
        font-weight: 700;
    }
    
    .filter-card .form-label {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        color: #2c3e50;
        font-weight: 600;
    }
    
    .filter-card .form-control,
    .filter-card .form-select {
        border: 1px solid #dee2e6;
        color: #212529;
        background: white;
    }
    
    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    /* Card header de tabla */
    .card-header h5 {
        color: #2c3e50 !important;
        font-weight: 700;
    }
    
    .card-header .badge {
        font-weight: 600;
    }
    
    /* Responsive para móviles */
    @media (max-width: 768px) {
        /* Ajustar tamaño de título en móvil */
        h1.h3 {
            font-size: 1.5rem !important;
            color: #2c3e50;
        }
        
        /* Estadísticas más compactas */
        .stat-card .card-body {
            padding: 0.75rem !important;
        }
        
        .stat-card .fs-4 {
            font-size: 1.5rem !important;
            font-weight: 700;
        }
        
        .stat-label {
            font-size: 0.75rem !important;
            font-weight: 600;
        }
        
        .stat-icon {
            font-size: 1.5rem !important;
        }
        
        /* Filtros más espaciados en móvil */
        .filter-card .form-label {
            font-size: 0.85rem;
            color: #2c3e50;
            font-weight: 600;
        }
        
        .filter-card .card-body {
            padding: 1rem;
        }
        
        /* Botones de acción más grandes en móvil */
        .btn-sm {
            font-size: 0.875rem !important;
            padding: 0.5rem 0.75rem !important;
            font-weight: 600;
        }
        
        /* Mejorar legibilidad de la tabla */
        #clientesTable {
            font-size: 0.85rem;
        }
        
        #clientesTable tbody td {
            color: #212529 !important;
        }
        
        /* Ajustar padding de celdas */
        #clientesTable td {
            padding: 0.75rem 0.5rem !important;
        }
        
        /* Hacer que los botones de acciones sean más accesibles */
        .d-flex.flex-column .btn {
            width: 100%;
            margin-bottom: 0.25rem;
        }
        
        /* Mejorar controles de DataTable */
        .dataTables_length,
        .dataTables_filter {
            margin-bottom: 1rem;
        }
        
        .dataTables_length label,
        .dataTables_filter label {
            color: #2c3e50;
            font-weight: 600;
        }
        
        .dataTables_length select,
        .dataTables_filter input {
            width: 100% !important;
            margin-top: 0.5rem;
            color: #212529;
            border: 1px solid #dee2e6;
        }
        
        /* Paginación más grande en móvil */
        .dataTables_paginate .pagination {
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .dataTables_paginate .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            color: #2c3e50;
            font-weight: 600;
        }
        
        .dataTables_paginate .page-link:hover {
            background-color: #667eea;
            color: white;
        }
        
        /* Info de DataTable centrada */
        .dataTables_info {
            text-align: center;
            font-size: 0.85rem;
            padding: 0.5rem 0;
            color: #2c3e50;
            font-weight: 500;
        }
    }
    
    /* Responsive para pantallas extra pequeñas */
    @media (max-width: 576px) {
        /* Hacer las estadísticas aún más compactas */
        .stat-card .fs-4 {
            font-size: 1.25rem !important;
        }
        
        .stat-label {
            font-size: 0.7rem !important;
        }
        
        .stat-icon {
            font-size: 1.25rem !important;
        }
        
        /* Stack completo para filtros */
        .filter-card .row > div {
            margin-bottom: 0.5rem;
        }
        
        /* Botón de nuevo cliente más prominente */
        .btn-primary-gold {
            padding: 0.75rem 1rem;
            font-weight: 600;
        }
        
        /* Ajustar el wrapper de DataTable */
        .dataTables_wrapper {
            overflow-x: auto;
        }
    }
    
    /* Mejoras para modo responsive de DataTables */
    table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control:before {
        background-color: #667eea;
        border: 2px solid #667eea;
        box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
    }
    
    table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed > tbody > tr.parent > th.dtr-control:before {
        background-color: #dc3545;
        border: 2px solid #dc3545;
    }
    
    /* Mejorar el diseño de filas expandidas en móvil */
    table.dataTable > tbody > tr.child {
        background: #f8f9fa;
    }
    
    table.dataTable > tbody > tr.child ul.dtr-details {
        display: block;
        padding-left: 0;
        margin: 0;
    }
    
    table.dataTable > tbody > tr.child ul.dtr-details > li {
        border-bottom: 1px solid #e9ecef;
        padding: 0.75rem 0.5rem;
    }
    
    table.dataTable > tbody > tr.child ul.dtr-details > li:last-child {
        border-bottom: none;
    }
    
    table.dataTable > tbody > tr.child span.dtr-title {
        display: inline-block;
        font-weight: 700;
        min-width: 100px;
        color: #2c3e50;
    }
    
    table.dataTable > tbody > tr.child span.dtr-data {
        display: inline-block;
        color: #495057;
    }
    
    /* Botones de acción mejorados en móvil */
    .action-buttons .btn-group {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .action-buttons .btn-group .btn {
        border-radius: 0 !important;
        border: none;
        padding: 0.5rem 0.75rem;
    }
    
    .action-buttons .btn-group .btn:not(:last-child) {
        border-right: 1px solid rgba(255,255,255,0.3);
    }
    
    /* Mejorar apariencia de badges en móvil */
    @media (max-width: 768px) {
        .badge {
            padding: 0.5em 0.75em;
        }
    }
    
    /* Animación suave al cargar datos */
    #clientesTable tbody tr {
        animation: fadeInRow 0.3s ease-in;
    }
    
    @keyframes fadeInRow {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Mejorar el estado de carga */
    .dataTables_processing {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9)) !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 1.5rem 2rem !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
    }
    
    /* Mejorar hover en filas */
    #clientesTable tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.05) !important;
        cursor: pointer;
    }
    
    #clientesTable tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }
    
    /* Enlaces mejorados */
    #clientesTable a {
        font-weight: 500;
        transition: all 0.2s;
    }
    
    #clientesTable a:hover {
        text-decoration: underline !important;
        opacity: 0.8;
    }
    
    /* Estado vacío mejorado */
    #empty-state {
        padding: 3rem 1rem !important;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border-radius: 12px;
        margin-top: 2rem;
    }
    
    #empty-state i {
        animation: float 3s ease-in-out infinite;
        color: #6c757d;
    }
    
    #empty-state h5 {
        color: #2c3e50;
        font-weight: 600;
    }
    
    #empty-state p {
        color: #6c757d;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    /* Mejorar experiencia táctil en móvil */
    @media (max-width: 768px) {
        /* Hacer elementos clicables más grandes para táctil */
        .action-buttons .btn {
            min-height: 44px;
            min-width: 44px;
        }
        
        /* Mejorar espaciado de enlaces */
        a[href^="tel:"],
        a[href^="mailto:"] {
            display: inline-block;
            padding: 0.25rem 0;
            min-height: 30px;
        }
        
        /* Botón nuevo cliente sticky en móvil */
        .sticky-mobile-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            border-radius: 50px;
            padding: 1rem 1.5rem;
            font-weight: 600;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            }
            50% {
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            }
        }
        
        /* Mejorar selectores de DataTables en móvil */
        .dataTables_length select {
            min-height: 44px;
            font-size: 1rem;
        }
        
        .dataTables_filter input {
            min-height: 44px;
            font-size: 1rem;
        }
        
        /* Card header más compacto en móvil */
        .card-header h5 {
            font-size: 1rem;
        }
        
        .card-header .badge {
            font-size: 0.75rem;
        }
    }
    
    /* Touch feedback para botones */
    .btn:active {
        transform: scale(0.95);
    }
    
    /* Mejorar legibilidad de texto en pantallas pequeñas */
    @media (max-width: 576px) {
        body {
            font-size: 14px;
        }
        
        .table {
            font-size: 0.85rem;
        }
        
        small, .small {
            font-size: 0.8rem;
        }
    }
    
    /* Vista de tarjetas para móvil - Clientes */
    .cliente-card-mobile {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .cliente-card-mobile:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }
    
    .cliente-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e9ecef;
    }
    
    .cliente-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }
    
    .cliente-card-title {
        flex: 1;
        min-width: 0;
    }
    
    .cliente-card-title h6 {
        margin: 0 0 4px 0;
        font-size: 1.05rem;
        font-weight: 600;
        color: #212529;
        line-height: 1.3;
        word-wrap: break-word;
    }
    
    .cliente-card-title .text-muted {
        font-size: 0.85rem;
        margin: 0;
    }
    
    .cliente-card-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 14px;
    }
    
    .cliente-info-item {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
        border-left: 3px solid #667eea;
    }
    
    .cliente-info-item label {
        display: block;
        font-size: 0.7rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 4px;
        letter-spacing: 0.5px;
    }
    
    .cliente-info-item .value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #212529;
        word-wrap: break-word;
    }
    
    .cliente-info-item .value.highlight {
        color: #28a745;
        font-size: 1.1rem;
    }
    
    .cliente-info-item .value a {
        color: #667eea;
        text-decoration: none;
        word-break: break-all;
    }
    
    .cliente-info-item .value a:hover {
        text-decoration: underline;
    }
    
    .cliente-info-full {
        grid-column: 1 / -1;
    }
    
    .cliente-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 8px;
    }
    
    .cliente-card-actions .btn {
        font-size: 0.8rem;
        padding: 8px 10px;
        white-space: nowrap;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }
    
    .cliente-card-actions .btn i {
        font-size: 0.85rem;
    }
    
    /* Responsive para tarjetas móviles */
    @media (max-width: 767px) {
        /* Ocultar tabla en móvil */
        .table-responsive {
            display: none !important;
        }
        
        /* Mostrar vista de tarjetas */
        #clientesMobileView {
            display: block !important;
        }
        
        .cliente-card-actions .btn {
            font-size: 0.75rem;
            padding: 6px 8px;
        }
        
        .cliente-avatar {
            width: 45px;
            height: 45px;
            font-size: 1.1rem;
        }
    }
    
    @media (min-width: 768px) {
        /* Ocultar vista móvil en desktop */
        #clientesMobileView {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Función para obtener iniciales del nombre
    function getIniciales(nombre) {
        if (!nombre) return '??';
        const palabras = nombre.trim().split(' ');
        if (palabras.length >= 2) {
            return (palabras[0][0] + palabras[1][0]).toUpperCase();
        }
        return nombre.substring(0, 2).toUpperCase();
    }
    
    // Función para crear tarjeta de cliente
    function createClienteCard(cliente) {
        // Avatar con iniciales
        const iniciales = getIniciales(cliente.nombre);
        
        // Estado badge
        const estadoBadge = cliente.estado === 'activo' 
            ? '<span class="badge bg-success">Activo</span>'
            : '<span class="badge bg-secondary">Inactivo</span>';
        
        // Formatear contacto
        const telefonoHtml = cliente.telefono 
            ? `<a href="tel:${cliente.telefono}">${cliente.telefono}</a>`
            : '<span class="text-muted">-</span>';
            
        const emailHtml = cliente.email 
            ? `<a href="mailto:${cliente.email}">${cliente.email}</a>`
            : '<span class="text-muted">-</span>';
        
        // Información de ventas
        const ventasCount = cliente.ventas_count || 0;
        const totalComprado = cliente.total_comprado_formateado || '$0';
        
        return $(`
            <div class="cliente-card-mobile">
                <div class="cliente-card-header">
                    <div class="cliente-avatar">
                        ${iniciales}
                    </div>
                    <div class="cliente-card-title">
                        <h6>${cliente.nombre}</h6>
                        <small class="text-muted">${cliente.documento || 'Sin documento'}</small>
                        <div class="mt-1">${estadoBadge}</div>
                    </div>
                </div>
                
                <div class="cliente-card-info">
                    <div class="cliente-info-item">
                        <label><i class="bi bi-telephone me-1"></i> Teléfono</label>
                        <div class="value">${telefonoHtml}</div>
                    </div>
                    <div class="cliente-info-item">
                        <label><i class="bi bi-cart-check me-1"></i> Ventas</label>
                        <div class="value">${ventasCount}</div>
                    </div>
                    <div class="cliente-info-item cliente-info-full">
                        <label><i class="bi bi-envelope me-1"></i> Email</label>
                        <div class="value">${emailHtml}</div>
                    </div>
                    <div class="cliente-info-item">
                        <label><i class="bi bi-cash-stack me-1"></i> Total</label>
                        <div class="value highlight">${totalComprado}</div>
                    </div>
                    <div class="cliente-info-item">
                        <label><i class="bi bi-calendar me-1"></i> Registro</label>
                        <div class="value">${cliente.created_at_formateado || '-'}</div>
                    </div>
                </div>
                
                <div class="cliente-card-actions">
                    <button type="button" 
                            class="btn btn-info btn-sm" 
                            onclick="window.location.href='/admin/clientes/${cliente.idCliente}'">
                        <i class="bi bi-eye"></i> Ver
                    </button>
                    <button type="button" 
                            class="btn btn-warning btn-sm" 
                            onclick="window.location.href='/admin/clientes/${cliente.idCliente}/edit'">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                    <button type="button" 
                            class="btn btn-danger btn-sm" 
                            onclick="eliminarCliente(${cliente.idCliente}, '${cliente.nombre.replace(/'/g, "\\'")}')">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>
            </div>
        `);
    }
    
    // Inicializar DataTable con mejoras para móvil
    var table = $('#clientesTable').DataTable({
        processing: true,
        serverSide: false,
        autoWidth: false, // CRÍTICO: Desactivar cálculo automático de ancho
        responsive: {
            details: {
                type: 'column',
                target: 0,
                renderer: function (api, rowIdx, columns) {
                    var data = $.map(columns, function (col, i) {
                        return col.hidden ?
                            '<div class="row mb-2">' +
                                '<div class="col-5"><strong>' + col.title + ':</strong></div>' +
                                '<div class="col-7">' + col.data + '</div>' +
                            '</div>' :
                            '';
                    }).join('');
                    
                    return data ? 
                        '<div class="p-3 bg-light rounded">' + data + '</div>' : 
                        false;
                }
            }
        },
        ajax: {
            url: '{{ route("admin.clientes.data") }}',
            data: function(d) {
                d.buscar = $('#search').val();
                d.estado = $('#filter-estado').val();
                d.con_ventas = $('#filter-ventas').val();
            }
        },
        columns: [
            {
                className: 'dtr-control',
                orderable: false,
                data: null,
                defaultContent: '',
                width: '5%'
            },
            {
                data: null,
                name: 'cliente',
                orderable: false,
                render: function(data, type, row) {
                    let direccion = row.direccion ? `<br><small class="text-muted d-none d-md-inline">${row.direccion.substring(0, 30)}${row.direccion.length > 30 ? '...' : ''}</small>` : '';
                    return `
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-gold rounded-circle me-2 me-md-3 d-flex align-items-center justify-content-center" 
                                 style="width: 35px; height: 35px; min-width: 35px;">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                            <div>
                                <strong class="d-block text-dark">${row.nombre}</strong>
                                ${direccion}
                            </div>
                        </div>
                    `;
                }
            },
            {
                data: null,
                name: 'contacto',
                responsivePriority: 3,
                render: function(data, type, row) {
                    let telefono = row.telefono && row.telefono !== '-' ? 
                        `<br><a href="tel:${row.telefono}" class="text-decoration-none text-success fw-semibold"><i class="bi bi-telephone-fill me-1"></i><span class="d-none d-lg-inline">${row.telefono}</span><span class="d-lg-none">${row.telefono.substring(0, 10)}...</span></a>` : '';
                    return `
                        <div>
                            <a href="mailto:${row.email}" class="text-decoration-none text-primary fw-semibold d-block mb-1">
                                <i class="bi bi-envelope-fill me-1"></i><span class="text-dark">${row.email}</span>
                            </a>
                            ${telefono}
                        </div>
                    `;
                }
            },
            {
                data: 'ventas_count',
                name: 'ventas',
                responsivePriority: 4,
                className: 'text-center',
                render: function(data, type, row) {
                    let badgeClass = data > 0 ? 'bg-success' : 'bg-secondary';
                    return `<span class="badge ${badgeClass} fs-6 fw-semibold">${data}</span>`;
                }
            },
            {
                data: 'total_ventas',
                name: 'total',
                responsivePriority: 5,
                className: 'text-end',
                render: function(data, type, row) {
                    return `<strong class="text-success fs-6">${data}</strong>`;
                }
            },
            {
                data: 'estado_badge',
                name: 'estado',
                responsivePriority: 6,
                orderable: false,
                className: 'text-center'
            },
            {
                data: 'created_at',
                name: 'fecha',
                responsivePriority: 7,
                className: 'text-muted'
            },
            {
                data: null,
                name: 'acciones',
                orderable: false,
                searchable: false,
                responsivePriority: 1,
                className: 'text-center action-buttons',
                width: '140px',
                render: function(data, type, row) {
                    let hasVentas = row.ventas_count > 0;
                    
                    // Para móvil: botones más compactos en dropdown
                    let mobileActions = `
                        <div class="d-md-none">
                            <div class="btn-group" role="group">
                                <a href="/admin/clientes/${row.idCliente}" 
                                   class="btn btn-sm btn-info" 
                                   title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="/admin/clientes/${row.idCliente}/edit" 
                                   class="btn btn-sm btn-warning" 
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>`;
                    
                    if (!hasVentas) {
                        mobileActions += `
                                <button type="button" 
                                        class="btn btn-sm btn-danger" 
                                        title="Eliminar"
                                        onclick="eliminarCliente(${row.idCliente}, '${row.nombre.replace(/'/g, "\\'")}')">
                                    <i class="bi bi-trash"></i>
                                </button>`;
                    }
                    
                    mobileActions += `
                            </div>
                        </div>`;
                    
                    // Para desktop: botones apilados como antes
                    let desktopActions = '<div class="d-none d-md-block"><div class="d-flex flex-column gap-1">';
                    
                    desktopActions += `
                        <a href="/admin/clientes/${row.idCliente}" 
                           class="btn btn-info btn-sm" 
                           title="Ver detalles"
                           data-bs-toggle="tooltip">
                            <i class="bi bi-eye me-1"></i> Ver
                        </a>`;
                    
                    desktopActions += `
                        <a href="/admin/clientes/${row.idCliente}/edit" 
                           class="btn btn-warning btn-sm" 
                           title="Editar cliente"
                           data-bs-toggle="tooltip">
                            <i class="bi bi-pencil-square me-1"></i> Editar
                        </a>`;
                    
                    if (!hasVentas) {
                        desktopActions += `
                            <button type="button" 
                                    class="btn btn-danger btn-sm" 
                                    title="Eliminar cliente"
                                    data-bs-toggle="tooltip"
                                    onclick="eliminarCliente(${row.idCliente}, '${row.nombre.replace(/'/g, "\\'")}')">
                                <i class="bi bi-trash-fill me-1"></i> Eliminar
                            </button>`;
                    } else {
                        desktopActions += `
                            <button type="button" 
                                    class="btn btn-secondary btn-sm disabled" 
                                    title="Tiene ventas asociadas"
                                    data-bs-toggle="tooltip"
                                    disabled>
                                <i class="bi bi-shield-lock me-1"></i> Protegido
                            </button>`;
                    }
                    
                    desktopActions += '</div></div>';
                    
                    return mobileActions + desktopActions;
                }
            }
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay datos disponibles en la tabla",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
            "infoFiltered": "(filtrado de _MAX_ entradas totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros coincidentes",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar para ordenar la columna de manera ascendente",
                "sortDescending": ": activar para ordenar la columna de manera descendente"
            }
        },
        order: [[1, 'asc']], // Ordenar por nombre (columna 1 es cliente)
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        drawCallback: function(settings) {
            // Forzar estilos en las celdas de la tabla
            $('#clientesTable tbody tr').each(function() {
                $(this).css({
                    'background': 'white',
                    'color': '#212529'
                });
                
                $(this).find('td').css({
                    'color': '#212529',
                    'font-weight': '500'
                });
                
                $(this).find('strong').css({
                    'color': '#000',
                    'font-weight': '700'
                });
                
                $(this).find('small').css({
                    'color': '#6c757d'
                });
            });
            
            // Generar vista móvil
            if (table) {
                const data = table.rows().data();
                const mobileView = $('#clientesMobileView');
                mobileView.empty();
                
                if (data.length > 0) {
                    data.each(function(cliente) {
                        const card = createClienteCard(cliente);
                        mobileView.append(card);
                    });
                }
            }
            
            // Inicializar tooltips después de cada recarga de la tabla
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Actualizar badge con total de clientes
            var totalRecords = settings.json ? settings.json.recordsTotal : 0;
            $('#total-clientes-badge').text(totalRecords + ' cliente' + (totalRecords !== 1 ? 's' : ''));
            
            // Mostrar/ocultar estado vacío
            if (settings.json && settings.json.data.length === 0) {
                $('#empty-state').show();
                $('#clientesTable_wrapper').hide();
                $('#clientesMobileView').hide();
            } else {
                $('#empty-state').hide();
                $('#clientesTable_wrapper').show();  
            }
        }
    });
    
    // Aplicar filtros
    $('#search').on('keyup', function() {
        table.ajax.reload();
    });
    
    $('#filter-estado').on('change', function() {
        table.ajax.reload();
    });
    
    $('#filter-ventas').on('change', function() {
        table.ajax.reload();
    });
});

function eliminarCliente(clienteId, nombre) {
    Swal.fire({
        title: '¿Eliminar cliente?',
        html: `
            <div class="text-center">
                <i class="bi bi-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                <p class="mb-3">¿Estás seguro de que deseas eliminar el cliente:</p>
                <p class="fw-bold text-primary-gold">${nombre}</p>
                <p class="text-muted small">Esta acción no se puede deshacer</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-trash me-1"></i> Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d'
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
            
            $.ajax({
                url: `/admin/clientes/${clienteId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: 'El cliente ha sido eliminado exitosamente.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    
                    // Recargar tabla
                    $('#clientesTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    let message = 'Error al eliminar el cliente';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        title: 'Error',
                        text: message,
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }
    });
}
</script>
@endpush
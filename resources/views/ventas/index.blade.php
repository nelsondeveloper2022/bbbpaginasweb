@extends('layouts.dashboard')

@section('title', 'Ventas Online')

@section('content')
<div class="container-fluid">
    <!-- Header responsive -->
    <div class="row align-items-center mb-4 g-3">
        <div class="col-12 col-md-auto flex-md-grow-1">
            <h1 class="h3 mb-0">
                <i class="bi bi-cart-check me-2"></i>
                <span class="d-none d-sm-inline">Gestión de Ventas Online</span>
                <span class="d-inline d-sm-none">Ventas</span>
            </h1>
        </div>
        <div class="col-12 col-md-auto">
            <a href="{{ route('admin.ventas.create') }}" class="btn btn-primary-gold">
                <i class="bi bi-plus me-1"></i>
                <span>Nueva Venta</span>
            </a>
        </div>
    </div>

<!-- Estadísticas -->
<div class="row mb-4">
    <div class="col-6 col-md-6 col-xl-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center stats-card-body">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-success bg-opacity-10 rounded-circle stats-icon-container">
                        <i class="bi bi-graph-up text-success stats-icon"></i>
                    </div>
                </div>
                <h3 class="text-success mb-1 fw-bold stats-number">{{ $stats['total_ventas'] }}</h3>
                <p class="text-muted mb-0 stats-label">Total Ventas</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center stats-card-body">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-primary bg-opacity-10 rounded-circle stats-icon-container">
                        <i class="bi bi-check-circle text-primary stats-icon"></i>
                    </div>
                </div>
                <h3 class="text-primary mb-1 fw-bold stats-number">{{ $stats['ventas_completadas'] }}</h3>
                <p class="text-muted mb-0 stats-label">Completadas</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center stats-card-body">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-warning bg-opacity-10 rounded-circle stats-icon-container">
                        <i class="bi bi-clock text-warning stats-icon"></i>
                    </div>
                </div>
                <h3 class="text-warning mb-1 fw-bold stats-number">{{ $stats['ventas_pendientes'] }}</h3>
                <p class="text-muted mb-0 stats-label">Pendientes</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6 col-xl-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center stats-card-body">
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <div class="bg-success bg-opacity-10 rounded-circle stats-icon-container">
                        <i class="bi bi-currency-dollar text-success stats-icon"></i>
                    </div>
                </div>
                <h3 class="text-success mb-1 fw-bold stats-number">${{ number_format($stats['ingresos_totales'], 0, ',', '.') }}</h3>
                <p class="text-muted mb-0 stats-label">Ingresos Totales</p>
            </div>
        </div>
    </div>
</div>

    <!-- Filtros responsive -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>
                Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg-3">
                    <label for="buscar" class="form-label">Buscar Venta</label>
                    <input type="text" 
                           class="form-control" 
                           id="buscar" 
                           placeholder="Cliente, ID, observaciones...">
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <label for="estado_filter" class="form-label">Estado</label>
                    <select class="form-select" id="estado_filter">
                        <option value="">Todos los estados</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="procesando">Procesando</option>
                        <option value="completada">Completada</option>
                        <option value="cancelada">Cancelada</option>
                    </select>
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <label for="fecha_desde" class="form-label">Desde</label>
                    <input type="date" class="form-control" id="fecha_desde">
                </div>
                <div class="col-6 col-md-3 col-lg-2">
                    <label for="fecha_hasta" class="form-label">Hasta</label>
                    <input type="date" class="form-control" id="fecha_hasta">
                </div>
                <div class="col-6 col-md-6 col-lg-2">
                    <label class="form-label d-none d-lg-block">&nbsp;</label>
                    <label class="form-label d-block d-lg-none">Acción</label>
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary-gold" onclick="filtrarVentas()">
                            <i class="bi bi-search me-1"></i>
                            Buscar
                        </button>
                    </div>
                </div>
                <div class="col-6 col-md-6 col-lg-1">
                    <label class="form-label d-none d-lg-block">&nbsp;</label>
                    <label class="form-label d-block d-lg-none">Limpiar</label>
                    <div class="d-grid">
                        <button type="button" class="btn btn-outline-secondary" onclick="limpiarFiltros()">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable responsive -->
    <div class="card">
        <div class="card-body p-0 p-md-3">
            <!-- Vista de escritorio - Tabla normal -->
            <div class="table-responsive">
                <table id="ventasTable" class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="80">ID</th>
                            <th>Cliente</th>
                            <th width="120">Fecha</th>
                            <th>Productos</th>
                            <th width="120">Total</th>
                            <th width="100">Estado</th>
                            <th width="120">Método Pago</th>
                            <th width="140" class="actions-header">Acciones</th>
                        </tr>
                    </thead>
                    <tbody style="background: white;">
                        <!-- Los datos se cargan vía AJAX -->
                    </tbody>
                </table>
            </div>
            
            <!-- Vista móvil - Tarjetas verticales -->
            <div id="ventasMobileView" style="display: none;">
                <!-- Las tarjetas se generan dinámicamente -->
            </div>
            
            <!-- Controles de paginación y información (compartidos) -->
            <div id="datatableControls" class="mt-3"></div>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

<style>
    /* Estilos generales de tarjetas */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }

    /* Estilos de tabla */
    .table {
        background: white;
        width: 100% !important;
    }
    
    .dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody table {
        width: 100% !important;
    }
    
    .dataTables_wrapper .dataTables_scrollHead table {
        width: 100% !important;
    }
    
    .dataTables_scrollHeadInner {
        width: 100% !important;
    }
    
    .dataTables_scrollHeadInner table {
        width: 100% !important;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #2c3e50, #34495e) !important;
        color: white !important;
        border: none !important;
        font-weight: 600 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.8rem;
        padding: 12px 8px !important;
        white-space: nowrap;
    }
    
    .table tbody {
        background: white !important;
    }
    
    .table tbody td {
        color: #212529 !important;
        font-weight: 500;
        vertical-align: middle;
        padding: 10px 8px !important;
    }
    
    .table tbody td strong {
        color: #000 !important;
        font-weight: 700 !important;
    }
    
    .table tbody td small {
        color: #6c757d !important;
        font-weight: 400;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,0.02) !important;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
    }

    /* Columna de acciones */
    .actions-column {
        min-width: 140px !important;
        width: 140px !important;
        max-width: 140px !important;
        background: white !important;
    }
    
    .actions-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
        align-items: center;
        justify-content: center;
        padding: 8px 4px;
    }
    
    .action-btn {
        width: 110px;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-size: 0.75rem;
        padding: 5px 10px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
    }
    
    .action-btn:hover {
        transform: translateX(3px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
    }
    
    .action-btn i {
        font-size: 0.75rem;
    }
    
    .actions-header {
        text-align: center !important;
        min-width: 140px !important;
        width: 140px !important;
        max-width: 140px !important;
    }

    /* DataTables responsive */
    .dataTables_wrapper .dataTables_filter input {
        display: none;
    }
    
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 0.875rem;
    }

    /* Botón primary-gold */
    .btn-primary-gold {
        background: linear-gradient(135deg, #FFD700, #FFA500);
        border: none;
        color: #000;
        font-weight: 600;
    }

    .btn-primary-gold:hover {
        background: linear-gradient(135deg, #FFA500, #FF8C00);
        color: #000;
    }

    /* Badge de ID */
    .badge.bg-primary-gold {
        background: linear-gradient(135deg, #FFD700, #FFA500) !important;
        color: #000 !important;
    }

    /* Stats Cards */
    .stats-card-body {
        padding: 1rem;
    }
    
    .stats-icon-container {
        padding: 0.75rem;
        width: 45px;
        height: 45px;
    }
    
    .stats-icon {
        font-size: 1.25rem;
    }
    
    .stats-number {
        font-size: 1.5rem;
    }
    
    .stats-label {
        font-size: 0.875rem;
    }

    /* Vista de tarjetas para móvil */
    .venta-card-mobile {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    
    .venta-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .venta-card-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 12px;
    }
    
    .venta-card-info-item {
        background: #f8f9fa;
        padding: 8px;
        border-radius: 6px;
    }
    
    .venta-card-info-item label {
        font-size: 0.7rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 4px;
        display: block;
    }
    
    .venta-card-info-item .value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #212529;
    }
    
    .venta-card-actions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
    }
    
    .venta-card-actions .btn {
        font-size: 0.75rem;
        padding: 6px 8px;
        white-space: nowrap;
    }

    /* Responsive para móviles */
    @media (max-width: 767px) {
        /* Ocultar tabla en móvil */
        .table-responsive {
            display: none !important;
        }
        
        /* Mostrar vista de tarjetas */
        #ventasMobileView {
            display: block !important;
        }
        
        /* Stats compactas */
        .stats-card-body {
            padding: 0.75rem !important;
        }
        
        .stats-icon-container {
            width: 35px !important;
            height: 35px !important;
        }
        
        .stats-icon {
            font-size: 1rem !important;
        }
        
        .stats-number {
            font-size: 1.25rem !important;
        }
        
        .stats-label {
            font-size: 0.75rem !important;
        }
    }
    
    @media (min-width: 768px) {
        /* Ocultar vista móvil en desktop */
        #ventasMobileView {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
let ventasTable;

$(document).ready(function() {
    // Configurar token CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Función para crear tarjeta de venta en móvil
    function createVentaCard(venta) {
        // Obtener nombre del cliente
        let clienteNombre = venta.cliente ? venta.cliente.nombre : 'Cliente eliminado';
        let clienteEmail = venta.cliente ? venta.cliente.email : '';
        let clienteInicial = venta.cliente ? venta.cliente.nombre.charAt(0).toUpperCase() : '?';
        
        // Crear botones de acciones
        let botonesAcciones = `
            <button type="button" 
                    class="btn btn-info btn-sm" 
                    onclick="window.location.href='/admin/ventas/${venta.idVenta}'" 
                    title="Ver detalles">
                <i class="bi bi-eye me-1"></i> Ver
            </button>
            <button type="button" 
                    class="btn btn-outline-primary btn-sm" 
                    onclick="window.open('/admin/ventas/${venta.idVenta}/print', '_blank')" 
                    title="Imprimir">
                <i class="bi bi-printer me-1"></i> Imprimir
            </button>
        `;

        if (venta.estado !== 'completada') {
            botonesAcciones += `
                <button type="button" 
                        class="btn btn-warning btn-sm" 
                        onclick="window.location.href='/admin/ventas/${venta.idVenta}/edit'" 
                        title="Editar venta">
                    <i class="bi bi-pencil-square me-1"></i> Editar
                </button>
            `;
        }

        if (venta.estado === 'pendiente') {
            botonesAcciones += `
                <button type="button" 
                        class="btn btn-success btn-sm" 
                        onclick="cambiarEstado(${venta.idVenta}, 'completada')" 
                        title="Completar venta">
                    <i class="bi bi-check-circle-fill me-1"></i> Completar
                </button>
            `;
        }

        if (venta.estado !== 'cancelada' && venta.estado !== 'completada') {
            botonesAcciones += `
                <button type="button" 
                        class="btn btn-danger btn-sm" 
                        onclick="cambiarEstado(${venta.idVenta}, 'cancelada')" 
                        title="Cancelar venta">
                    <i class="bi bi-x-circle-fill me-1"></i> Cancelar
                </button>
            `;
        }

        return `
            <div class="venta-card-mobile">
                <div class="venta-card-header">
                    <span class="badge bg-primary-gold text-dark fw-bold" style="font-size: 0.9rem;">#${venta.idVenta}</span>
                    <span>${venta.estado_badge}</span>
                </div>
                
                <div class="venta-card-cliente">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                             style="width: 40px; height: 40px; flex-shrink: 0;">
                            <span class="text-white fw-bold">${clienteInicial}</span>
                        </div>
                        <div style="min-width: 0;">
                            <div class="fw-semibold text-truncate">${clienteNombre}</div>
                            <small class="text-muted text-truncate d-block">${clienteEmail}</small>
                        </div>
                    </div>
                </div>
                
                <div class="venta-card-info">
                    <div class="venta-info-item">
                        <span class="venta-info-label">
                            <i class="bi bi-calendar3 me-1"></i>Fecha
                        </span>
                        <span class="venta-info-value">${venta.fecha}</span>
                    </div>
                    
                    <div class="venta-info-item">
                        <span class="venta-info-label">
                            <i class="bi bi-currency-dollar me-1"></i>Total
                        </span>
                        <span class="venta-info-value text-success">${venta.total_formateado}</span>
                    </div>
                    
                    <div class="venta-info-item">
                        <span class="venta-info-label">
                            <i class="bi bi-credit-card me-1"></i>Método Pago
                        </span>
                        <span class="venta-info-value">${venta.metodo_pago_badge}</span>
                    </div>
                    
                    <div class="venta-info-item">
                        <span class="venta-info-label">
                            <i class="bi bi-box-seam me-1"></i>Productos
                        </span>
                        <span class="venta-info-value">${venta.productos_info}</span>
                    </div>
                </div>
                
                <div class="venta-card-actions">
                    ${botonesAcciones}
                </div>
            </div>
        `;
    }

    // Inicializar DataTable
    ventasTable = $('#ventasTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("admin.ventas.data") }}',
            data: function(d) {
                d.buscar = $('#buscar').val();
                d.estado = $('#estado_filter').val();
                d.fecha_desde = $('#fecha_desde').val();
                d.fecha_hasta = $('#fecha_hasta').val();
            }
        },
        columns: [
            {
                data: 'idVenta',
                name: 'idVenta',
                responsivePriority: 1,
                render: function(data, type, row) {
                    return `<span class="badge bg-primary-gold text-dark fw-bold">#${data}</span>`;
                }
            },
            {
                data: 'cliente',
                name: 'cliente',
                responsivePriority: 2,
                render: function(data, type, row) {
                    if (data) {
                        return `
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 35px; height: 35px;">
                                        <span class="text-white fw-bold small">
                                            ${data.nombre.charAt(0).toUpperCase()}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold">${data.nombre}</div>
                                    <small class="text-muted">${data.email}</small>
                                </div>
                            </div>
                        `;
                    }
                    return '<span class="text-muted">Cliente eliminado</span>';
                }
            },
            {
                data: 'fecha',
                name: 'fecha',
                responsivePriority: 3,
                className: 'text-center'
            },
            {
                data: 'productos_info',
                name: 'productos_info',
                responsivePriority: 5,
                orderable: false,
                searchable: false
            },
            {
                data: 'total_formateado',
                name: 'total',
                responsivePriority: 4,
                className: 'text-end fw-bold text-success'
            },
            {
                data: 'estado_badge',
                name: 'estado',
                responsivePriority: 6,
                className: 'text-center'
            },
            {
                data: 'metodo_pago_badge',
                name: 'metodo_pago',
                responsivePriority: 7,
                className: 'text-center'
            },
            {
                data: 'idVenta',
                name: 'acciones',
                responsivePriority: 1,
                orderable: false,
                searchable: false,
                className: 'text-center actions-column',
                render: function(data, type, row) {
                    let botones = `
                        <div class="actions-container">
                            <button type="button" 
                                    class="btn btn-info btn-sm action-btn" 
                                    onclick="window.location.href='/admin/ventas/${data}'" 
                                    title="Ver detalles"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-eye me-1"></i> Ver
                            </button>
                            <button type="button" 
                                    class="btn btn-outline-primary btn-sm action-btn" 
                                    onclick="window.open('/admin/ventas/${data}/print', '_blank')" 
                                    title="Imprimir"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-printer me-1"></i> Imprimir
                            </button>
                    `;

                    if (row.estado !== 'completada') {
                        botones += `
                            <button type="button" 
                                    class="btn btn-warning btn-sm action-btn" 
                                    onclick="window.location.href='/admin/ventas/${data}/edit'" 
                                    title="Editar venta"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-pencil-square me-1"></i> Editar
                            </button>
                        `;
                    }

                    if (row.estado === 'pendiente') {
                        botones += `
                            <button type="button" 
                                    class="btn btn-success btn-sm action-btn" 
                                    onclick="cambiarEstado(${data}, 'completada')" 
                                    title="Completar venta"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-check-circle-fill me-1"></i> Completar
                            </button>
                        `;
                    }

                    if (row.estado !== 'cancelada' && row.estado !== 'completada') {
                        botones += `
                            <button type="button" 
                                    class="btn btn-danger btn-sm action-btn" 
                                    onclick="cambiarEstado(${data}, 'cancelada')" 
                                    title="Cancelar venta"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-x-circle-fill me-1"></i> Cancelar
                            </button>
                        `;
                    }

                    botones += '</div>';
                    return botones;
                }
            }
        ],
        responsive: true,
        scrollX: false,
        autoWidth: false,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 25,
        order: [[2, 'desc']], // Ordenar por fecha
        columnDefs: [
            { width: "80px", targets: 0 },
            { width: "120px", targets: 2 },
            { width: "120px", targets: 4 },
            { width: "100px", targets: 5 },
            { width: "120px", targets: 6 },
            { width: "140px", targets: 7 }
        ],
        drawCallback: function(settings) {
            // Inicializar tooltips después de cada recarga de la tabla
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Renderizar vista móvil
            if (window.innerWidth < 768) {
                const data = settings.json?.data || [];
                let mobileHTML = '';
                
                if (data.length === 0) {
                    mobileHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">No hay ventas para mostrar</p>
                        </div>
                    `;
                } else {
                    data.forEach(venta => {
                        mobileHTML += createVentaCard(venta);
                    });
                }
                
                $('#ventasMobileView').html(mobileHTML);
            }
        }
    });
});

function filtrarVentas() {
    if (ventasTable) {
        ventasTable.ajax.reload();
    }
}

function limpiarFiltros() {
    $('#buscar').val('');
    $('#estado_filter').val('');
    $('#fecha_desde').val('');
    $('#fecha_hasta').val('');
    if (ventasTable) {
        ventasTable.ajax.reload();
    }
}

function cambiarEstado(ventaId, nuevoEstado) {
    let titulo = '';
    let mensaje = '';
    let confirmText = '';
    let color = '';
    
    switch(nuevoEstado) {
        case 'completada':
            titulo = 'Completar Venta';
            mensaje = '¿Confirmas que esta venta ha sido completada exitosamente?';
            confirmText = 'Sí, completar';
            color = '#28a745';
            break;
        case 'cancelada':
            titulo = 'Cancelar Venta';
            mensaje = '¿Estás seguro de que deseas cancelar esta venta?';
            confirmText = 'Sí, cancelar';
            color = '#dc3545';
            break;
    }
    
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: confirmText,
        cancelButtonText: 'No, mantener',
        confirmButtonColor: color,
        cancelButtonColor: '#6c757d'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/ventas/${ventaId}/change-status`,
                method: 'POST',
                data: {
                    estado: nuevoEstado,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'El estado de la venta ha sido actualizado.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    if (ventasTable) {
                        ventasTable.ajax.reload();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        title: 'Error',
                        text: 'No se pudo actualizar el estado de la venta.',
                        icon: 'error'
                    });
                }
            });
        }
    });
}
</script>
@endpush
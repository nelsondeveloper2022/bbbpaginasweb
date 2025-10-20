@extends('layouts.dashboard')

@section('title', 'Productos')

@php
    $isLicenseExpired = auth()->user()->trial_ends_at && auth()->user()->trial_ends_at->isPast();
@endphp

@section('content')
    <div class="container-fluid">
        @if($isLicenseExpired)
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Tu licencia ha expirado. <a href="{{ route('admin.plans.index') }}" class="alert-link">Gestiona tu plan</a> para continuar usando esta función.
            </div>
        @endif

        <!-- Header responsive -->
        <div class="row align-items-center mb-4 g-3">
            <div class="col-12 col-md-auto flex-md-grow-1">
                <h1 class="h3 mb-0">
                    <i class="bi bi-box-seam me-2"></i>
                    <span class="d-none d-sm-inline">Gestión de Productos</span>
                    <span class="d-inline d-sm-none">Productos</span>
                </h1>
            </div>
            <div class="col-12 col-md-auto">
                <div class="d-flex gap-2 flex-column flex-sm-row">
                    <a href="{{ route('admin.productos.import') }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-spreadsheet me-1"></i> 
                        <span class="d-none d-lg-inline">Importación Masiva</span>
                        <span class="d-inline d-lg-none">Importar</span>
                    </a>
                    <a href="{{ route('admin.productos.create') }}" class="btn btn-primary-gold">
                        <i class="bi bi-plus"></i> 
                        <span>Nuevo Producto</span>
                    </a>
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
                    <div class="col-12 col-md-6 col-lg-5">
                        <label for="buscar" class="form-label">Buscar Producto</label>
                        <input type="text" 
                               class="form-control" 
                               id="buscar" 
                               placeholder="Nombre o descripción...">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado">
                            <option value="">Todos los estados</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-6 col-lg-2">
                        <label class="form-label d-none d-lg-block">&nbsp;</label>
                        <label class="form-label d-block d-lg-none">Acción</label>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary-gold" onclick="filtrarProductos()">
                                <i class="bi bi-search me-1"></i>
                                Buscar
                            </button>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-2">
                        <label class="form-label d-none d-lg-block">&nbsp;</label>
                        <label class="form-label d-block d-lg-none">Limpiar</label>
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-secondary" onclick="limpiarFiltros()">
                                <i class="bi bi-x-circle me-1"></i>
                                Limpiar
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
                    <table id="productosTable" class="table table-striped table-hover mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th width="60">Imagen</th>
                                <th>Producto</th>
                                <th width="100">Referencia</th>
                                <th width="100">Precio</th>
                                <th width="90">Costo</th>
                                <th width="80">Margen</th>
                                <th width="70">Stock</th>
                                <th width="90">Estado</th>
                                <th width="100">Fecha</th>
                                <th width="140" class="actions-header">Acciones</th>
                            </tr>
                        </thead>
                        <tbody style="background: white;">
                            <!-- Los datos se cargan vía AJAX -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Vista móvil - Tarjetas verticales -->
                <div id="productosMobileView" style="display: none;">
                    <!-- Las tarjetas se generan dinámicamente -->
                </div>
                
                <!-- Controles de paginación y información (compartidos) -->
                <div id="datatableControls" class="mt-3"></div>
            </div>
        </div>
    </div>

    <!-- Modal para ver/cambiar imágenes -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Imágenes del Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carouselContent">
                            <!-- Las imágenes se cargan dinámicamente -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para edición rápida -->
    <div class="modal fade" id="quickEditModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edición Rápida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="quickEditForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <p class="form-control-plaintext" id="quickEditProductName"></p>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quickEditPrecio" class="form-label">Precio <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="quickEditPrecio" required min="0" step="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quickEditCosto" class="form-label">Costo</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" id="quickEditCosto" min="0" step="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="quickEditStock" class="form-label">Stock <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="quickEditStock" required min="0" step="1">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Información de margen -->
                        <div class="alert alert-info d-none" id="quickEditMargenInfo">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Margen de ganancia:</strong> <span id="quickEditMargenPercentage">0%</span>
                                </div>
                                <div>
                                    <strong>Ganancia por unidad:</strong> <span id="quickEditGananciaUnidad">$0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary-gold">
                            <i class="bi bi-check-lg me-1"></i>
                            Actualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<style>
    /* Productos Index - Mobile Optimized - Version 1.0 */
    
    /* Imágenes de productos */
    .product-image-thumb {
        width: 45px;
        height: 45px;
        object-fit: cover;
        border-radius: 6px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .product-image-thumb:hover {
        transform: scale(1.1);
    }
    
    .default-product-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-gold), #ffd700);
        border-radius: 6px;
        color: white;
        font-size: 1.25rem;
        cursor: pointer;
    }
    
    /* Colores de margen */
    .margin-positive { color: #28a745; font-weight: 600; }
    .margin-negative { color: #dc3545; font-weight: 600; }
    .margin-zero { color: #6c757d; font-weight: 600; }
    
    /* Modal de carrusel */
    .carousel-item img {
        width: 100%;
        height: 400px;
        object-fit: contain;
        background: #f8f9fa;
    }
    
    /* Estilos de tabla */
    .table {
        background: white;
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
        min-height: 160px;
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
    
    /* Altura de filas */
    #productosTable tbody tr {
        height: auto;
        min-height: 160px;
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
    
    /* Badge de referencia */
    .badge.bg-light {
        border: 1px solid #dee2e6;
        color: #495057 !important;
    }
    
    /* Vista de tarjetas para móvil */
    .product-card-mobile {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }
    
    .product-card-header {
        display: flex;
        align-items: start;
        gap: 15px;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e9ecef;
    }
    
    .product-card-image {
        flex-shrink: 0;
    }
    
    .product-card-image img,
    .product-card-image .default-product-icon {
        width: 70px !important;
        height: 70px !important;
        border-radius: 8px;
    }
    
    .product-card-title {
        flex: 1;
        min-width: 0;
    }
    
    .product-card-title h6 {
        margin: 0 0 5px 0;
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        line-height: 1.3;
    }
    
    .product-card-title .badge {
        font-size: 0.75rem;
    }
    
    .product-card-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-bottom: 12px;
    }
    
    .product-info-item {
        background: #f8f9fa;
        padding: 8px 10px;
        border-radius: 6px;
    }
    
    .product-info-item label {
        display: block;
        font-size: 0.7rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 3px;
        letter-spacing: 0.5px;
    }
    
    .product-info-item .value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #212529;
    }
    
    .product-info-item .value.price {
        color: #28a745;
        font-size: 1.1rem;
    }
    
    .product-card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }
    
    .product-card-actions .btn {
        font-size: 0.85rem;
        padding: 8px 12px;
        white-space: nowrap;
    }
    
    .product-card-actions .btn i {
        font-size: 0.8rem;
    }
    
    /* Responsive - Mobile First */
    @media (max-width: 767px) {
        /* Ocultar tabla normal en móvil */
        .table-responsive {
            display: none !important;
        }
        
        /* Mostrar vista de tarjetas */
        #productosMobileView {
            display: block !important;
        }
        
        /* Header móvil */
        .h3 {
            font-size: 1.3rem !important;
        }
        
        /* Botones de header más compactos */
        .btn {
            font-size: 0.85rem;
            padding: 0.5rem 0.75rem;
        }
        
        /* Card de filtros */
        .card-header h5 {
            font-size: 1rem;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        /* DataTables info y paginación */
        .dataTables_wrapper .dataTables_info {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            text-align: center;
        }
        
        .dataTables_wrapper .dataTables_paginate {
            font-size: 0.75rem;
            margin-top: 1rem;
            text-align: center;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.4rem 0.7rem;
            font-size: 0.75rem;
            margin: 0 2px;
        }
        
        .dataTables_wrapper .dataTables_length {
            text-align: center;
            margin-bottom: 1rem;
        }
        
        /* Modal más pequeño en móvil */
        .carousel-item img {
            height: 250px;
        }
        
        .modal-body {
            padding: 1rem;
        }
    }
    
    @media (min-width: 768px) {
        /* Ocultar vista móvil en desktop */
        #productosMobileView {
            display: none !important;
        }
    }
    
    @media (min-width: 768px) and (max-width: 991px) {
        /* Tablets */
        .action-btn {
            width: 100px;
            font-size: 0.72rem;
        }
        
        .product-image-thumb,
        .default-product-icon {
            width: 42px;
            height: 42px;
        }
    }
    
    @media (min-width: 992px) {
        /* Desktop - espaciado óptimo */
        .card-body {
            padding: 1.5rem;
        }
        
        .table thead th {
            padding: 14px 10px !important;
        }
        
        .table tbody td {
            padding: 12px 10px !important;
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
let productosTable;
let currentEditingId = null;

$(document).ready(function() {
    // Configurar token CSRF para todas las peticiones AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // Inicializar DataTable con responsive optimizado
    productosTable = $('#productosTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("admin.productos.data") }}',
            data: function(d) {
                d.buscar = $('#buscar').val();
                d.estado = $('#estado').val();
            }
        },
        columns: [
            {
                data: 'imagen',
                name: 'imagen',
                orderable: false,
                searchable: false,
                responsivePriority: 3,
                render: function(data, type, row) {
                    if (row.todas_imagenes && row.todas_imagenes.length > 0) {
                        return `<img src="${row.imagen}" class="product-image-thumb" onclick="mostrarImagenes(${row.idProducto}, '${row.nombre}', ${JSON.stringify(row.todas_imagenes).replace(/"/g, '&quot;')})" alt="${row.nombre}">`;
                    } else {
                        return `<div class="default-product-icon" title="Sin imagen"><i class="${row.default_icon}"></i></div>`;
                    }
                }
            },
            {
                data: 'nombre',
                name: 'nombre',
                responsivePriority: 1,
                render: function(data, type, row) {
                    return `<strong>${data}</strong>`;
                }
            },
            {
                data: 'referencia',
                name: 'referencia',
                responsivePriority: 4,
                render: function(data, type, row) {
                    if (data) {
                        return `<span class="badge bg-light text-dark"><i class="bi bi-tag me-1"></i>${data}</span>`;
                    }
                    return '<span class="text-muted small">-</span>';
                }
            },
            {
                data: 'precio_formateado',
                name: 'precio',
                className: 'text-end',
                responsivePriority: 2,
                render: function(data, type, row) {
                    return `<strong style="color: #28a745;">${data}</strong>`;
                }
            },
            {
                data: 'costo_formateado', 
                name: 'costo',
                className: 'text-end',
                responsivePriority: 6
            },
            {
                data: 'margen',
                name: 'margen',
                className: 'text-center',
                responsivePriority: 5,
                render: function(data, type, row) {
                    let clase = data > 0 ? 'margin-positive' : (data < 0 ? 'margin-negative' : 'margin-zero');
                    return `<span class="${clase}">${data.toFixed(1)}%</span>`;
                }
            },
            {
                data: 'stock',
                name: 'stock',
                className: 'text-center',
                responsivePriority: 3,
                render: function(data, type, row) {
                    let clase = data > 10 ? 'text-success' : (data > 0 ? 'text-warning' : 'text-danger');
                    return `<strong class="${clase}">${data}</strong>`;
                }
            },
            {
                data: 'estado_badge',
                name: 'estado',
                className: 'text-center',
                responsivePriority: 4
            },
            {
                data: 'created_at',
                name: 'created_at',
                className: 'text-center',
                responsivePriority: 7,
                visible: false
            },
            {
                data: 'idProducto',
                name: 'acciones',
                orderable: false,
                searchable: false,
                className: 'text-center actions-column',
                width: '140px',
                responsivePriority: 1,
                render: function(data, type, row) {
                    return `
                        <div class="actions-container">
                            <button type="button" 
                                    class="btn btn-info btn-sm action-btn" 
                                    onclick="window.location.href='/admin/productos/${data}'" 
                                    title="Ver detalles">
                                <i class="bi bi-eye me-1"></i> Ver
                            </button>
                            <button type="button" 
                                    class="btn btn-success btn-sm action-btn" 
                                    onclick="editarRapido(${data}, '${row.nombre.replace(/'/g, "\\'")}', ${row.precio}, ${row.costo}, ${row.stock})" 
                                    title="Edición rápida">
                                <i class="bi bi-lightning-charge-fill me-1"></i> Rápido
                            </button>
                            <button type="button" 
                                    class="btn btn-warning btn-sm action-btn" 
                                    onclick="window.location.href='/admin/productos/${data}/edit'" 
                                    title="Editar completo">
                                <i class="bi bi-pencil-square me-1"></i> Editar
                            </button>
                            <button type="button" 
                                    class="btn btn-danger btn-sm action-btn" 
                                    onclick="eliminarProducto(${data}, '${row.nombre.replace(/'/g, "\\'")}')" 
                                    title="Eliminar">
                                <i class="bi bi-trash-fill me-1"></i> Eliminar
                            </button>
                        </div>
                    `;
                }
            }
        ],
        responsive: {
            details: {
                type: 'column',
                target: 'tr',
                renderer: function(api, rowIdx, columns) {
                    var data = $.map(columns, function(col, i) {
                        return col.hidden ?
                            '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                            '<td class="fw-bold" style="padding: 8px;">' + col.title + ':</td> ' +
                            '<td style="padding: 8px;">' + col.data + '</td>' +
                            '</tr>' :
                            '';
                    }).join('');

                    return data ?
                        $('<table class="table table-sm mb-0" style="background: white;"/>').append(data) :
                        false;
                }
            }
        },
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div>'
        },
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        order: [[8, 'desc']],
        drawCallback: function() {
            // Forzar estilos en elementos de la tabla
            $('#productosTable tbody tr').css('background', 'white');
            $('#productosTable tbody td').css({
                'color': '#212529',
                'font-weight': '500'
            });
            $('#productosTable tbody td strong').css({
                'color': '#000',
                'font-weight': '700'
            });
            $('#productosTable tbody td small').css({
                'color': '#6c757d',
                'font-weight': '400'
            });
            
            // Generar vista móvil
            renderMobileView();
            
            // Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
});

// Función para renderizar vista móvil
function renderMobileView() {
    const data = productosTable.rows().data();
    const mobileView = $('#productosMobileView');
    mobileView.empty();
    
    if (data.length === 0) {
        mobileView.html(`
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3">No hay productos para mostrar</p>
            </div>
        `);
        return;
    }
    
    data.each(function(product) {
        const card = createProductCard(product);
        mobileView.append(card);
    });
}

// Función para crear tarjeta de producto
function createProductCard(product) {
    // Imagen o icono por defecto
    let imageHtml = '';
    if (product.todas_imagenes && product.todas_imagenes.length > 0) {
        imageHtml = `
            <img src="${product.imagen}" 
                 alt="${product.nombre}"
                 onclick="mostrarImagenes(${product.idProducto}, '${product.nombre}', ${JSON.stringify(product.todas_imagenes).replace(/"/g, '&quot;')})">
        `;
    } else {
        imageHtml = `
            <div class="default-product-icon" title="Sin imagen">
                <i class="${product.default_icon}"></i>
            </div>
        `;
    }
    
    // Estado
    const estadoBadge = product.estado === 'activo' 
        ? '<span class="badge bg-success">Activo</span>'
        : '<span class="badge bg-secondary">Inactivo</span>';
    
    // Referencia
    const referenciaHtml = product.referencia 
        ? `<span class="badge bg-light text-dark"><i class="bi bi-tag me-1"></i>${product.referencia}</span>`
        : '<span class="text-muted small">Sin referencia</span>';
    
    // Margen con color
    const margen = product.margen || 0;
    let margenClass = 'margin-zero';
    if (margen > 0) margenClass = 'margin-positive';
    else if (margen < 0) margenClass = 'margin-negative';
    
    // Stock con color
    const stock = product.stock || 0;
    let stockClass = 'text-danger';
    if (stock > 10) stockClass = 'text-success';
    else if (stock > 0) stockClass = 'text-warning';
    
    return $(`
        <div class="product-card-mobile">
            <div class="product-card-header">
                <div class="product-card-image">
                    ${imageHtml}
                </div>
                <div class="product-card-title">
                    <h6>${product.nombre}</h6>
                    ${referenciaHtml}
                    <div class="mt-2">${estadoBadge}</div>
                </div>
            </div>
            
            <div class="product-card-info">
                <div class="product-info-item">
                    <label>Precio</label>
                    <div class="value price">${product.precio_formateado}</div>
                </div>
                <div class="product-info-item">
                    <label>Stock</label>
                    <div class="value ${stockClass}">${stock}</div>
                </div>
                <div class="product-info-item">
                    <label>Costo</label>
                    <div class="value">${product.costo_formateado || '-'}</div>
                </div>
                <div class="product-info-item">
                    <label>Margen</label>
                    <div class="value ${margenClass}">${margen.toFixed(1)}%</div>
                </div>
            </div>
            
            <div class="product-card-actions">
                <button type="button" 
                        class="btn btn-info btn-sm" 
                        onclick="window.location.href='/admin/productos/${product.idProducto}'">
                    <i class="bi bi-eye me-1"></i> Ver
                </button>
                <button type="button" 
                        class="btn btn-success btn-sm" 
                        onclick="editarRapido(${product.idProducto}, '${product.nombre.replace(/'/g, "\\'")}', ${product.precio}, ${product.costo}, ${product.stock})">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Rápido
                </button>
                <button type="button" 
                        class="btn btn-warning btn-sm" 
                        onclick="window.location.href='/admin/productos/${product.idProducto}/edit'">
                    <i class="bi bi-pencil-square me-1"></i> Editar
                </button>
                <button type="button" 
                        class="btn btn-danger btn-sm" 
                        onclick="eliminarProducto(${product.idProducto}, '${product.nombre.replace(/'/g, "\\'")}')">
                    <i class="bi bi-trash-fill me-1"></i> Eliminar
                </button>
            </div>
        </div>
    `);
}

function filtrarProductos() {
    productosTable.ajax.reload();
}

function limpiarFiltros() {
    $('#buscar').val('');
    $('#estado').val('');
    productosTable.ajax.reload();
}

function mostrarImagenes(id, nombre, imagenes) {
    $('#imageModal .modal-title').text('Imágenes de: ' + nombre);
    
    let carouselContent = '';
    imagenes.forEach((imagen, index) => {
        carouselContent += `
            <div class="carousel-item ${index === 0 ? 'active' : ''}">
                <img src="${imagen.url}" class="d-block w-100" alt="${imagen.alt}">
                <div class="carousel-caption d-none d-md-block">
                    <p>${imagen.tipo === 'principal' ? 'Imagen Principal' : 'Galería'}</p>
                </div>
            </div>
        `;
    });
    
    $('#carouselContent').html(carouselContent);
    
    // Mostrar/ocultar controles si hay más de una imagen
    if (imagenes.length <= 1) {
        $('.carousel-control-prev, .carousel-control-next').hide();
    } else {
        $('.carousel-control-prev, .carousel-control-next').show();
    }
    
    $('#imageModal').modal('show');
}

function editarRapido(id, nombre, precio, costo, stock) {
    currentEditingId = id;
    $('#quickEditProductName').text(nombre);
    $('#quickEditPrecio').val(precio);
    $('#quickEditCosto').val(costo || 0);
    $('#quickEditStock').val(stock);
    
    // Calcular margen inicial
    calcularMargenRapido();
    
    $('#quickEditModal').modal('show');
}

$('#quickEditForm').on('submit', function(e) {
    e.preventDefault();
    
    if (!currentEditingId) return;
    
    const precio = $('#quickEditPrecio').val();
    const costo = $('#quickEditCosto').val();
    const stock = $('#quickEditStock').val();
    
    $.ajax({
        url: `/admin/productos/${currentEditingId}/quick-update`,
        method: 'PATCH',
        data: {
            precio: precio,
            costo: costo,
            stock: stock,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#quickEditModal').modal('hide');
            
            Swal.fire({
                title: '¡Actualizado!',
                text: response.message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
            
            productosTable.ajax.reload(null, false);
        },
        error: function(xhr) {
            let message = 'Error al actualizar el producto';
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
});

function eliminarProducto(id, nombre) {
    Swal.fire({
        title: '¿Eliminar producto?',
        html: `
            <div class="text-center">
                <i class="bi bi-exclamation-triangle text-warning mb-3" style="font-size: 3rem;"></i>
                <p class="mb-3">¿Estás seguro de que deseas eliminar el producto:</p>
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
            $.ajax({
                url: `/admin/productos/${id}/delete-ajax`,
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: 'El producto ha sido eliminado exitosamente.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    
                    productosTable.ajax.reload();
                },
                error: function(xhr) {
                    let message = 'Error al eliminar el producto';
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

// Función para calcular margen de ganancia en edición rápida
function calcularMargenRapido() {
    const precio = parseInt($('#quickEditPrecio').val()) || 0;
    const costo = parseInt($('#quickEditCosto').val()) || 0;
    
    if (precio > 0 && costo > 0) {
        const ganancia = precio - costo;
        const margen = ((ganancia / costo) * 100);
        
        $('#quickEditMargenPercentage').text(margen.toFixed(1) + '%');
        $('#quickEditGananciaUnidad').text('$' + ganancia.toLocaleString('es-CO', {maximumFractionDigits: 0}));
        
        // Cambiar color según el margen
        const alertBox = $('#quickEditMargenInfo');
        alertBox.removeClass('alert-success alert-warning alert-danger').addClass('alert-info');
        
        if (margen > 50) {
            alertBox.removeClass('alert-info').addClass('alert-success');
        } else if (margen > 20) {
            alertBox.removeClass('alert-info').addClass('alert-warning');
        } else if (margen > 0) {
            alertBox.removeClass('alert-info').addClass('alert-danger');
        }
        
        alertBox.removeClass('d-none').show();
    } else if (precio > 0 || costo > 0) {
        $('#quickEditMargenInfo').show();
    } else {
        $('#quickEditMargenInfo').hide();
    }
}

// Event listeners para cálculo de margen en edición rápida
$(document).on('input blur', '#quickEditPrecio, #quickEditCosto', calcularMargenRapido);
</script>
@endpush

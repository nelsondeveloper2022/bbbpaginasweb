@extends('layouts.dashboard')

@section('title', 'Ventas Online')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-cart-check text-primary-gold me-2"></i>
                Ventas Online
            </h1>
            <p class="text-muted mb-0">Gestiona las ventas de {{ $empresa->nombre }}</p>
        </div>
        <a href="{{ route('admin.ventas.create') }}" class="btn btn-primary-gold">
            <i class="bi bi-plus me-1"></i> Nueva Venta
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-graph-up text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-success mb-1 fw-bold">{{ $stats['total_ventas'] }}</h3>
                    <p class="text-muted mb-0">Total Ventas</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-check-circle text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-primary mb-1 fw-bold">{{ $stats['ventas_completadas'] }}</h3>
                    <p class="text-muted mb-0">Completadas</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-warning mb-1 fw-bold">{{ $stats['ventas_pendientes'] }}</h3>
                    <p class="text-muted mb-0">Pendientes</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-currency-dollar text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <h3 class="text-success mb-1 fw-bold">${{ number_format($stats['ingresos_totales'], 0, ',', '.') }}</h3>
                    <p class="text-muted mb-0">Ingresos Totales</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>
                Filtros de Búsqueda
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="mb-3">
                        <label for="buscar" class="form-label">Buscar Venta</label>
                        <input type="text" 
                               class="form-control" 
                               id="buscar" 
                               placeholder="Cliente, ID, observaciones...">
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="mb-3">
                        <label for="estado_filter" class="form-label">Estado</label>
                        <select class="form-select" id="estado_filter">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="procesando">Procesando</option>
                            <option value="completada">Completada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="mb-3">
                        <label for="fecha_desde" class="form-label">Desde</label>
                        <input type="date" class="form-control" id="fecha_desde">
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <div class="mb-3">
                        <label for="fecha_hasta" class="form-label">Hasta</label>
                        <input type="date" class="form-control" id="fecha_hasta">
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-12">
                    <div class="mb-3">
                        <label class="form-label d-block">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary-gold flex-fill" onclick="filtrarVentas()">
                                <i class="bi bi-search me-1"></i>
                                Buscar
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="limpiarFiltros()">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto;">
                <table id="ventasTable" class="table table-striped table-hover" style="min-width: 1200px;">
                    <thead class="table-dark">
                        <tr>
                            <th width="80" style="min-width: 80px;">ID</th>
                            <th style="min-width: 200px;">Cliente</th>
                            <th width="120" style="min-width: 120px;">Fecha</th>
                            <th style="min-width: 150px;">Productos</th>
                            <th width="120" style="min-width: 120px;">Total</th>
                            <th width="100" style="min-width: 100px;">Estado</th>
                            <th width="120" style="min-width: 120px;">Método Pago</th>
                            <th width="200" style="min-width: 200px; position: sticky; right: 0; background: var(--dark-bg); z-index: 10;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargan vía AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

<style>
.card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
}

.table th {
    background: var(--dark-bg) !important;
    color: white !important;
    border: none !important;
}

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

.dataTables_wrapper .dataTables_filter input {
    display: none; /* Ocultamos el buscador por defecto */
}

/* Mejoras de botones en fila horizontal */
#ventasTable .d-flex {
    display: flex !important;
    flex-direction: row !important;
    gap: 0.25rem !important;
    justify-content: center !important;
    align-items: center !important;
    flex-wrap: nowrap !important;
}

#ventasTable .d-flex .btn {
    white-space: nowrap !important;
    transition: all 0.2s;
    min-width: 36px;
    height: 32px;
    padding: 0.25rem 0.5rem;
    margin: 0 !important;
    flex-shrink: 0 !important;
}

#ventasTable .d-flex .btn:hover {
    transform: scale(1.1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

/* Badge de ID */
.badge.bg-primary-gold {
    background: linear-gradient(135deg, #FFD700, #FFA500) !important;
    color: #000 !important;
}

/* Columna de acciones siempre visible */
#ventasTable td:last-child {
    position: sticky !important;
    right: 0 !important;
    background: white !important;
    z-index: 5 !important;
    border-left: 1px solid #dee2e6 !important;
    box-shadow: -2px 0 4px rgba(0,0,0,0.1) !important;
}

/* Para filas con hover */
#ventasTable tbody tr:hover td:last-child {
    background: #f5f5f5 !important;
}

/* Para filas alternas */
#ventasTable tbody tr:nth-child(even) td:last-child {
    background: #f8f9fa !important;
}

#ventasTable tbody tr:nth-child(even):hover td:last-child {
    background: #e9ecef !important;
}

/* Asegurar que el scroll horizontal funcione bien */
.table-responsive {
    border-radius: 8px;
}

.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
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
                render: function(data, type, row) {
                    return `<span class="badge bg-primary-gold text-dark fw-bold">#${data}</span>`;
                }
            },
            {
                data: 'cliente',
                name: 'cliente',
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
                className: 'text-center'
            },
            {
                data: 'productos_info',
                name: 'productos_info',
                orderable: false,
                searchable: false
            },
            {
                data: 'total_formateado',
                name: 'total',
                className: 'text-end fw-bold text-success'
            },
            {
                data: 'estado_badge',
                name: 'estado',
                className: 'text-center'
            },
            {
                data: 'metodo_pago_badge',
                name: 'metodo_pago',
                className: 'text-center'
            },
            {
                data: 'idVenta',
                name: 'acciones',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '200px',
                render: function(data, type, row) {
                    let botones = `
                        <div class="d-flex" style="gap: 4px; justify-content: center; align-items: center; min-width: 200px; flex-wrap: nowrap;">
                            <button type="button" 
                                    class="btn btn-info btn-sm" 
                                    onclick="window.location.href='/admin/ventas/${data}'" 
                                    title="Ver detalles"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" 
                                    class="btn btn-outline-primary btn-sm" 
                                    onclick="window.open('/admin/ventas/${data}/print', '_blank')" 
                                    title="Imprimir"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-printer"></i>
                            </button>
                    `;

                    if (row.estado !== 'completada') {
                        botones += `
                            <button type="button" 
                                    class="btn btn-warning btn-sm" 
                                    onclick="window.location.href='/admin/ventas/${data}/edit'" 
                                    title="Editar venta"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        `;
                    }

                    if (row.estado === 'pendiente') {
                        botones += `
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    onclick="cambiarEstado(${data}, 'completada')" 
                                    title="Completar venta"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-check-circle-fill"></i>
                            </button>
                        `;
                    }

                    if (row.estado !== 'cancelada' && row.estado !== 'completada') {
                        botones += `
                            <button type="button" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="cambiarEstado(${data}, 'cancelada')" 
                                    title="Cancelar venta"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-x-circle-fill"></i>
                            </button>
                        `;
                    }

                    botones += '</div>';
                    return botones;
                }
            }
        ],
        responsive: false,
        scrollX: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 25,
        order: [[2, 'desc']], // Ordenar por fecha
        drawCallback: function() {
            // Inicializar tooltips después de cada recarga de la tabla
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
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
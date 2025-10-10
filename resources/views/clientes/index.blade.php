@extends('layouts.dashboard')

@section('title', 'Clientes')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-people me-2"></i>
                Clientes
            </h1>
            <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary-gold">
                <i class="bi bi-plus-lg me-1"></i> Nuevo Cliente
            </a>
        </div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-4 fw-bold">{{ $stats['total_clientes'] ?? 0 }}</div>
                                <div>Total Clientes</div>
                            </div>
                            <div class="fs-1 opacity-50">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-4 fw-bold">{{ $stats['clientes_activos'] ?? 0 }}</div>
                                <div>Activos</div>
                            </div>
                            <div class="fs-1 opacity-50">
                                <i class="bi bi-person-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-4 fw-bold">{{ $stats['clientes_con_ventas'] ?? 0 }}</div>
                                <div>Con Ventas</div>
                            </div>
                            <div class="fs-1 opacity-50">
                                <i class="bi bi-cart-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fs-4 fw-bold">{{ $stats['nuevos_este_mes'] ?? 0 }}</div>
                                <div>Nuevos Este Mes</div>
                            </div>
                            <div class="fs-1 opacity-50">
                                <i class="bi bi-person-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nombre, email, teléfono...">
                    </div>
                    <div class="col-md-2">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado">
                            <option value="">Todos</option>
                            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="con_ventas" class="form-label">Ventas</label>
                        <select class="form-select" id="con_ventas" name="con_ventas">
                            <option value="">Todos</option>
                            <option value="1" {{ request('con_ventas') == '1' ? 'selected' : '' }}>Con ventas</option>
                            <option value="0" {{ request('con_ventas') == '0' ? 'selected' : '' }}>Sin ventas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i> Filtrar
                            </button>
                            <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Clientes -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="clientesTable">
                        <thead class="table-light">
                            <tr>
                                <th>Cliente</th>
                                <th>Contacto</th>
                                <th>Ventas</th>
                                <th>Total Comprado</th>
                                <th>Estado</th>
                                <th>Registrado</th>
                                <th width="150">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Los datos se cargarán via AJAX -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Estado vacío si no hay datos -->
                <div id="empty-state" class="text-center py-5" style="display: none;">
                    <i class="bi bi-people text-muted mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted">No hay clientes registrados</h5>
                    <p class="text-muted">Comienza agregando tu primer cliente</p>
                    <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary-gold">
                        <i class="bi bi-plus-lg me-1"></i> Nuevo Cliente
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<style>
    .table th {
        background: var(--dark-bg) !important;
        color: white !important;
        border: none !important;
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
    // Inicializar DataTable
    var table = $('#clientesTable').DataTable({
        processing: true,
        serverSide: false,
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
                data: null,
                name: 'cliente',
                render: function(data, type, row) {
                    let direccion = row.direccion ? `<br><small class="text-muted">${row.direccion.substring(0, 30)}${row.direccion.length > 30 ? '...' : ''}</small>` : '';
                    return `
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-gold rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                            <div>
                                <strong>${row.nombre}</strong>
                                ${direccion}
                            </div>
                        </div>
                    `;
                }
            },
            {
                data: null,
                name: 'contacto',
                render: function(data, type, row) {
                    let telefono = row.telefono && row.telefono !== '-' ? 
                        `<br><a href="tel:${row.telefono}" class="text-decoration-none"><i class="bi bi-telephone me-1"></i>${row.telefono}</a>` : '';
                    return `
                        <div>
                            <a href="mailto:${row.email}" class="text-decoration-none">
                                <i class="bi bi-envelope me-1"></i>${row.email}
                            </a>
                            ${telefono}
                        </div>
                    `;
                }
            },
            {
                data: 'ventas_count',
                name: 'ventas',
                render: function(data, type, row) {
                    return `<div class="text-center"><span class="badge bg-secondary">${data}</span></div>`;
                }
            },
            {
                data: 'total_ventas',
                name: 'total',
                render: function(data, type, row) {
                    return `<div class="text-end"><strong>${data}</strong></div>`;
                }
            },
            {
                data: 'estado_badge',
                name: 'estado',
                orderable: false
            },
            {
                data: 'created_at',
                name: 'fecha'
            },
            {
                data: null,
                name: 'acciones',
                orderable: false,
                searchable: false,
                className: 'text-center',
                width: '120px',
                render: function(data, type, row) {
                    let hasVentas = row.ventas_count > 0;
                    let actions = '<div class="d-flex flex-column gap-1">';
                    
                    actions += `
                        <a href="/admin/clientes/${row.idCliente}" 
                           class="btn btn-info btn-sm" 
                           title="Ver detalles"
                           data-bs-toggle="tooltip">
                            <i class="bi bi-eye me-1"></i> Ver
                        </a>`;
                    
                    actions += `
                        <a href="/admin/clientes/${row.idCliente}/edit" 
                           class="btn btn-warning btn-sm" 
                           title="Editar cliente"
                           data-bs-toggle="tooltip">
                            <i class="bi bi-pencil-square me-1"></i> Editar
                        </a>`;
                    
                    if (!hasVentas) {
                        actions += `
                            <button type="button" 
                                    class="btn btn-danger btn-sm" 
                                    title="Eliminar cliente"
                                    data-bs-toggle="tooltip"
                                    onclick="eliminarCliente(${row.idCliente}, '${row.nombre.replace(/'/g, "\\'")}')">
                                <i class="bi bi-trash-fill me-1"></i> Eliminar
                            </button>`;
                    } else {
                        actions += `
                            <button type="button" 
                                    class="btn btn-secondary btn-sm disabled" 
                                    title="Tiene ventas asociadas"
                                    data-bs-toggle="tooltip"
                                    disabled>
                                <i class="bi bi-shield-lock me-1"></i> Protegido
                            </button>`;
                    }
                    
                    actions += '</div>';
                    return actions;
                }
            }
        ],
        responsive: true,
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
        order: [[0, 'asc']], // Ordenar por nombre
        pageLength: 25,
        drawCallback: function(settings) {
            // Inicializar tooltips después de cada recarga de la tabla
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Mostrar/ocultar estado vacío
            if (settings.json && settings.json.data.length === 0) {
                $('#empty-state').show();
                $('#clientesTable_wrapper').hide();
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
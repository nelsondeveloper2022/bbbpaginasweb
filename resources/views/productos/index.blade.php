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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="bi bi-box-seam me-2"></i>
                Gestión de Productos
            </h1>
                        <a href="{{ route('admin.productos.create') }}" class="btn btn-primary-gold">
                <i class="bi bi-plus"></i> Nuevo Producto
            </a>
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
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="mb-3">
                            <label for="buscar" class="form-label">Buscar Producto</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="buscar" 
                                   placeholder="Nombre o descripción...">
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado">
                                <option value="">Todos los estados</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary-gold" onclick="filtrarProductos()">
                                    <i class="bi bi-search me-1"></i>
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">&nbsp;</label>
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
        </div>

        <!-- DataTable -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="productosTable" class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="80">Imagen</th>
                                <th>Producto</th>
                                <th width="120">Referencia</th>
                                <th width="120">Precio</th>
                                <th width="100">Costo</th>
                                <th width="80">Margen</th>
                                <th width="80">Stock</th>
                                <th width="100">Estado</th>
                                <th width="100">Fecha</th>
                                <th width="140" class="actions-header">Acciones</th>
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
    .product-image-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .product-image-thumb:hover {
        transform: scale(1.1);
    }
    
    .default-product-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-gold), #ffd700);
        border-radius: 8px;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }
    
    .margin-positive { color: #28a745; }
    .margin-negative { color: #dc3545; }
    .margin-zero { color: #6c757d; }
    
    .carousel-item img {
        width: 100%;
        height: 400px;
        object-fit: contain;
        background: #f8f9fa;
    }
    
    .table th {
        background: var(--dark-bg) !important;
        color: white !important;
        border: none !important;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        display: none; /* Ocultamos el buscador por defecto */
    }
    
    /* Columna de acciones */
    .actions-column {
        min-width: 140px !important;
        width: 140px !important;
        max-width: 140px !important;
    }
    
    .actions-container {
        display: flex;
        flex-direction: column;
        gap: 4px;
        align-items: center;
        justify-content: center;
        min-height: 160px;
        padding: 8px 4px;
    }
    
    .action-btn {
        width: 100px;
        white-space: nowrap;
        transition: all 0.2s ease;
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .action-btn:hover {
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        z-index: 1;
    }
    
    .action-btn i {
        font-size: 0.7rem;
    }
    
    /* Asegurar que la columna de acciones nunca se oculte */
    .actions-column.never {
        display: table-cell !important;
    }
    
    .actions-header {
        text-align: center !important;
        min-width: 140px !important;
        width: 140px !important;
        max-width: 140px !important;
    }
    
    /* Ajustar altura de filas para acomodar botones */
    #productosTable tbody tr {
        height: auto;
        min-height: 160px;
    }
    
    #productosTable tbody td {
        vertical-align: middle;
        padding: 12px 8px;
    }
    
    /* Responsive adjustments para que se vea bien en mobile */
    @media (max-width: 768px) {
        .actions-container {
            min-height: 140px;
            gap: 3px;
        }
        
        .action-btn {
            width: 90px;
            font-size: 0.7rem;
            padding: 3px 6px;
        }
        
        .action-btn i {
            font-size: 0.65rem;
        }
    }
    
    /* Badge de referencia */
    .badge.bg-light {
        border: 1px solid #dee2e6;
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
    // Inicializar DataTable
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
            },
            {
                data: 'referencia',
                name: 'referencia',
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
                className: 'text-end'
            },
            {
                data: 'costo_formateado', 
                name: 'costo',
                className: 'text-end'
            },
            {
                data: 'margen',
                name: 'margen',
                className: 'text-center',
                render: function(data, type, row) {
                    let clase = data > 0 ? 'margin-positive' : (data < 0 ? 'margin-negative' : 'margin-zero');
                    return `<span class="${clase} fw-bold">${data.toFixed(1)}%</span>`;
                }
            },
            {
                data: 'stock',
                name: 'stock',
                className: 'text-center',
                render: function(data, type, row) {
                    let clase = data > 10 ? 'text-success' : (data > 0 ? 'text-warning' : 'text-danger');
                    return `<span class="${clase} fw-bold">${data}</span>`;
                }
            },
            {
                data: 'estado_badge',
                name: 'estado',
                className: 'text-center'
            },
            {
                data: 'created_at',
                name: 'created_at',
                className: 'text-center',
                visible: false // Ocultar para optimizar espacio
            },
            {
                data: 'idProducto',
                name: 'acciones',
                orderable: false,
                searchable: false,
                className: 'text-center actions-column',
                width: '140px',
                responsivePriority: 1, // Alta prioridad para que siempre se muestre
                render: function(data, type, row) {
                    return `
                        <div class="actions-container">
                            <button type="button" 
                                    class="btn btn-info btn-sm action-btn mb-1" 
                                    onclick="window.location.href='/admin/productos/${data}'" 
                                    title="Ver detalles"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-eye me-1"></i> Ver
                            </button>
                            <button type="button" 
                                    class="btn btn-success btn-sm action-btn mb-1" 
                                    onclick="editarRapido(${data}, '${row.nombre.replace(/'/g, "\\'")}', ${row.precio}, ${row.costo}, ${row.stock})" 
                                    title="Edición rápida"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-lightning-charge-fill me-1"></i> Rápido
                            </button>
                            <button type="button" 
                                    class="btn btn-warning btn-sm action-btn mb-1" 
                                    onclick="window.location.href='/admin/productos/${data}/edit'" 
                                    title="Editar completo"
                                    data-bs-toggle="tooltip">
                                <i class="bi bi-pencil-square me-1"></i> Editar
                            </button>
                            <button type="button" 
                                    class="btn btn-danger btn-sm action-btn" 
                                    onclick="eliminarProducto(${data}, '${row.nombre.replace(/'/g, "\\'")}')" 
                                    title="Eliminar"
                                    data-bs-toggle="tooltip">
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
                target: 'tr'
            }
        },
        columnDefs: [
            {
                targets: [0], // Imagen
                responsivePriority: 2
            },
            {
                targets: [1], // Nombre
                responsivePriority: 1
            },
            {
                targets: [-1], // Acciones (última columna)
                responsivePriority: 1,
                className: 'actions-column never'
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 25,
        order: [[8, 'desc']], // Ordenar por fecha de creación
        drawCallback: function() {
            // Inicializar tooltips después de cada recarga de la tabla
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
});

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
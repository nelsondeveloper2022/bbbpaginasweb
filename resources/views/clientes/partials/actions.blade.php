<div class="btn-group" role="group">
    <a href="{{ route('admin.clientes.show', $cliente) }}" 
       class="btn btn-sm btn-outline-info"
       title="Ver detalles">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ route('admin.clientes.edit', $cliente) }}" 
       class="btn btn-sm btn-outline-primary"
       title="Editar">
        <i class="bi bi-pencil"></i>
    </a>
    @if($cliente->ventasOnline->count() == 0)
    <button type="button" 
            class="btn btn-sm btn-outline-danger"
            title="Eliminar"
            onclick="eliminarCliente({{ $cliente->id }}, '{{ $cliente->nombre }}')">
        <i class="bi bi-trash"></i>
    </button>
    @else
    <button type="button" 
            class="btn btn-sm btn-outline-secondary disabled"
            title="No se puede eliminar - Tiene ventas asociadas"
            disabled>
        <i class="bi bi-shield-lock"></i>
    </button>
    @endif
</div>
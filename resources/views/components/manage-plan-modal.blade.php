<!-- Plan Management Modal -->
<div class="modal fade" id="managePlanModal" tabindex="-1" aria-labelledby="managePlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="managePlanModalLabel">
                    <i class="bi bi-credit-card-2-front me-2"></i>
                    Gestión de Mi Plan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                @php
                    $user = auth()->user();
                    $currentPlan = $user->plan ?? null;
                    $trialExpired = $user->trial_ends_at && $user->trial_ends_at->isPast();
                    $trialExpiringSoon = $user->trial_ends_at && $user->trial_ends_at->diffInDays(now()) <= 3 && $user->trial_ends_at->isFuture();
                    $lastRenovacion = $user->renovaciones()->latest()->first();
                @endphp

                <!-- Trial Status Alert -->
                @if($user->currentPlanExpired())
                    <div class="alert alert-danger mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Plan Expirado</h6>
                                <p class="mb-0">
                                    @if($user->hasFreePlan())
                                        Tu período gratuito de 15 días ha finalizado. Adquiere un plan premium para continuar.
                                    @else
                                        Tu plan ha expirado. Renueva o adquiere un nuevo plan para continuar.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($user->trial_ends_at && $user->trial_ends_at->diffInDays(now()) <= 3 && $user->trial_ends_at->isFuture())
                    <div class="alert alert-warning mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-history fs-4 me-3"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Plan por Expirar</h6>
                                <p class="mb-0">
                                    @if($user->hasFreePlan())
                                        Tu período gratuito expira el <strong>{{ $user->trial_ends_at->format('d/m/Y') }}</strong>
                                        ({{ $user->trial_ends_at->diffForHumans() }})
                                    @else
                                        Tu plan expira el <strong>{{ $user->trial_ends_at->format('d/m/Y') }}</strong>
                                        ({{ $user->trial_ends_at->diffForHumans() }})
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <!-- Current Plan Info -->
                    <div class="col-md-6">
                        <div class="current-plan-card bg-light rounded p-4 h-100">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-star-fill me-2"></i>
                                Plan Actual
                            </h6>
                            
                            @if($currentPlan)
                                <div class="plan-info">
                                    <div class="plan-header mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="{{ $currentPlan->icono ?? 'bi bi-star' }} fs-2 text-primary me-3"></i>
                                            <div>
                                                <h5 class="mb-0">{{ $currentPlan->nombre }}</h5>
                                                @if($currentPlan->destacado)
                                                    <span class="badge bg-primary">Popular</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="plan-details">
                                        <div class="detail-row mb-2">
                                            <span class="text-muted">Precio:</span>
                                            <span class="fw-bold">${{ number_format($currentPlan->precioPesos, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        <div class="detail-row mb-2">
                                            <span class="text-muted">Tipo:</span>
                                            <span class="fw-bold">
                                                @if($currentPlan->dias > 0)
                                                    Plan renovable ({{ $currentPlan->dias }} días)
                                                @else
                                                    Plan permanente
                                                @endif
                                            </span>
                                        </div>
                                        
                                        @if($user->trial_ends_at && $currentPlan->dias > 0)
                                            <div class="detail-row mb-2">
                                                <span class="text-muted">Vence:</span>
                                                <span class="fw-bold {{ $user->trial_ends_at->isFuture() ? 'text-success' : 'text-danger' }}">
                                                    {{ $user->trial_ends_at->format('d/m/Y H:i') }}
                                                </span>
                                            </div>
                                            
                                            @if($user->trial_ends_at->isFuture())
                                                <div class="detail-row mb-2">
                                                    <span class="text-muted">Tiempo restante:</span>
                                                    <span class="fw-bold text-info">
                                                        {{ $user->trial_ends_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            @endif
                                        @endif
                                        
                                        <div class="detail-row">
                                            <span class="text-muted">Estado:</span>
                                            <span class="badge {{ $trialExpired ? 'bg-danger' : 'bg-success' }}">
                                                {{ $trialExpired ? 'Expirado' : 'Activo' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-exclamation-circle fs-1 text-muted mb-3"></i>
                                    <h6 class="text-muted">Sin Plan Activo</h6>
                                    <p class="text-muted mb-0">Actualmente no tienes un plan asignado.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Last Payment Info -->
                    <div class="col-md-6">
                        <div class="payment-info-card bg-light rounded p-4 h-100">
                            <h6 class="text-success mb-3">
                                <i class="bi bi-receipt me-2"></i>
                                Último Pago
                            </h6>
                            
                            @if($lastRenovacion)
                                <div class="payment-details">
                                    <div class="detail-row mb-2">
                                        <span class="text-muted">Fecha:</span>
                                        <span class="fw-bold">{{ $lastRenovacion->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    
                                    <div class="detail-row mb-2">
                                        <span class="text-muted">Monto:</span>
                                        <span class="fw-bold text-success">${{ number_format($lastRenovacion->amount, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <div class="detail-row mb-2">
                                        <span class="text-muted">Plan:</span>
                                        <span class="fw-bold">{{ $lastRenovacion->plan->nombre ?? 'N/A' }}</span>
                                    </div>
                                    
                                    <div class="detail-row mb-2">
                                        <span class="text-muted">ID Transacción:</span>
                                        <span class="fw-bold font-monospace small">{{ $lastRenovacion->transaction_id }}</span>
                                    </div>
                                    
                                    <div class="detail-row">
                                        <span class="text-muted">Estado:</span>
                                        <span class="badge {{ $lastRenovacion->status === 'completed' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($lastRenovacion->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted">
                                        <i class="bi bi-shield-check me-1"></i>
                                        Pago procesado con Wompi
                                    </small>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-credit-card fs-1 text-muted mb-3"></i>
                                    <h6 class="text-muted">Sin Pagos</h6>
                                    <p class="text-muted mb-0">Aún no has realizado ningún pago.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Plan Description -->
                @if($currentPlan && $currentPlan->descripcion)
                    <div class="plan-description mt-4">
                        <h6 class="text-muted mb-2">Descripción del Plan:</h6>
                        <div class="bg-light p-3 rounded">
                            {!! $currentPlan->descripcion !!}
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="quick-actions mt-4">
                    <h6 class="text-muted mb-3">Acciones Rápidas:</h6>
                    <div class="d-grid gap-2 d-md-flex">
                        @if($currentPlan && $currentPlan->dias > 0 && $currentPlan->idPlan != 6)
                            {{-- Solo mostrar renovar si no es plan gratuito --}}
                            <a href="{{ route('admin.plans.purchase', $currentPlan->idPlan) }}" class="btn btn-success flex-md-fill">
                                <i class="bi bi-arrow-repeat me-2"></i>
                                Renovar Plan Actual
                            </a>
                        @elseif($currentPlan && $currentPlan->idPlan == 6)
                            {{-- Para plan gratuito mostrar botón de upgrade --}}
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-primary flex-md-fill">
                                <i class="bi bi-arrow-up-circle me-2"></i>
                                Adquirir Plan Premium
                            </a>
                        @endif
                        
                        <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-primary flex-md-fill">
                            <i class="bi bi-grid-3x3-gap me-2"></i>
                            Ver Todos los Planes
                        </a>
                        
                        @if($lastRenovacion)
                            <button type="button" class="btn btn-outline-secondary" onclick="downloadInvoice('{{ $lastRenovacion->id }}')">
                                <i class="bi bi-download me-2"></i>
                                Descargar Recibo
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light">
                <div class="w-100 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        ¿Necesitas ayuda? <a href="mailto:{{ config('app.support.email') }}">Contáctanos</a>
                    </small>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.current-plan-card, .payment-info-card {
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.current-plan-card:hover, .payment-info-card:hover {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.detail-row {
    display: flex;
    justify-content: between;
    align-items: center;
}

.detail-row span:first-child {
    flex: 1;
}

.detail-row span:last-child {
    text-align: right;
}

.plan-header {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 1rem;
}

@media (max-width: 768px) {
    .modal-lg {
        margin: 1rem;
        max-width: calc(100vw - 2rem);
    }
    
    .d-grid.gap-2.d-md-flex {
        gap: 0.5rem !important;
    }
    
    .d-grid.gap-2.d-md-flex > * {
        margin-bottom: 0.5rem;
    }
}
</style>

<script>
// Función para descargar recibo de pago
function downloadInvoice(renovacionId) {
    if (!renovacionId) {
        // Si no se proporciona ID, descargar el último recibo
        window.open('/receipt/download-latest', '_blank');
        return;
    }
    
    // Mostrar loading
    
    
    try {
        // Abrir el recibo en una nueva ventana/pestaña
        const receiptUrl = `/receipt/download/${renovacionId}`;
        const receiptWindow = window.open(receiptUrl, '_blank');
        Swal.close();
        
        // Verificar si se bloqueó la ventana emergente
        if (!receiptWindow || receiptWindow.closed || typeof receiptWindow.closed == 'undefined') {
            // Si se bloqueó, mostrar mensaje y ofrecer enlace directo
            Swal.fire({
                title: 'Ventana bloqueada',
                html: `
                    <p>Tu navegador bloqueó la ventana emergente.</p>
                    <p>Haz clic en el botón de abajo para descargar el recibo:</p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Abrir Recibo',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#007bff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = receiptUrl;
                }
            });
        } else {
            // Cerrar el loading después de un momento
            setTimeout(() => {
                Swal.close();
            }, 1500);
        }
    } catch (error) {
        console.error('Error al abrir recibo:', error);
        Swal.fire({
            title: 'Error',
            text: 'No se pudo abrir el recibo. Por favor, intenta nuevamente.',
            icon: 'error',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#dc3545'
        });
    }
}

// Función auxiliar para mostrar loading
function showLoadingAlert(message) {
    Swal.fire({
        title: 'Cargando...',
        text: message,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

// Auto-refresh modal data when opened
document.addEventListener('DOMContentLoaded', function() {
    const managePlanModal = document.getElementById('managePlanModal');
    if (managePlanModal) {
        managePlanModal.addEventListener('show.bs.modal', function() {
            // Aquí podrías hacer una petición AJAX para actualizar datos
            // Por ahora solo logueamos que se abrió el modal
            console.log('Plan management modal opened');
        });
    }
});
</script>
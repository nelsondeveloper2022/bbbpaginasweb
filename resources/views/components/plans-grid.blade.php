<!-- Plans Grid Component -->
@push('styles')
<style>
    :root {
        --recommended-text: "Recomendado";
    }
    
    .plan-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .plan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .plan-card.featured {
        border: 3px solid var(--primary-gold);
        transform: scale(1.05);
    }

    .plan-card.featured::before {
        content: var(--recommended-text);
        position: absolute;
        top: 20px;
        right: -48px;
        background: var(--primary-gold);
        color: white;
        padding: 5px 40px;
        font-size: 0.8rem;
        font-weight: 600;
        transform: rotate(45deg);
        padding-left: 73px;
    }

    .plan-icon {
        font-size: 3rem;
        color: var(--primary-gold);
        margin-bottom: 1rem;
    }

    .plan-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-red);
        margin-bottom: 1rem;
    }

    .plan-badges {
        margin-bottom: 1rem;
    }

    .plan-badge {
        display: inline-block;
        background: var(--light-gray);
        color: #333;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.8rem;
        font-weight: 600;
        margin: 0 6px 6px 0;
    }

    .plan-badge.primary { background: var(--primary-gold); color: var(--dark-bg); }
    .plan-badge.danger { background: #ffe2e0; color: #b01e1a; }

    .plan-price {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .plan-price.cop {
        color: var(--primary-red);
    }

    .plan-price.usd {
        color: var(--primary-gold);
    }

    .plan-currency {
        font-size: 1rem;
        opacity: 0.7;
        margin-bottom: 2rem;
    }

    .plan-note {
        font-size: 0.9rem;
        color: var(--medium-gray);
        margin-top: -1rem;
        margin-bottom: 1.5rem;
    }

    .plan-features {
        margin-bottom: 2rem;
        flex-grow: 1;
    }

    .plan-features ul {
        list-style: none;
        padding: 0;
    }

    .plan-features li {
        padding: 8px 0;
        color: #666;
        border-bottom: 1px solid #f0f0f0;
    }

    .plan-features li:last-child {
        border-bottom: none;
    }

    .plan-features i {
        color: var(--primary-gold);
        margin-right: 10px;
        width: 20px;
    }

    .select-plan-btn {
        background: var(--primary-red);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 25px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .select-plan-btn:hover {
        background: #b01e1a;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    .plan-card.featured .select-plan-btn {
        background: var(--primary-gold);
    }

    .plan-card.featured .select-plan-btn:hover {
        background: #d4a855;
    }
</style>
@endpush

<!-- Plans Grid -->
<div class="row justify-content-center">
    @foreach($plans as $plan)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="plan-card {{ $plan->destacado ? 'featured' : '' }}">
            <div class="text-center">
                <div class="plan-icon">
                    <i class="{{ $plan->icono }}"></i>
                </div>
                <h3 class="plan-name">{{ $plan->nombre }}</h3>
                <div class="plan-badges">
                    @if($plan->slug === 'plan-pagina-web-arriendo')
                        <span class="plan-badge primary"><i class="fas fa-sync-alt me-1"></i>Pago Trimestral</span>
                        <span class="plan-badge"><i class="fas fa-globe me-1"></i>Subdominio incluido</span>
                    @else
                        <span class="plan-badge primary"><i class="fas fa-check-circle me-1"></i>Pago Único</span>
                        <span class="plan-badge"><i class="fas fa-globe me-1"></i>Dominio + Hosting 1er año</span>
                    @endif
                </div>
                
                <!-- Precio en COP -->
                <div class="price-cop" style="display: block;">
                    <div class="plan-price cop">
                        ${{ number_format($plan->precioPesos, 0, ',', '.') }}
                    </div>
                    <div class="plan-currency">COP</div>
                    @if($plan->slug === 'web-en-arriendo')
                        <div class="plan-note">trimestral</div>
                    @else
                        <div class="plan-note">único pago inicial</div>
                    @endif
                </div>
                
                <!-- Precio en USD -->
                <div class="price-usd" style="display: none;">
                    <div class="plan-price usd">
                        ${{ number_format($plan->preciosDolar, 0, ',', '.') }}
                    </div>
                    <div class="plan-currency">USD</div>
                    @if($plan->slug === 'web-en-arriendo')
                        <div class="plan-note">quarterly</div>
                    @else
                        <div class="plan-note">one-time setup</div>
                    @endif
                </div>
            </div>
            
            <div class="plan-features">
                {!! $plan->descripcion !!}
            </div>
            
            <div class="text-center">
                <a href="{{ route('acquire', ['planSlug' => $plan->slug]) }}" 
                   class="select-plan-btn">
                    <i class="fas fa-rocket me-2"></i>Seleccionar Plan
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($plans->isEmpty())
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="text-center" style="background: white; padding: 3rem; border-radius: 20px;">
            <i class="fas fa-tools" style="font-size: 3rem; color: var(--primary-gold); margin-bottom: 1rem;"></i>
            <h3>¡Estamos trabajando en ello!</h3>
            <p>Pronto tendremos planes increíbles para tu negocio. Mantente atento.</p>
        </div>
    </div>
</div>
@endif
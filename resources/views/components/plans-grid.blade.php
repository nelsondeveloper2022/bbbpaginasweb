<!-- Plans Carousel Component -->
@push('styles')
<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<style>
    :root {
        --recommended-text: "Recomendado";
    }
    
    .plans-carousel {
        padding: 2rem 0;
        position: relative;
        background: transparent; /* Asegurar fondo transparente */
    }
    
    .plans-owl {
        padding: 0 20px;
        background: transparent !important; /* Eliminar cualquier fondo gris */
    }
    
    .owl-stage-outer {
        background: transparent !important; /* Eliminar fondo del contenedor owl */
    }
    
    .owl-stage {
        background: transparent !important; /* Eliminar fondo del stage */
    }
    
    .owl-item {
        background: transparent !important; /* Eliminar fondo de los items */
        height: auto; /* Permitir altura automática en items */
        display: flex; /* Flexbox para igualar alturas */
        align-items: stretch; /* Estirar items para igualar alturas */
    }
    
    .owl-item .item {
        width: 100%;
        display: flex;
        align-items: stretch;
    }
    
    .plan-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        width: 100%;
        height: auto; /* Será controlada por JavaScript */
        min-height: 100%;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Distribuir contenido uniformemente */
        margin: 0 12px;
        z-index: 1; /* Base z-index */
    }

    .plan-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        z-index: 999 !important; /* Z-index muy alto para hover */
        position: relative;
    }

    .plan-card.featured {
        border: 3px solid var(--primary-gold);
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
    
    /* Eliminar fondos grises de Owl Carousel */
    .owl-carousel,
    .owl-carousel .owl-stage-outer,
    .owl-carousel .owl-stage,
    .owl-carousel .owl-item,
    .owl-carousel .owl-wrapper,
    .owl-carousel .owl-wrapper-outer {
        background: white !important;
        min-height: auto;
        padding-top: 20px;
    }
    
    /* Asegurar que no hay overlays o fondos interferentes */
    .owl-carousel::before,
    .owl-carousel::after {
        display: none !important;
    }
    
    /* Owl Carousel Navigation */
    .owl-nav {
        margin-top: 30px;
        text-align: center;
    }
    
    .owl-nav button {
        background: white !important;
        color: var(--primary-gold) !important;
        border-radius: 50% !important;
        width: 50px !important;
        height: 50px !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
        transition: all 0.3s ease !important;
        margin: 0 10px !important;
        font-size: 20px !important;
        border: none !important;
    }
    
    .owl-nav button:hover {
        background: var(--primary-gold) !important;
        color: white !important;
        transform: scale(1.1);
    }
    
    .owl-nav button.owl-prev:after {
        content: '‹';
    }
    
    .owl-nav button.owl-next:after {
        content: '›';
    }
    
    /* Owl Carousel Dots */
    .owl-dots {
        text-align: center;
        margin-top: 20px;
    }
    
    .owl-dots .owl-dot {
        display: inline-block;
        margin: 0 5px;
    }
    
    .owl-dots .owl-dot span {
        width: 12px;
        height: 12px;
        background: var(--medium-gray);
        border-radius: 50%;
        display: block;
        transition: all 0.3s ease;
        opacity: 0.5;
    }
    
    .owl-dots .owl-dot.active span {
        background: var(--primary-gold);
        opacity: 1;
        transform: scale(1.2);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .plans-owl {
            padding: 0 10px;
            background: transparent !important;
        }
        
        .owl-nav button {
            width: 40px !important;
            height: 40px !important;
            font-size: 16px !important;
        }
        
        .plan-card {
            padding: 1.5rem;
            margin: 0 6px;
        }
        
        .plan-card:hover {
            z-index: 999 !important;
        }
    }
    
    @media (max-width: 480px) {
        .plans-owl {
            padding: 0 5px;
            background: transparent !important;
        }
        
        .plan-card:hover {
            z-index: 999 !important;
        }
    }
</style>
@endpush

<!-- Plans Carousel -->
<div class="plans-carousel">
    <div class="owl-carousel owl-theme plans-owl">
        @foreach($plans as $plan)
        <div class="item">
            <div class="plan-card {{ $plan->destacado ? 'featured' : '' }}">
                <div class="text-center">
                    <div class="plan-icon">
                        <i class="{{ $plan->icono }}"></i>
                    </div>
                    <h3 class="plan-name">{{ $plan->nombre }}</h3>
                   <div class="plan-badges">
                        @if(stripos($plan->slug ?? '', 'free') !== false)
                            <span class="plan-badge primary"><i class="fas fa-check-circle me-1"></i>Pago Único</span>
                            <span class="plan-badge"><i class="fas fa-globe me-1"></i>Hosting Incluido</span>
                        @elseif(stripos($plan->slug ?? '', 'mensual') !== false)
                            <span class="plan-badge primary"><i class="fas fa-sync-alt me-1"></i>Pago Mensual</span>
                            <span class="plan-badge"><i class="fas fa-globe me-1"></i>Hosting Incluido</span>
                        @else
                            <span class="plan-badge primary"><i class="fas fa-sync-alt me-1"></i>Pago Trimestral</span>
                            <span class="plan-badge"><i class="fas fa-globe me-1"></i>Hosting Incluido</span>
                        @endif
                    </div>

                    
                    <!-- Precio en COP -->
                    <div class="price-cop" style="display: block;">
                        <div class="plan-price cop">
                            ${{ number_format($plan->precioPesos, 0, ',', '.') }}
                        </div>
                        <div class="plan-currency">COP</div>
                        @if(stripos($plan->slug ?? '', 'free') !== false)
                            <div class="plan-note">Único pago inicial</div>
                        @elseif(stripos($plan->slug ?? '', 'mensual') !== false)
                            <div class="plan-note">Mensual</div>
                        @else
                            <div class="plan-note">Trimestral</div>
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
                
                <div class="text-center mt-auto">
                    <a href="{{ route('acquire', ['planSlug' => $plan->slug]) }}" 
                       class="select-plan-btn">
                        <i class="fas fa-rocket me-2"></i>Seleccionar Plan
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
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

@push('scripts')
<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
$(document).ready(function(){
    // Inicializar Owl Carousel
    $('.plans-owl').owlCarousel({
        loop: false,
        margin: 24,
        nav: true,
        dots: true,
        autoHeight: false,
        smartSpeed: 600,
        navText: ['‹', '›'],
        responsive: {
            0: {
                items: 1,
                margin: 10
            },
            768: {
                items: 2,
                margin: 20
            },
            1024: {
                items: 3,
                margin: 24
            },
            1400: {
                items: 4,
                margin: 24
            }
        },
        onInitialized: function() {
            equalizeCardHeights();
        },
        onResized: function() {
            equalizeCardHeights();
        }
    });
    
    // Función para igualar las alturas de las tarjetas
    function equalizeCardHeights() {
        setTimeout(function() {
            let maxHeight = 0;
            
            // Resetear altura para calcular correctamente
            $('.plan-card').css('height', 'auto');
            
            // Encontrar la altura máxima
            $('.plan-card').each(function() {
                const currentHeight = $(this).outerHeight();
                if (currentHeight > maxHeight) {
                    maxHeight = currentHeight;
                }
            });
            
            // Aplicar la altura máxima a todas las tarjetas
            $('.plan-card').css('height', maxHeight + 'px');
        }, 100); // Pequeño delay para asegurar que el DOM esté listo
    }
    
    // También igualar alturas en resize de ventana
    $(window).resize(function() {
        clearTimeout(window.resizeTimeout);
        window.resizeTimeout = setTimeout(function() {
            equalizeCardHeights();
        }, 250);
    });
    
    // Igualar alturas cuando se cambie de slide (si se añaden nuevas tarjetas dinámicamente)
    $('.plans-owl').on('changed.owl.carousel', function(event) {
        equalizeCardHeights();
    });
});
</script>
@endpush
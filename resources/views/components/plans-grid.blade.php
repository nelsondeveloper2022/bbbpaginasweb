<!-- Plans Carousel Component -->
@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    :root {
        --recommended-text: "Recomendado";
    }
    
    .plans-carousel {
        padding: 2rem 0;
        position: relative;
    }
    
    .plans-swiper {
        overflow: visible;
        padding: 0 20px;
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
        display: flex;
        flex-direction: column;
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
    
    /* Carousel Navigation */
    .swiper-button-next,
    .swiper-button-prev {
        color: var(--primary-gold);
        background: white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background: var(--primary-gold);
        color: white;
        transform: scale(1.1);
    }
    
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 20px;
        font-weight: bold;
    }
    
    /* Pagination */
    .swiper-pagination {
        position: relative;
        margin-top: 2rem;
    }
    
    .swiper-pagination-bullet {
        width: 12px;
        height: 12px;
        background: var(--medium-gray);
        opacity: 0.5;
        transition: all 0.3s ease;
    }
    
    .swiper-pagination-bullet-active {
        background: var(--primary-gold);
        opacity: 1;
        transform: scale(1.2);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .plans-swiper {
            padding: 0 10px;
        }
        
        .swiper-button-next,
        .swiper-button-prev {
            width: 40px;
            height: 40px;
        }
        
        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 16px;
        }
        
        .plan-card {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .plans-swiper {
            padding: 0 5px;
        }
    }
</style>
@endpush

<!-- Plans Carousel -->
<div class="plans-carousel">
    <div class="swiper plans-swiper">
        <div class="swiper-wrapper">
            @foreach($plans as $plan)
            <div class="swiper-slide">
                <div class="plan-card {{ $plan->destacado ? 'featured' : '' }}">
                    <div class="text-center">
                        <div class="plan-icon">
                            <i class="{{ $plan->icono }}"></i>
                        </div>
                        <h3 class="plan-name">{{ $plan->nombre }}</h3>
                        <div class="plan-badges">
                            @if($plan->slug === 'plan-pagina-web-arriendo' || $plan->slug === 'plan-free-15')
                                <span class="plan-badge primary"><i class="fas fa-sync-alt me-1"></i>Pago Trimestral</span>
                                <span class="plan-badge"><i class="fas fa-globe me-1"></i>Subdominio incluido</span>
                            @else
                                <span class="plan-badge primary"><i class="fas fa-check-circle me-1"></i>Pago Único</span>
                                <span class="plan-badge"><i class="fas fa-globe me-1"></i>Hosting Incluido</span>
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
        
        <!-- Navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
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
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const plansSwiper = new Swiper('.plans-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: false,
        centeredSlides: false,
        
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 480px
            480: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 768px
            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            // when window width is >= 1024px
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        },
        
        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        
        // Pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        
        // Auto height
        autoHeight: false,
        
        // Smooth transitions
        speed: 600,
        
        // Enable grab cursor
        grabCursor: true,
        
        // Keyboard control
        keyboard: {
            enabled: true,
        },
        
        // Mousewheel control
        mousewheel: {
            enabled: false,
        },
        
        // Auto play (optional - uncomment if you want auto-play)
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
    });
    
    // Optional: Pause autoplay on hover (if autoplay is enabled)
    // const swiperContainer = document.querySelector('.plans-swiper');
    // if (swiperContainer) {
    //     swiperContainer.addEventListener('mouseenter', () => {
    //         plansSwiper.autoplay.stop();
    //     });
    //     
    //     swiperContainer.addEventListener('mouseleave', () => {
    //         plansSwiper.autoplay.start();
    //     });
    // }
});
</script>
@endpush
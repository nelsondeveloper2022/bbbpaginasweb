<!-- Currency Selector Component -->
@push('styles')
<style>
    .currency-selector {
        text-align: center;
        margin-bottom: 4rem;
        background: white;
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        overflow: hidden;
    }

    .currency-selector::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-red) 0%, var(--primary-gold) 100%);
    }

    .currency-selector h3 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary-red);
        margin-bottom: 0.5rem;
    }

    .currency-subtitle {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 2rem;
        opacity: 0.8;
    }

    .currency-toggle-container {
        display: inline-block;
        background: #f8f9fa;
        border-radius: 50px;
        padding: 6px;
        box-shadow: inset 0 2px 8px rgba(0,0,0,0.1);
        position: relative;
    }

    .currency-btn {
        background: transparent;
        border: none;
        color: #666;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        z-index: 2;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-width: 180px;
        justify-content: center;
    }

    .currency-btn i {
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .currency-btn.active {
        color: white;
        transform: scale(1.02);
    }

    .currency-btn:hover:not(.active) {
        color: var(--primary-red);
        background: rgba(255,255,255,0.7);
    }

    .currency-toggle-container::after {
        content: '';
        position: absolute;
        top: 6px;
        left: 6px;
        width: calc(50% - 6px);
        height: calc(100% - 12px);
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(218, 32, 27, 0.3);
        z-index: 1;
    }

    .currency-toggle-container.usd-active::after {
        transform: translateX(100%);
        box-shadow: 0 4px 15px rgba(218, 165, 32, 0.3);
    }

    .exchange-rate {
        margin-top: 1.5rem;
        padding: 12px 20px;
        background: linear-gradient(135deg, rgba(218, 32, 27, 0.05) 0%, rgba(218, 165, 32, 0.05) 100%);
        border-radius: 10px;
        border: 1px solid rgba(218, 165, 32, 0.2);
        font-size: 0.85rem;
        color: #666;
    }

    .exchange-rate i {
        color: var(--primary-gold);
        margin-right: 8px;
    }
</style>
@endpush

<div class="currency-selector">
    <h3>{{ __('plans.currency.title') }}</h3>
    <p class="currency-subtitle">{{ __('plans.currency.subtitle') }}</p>
    
    <div class="currency-toggle-container" id="currencyToggle">
        <button class="currency-btn active" data-currency="COP">
            <i class="fas fa-peso-sign"></i>
            <span>{{ __('plans.currency.cop') }}</span>
        </button>
        <button class="currency-btn" data-currency="USD">
            <i class="fas fa-dollar-sign"></i>
            <span>{{ __('plans.currency.usd') }}</span>
        </button>
    </div>
    
    <div class="exchange-rate">
        <i class="fas fa-exchange-alt"></i>
        <span>{{ __('plans.currency.exchange_info') }}</span>
    </div>
</div>
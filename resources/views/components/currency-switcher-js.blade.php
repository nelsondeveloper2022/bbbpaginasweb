<!-- Currency Switching JavaScript -->
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const currencyBtns = document.querySelectorAll('.currency-btn');
    const copPrices = document.querySelectorAll('.price-cop');
    const usdPrices = document.querySelectorAll('.price-usd');
    const toggleContainer = document.getElementById('currencyToggle');
    
    // Only proceed if we have the currency selector elements
    if (currencyBtns.length === 0 || !toggleContainer) return;
    
    currencyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const currency = this.dataset.currency;
            
            // Update active button with smooth transition
            currencyBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update toggle container class for background animation
            if (currency === 'USD') {
                toggleContainer.classList.add('usd-active');
            } else {
                toggleContainer.classList.remove('usd-active');
            }
            
            // Show/hide prices with fade effect
            if (currency === 'COP') {
                copPrices.forEach(p => {
                    p.style.opacity = '0';
                    setTimeout(() => {
                        p.style.display = 'block';
                        setTimeout(() => p.style.opacity = '1', 10);
                    }, 150);
                });
                usdPrices.forEach(p => {
                    p.style.opacity = '0';
                    setTimeout(() => p.style.display = 'none', 150);
                });
            } else {
                usdPrices.forEach(p => {
                    p.style.opacity = '0';
                    setTimeout(() => {
                        p.style.display = 'block';
                        setTimeout(() => p.style.opacity = '1', 10);
                    }, 150);
                });
                copPrices.forEach(p => {
                    p.style.opacity = '0';
                    setTimeout(() => p.style.display = 'none', 150);
                });
            }
        });
    });
    
    // Add initial transition styles
    document.querySelectorAll('.price-cop, .price-usd').forEach(p => {
        p.style.transition = 'opacity 0.3s ease';
    });
});
</script>
@endpush
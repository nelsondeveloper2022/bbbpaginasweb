<!DOCTYPE html>
<html>
<head>
    <title>Wompi Configuration Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .config-item { margin: 10px 0; padding: 10px; border: 1px solid #ccc; }
        .success { background: #d4edda; }
        .error { background: #f8d7da; }
        .warning { background: #fff3cd; }
    </style>
</head>
<body>
    <h1>Wompi Configuration Debug</h1>
    
    <div class="config-item {{ config('wompi.public_key') ? 'success' : 'error' }}">
        <strong>Public Key (wompi.php):</strong> {{ config('wompi.public_key') ? 'SET' : 'NOT SET' }}
        <br><small>{{ config('wompi.public_key') }}</small>
    </div>
    
    <div class="config-item {{ config('wompi.private_key') ? 'success' : 'error' }}">
        <strong>Private Key (wompi.php):</strong> {{ config('wompi.private_key') ? 'SET' : 'NOT SET' }}
        <br><small>{{ config('wompi.private_key') ? substr(config('wompi.private_key'), 0, 20) . '...' : 'N/A' }}</small>
    </div>
    
    <div class="config-item {{ config('wompi.events_key') ? 'success' : 'error' }}">
        <strong>Events Key (wompi.php):</strong> {{ config('wompi.events_key') ? 'SET' : 'NOT SET' }}
        <br><small>{{ config('wompi.events_key') }}</small>
    </div>
    
    <div class="config-item {{ config('wompi.integrity_key') ? 'success' : 'error' }}">
        <strong>Integrity Key (wompi.php):</strong> {{ config('wompi.integrity_key') ? 'SET' : 'NOT SET' }}
        <br><small>{{ config('wompi.integrity_key') }}</small>
    </div>
    
    <div class="config-item">
        <strong>Environment (wompi.php):</strong> {{ config('wompi.environment') }}
    </div>
    
    <div class="config-item">
        <strong>API URL (wompi.php):</strong> {{ config('wompi.api_url') }}
    </div>
    
    <div class="config-item">
        <strong>Checkout URL (wompi.php):</strong> {{ config('wompi.checkout_url') }}
    </div>
    
    <hr>
    
    <h2>Services Configuration (Alternative)</h2>
    
    <div class="config-item {{ config('services.wompi.public_key') ? 'success' : 'error' }}">
        <strong>Public Key (services.php):</strong> {{ config('services.wompi.public_key') ? 'SET' : 'NOT SET' }}
        <br><small>{{ config('services.wompi.public_key') }}</small>
    </div>
    
    <div class="config-item {{ config('services.wompi.private_key') ? 'success' : 'error' }}">
        <strong>Private Key (services.php):</strong> {{ config('services.wompi.private_key') ? 'SET' : 'NOT SET' }}
        <br><small>{{ config('services.wompi.private_key') ? substr(config('services.wompi.private_key'), 0, 20) . '...' : 'N/A' }}</small>
    </div>
    
    <div class="config-item {{ config('services.wompi.event_secret') ? 'success' : 'error' }}">
        <strong>Event Secret (services.php):</strong> {{ config('services.wompi.event_secret') ? 'SET' : 'NOT SET' }}
        <br><small>{{ config('services.wompi.event_secret') }}</small>
    </div>
    
    <div class="config-item">
        <strong>Environment (services.php):</strong> {{ config('services.wompi.environment') }}
    </div>
    
    <hr>
    
    <h2>Environment Variables</h2>
    
    <div class="config-item">
        <strong>APP_ENV:</strong> {{ config('app.env') }}
    </div>
    
    <div class="config-item">
        <strong>APP_DEBUG:</strong> {{ config('app.debug') ? 'TRUE' : 'FALSE' }}
    </div>
    
    <div class="config-item {{ env('WOMPI_PUBLIC_KEY') ? 'success' : 'warning' }}">
        <strong>WOMPI_PUBLIC_KEY (.env):</strong> {{ env('WOMPI_PUBLIC_KEY') ? 'SET' : 'NOT SET' }}
        <br><small>{{ env('WOMPI_PUBLIC_KEY') ?: 'Using default value' }}</small>
    </div>
    
    <div class="config-item {{ env('WOMPI_PRIVATE_KEY') ? 'success' : 'warning' }}">
        <strong>WOMPI_PRIVATE_KEY (.env):</strong> {{ env('WOMPI_PRIVATE_KEY') ? 'SET' : 'NOT SET' }}
        <br><small>{{ env('WOMPI_PRIVATE_KEY') ? substr(env('WOMPI_PRIVATE_KEY'), 0, 20) . '...' : 'Using default value' }}</small>
    </div>
    
    <div class="config-item {{ env('WOMPI_ENVIRONMENT') ? 'success' : 'warning' }}">
        <strong>WOMPI_ENVIRONMENT (.env):</strong> {{ env('WOMPI_ENVIRONMENT') ?: 'Using default (production)' }}
    </div>
    
    <hr>
    
    <h2>Current Routes Using Wompi</h2>
    
    <div class="config-item">
        <strong>Subscription Checkout:</strong> /subscription/checkout/{planId} → uses subscription/checkout.blade.php
        <br><small>Uses: config('wompi.public_key')</small>
    </div>
    
    <div class="config-item">
        <strong>Admin Plans Purchase:</strong> /admin/plans/purchase/{planId} → uses admin/plans/checkout.blade.php
        <br><small>Uses: config('wompi.public_key') (UPDATED)</small>
        <br><small>Previously used: config('services.wompi.public_key')</small>
    </div>
    
    <hr>
    
    <h2>Test Widget</h2>
    <div id="wompi-test" style="margin: 20px 0;">
        <button id="test-wompi-btn" class="btn btn-primary">Test Wompi Widget (wompi.php config)</button>
        <button id="test-wompi-services-btn" class="btn btn-secondary">Test Wompi Widget (services.php config)</button>
        <div id="test-result" style="margin-top: 10px;"></div>
    </div>
    
    <script src="https://checkout.wompi.co/widget.js"></script>
    <script>
        document.getElementById('test-wompi-btn').addEventListener('click', function() {
            const publicKey = '{{ config("wompi.public_key") }}';
            const resultDiv = document.getElementById('test-result');
            
            resultDiv.innerHTML = '<p><strong>Testing wompi.php config</strong></p>';
            resultDiv.innerHTML += '<p>Public key: ' + publicKey + '</p>';
            
            try {
                const checkout = new WidgetCheckout({
                    currency: 'COP',
                    amountInCents: 100000, // $1000 COP for testing
                    reference: 'TEST_WOMPI_' + Date.now(),
                    publicKey: publicKey,
                    redirectUrl: window.location.href,
                    customerData: {
                        email: 'test@example.com',
                        fullName: 'Test User'
                    }
                });
                
                resultDiv.innerHTML += '<p style="color: green;">✓ wompi.php config - Widget initialized successfully!</p>';
                
            } catch (error) {
                resultDiv.innerHTML += '<p style="color: red;">✗ wompi.php config - Error: ' + error.message + '</p>';
                console.error('Wompi Widget Error (wompi.php):', error);
            }
        });
        
        document.getElementById('test-wompi-services-btn').addEventListener('click', function() {
            const publicKey = '{{ config("services.wompi.public_key") }}';
            const resultDiv = document.getElementById('test-result');
            
            resultDiv.innerHTML += '<hr><p><strong>Testing services.php config</strong></p>';
            resultDiv.innerHTML += '<p>Public key: ' + publicKey + '</p>';
            
            try {
                const checkout = new WidgetCheckout({
                    currency: 'COP',
                    amountInCents: 100000, // $1000 COP for testing
                    reference: 'TEST_SERVICES_' + Date.now(),
                    publicKey: publicKey,
                    redirectUrl: window.location.href,
                    customerData: {
                        email: 'test@example.com',
                        fullName: 'Test User'
                    }
                });
                
                resultDiv.innerHTML += '<p style="color: green;">✓ services.php config - Widget initialized successfully!</p>';
                
            } catch (error) {
                resultDiv.innerHTML += '<p style="color: red;">✗ services.php config - Error: ' + error.message + '</p>';
                console.error('Wompi Widget Error (services.php):', error);
            }
        });
    </script>
    
    <style>
        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</body>
</html>
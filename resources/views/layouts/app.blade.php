<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'BBB - Páginas Web Profesionales')</title>
    <meta name="description" content="@yield('description', 'Potencia tu negocio con las mejores páginas web profesionales. Diseño moderno, funcional y optimizado para resultados.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- BBB Configuration -->
    <meta name="empresa-id" content="@yield('empresa-id', '1')">
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KV4KZV82');</script>
    <!-- End Google Tag Manager -->
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CCD5109GWF"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-CCD5109GWF');
    </script>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bbb.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-bbb.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-red: #d22e23;
            --primary-gold: #f0ac21;
            --dark-bg: #2c3e50;
            --dark-gray: #343a40;
            --light-gray: #f8f9fa;
            --medium-gray: #6c757d;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Header Styles */
        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.2rem;
            text-decoration: none;
        }

        .brand-logo-3b {
            background: var(--primary-red);
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            margin-right: 8px;
            font-weight: 800;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .brand-logo-3b:hover {
            transform: scale(1.05);
            background: #b01e1a;
        }

        .brand-text {
            color: white !important;
            font-weight: 600;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover .brand-text {
            color: white !important;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.2rem;
            text-decoration: none !important;
            color: white !important;
        }

        .navbar-brand:hover {
            color: white !important;
            text-decoration: none !important;
        }

        .navbar {
            background: var(--dark-bg) !important;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-gold) !important;
        }

        .currency-selector {
            background: var(--primary-gold);
            color: var(--dark-bg);
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 600;
            margin-left: 15px;
            transition: background 0.3s ease;
        }

        .currency-selector:hover {
            background: #e09a1d;
        }

        /* Main Content */
        main {
            min-height: calc(100vh - 200px);
        }

        /* Utility Classes */
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        }

        .btn-primary-custom {
            background: var(--primary-gold);
            border: none;
            color: var(--dark-bg);
            font-weight: 600;
            padding: 7px 21px;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-custom:hover {
            background: #e09a1d;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(240, 172, 33, 0.4);
            color: var(--dark-bg);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-gold);
            color: var(--primary-gold);
            background: transparent;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline-custom:hover {
            background: var(--primary-gold);
            color: var(--dark-bg);
            transform: translateY(-2px);
        }

        .btn-outline-primary-custom {
            border: 2px solid var(--primary-gold);
            color: var(--primary-gold);
            background: transparent;
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline-primary-custom:hover {
            background: var(--primary-gold);
            color: var(--dark-bg);
            border-color: var(--primary-gold);
        }

        /* Footer Styles */
        .footer {
            background: var(--dark-bg);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer h5 {
            color: var(--primary-gold);
            margin-bottom: 1rem;
        }

        .footer a {
            color: #ecf0f1;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--primary-gold);
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: var(--primary-red);
            color: white;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-gold);
            color: var(--dark-bg);
            transform: translateY(-2px);
        }

        /* BBB Promotional Pop-up Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .popup-overlay.popup-show {
            opacity: 1;
        }

        .popup-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            position: relative;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.7) translateY(50px);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .popup-show .popup-container {
            transform: scale(1) translateY(0);
        }

        .popup-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: var(--medium-gray);
            cursor: pointer;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .popup-close:hover {
            background: rgba(210, 46, 35, 0.1);
            color: var(--primary-red);
            transform: rotate(90deg);
        }

        .popup-content {
            padding: 40px 30px 30px;
            text-align: center;
        }

        .popup-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-red), var(--primary-gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            animation: pulse 2s infinite;
        }

        .popup-icon i {
            font-size: 2rem;
            color: white;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .popup-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-bg);
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .popup-subtitle {
            font-size: 1.1rem;
            color: var(--medium-gray);
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .popup-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn-primary-popup {
            background: linear-gradient(135deg, var(--primary-red), var(--primary-gold));
            border: none;
            color: white;
            font-weight: 600;
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(210, 46, 35, 0.3);
        }

        .btn-primary-popup:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(210, 46, 35, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary-popup {
            background: transparent;
            border: 2px solid #e9ecef;
            color: var(--medium-gray);
            font-weight: 500;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary-popup:hover {
            border-color: var(--primary-gold);
            color: var(--primary-gold);
            background: rgba(240, 172, 33, 0.05);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1rem;
            }
            
            .navbar-brand img {
                height: 35px;
                margin-right: 8px;
            }
            
            .navbar-brand span {
                font-size: 1.3rem !important;
            }
            
            .currency-selector {
                margin-left: 10px;
                margin-top: 10px;
            }
            
            .btn-primary-custom, .btn-outline-custom {
                padding: 10px 25px;
                margin: 5px;
            }

            /* Navbar mobile responsive fixes */
            .navbar-nav {
                text-align: center;
                margin-bottom: 1rem;
            }
            
            .navbar-nav .nav-item {
                margin: 0.25rem 0;
            }
            
            .navbar-collapse {
                padding-top: 1rem;
            }
            
            /* Authentication buttons in mobile */
            .navbar-collapse .d-flex.me-3 {
                flex-direction: column !important;
                gap: 0.5rem;
                width: 100%;
                padding: 0 1rem;
                margin: 1rem 0 !important;
            }
            
            .navbar-collapse .d-flex.me-3 .btn,
            .navbar-collapse .d-flex.me-3 .btn-primary-custom,
            .navbar-collapse .d-flex.me-3 .btn-sm {
                width: 100% !important;
                margin: 0.25rem 0 !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.9rem !important;
                text-align: center !important;
                justify-content: center !important;
                display: flex !important;
                align-items: center !important;
            }
            
            /* User dropdown in mobile */
            .navbar-collapse .dropdown.me-3 {
                width: 100%;
                text-align: center;
                margin: 1rem 0 !important;
                padding: 0 1rem;
            }
            
            .navbar-collapse .dropdown.me-3 .btn {
                width: 100% !important;
                justify-content: center !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.9rem !important;
                display: flex !important;
                align-items: center !important;
            }
            
            /* Header container alignment */
            .navbar .container {
                flex-wrap: wrap;
            }
            
            .navbar-brand {
                flex: 1;
                min-width: 0;
            }
            
            .navbar-toggler {
                border: none;
                padding: 0.25rem 0.5rem;
            }

            /* Pop-up responsive styles */
            .popup-container {
                width: 95%;
                margin: 20px;
            }

            .popup-content {
                padding: 30px 20px 25px;
            }

            .popup-title {
                font-size: 1.5rem;
            }

            .popup-subtitle {
                font-size: 1rem;
            }

            .popup-icon {
                width: 70px;
                height: 70px;
                margin-bottom: 20px;
            }

            .popup-icon i {
                font-size: 1.7rem;
            }

            .btn-primary-popup {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }

        /* Extra small devices (phones, less than 576px) */
        @media (max-width: 575px) {
            .navbar-brand img {
                height: 30px;
                margin-right: 6px;
            }
            
            .navbar-brand span {
                font-size: 1.1rem !important;
            }
            
            .navbar-nav .nav-link {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
            
            .navbar-collapse .d-flex.me-3 .btn,
            .navbar-collapse .d-flex.me-3 .btn-primary-custom,
            .navbar-collapse .dropdown.me-3 .btn {
                font-size: 0.85rem !important;
                padding: 0.6rem 0.8rem !important;
            }
            
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }
            
            .navbar-toggler {
                padding: 0.2rem 0.4rem;
                font-size: 0.9rem;
            }
            
            /* Force proper alignment for all navbar content */
            .navbar-collapse .d-flex {
                flex-direction: column !important;
                align-items: center !important;
            }
        }

        /* Specific fixes for navbar button spacing */
        @media (max-width: 991px) {
            .navbar-collapse .d-flex.align-items-center.ms-3 {
                margin-top: 1rem !important;
                flex-direction: column !important;
                width: 100%;
            }
            
            .navbar-collapse .d-flex.align-items-center.ms-3 > * {
                margin: 0.25rem 0 !important;
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('styles')
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KV4KZV82"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Main BBB JavaScript - Company data management -->
    <script src="{{ asset('js/main.js') }}"></script>
    
    <!-- BBB Promotional Pop-up -->
    <div id="promoPopup" class="popup-overlay" style="display: none;">
        <div class="popup-container">
            <button type="button" class="popup-close" onclick="closePromoPopup()">
                <i class="fas fa-times"></i>
            </button>
            <div class="popup-content">
                <div class="popup-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <h2 class="popup-title">¡Adquiere tu prueba gratuita hoy mismo!</h2>
                <p class="popup-subtitle">Disfruta de la experiencia premium sin costo.</p>
                <div class="popup-buttons">
                    <a href="{{ route('plans') }}" class="btn btn-primary-popup">
                        <i class="fas fa-star me-2"></i>Quiero mi prueba gratuita
                    </a>
                    <button type="button" class="btn btn-secondary-popup" onclick="dismissPromoPopup()">
                        Ya conozco sobre el plan gratuito
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom JavaScript -->
    <script>
        // Promotional Pop-up Management
        function showPromoPopup() {
            const popup = document.getElementById('promoPopup');
            if (popup) {
                popup.style.display = 'flex';
                document.body.style.overflow = 'hidden';
                
                // Add animation classes
                setTimeout(() => {
                    popup.classList.add('popup-show');
                }, 10);
            }
        }

        function closePromoPopup() {
            const popup = document.getElementById('promoPopup');
            if (popup) {
                popup.classList.remove('popup-show');
                setTimeout(() => {
                    popup.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }, 300);
            }
        }

        function dismissPromoPopup() {
            localStorage.setItem('bbb_promo_dismissed', 'true');
            closePromoPopup();
        }

        // Show popup on home page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check if we're on the home page and popup hasn't been dismissed
            const isHomePage = window.location.pathname === '/' || window.location.pathname === '/home';
            const isDismissed = localStorage.getItem('bbb_promo_dismissed') === 'true';
            
            if (isHomePage && !isDismissed) {
                // Show popup after 1 second delay
                setTimeout(showPromoPopup, 1000);
            }
        });

        // Close popup when clicking outside
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('promoPopup');
            const popupContainer = document.querySelector('.popup-container');
            
            if (popup && event.target === popup && !popupContainer.contains(event.target)) {
                closePromoPopup();
            }
        });

        // Close popup with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePromoPopup();
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Active navigation highlighting
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>

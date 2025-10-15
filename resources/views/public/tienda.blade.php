<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Virtual - {{ $empresa->nombre }}</title>
    <meta name="description" content="Tienda virtual de {{ $empresa->nombre }}. Encuentra los mejores productos con envío rápido y seguro.">

    @php
        $favicon = (isset($landing) && $landing && $landing->logo_url)
            ? asset('storage/' . $landing->logo_url)
            : asset('favicon.ico');
    @endphp
    <link rel="icon" href="{{ $favicon }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ $favicon }}">
    <meta name="theme-color" content="{{ isset($landing) && $landing ? $landing->color_principal : '#050505' }}">
    <meta property="og:image" content="{{ $favicon }}">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- GLightbox CSS (Modern alternative to Lightbox, no jQuery required) -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    @if(isset($landing) && $landing)
    <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;600;700&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    @endif
    
    <style>
        :root {
            --primary-color: {{ isset($landing) && $landing ? $landing->color_principal : '#050505' }};
            --secondary-color: {{ isset($landing) && $landing ? ($landing->color_secundario ?? '#258a00') : '#258a00' }};
            --font-family: '{{ isset($landing) && $landing ? $landing->tipografia : 'Inter' }}', sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-family);
            background: #f8f9fa;
            color: #333;
        }
        
        /* Header */
        .header {
            background: var(--primary-color);
            color: white;
            padding: 2rem 0;
            text-align: center;
            position: relative;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            opacity: 0.1;
        }
        
        .header-content {
            position: relative;
            z-index: 2;
        }
        
        .back-btn {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }
        
        .company-logo {
            max-height: 80px;
            margin-bottom: 1rem;
            border-radius: 10px;
        }
        
        .company-name {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .store-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        /* Products Grid */
        .products-section {
            padding: 4rem 0;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
        }
        
        /* Filters Section */
        .filters-section {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 3rem;
        }
        
        .filters-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .filter-group {
            margin-bottom: 1rem;
        }
        
        .filter-label {
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .filter-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(var(--primary-color), 0.1);
        }
        
        .filter-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn-filter {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-filter:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-clear-filters {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-clear-filters:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .filters-results {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
            font-size: 0.9rem;
            color: #666;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }
        
        .product-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        
        .product-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .product-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .product-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .product-description-full {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .product-footer {
            margin-top: auto;
        }
        
        .btn-comprar {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            width: 100%;
            text-align: center;
        }
        
        .btn-comprar:hover {
            background: #1e6f00;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 138, 0, 0.3);
        }
        
        /* Contact Section */
        .contact-section {
            background: var(--primary-color);
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .contact-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }
        
        .contact-item {
            margin-bottom: 1rem;
        }
        
        .contact-item i {
            margin-right: 0.5rem;
            color: var(--secondary-color);
        }
        
        .btn-whatsapp {
            background: #25D366;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }
        
        .btn-whatsapp:hover {
            background: #20ba5a;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
        }
        
        /* Cart Styles */
        .cart-icon-container {
            position: fixed;
            right: 30px;
            top: 70px;
            z-index: 9999;
        }
        
        .cart-icon {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .cart-icon:hover {
            background: #1e6d00;
            transform: scale(1.1);
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
        
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        
        .cart-sidebar.active {
            right: 0;
        }
        
        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--primary-color);
            color: white;
        }
        
        .cart-header h3 {
            margin: 0;
            font-size: 1.25rem;
        }
        
        .cart-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background 0.3s ease;
        }
        
        .cart-close:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .cart-body {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }
        
        .cart-item-price {
            color: var(--secondary-color);
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        
        .qty-btn {
            width: 25px;
            height: 25px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .qty-btn:hover {
            background: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
        }
        
        .qty-input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 0.25rem;
            font-size: 0.8rem;
        }
        
        .cart-remove {
            color: #dc3545;
            cursor: pointer;
            font-size: 1rem;
            margin-left: 0.5rem;
        }
        
        .cart-remove:hover {
            color: #c82333;
        }
        
        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid #eee;
            background: #f8f9fa;
        }
        
        .cart-total {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            color: var(--primary-color);
        }
        
        .btn-checkout {
            display: block;
            width: 100%;
            background: var(--secondary-color);
            color: white;
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-checkout:hover {
            background: #1e6d00;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
        
        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .cart-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .cart-empty {
            text-align: center;
            padding: 2rem 1rem;
            color: #666;
        }
        
        .cart-empty i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 1rem;
        }
        
        /* Footer */
        .footer {
            background: #1a1a1a;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 1rem;
        }
        
        .empty-state h3 {
            color: #666;
            margin-bottom: 1rem;
        }
        
        .empty-state p {
            color: #999;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .company-name {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 2rem;
                margin-bottom: 1.5rem;
            }
            
            .filters-section {
                padding: 1rem;
                margin-bottom: 2rem;
            }
            
            .filters-title {
                font-size: 1.1rem;
            }
            
            .filter-actions {
                justify-content: center;
                margin-top: 1rem;
            }
            
            .btn-filter,
            .btn-clear-filters {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
                flex: 1;
                max-width: 150px;
            }
            
            .back-btn {
                position: relative;
                top: auto;
                left: auto;
                display: inline-block;
                margin-bottom: 1rem;
            }
            
            .header {
                padding: 1.5rem 0;
            }
            
            .cart-sidebar {
                width: 100%;
                right: -100%;
            }
            
            .cart-sidebar.active {
                right: 0;
            }
        }
        
        /* Product Badge */
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--secondary-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .product-image-container {
            position: relative;
        }
        
        /* Estilos para el carousel de productos */
        .product-carousel {
            border-radius: 15px 15px 0 0;
            overflow: hidden;
        }
        
        .product-carousel .carousel-inner {
            height: 250px;
        }
        
        .product-carousel .carousel-item {
            height: 250px;
        }
        
        .product-carousel .carousel-control-prev,
        .product-carousel .carousel-control-next {
            width: 15%;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .product-card:hover .carousel-control-prev,
        .product-card:hover .carousel-control-next {
            opacity: 0.8;
        }
        
        .product-carousel .carousel-control-prev-icon,
        .product-carousel .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            width: 30px;
            height: 30px;
        }
        
        .product-carousel .carousel-indicators {
            bottom: 10px;
            margin-bottom: 0;
        }
        
        .product-carousel .carousel-indicators button {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin: 0 3px;
            border: 2px solid white;
            background-color: rgba(255, 255, 255, 0.5);
        }
        
        .product-carousel .carousel-indicators button.active {
            background-color: white;
        }
        
        /* Ocultar controles e indicadores cuando solo hay una imagen */
        .product-carousel.single-image .carousel-control-prev,
        .product-carousel.single-image .carousel-control-next,
        .product-carousel.single-image .carousel-indicators {
            display: none !important;
        }
        
        /* Asegurar que las imágenes se muestren correctamente */
        .product-carousel .product-image {
            border-radius: 0; /* El carousel ya tiene border-radius */
        }
        
        /* GLightbox - Cursor pointer para imágenes clickeables */
        .product-carousel a.glightbox {
            display: block;
            cursor: pointer;
            transition: opacity 0.3s ease;
            position: relative;
        }
        
        .product-carousel a.glightbox:hover {
            opacity: 0.9;
        }
        
        .product-carousel a.glightbox:hover .product-image {
            transform: scale(1.02);
            transition: transform 0.3s ease;
        }
        
        /* Icono de zoom overlay */
        .product-carousel a.glightbox::after {
            content: '\f00e'; /* FontAwesome search-plus icon */
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 8px;
            border-radius: 50%;
            font-size: 12px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }
        
        .product-carousel a.glightbox:hover::after {
            opacity: 1;
        }
        
        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Search Bar Styles */
        .search-section {
            padding: 2rem 0;
            background: white;
            border-bottom: 1px solid #eee;
        }
        
        .search-container {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        .search-input {
            width: 100%;
            padding: 1rem 3rem 1rem 1.5rem;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(5, 5, 5, 0.1);
        }
        
        .search-button {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.7rem 1.2rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-button:hover {
            background: var(--secondary-color);
            transform: translateY(-50%) scale(1.05);
        }
        
        /* Product Modal Styles */
        .product-modal .modal-dialog {
            max-width: 1000px;
            margin: 1rem auto;
        }
        
        .product-modal .modal-body {
            padding: 1rem;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .product-modal-image {
            width: 100%;
            height: 450px;
            object-fit: cover;
            object-position: center;
            border-radius: 10px;
        }
        
        .product-modal-content {
            padding: 1rem 2rem;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .modal-image-container {
            padding-right: 1rem;
        }
        
        .product-modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }
        
        .product-modal-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .product-modal-description {
            font-size: 1rem;
            line-height: 1.6;
            color: #666;
            margin-bottom: 2rem;
            flex-grow: 1;
            max-height: 200px;
            overflow-y: auto;
            padding-right: 10px;
        }
        
        .product-modal-description::-webkit-scrollbar {
            width: 6px;
        }
        
        .product-modal-description::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .product-modal-description::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 3px;
        }
        
        .product-modal-description::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
        
        .product-modal-reference {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 0.5rem;
            font-style: italic;
        }
        
        .product-clickable {
            cursor: pointer;
        }
        
        .product-clickable:hover {
            opacity: 0.95;
        }
        
        /* Product Carousel in Modal */
        .modal-product-carousel {
            border-radius: 10px;
            background: #f8f9fa;
            overflow: hidden;
        }
        
        .modal-product-carousel .carousel-inner {
            height: 450px;
            border-radius: 8px 8px 0 0;
        }
        
        .modal-product-carousel .carousel-item {
            height: 450px;
        }
        
        .modal-product-carousel .product-modal-image {
            border-radius: 0;
            transition: transform 0.3s ease;
        }
        
        .modal-product-carousel .product-modal-image:hover {
            transform: scale(1.05);
        }
        
        .modal-product-carousel .carousel-control-prev,
        .modal-product-carousel .carousel-control-next {
            width: 8%;
            opacity: 0.8;
        }
        
        .modal-product-carousel .carousel-control-prev-icon,
        .modal-product-carousel .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }
        
        .modal-product-carousel .carousel-indicators {
            bottom: 15px;
        }
        
        .modal-product-carousel .carousel-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin: 0 5px;
            border: 2px solid white;
            background-color: rgba(255, 255, 255, 0.6);
        }
        
        .modal-product-carousel .carousel-indicators button.active {
            background-color: white;
            transform: scale(1.2);
        }
        
        /* Image zoom feature */
        .modal-image-container {
            position: relative;
            overflow: hidden;
            cursor: zoom-in;
            border-radius: 8px 8px 0 0;
        }
        
        .modal-image-container.zoomed {
            cursor: zoom-out;
        }
        
        .modal-image-container.zoomed .product-modal-image {
            transform: scale(2);
            transition: transform 0.3s ease;
        }
        
        /* Search Results */
        .search-no-results {
            text-align: center;
            padding: 3rem 2rem;
            color: #666;
        }
        
        .search-no-results i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 1rem;
        }
        
        .search-results-count {
            text-align: center;
            margin-bottom: 2rem;
            color: #666;
            font-style: italic;
        }
        
        /* Modal responsive improvements */
        @media (max-width: 768px) {
            .product-modal .modal-dialog {
                margin: 0.5rem;
                max-width: none;
            }
            
            .product-modal .modal-body {
                padding: 0.5rem;
            }
            
            .product-modal-image {
                height: 300px;
            }
            
            .modal-product-carousel .carousel-inner {
                height: 300px;
            }
            
            .modal-product-carousel .carousel-item {
                height: 300px;
            }
            
            .product-modal-content {
                padding: 1rem;
            }
            
            .modal-image-container {
                padding-right: 0;
                margin-bottom: 1rem;
            }
            
            .product-modal-title {
                font-size: 1.5rem;
            }
            
            .product-modal-price {
                font-size: 1.6rem;
            }
            
            .product-modal-description {
                max-height: 150px;
                font-size: 0.95rem;
            }
        }
        
        /* Description expand/collapse */
        .description-expandable {
            position: relative;
        }
        
        .description-toggle {
            background: none;
            border: none;
            color: var(--primary-color);
            font-weight: 600;
            cursor: pointer;
            padding: 0;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            text-decoration: underline;
        }
        
        .description-toggle:hover {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Header -->
    @if($tieneCarrito)
        <div class="cart-icon-container">
            <button class="cart-icon" id="cart-toggle">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-badge" id="cart-count">0</span>
            </button>
        </div>
    @endif
    <div class="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('public.landing', $empresa->slug) }}" class="back-btn">
                    <i class="fas fa-arrow-left me-2"></i>Volver a la Landing
                </a>
            </div>
            
            <div class="header-content">
                @if(isset($landing) && $landing && $landing->logo_url)
                    <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="company-logo">
                @endif
                
                <h1 class="company-name">{{ $empresa->nombre }}</h1>
                <p class="store-subtitle">Tienda Virtual</p>
            </div>
        </div>
    </div>

    @if($tieneCarrito)
        <!-- Cart Sidebar -->
        <div class="cart-sidebar" id="cart-sidebar">
            <div class="cart-header">
                <h3>Mi Carrito</h3>
                <button class="cart-close" id="cart-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="cart-body" id="cart-items">
                <!-- Cart items will be populated here -->
            </div>
            <div class="cart-footer">
                <div class="cart-total">
                    <strong>Total: $<span id="cart-total">0</span></strong>
                </div>
                <a href="{{ route('public.checkout', $empresa->slug) }}" class="btn-checkout" id="checkout-btn" style="display: none;">
                    <i class="fas fa-credit-card me-2"></i>Ir al Checkout
                </a>
            </div>
        </div>
        
        <!-- Cart Overlay -->
        <div class="cart-overlay" id="cart-overlay"></div>
    @endif

    <!-- Search Section -->
    <section class="search-section">
        <div class="container">
            <div class="search-container" data-aos="fade-up">
                <input type="text" 
                       id="search-input" 
                       class="search-input" 
                       placeholder="Buscar productos por nombre, descripción, referencia...">
                <button type="button" class="search-button" id="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Nuestros Productos</h2>
            
            <!-- Filters Section -->
            <div class="filters-section" data-aos="fade-up" data-aos-delay="100">
                <div class="filters-title">
                    <i class="fas fa-filter"></i>
                    Filtrar productos
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label class="filter-label">Ordenar por precio:</label>
                            <select id="price-filter" class="filter-select">
                                <option value="">Sin filtro</option>
                                <option value="price-asc">Menor a mayor precio</option>
                                <option value="price-desc">Mayor a menor precio</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label class="filter-label">Ordenar por nombre:</label>
                            <select id="name-filter" class="filter-select">
                                <option value="">Sin filtro</option>
                                <option value="name-asc">A - Z (Ascendente)</option>
                                <option value="name-desc">Z - A (Descendente)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="filter-group">
                            <label class="filter-label">&nbsp;</label>
                            <div class="filter-actions">
                                <button type="button" class="btn-filter" onclick="applyFilters()">
                                    <i class="fas fa-check me-1"></i>Aplicar filtros
                                </button>
                                <button type="button" class="btn-clear-filters" onclick="clearFilters()">
                                    <i class="fas fa-times me-1"></i>Limpiar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="filters-results" id="filters-results" style="display: none;">
                    Mostrando <span id="products-count">0</span> productos
                </div>
            </div>
            
            <!-- Search Results Count -->
            <div id="search-results-count" class="search-results-count" style="display: none;"></div>
            
            @if($productos->count() > 0)
                <div class="row" id="products-container">
                    @foreach($productos as $index => $producto)
                        <div class="col-lg-4 col-md-6 mb-4 product-item" 
                             data-aos="fade-up" 
                             data-aos-delay="{{ $index * 100 }}"
                             data-product-name="{{ strtolower($producto->nombre) }}"
                             data-product-description="{{ strtolower($producto->descripcion) }}"
                             data-product-reference="{{ strtolower($producto->referencia ?? '') }}"
                             data-product-price="{{ $producto->precio ?? 0 }}"
                             data-product-name-original="{{ $producto->nombre }}">
                            <div class="product-card">
                                <div class="product-image-container">
                                    @php
                                        // Obtener todas las imágenes del producto
                                        $todasImagenes = collect();
                                        
                                        // Agregar imagen principal si existe
                                        if ($producto->imagen) {
                                            $todasImagenes->push((object)[
                                                'url' => asset('storage/' . $producto->imagen),
                                                'tipo' => 'principal'
                                            ]);
                                        }
                                        
                                        // Agregar imágenes adicionales
                                        if ($producto->imagenes && $producto->imagenes->count() > 0) {
                                            foreach ($producto->imagenes as $imagen) {
                                                $todasImagenes->push((object)[
                                                    'url' => asset('storage/' . $imagen->url_imagen),
                                                    'tipo' => $imagen->es_principal ? 'principal' : 'adicional'
                                                ]);
                                            }
                                        }
                                        
                                        // Eliminar duplicados basados en URL
                                        $todasImagenes = $todasImagenes->unique('url');
                                        
                                        $carouselId = 'carousel-' . $producto->idProducto;
                                    @endphp
                                    
                                    @if($todasImagenes->count() > 0)
                                        <div id="{{ $carouselId }}" class="carousel slide product-carousel {{ $todasImagenes->count() === 1 ? 'single-image' : '' }}">
                                            <div class="carousel-inner">
                                                @foreach($todasImagenes as $index => $imagen)
                                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                        <a href="{{ $imagen->url }}" 
                                                           class="glightbox" 
                                                           data-gallery="product-{{ $producto->idProducto }}" 
                                                           data-title="{{ $producto->nombre }} - Imagen {{ $index + 1 }}">
                                                            <img src="{{ $imagen->url }}" 
                                                                 alt="{{ $producto->nombre }} - Imagen {{ $index + 1 }}" 
                                                                 class="product-image d-block w-100">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            @if($todasImagenes->count() > 1)
                                                <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Anterior</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#{{ $carouselId }}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Siguiente</span>
                                                </button>
                                                
                                                <!-- Indicadores de carousel -->
                                                <div class="carousel-indicators">
                                                    @foreach($todasImagenes as $index => $imagen)
                                                        <button type="button" 
                                                                data-bs-target="#{{ $carouselId }}" 
                                                                data-bs-slide-to="{{ $index }}" 
                                                                class="{{ $index === 0 ? 'active' : '' }}"
                                                                aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                                                aria-label="Imagen {{ $index + 1 }}">
                                                        </button>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="product-image d-flex align-items-center justify-content-center" style="background: #f8f9fa;">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    
                                    @if($producto->destacado)
                                        <div class="product-badge">Destacado</div>
                                    @endif
                                </div>
                                
                                <div class="product-body product-clickable" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#productModal{{ $producto->idProducto }}">
                                    <h3 class="product-title">{{ $producto->nombre }}</h3>
                                    @if($producto->referencia)
                                        <p class="product-modal-reference">Ref: {{ $producto->referencia }}</p>
                                    @endif
                                    <p class="product-description">{{ $producto->descripcion }}</p>
                                    
                                    @if($producto->precio)
                                        <div class="product-price">
                                            ${{ number_format($producto->precio, 0, ',', '.') }}
                                        </div>
                                    @endif
                                    <div class="product-footer">
                                        @if($tieneCarrito && $producto->precio)
                                            <button class="btn-comprar add-to-cart" 
                                                    data-product-id="{{ $producto->idProducto }}"
                                                    data-product-name="{{ $producto->nombre }}"
                                                    data-product-price="{{ $producto->precio }}"
                                                    data-product-image="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : asset('images/no-image.jpg') }}"
                                                    onclick="event.stopPropagation();">
                                                <i class="fas fa-shopping-cart me-2"></i>Agregar al carrito
                                            </button>
                                        @else
                                            <a href="https://wa.me/{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20el%20producto:%20{{ urlencode($producto->nombre) }}%20¿Podrías%20darme%20más%20información?" 
                                               class="btn-comprar" 
                                               target="_blank"
                                               onclick="event.stopPropagation();">
                                                <i class="fab fa-whatsapp me-2"></i>Comunícate por WhatsApp
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Search No Results -->
                <div id="search-no-results" class="search-no-results" style="display: none;">
                    <i class="fas fa-search"></i>
                    <h3>No se encontraron productos</h3>
                    <p>Intenta con otros términos de búsqueda</p>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>Próximamente nuevos productos</h3>
                    <p>Estamos preparando increíbles productos para ti. ¡Mantente atento!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Product Modals -->
    @if($productos->count() > 0)
        @foreach($productos as $producto)
            <div class="modal fade product-modal" id="productModal{{ $producto->idProducto }}" tabindex="-1" aria-labelledby="productModalLabel{{ $producto->idProducto }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header border-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-0">
                                <div class="col-lg-7">
                                    @php
                                        // Reutilizar la lógica de imágenes del producto
                                        $todasImagenes = collect();
                                        
                                        if ($producto->imagen) {
                                            $todasImagenes->push((object)[
                                                'url' => asset('storage/' . $producto->imagen),
                                                'tipo' => 'principal'
                                            ]);
                                        }
                                        
                                        if ($producto->imagenes && $producto->imagenes->count() > 0) {
                                            foreach ($producto->imagenes as $imagen) {
                                                $todasImagenes->push((object)[
                                                    'url' => asset('storage/' . $imagen->url_imagen),
                                                    'tipo' => $imagen->es_principal ? 'principal' : 'adicional'
                                                ]);
                                            }
                                        }
                                        
                                        $todasImagenes = $todasImagenes->unique('url');
                                        $modalCarouselId = 'modal-carousel-' . $producto->idProducto;
                                    @endphp
                                    
                                    @if($todasImagenes->count() > 0)
                                        <div class="modal-image-container">
                                            <div id="{{ $modalCarouselId }}" class="carousel slide modal-product-carousel {{ $todasImagenes->count() === 1 ? 'single-image' : '' }}">
                                                <div class="carousel-inner">
                                                    @foreach($todasImagenes as $index => $imagen)
                                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                            <img src="{{ $imagen->url }}" 
                                                                 alt="{{ $producto->nombre }} - Imagen {{ $index + 1 }}" 
                                                                 class="product-modal-image d-block w-100"
                                                                 onclick="toggleImageZoom(this)">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                @if($todasImagenes->count() > 1)
                                                    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $modalCarouselId }}" data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Anterior</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button" data-bs-target="#{{ $modalCarouselId }}" data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Siguiente</span>
                                                    </button>
                                                    
                                                    <div class="carousel-indicators">
                                                        @foreach($todasImagenes as $index => $imagen)
                                                            <button type="button" 
                                                                    data-bs-target="#{{ $modalCarouselId }}" 
                                                                    data-bs-slide-to="{{ $index }}" 
                                                                    class="{{ $index === 0 ? 'active' : '' }}"
                                                                    aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                                                    aria-label="Imagen {{ $index + 1 }}">
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                @endif
                                                
                                                <!-- Zoom indicator -->
                                                <div class="position-absolute top-0 end-0 m-3">
                                                    <small class="bg-dark text-white px-2 py-1 rounded">
                                                        <i class="fas fa-search-plus me-1"></i>Click para zoom
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="modal-image-container">
                                            <div class="product-modal-image d-flex align-items-center justify-content-center" style="background: #f8f9fa;">
                                                <i class="fas fa-image fa-5x text-muted"></i>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-5">
                                    <div class="product-modal-content">
                                        <h3 class="product-modal-title">{{ $producto->nombre }}</h3>
                                        
                                        @if($producto->referencia)
                                            <p class="product-modal-reference">
                                                <i class="fas fa-tag me-1"></i>
                                                Referencia: {{ $producto->referencia }}
                                            </p>
                                        @endif
                                        
                                        @if($producto->precio)
                                            <div class="product-modal-price">
                                                <i class="fas fa-dollar-sign me-1"></i>
                                                ${{ number_format($producto->precio, 0, ',', '.') }}
                                            </div>
                                        @endif
                                        
                                        @php
                                            $descripcionLarga = strlen($producto->descripcion) > 300;
                                            $descripcionCorta = $descripcionLarga ? substr($producto->descripcion, 0, 300) . '...' : $producto->descripcion;
                                        @endphp
                                        
                                        <div class="description-expandable">
                                            <div class="product-modal-description" id="description-{{ $producto->idProducto }}">
                                                @if($descripcionLarga)
                                                    <span class="description-short">{{ $descripcionCorta }}</span>
                                                    <span class="description-full" style="display: none;">{{ $producto->descripcion }}</span>
                                                @else
                                                    {{ $producto->descripcion }}
                                                @endif
                                            </div>
                                            
                                            @if($descripcionLarga)
                                                <button type="button" class="description-toggle" onclick="toggleDescription({{ $producto->idProducto }})">
                                                    <span class="expand-text">Ver más</span>
                                                    <span class="collapse-text" style="display: none;">Ver menos</span>
                                                </button>
                                            @endif
                                        </div>
                                        
                                        <div class="mt-auto">
                                            @if($tieneCarrito && $producto->precio)
                                                <button class="btn-comprar add-to-cart w-100 mb-2" 
                                                        data-product-id="{{ $producto->idProducto }}"
                                                        data-product-name="{{ $producto->nombre }}"
                                                        data-product-price="{{ $producto->precio }}"
                                                        data-product-image="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : asset('images/no-image.jpg') }}"
                                                        data-bs-dismiss="modal">
                                                    <i class="fas fa-shopping-cart me-2"></i>Agregar al carrito
                                                </button>
                                            @endif
                                            
                                            <a href="https://wa.me/{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20el%20producto:%20{{ urlencode($producto->nombre) }}%20¿Podrías%20darme%20más%20información?" 
                                               class="btn-whatsapp w-100" 
                                               target="_blank"
                                               onclick="setTimeout(() => { $('#productModal{{ $producto->idProducto }}').modal('hide'); }, 100);">
                                                <i class="fab fa-whatsapp me-2"></i>Consultar por WhatsApp
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- Contact Section -->
    @if($productos->count() > 0)
    <section class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3 class="mb-4">¿Tienes alguna pregunta?</h3>
                    <div class="contact-info">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <strong>{{ $empresa->movil }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <strong>{{ $empresa->email }}</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <strong>{{ $empresa->direccion }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="https://wa.me/{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20visitando%20su%20tienda%20virtual%20y%20me%20gustaría%20recibir%20más%20información%20sobre%20sus%20productos" 
                       class="btn-whatsapp" 
                       target="_blank">
                        <i class="fab fa-whatsapp me-2"></i>Contactar por WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
            <p class="mb-0">Tienda Virtual - Productos de calidad</p>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Products filtering functionality
        function applyFilters() {
            const priceFilter = document.getElementById('price-filter').value;
            const nameFilter = document.getElementById('name-filter').value;
            const productsContainer = document.getElementById('products-container');
            const products = Array.from(productsContainer.querySelectorAll('.product-item'));
            
            // Show all products first
            products.forEach(product => {
                product.style.display = 'block';
            });
            
            // Apply sorting
            if (priceFilter || nameFilter) {
                products.sort((a, b) => {
                    if (priceFilter === 'price-asc') {
                        const priceA = parseFloat(a.dataset.productPrice) || 0;
                        const priceB = parseFloat(b.dataset.productPrice) || 0;
                        return priceA - priceB;
                    } else if (priceFilter === 'price-desc') {
                        const priceA = parseFloat(a.dataset.productPrice) || 0;
                        const priceB = parseFloat(b.dataset.productPrice) || 0;
                        return priceB - priceA;
                    } else if (nameFilter === 'name-asc') {
                        return a.dataset.productNameOriginal.localeCompare(b.dataset.productNameOriginal, 'es', { sensitivity: 'base' });
                    } else if (nameFilter === 'name-desc') {
                        return b.dataset.productNameOriginal.localeCompare(a.dataset.productNameOriginal, 'es', { sensitivity: 'base' });
                    }
                    return 0;
                });
                
                // Reorder products in DOM
                products.forEach(product => {
                    productsContainer.appendChild(product);
                });
            }
            
            // Update results count
            updateFiltersResults(products.length);
            
            // Show success message
            showFilterMessage('Filtros aplicados correctamente', 'success');
        }
        
        function clearFilters() {
            document.getElementById('price-filter').value = '';
            document.getElementById('name-filter').value = '';
            
            // Reset to original order
            const productsContainer = document.getElementById('products-container');
            const products = Array.from(productsContainer.querySelectorAll('.product-item'));
            
            // Sort by original index (data-aos-delay can help us determine original order)
            products.sort((a, b) => {
                const delayA = parseInt(a.dataset.aosDelay) || 0;
                const delayB = parseInt(b.dataset.aosDelay) || 0;
                return delayA - delayB;
            });
            
            products.forEach(product => {
                product.style.display = 'block';
                productsContainer.appendChild(product);
            });
            
            // Hide results count
            document.getElementById('filters-results').style.display = 'none';
            
            // Show success message
            showFilterMessage('Filtros limpiados', 'info');
        }
        
        function updateFiltersResults(count) {
            const resultsDiv = document.getElementById('filters-results');
            const countSpan = document.getElementById('products-count');
            
            countSpan.textContent = count;
            resultsDiv.style.display = 'block';
        }
        
        function showFilterMessage(message, type) {
            // Create temporary message element
            const messageDiv = document.createElement('div');
            messageDiv.className = `alert alert-${type === 'success' ? 'success' : 'info'} alert-dismissible fade show`;
            messageDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            messageDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(messageDiv);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.remove();
                }
            }, 3000);
        }
        
        // Auto-apply filters when selects change
        document.getElementById('price-filter').addEventListener('change', function() {
            if (this.value || document.getElementById('name-filter').value) {
                applyFilters();
            }
        });
        
        document.getElementById('name-filter').addEventListener('change', function() {
            if (this.value || document.getElementById('price-filter').value) {
                applyFilters();
            }
        });

        // Add loading animation to buttons
        document.querySelectorAll('.btn-comprar, .btn-whatsapp').forEach(btn => {
            btn.addEventListener('click', function() {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="loading"></span> Conectando...';
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        });

        // Smooth scroll for back button
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add hover effect to product cards
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Search functionality
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        const productsContainer = document.getElementById('products-container');
        const searchResultsCount = document.getElementById('search-results-count');
        const searchNoResults = document.getElementById('search-no-results');
        const productItems = document.querySelectorAll('.product-item');

        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let visibleCount = 0;

            if (searchTerm === '') {
                // Mostrar todos los productos
                productItems.forEach(item => {
                    item.style.display = 'block';
                    visibleCount++;
                });
                searchResultsCount.style.display = 'none';
                searchNoResults.style.display = 'none';
            } else {
                // Filtrar productos
                productItems.forEach(item => {
                    const productName = item.dataset.productName || '';
                    const productDescription = item.dataset.productDescription || '';
                    const productReference = item.dataset.productReference || '';
                    
                    const searchInContent = productName + ' ' + productDescription + ' ' + productReference;
                    
                    if (searchInContent.includes(searchTerm)) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Mostrar contador de resultados
                if (visibleCount > 0) {
                    searchResultsCount.textContent = `Se encontraron ${visibleCount} producto${visibleCount !== 1 ? 's' : ''} para "${searchInput.value}"`;
                    searchResultsCount.style.display = 'block';
                    searchNoResults.style.display = 'none';
                } else {
                    searchResultsCount.style.display = 'none';
                    searchNoResults.style.display = 'block';
                }
            }
        }

        // Event listeners para el buscador
        if (searchInput && searchButton) {
            searchInput.addEventListener('input', performSearch);
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    performSearch();
                }
            });
            searchButton.addEventListener('click', performSearch);
        }

        // Toggle description function
        window.toggleDescription = function(productId) {
            const description = document.getElementById(`description-${productId}`);
            const shortSpan = description.querySelector('.description-short');
            const fullSpan = description.querySelector('.description-full');
            const button = description.parentElement.querySelector('.description-toggle');
            const expandText = button.querySelector('.expand-text');
            const collapseText = button.querySelector('.collapse-text');
            
            if (shortSpan.style.display === 'none') {
                // Mostrar versión corta
                shortSpan.style.display = 'inline';
                fullSpan.style.display = 'none';
                expandText.style.display = 'inline';
                collapseText.style.display = 'none';
                description.style.maxHeight = '200px';
            } else {
                // Mostrar versión completa
                shortSpan.style.display = 'none';
                fullSpan.style.display = 'inline';
                expandText.style.display = 'none';
                collapseText.style.display = 'inline';
                description.style.maxHeight = 'none';
            }
        };

        // Toggle image zoom function
        window.toggleImageZoom = function(image) {
            const container = image.closest('.modal-image-container');
            const isZoomed = container.classList.contains('zoomed');
            
            if (isZoomed) {
                container.classList.remove('zoomed');
                image.style.transform = 'scale(1)';
                image.style.cursor = 'zoom-in';
            } else {
                container.classList.add('zoomed');
                image.style.transform = 'scale(1.8)';
                image.style.cursor = 'zoom-out';
            }
        };

        // Reset zoom when modal is closed
        document.addEventListener('hidden.bs.modal', function(event) {
            if (event.target.classList.contains('product-modal')) {
                const images = event.target.querySelectorAll('.product-modal-image');
                const containers = event.target.querySelectorAll('.modal-image-container');
                
                images.forEach(img => {
                    img.style.transform = 'scale(1)';
                    img.style.cursor = 'zoom-in';
                });
                
                containers.forEach(container => {
                    container.classList.remove('zoomed');
                });
            }
        });

        // Mejorar comportamiento del carousel de productos
        document.querySelectorAll('.product-carousel').forEach(carousel => {
            const carouselInstance = new bootstrap.Carousel(carousel, {
                interval: false, // No auto-slide por defecto
                wrap: true,
                pause: false
            });

            // Activar auto-slide solo en hover de la tarjeta del producto
            const productCard = carousel.closest('.product-card');
            if (productCard) {
                let hoverTimer;
                
                productCard.addEventListener('mouseenter', () => {
                    // Iniciar auto-slide después de un breve delay en hover
                    hoverTimer = setTimeout(() => {
                        carouselInstance._config.interval = 3000; // 3 segundos
                        carouselInstance.cycle();
                    }, 1000); // Esperar 1 segundo antes de iniciar
                });
                
                productCard.addEventListener('mouseleave', () => {
                    // Limpiar timer y pausar carousel
                    clearTimeout(hoverTimer);
                    carouselInstance.pause();
                    carouselInstance._config.interval = false;
                });
            }

            // Evitar conflictos con el hover de la tarjeta madre
            carousel.addEventListener('mouseenter', (e) => {
                e.stopPropagation();
            });
        });
    </script>

    @if($tieneCarrito)
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif

    <!-- GLightbox JS (Modern alternative to Lightbox, no jQuery required) -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        // Initialize GLightbox
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = GLightbox({
                touchNavigation: true,
                loop: true,
                autoplayVideos: false,
                descPosition: 'bottom'
            });
            
            console.log('GLightbox initialized successfully');
        });
    </script>

    @if($tieneCarrito)
    <script>
        // Shopping Cart functionality
        class ShoppingCart {
            constructor() {
                this.items = this.getCartFromStorage();
                this.bindEvents();
                this.updateCartUI();
            }

            getCartFromStorage() {
                const cart = localStorage.getItem('shopping_cart_{{ $empresa->slug }}');
                return cart ? JSON.parse(cart) : [];
            }

            saveCartToStorage() {
                localStorage.setItem('shopping_cart_{{ $empresa->slug }}', JSON.stringify(this.items));
            }

            addToCart(product) {
                const existingItem = this.items.find(item => item.id === product.id);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    this.items.push({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        image: product.image,
                        quantity: 1
                    });
                }

                this.saveCartToStorage();
                this.updateCartUI();
                this.showCartSidebar();
                
                // Show success message
                this.showNotification('Producto agregado al carrito', 'success');
            }

            removeFromCart(productId) {
                this.items = this.items.filter(item => item.id !== productId);
                this.saveCartToStorage();
                this.updateCartUI();
            }

            updateQuantity(productId, newQuantity) {
                if (newQuantity <= 0) {
                    this.removeFromCart(productId);
                    return;
                }

                const item = this.items.find(item => item.id === productId);
                if (item) {
                    item.quantity = newQuantity;
                    this.saveCartToStorage();
                    this.updateCartUI();
                }
            }

            updateCartUI() {
                const cartCount = document.getElementById('cart-count');
                const cartItems = document.getElementById('cart-items');
                const cartTotal = document.getElementById('cart-total');
                const checkoutBtn = document.getElementById('checkout-btn');

                const totalItems = this.items.reduce((sum, item) => sum + item.quantity, 0);
                const totalPrice = this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);

                cartCount.textContent = totalItems;
                cartTotal.textContent = this.formatPrice(totalPrice);

                if (this.items.length === 0) {
                    cartItems.innerHTML = `
                        <div class="cart-empty">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Tu carrito está vacío</p>
                        </div>
                    `;
                    checkoutBtn.style.display = 'none';
                } else {
                    const itemsHtml = this.items.map(item => `
                        <div class="cart-item" data-product-id="${item.id}">
                            <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                            <div class="cart-item-details">
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-price">$${this.formatPrice(item.price)}</div>
                                <div class="cart-item-quantity">
                                    <button class="qty-btn decrease-qty" type="button">-</button>
                                    <input type="number" value="${item.quantity}" min="1" class="qty-input" readonly>
                                    <button class="qty-btn increase-qty" type="button">+</button>
                                    <i class="fas fa-trash cart-remove" title="Eliminar"></i>
                                </div>
                            </div>
                        </div>
                    `).join('');
                    
                    cartItems.innerHTML = itemsHtml;
                    checkoutBtn.style.display = 'block';
                }
            }

            formatPrice(price) {
                return new Intl.NumberFormat('es-CO').format(price);
            }

            showCartSidebar() {
                document.getElementById('cart-sidebar').classList.add('active');
                document.getElementById('cart-overlay').classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            hideCartSidebar() {
                document.getElementById('cart-sidebar').classList.remove('active');
                document.getElementById('cart-overlay').classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            showNotification(message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `alert alert-${type === 'success' ? 'success' : 'info'} position-fixed`;
                notification.style.cssText = `
                    top: 20px;
                    right: 20px;
                    z-index: 9999;
                    min-width: 300px;
                    animation: slideInRight 0.3s ease;
                `;
                notification.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
                    ${message}
                `;

                document.body.appendChild(notification);

                // Remove notification after 3 seconds
                setTimeout(() => {
                    notification.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 3000);
            }

            bindEvents() {
                // Add to cart buttons
                document.addEventListener('click', (e) => {
                    if (e.target.closest('.add-to-cart')) {
                        const button = e.target.closest('.add-to-cart');
                        console.log(button.dataset);
                        const product = {
                            id: parseInt(button.dataset.productId),
                            name: button.dataset.productName,
                            price: parseFloat(button.dataset.productPrice),
                            image: button.dataset.productImage
                        };
                        this.addToCart(product);
                    }

                    // Cart toggle
                    if (e.target.closest('#cart-toggle')) {
                        this.showCartSidebar();
                    }

                    // Cart close
                    if (e.target.closest('#cart-close') || e.target.closest('#cart-overlay')) {
                        this.hideCartSidebar();
                    }

                    // Quantity controls
                    if (e.target.closest('.increase-qty')) {
                        const cartItem = e.target.closest('.cart-item');
                        const productId = parseInt(cartItem.dataset.productId);
                        const quantityInput = cartItem.querySelector('.qty-input');
                        const newQuantity = parseInt(quantityInput.value) + 1;
                        quantityInput.value = newQuantity;
                        this.updateQuantity(productId, newQuantity);
                    }

                    if (e.target.closest('.decrease-qty')) {
                        const cartItem = e.target.closest('.cart-item');
                        const productId = parseInt(cartItem.dataset.productId);
                        const quantityInput = cartItem.querySelector('.qty-input');
                        const newQuantity = parseInt(quantityInput.value) - 1;
                        if (newQuantity > 0) {
                            quantityInput.value = newQuantity;
                            this.updateQuantity(productId, newQuantity);
                        }
                    }

                    if (e.target.closest('.cart-remove')) {
                        const cartItem = e.target.closest('.cart-item');
                        const productId = parseInt(cartItem.dataset.productId);
                        Swal.fire({
                            title: '¿Eliminar producto?',
                            text: 'Esta acción eliminará el producto del carrito.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.removeFromCart(productId);
                                this.showNotification('Producto eliminado del carrito', 'success');
                            }
                        });
                    }
                });

                // Keyboard events
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        this.hideCartSidebar();
                    }
                });
            }
        }

        // Initialize cart when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new ShoppingCart();
        });

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>
    @endif

    <!-- Modal de Confirmación de Pago -->
    @if(session('payment_success') || session('payment_error'))
    <div class="modal fade" id="paymentResultModal" tabindex="-1" aria-labelledby="paymentResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header {{ session('payment_success') ? 'bg-success' : 'bg-danger' }} text-white">
                    <h5 class="modal-title" id="paymentResultModalLabel">
                        @if(session('payment_success'))
                            <i class="fas fa-check-circle me-2"></i>
                            @if(session('venta_data.test_mode'))
                                🧪 Pago de Prueba Exitoso
                            @else
                                ¡Pago Exitoso!
                            @endif
                        @else
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Error en el Pago
                        @endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(session('payment_success'))
                        @if(session('venta_data.test_mode'))
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Modo de Prueba:</strong> Esta transacción fue procesada automáticamente para pruebas.
                            </div>
                        @endif
                        
                        <p class="mb-3">Tu compra ha sido procesada correctamente.</p>
                        
                        @if(session('venta_data'))
                        <div class="transaction-details">
                            <h6 class="fw-bold mb-3">Detalles de la Transacción:</h6>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <small class="text-muted">ID de Venta:</small><br>
                                    <span class="fw-bold">#{{ session('venta_data.id') }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted">Total:</small><br>
                                    <span class="fw-bold text-success">${{ number_format(session('venta_data.total'), 0, ',', '.') }} COP</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted">Cliente:</small><br>
                                    <span>{{ session('venta_data.cliente.nombre') }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted">Email:</small><br>
                                    <span>{{ session('venta_data.cliente.email') }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted">Estado:</small><br>
                                    <span class="badge bg-success">{{ ucfirst(session('venta_data.estado')) }}</span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted">Método de Pago:</small><br>
                                    <span>
                                        @if(session('venta_data.test_mode'))
                                            Prueba Automática
                                        @else
                                            {{ ucfirst(session('venta_data.metodo_pago')) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="mt-3">
                            <p class="text-muted small">
                                <i class="fas fa-envelope me-1"></i>
                                Recibirás un correo de confirmación con todos los detalles.
                            </p>
                        </div>
                    @else
                        <p class="mb-3">{{ session('error_message') }}</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Puedes intentar realizar el pago nuevamente o contactar con nuestro soporte.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    @if(session('payment_success'))
                        <button type="button" class="btn btn-primary" onclick="clearCart(); location.reload();">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Continuar Comprando
                        </button>
                    @else
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            <i class="fas fa-redo me-2"></i>
                            Intentar de Nuevo
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar modal automáticamente si hay resultado de pago
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('payment_success') || session('payment_error'))
                const modal = new bootstrap.Modal(document.getElementById('paymentResultModal'));
                modal.show();
                
                @if(session('payment_success'))
                // Limpiar carrito después de pago exitoso
                setTimeout(() => {
                    clearCart();
                }, 2000);
                @endif
            @endif
        });
        
        // Función para limpiar el carrito
        function clearCart() {
            localStorage.removeItem('shopping_cart_{{ $empresa->slug }}');
        }
    </script>
    @endif
</body>
</html>
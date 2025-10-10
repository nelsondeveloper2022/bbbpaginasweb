<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{{ $landing->descripcion }}">
	<meta name="keywords" content="marroquinería, bolsos, carteras, maletines, cuero, accesorios, {{ $empresa->nombre }}">
	<title>{{ $landing->titulo_principal }} - {{ $empresa->nombre }}</title>

	<!-- Favicon / App Icons -->
	<link rel="icon" type="image/png" href="{{ asset('storage/' . $landing->logo_url) }}">
	<link rel="shortcut icon" href="{{ asset('storage/' . $landing->logo_url) }}">
	<link rel="apple-touch-icon" href="{{ asset('storage/' . $landing->logo_url) }}">
	<meta name="theme-color" content="{{ $landing->color_principal }}">
	<meta property="og:image" content="{{ asset('storage/' . $landing->logo_url) }}">
	<meta property="og:title" content="{{ $landing->titulo_principal }} - {{ $empresa->nombre }}">
	<meta property="og:description" content="{{ $landing->descripcion }}">

	<!-- Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- AOS Animations -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;600;700&display=swap" rel="stylesheet">

	<style>
		:root {
			--primary-color: {{ $landing->color_principal }};
			--secondary-color: {{ $landing->color_secundario ?? '#6c757d' }};
			--font-family: '{{ $landing->tipografia }}', sans-serif;
			--surface-0: #ffffff;
			--surface-50: #f8f9fa;
			--ink-900: #1d1d1f;
		}

		* { margin: 0; padding: 0; box-sizing: border-box; }

		body { font-family: var(--font-family); overflow-x: hidden; color: #333; background: var(--surface-50); }

		/* Navbar */
		.navbar {
			background: rgba(255, 255, 255, 0.95) !important;
			backdrop-filter: blur(20px);
			box-shadow: 0 2px 20px rgba(0,0,0,0.08);
			transition: all 0.3s ease;
			border-bottom: 1px solid rgba(0,0,0,0.08);
		}
		.navbar.scrolled { box-shadow: 0 5px 30px rgba(0,0,0,0.15); }
		.navbar-brand img { max-width: 180px; max-height: 60px; height: auto; object-fit: contain; transition: transform 0.3s ease; }
		.navbar-brand:hover img { transform: scale(1.05); }
		.nav-link { color: var(--ink-900) !important; font-weight: 500; margin: 0 12px; position: relative; transition: color 0.3s ease; font-size: 0.95rem; }
		.nav-link::after { content: ''; position: absolute; bottom: -6px; left: 50%; width: 0; height: 2px; background: var(--primary-color); transition: all 0.3s ease; transform: translateX(-50%); border-radius: 1px; }
		.nav-link:hover::after { width: 80%; }
		.nav-link:hover { color: var(--primary-color) !important; }
		.btn-whatsapp-header { background: var(--primary-color); color: #fff; padding: 10px 22px; border-radius: 999px; font-weight: 600; transition: all 0.3s ease; border: 2px solid var(--primary-color); font-size: 0.9rem; }
		.btn-whatsapp-header:hover { background: transparent; color: var(--primary-color); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.08); }

		/* Hero */
		.hero-section { position: relative; min-height: 100vh; display: flex; align-items: center; background: linear-gradient(135deg, var(--surface-50) 0%, #eef2f7 100%); overflow: hidden; padding-top: 96px; }
		.hero-section::before { content: ''; position: absolute; top: -10%; right: -40%; width: 90%; height: 120%; background: radial-gradient(ellipse at center, rgba(0,0,0,0.04), transparent 70%); transform: rotate(-15deg); }
		.hero-title { font-size: 3.2rem; font-weight: 800; color: var(--ink-900); margin-bottom: 16px; line-height: 1.1; letter-spacing: -0.5px; }
		.hero-subtitle { font-size: 1.4rem; color: var(--primary-color); margin-bottom: 16px; font-weight: 700; letter-spacing: 0.2px; }
		.hero-description { font-size: 1.1rem; color: #555; margin-bottom: 32px; line-height: 1.8; }
		.hero-image { position: relative; animation: float 6s ease-in-out infinite; }
		.hero-image img { max-width: 100%; height: auto; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,0.12); }
		@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-16px)} }

		/* Buttons */
		.btn-primary-custom { background: var(--primary-color); color: #fff; padding: 14px 36px; border-radius: 999px; font-weight: 700; font-size: 1.05rem; border: 2px solid var(--primary-color); transition: all 0.3s ease; text-decoration: none; display: inline-block; margin: 8px; }
		.btn-primary-custom:hover { background: transparent; color: var(--primary-color); transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
		.btn-outline-custom { background: transparent; color: var(--ink-900); padding: 14px 36px; border-radius: 999px; font-weight: 700; font-size: 1.05rem; border: 2px solid var(--ink-900); transition: all 0.3s ease; text-decoration: none; display: inline-block; margin: 8px; }
		.btn-outline-custom:hover { background: var(--ink-900); color: #fff; transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }

		/* Sections */
		.section { padding: 96px 0; position: relative; }
		.section-title { font-size: 2.4rem; font-weight: 800; color: var(--ink-900); margin-bottom: 12px; text-align: center; }
		.section-subtitle { font-size: 1.1rem; color: #666; text-align: center; margin-bottom: 48px; max-width: 780px; margin-left: auto; margin-right: auto; line-height: 1.7; }

		/* About */
		.about-section { background: #fff; }
		.about-card { background: #fff; padding: 32px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); transition: transform 0.3s ease; border: 1px solid rgba(0,0,0,0.06); }
		.about-card:hover { transform: translateY(-4px); }
		.about-icon { width: 72px; height: 72px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 24px; color: white; font-size: 1.8rem; }

		/* Problems */
		.problems-section { background: var(--surface-50); }
		.problem-card { background: #fff; padding: 28px; border-radius: 20px; text-align: center; margin-bottom: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.06); }
		.problem-card:hover { transform: translateY(-5px); box-shadow: 0 20px 60px rgba(0,0,0,0.12); }
		.problem-icon { width: 72px; height: 72px; background: linear-gradient(135deg, #ff6b6b, #e03131); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: white; font-size: 1.6rem; }

		/* Benefits */
		.benefits-section { background: #fff; }
		.benefit-card { background: linear-gradient(135deg, var(--primary-color), #0056b3); color: #fff; padding: 32px; border-radius: 20px; text-align: center; margin-bottom: 24px; transition: all 0.3s ease; border: none; }
		.benefit-card:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 20px 60px rgba(0,0,0,0.12); }
		.benefit-icon { width: 72px; height: 72px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 1.6rem; backdrop-filter: blur(10px); }

		/* Gallery */
		.gallery-section { background: var(--surface-50); }
		.gallery-item { border-radius: 20px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 15px 50px rgba(0,0,0,0.1); transition: all 0.3s ease; background: #fff; position: relative; cursor: pointer; }
		.gallery-item:hover { transform: translateY(-8px); box-shadow: 0 25px 70px rgba(0,0,0,0.18); }
		.gallery-item img { width: 100%; height: 320px; object-fit: cover; transition: transform 0.3s ease; max-width: 100%; }
		.gallery-item:hover img { transform: scale(1.04); }
		.gallery-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.55); color: white; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; transition: all 0.3s ease; backdrop-filter: blur(3px); }
		.gallery-item:hover .gallery-overlay { opacity: 1; }
		.gallery-overlay i { font-size: 2rem; margin-bottom: 10px; }
		.gallery-overlay p { font-size: 1rem; font-weight: 600; margin: 0; text-align: center; padding: 0 16px; }

		.gallery-modal .modal-dialog { max-width: 92vw; margin: 24px auto; }
		.gallery-modal .modal-content { background: transparent; border: none; box-shadow: none; overflow: hidden; }
		.gallery-modal .modal-header { background: rgba(0,0,0,0.85); border: none; border-radius: 12px 12px 0 0; padding: 12px 16px; color: #fff; }
		.gallery-modal .modal-body { padding: 0; position: relative; background: rgba(0,0,0,0.92); border-radius: 0 0 12px 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; min-height: 320px; }
		.gallery-modal .modal-image { width: 100%; max-height: 72vh; object-fit: contain; display: block; margin: 0 auto; }
		.gallery-nav-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.25); border-radius: 50%; width: 48px; height: 48px; font-size: 1rem; cursor: pointer; transition: all 0.2s ease; z-index: 1001; }
		.gallery-nav-btn:hover { background: rgba(255,255,255,0.3); transform: translateY(-50%) scale(1.05); }
		.gallery-nav-btn.prev { left: 16px; }
		.gallery-nav-btn.next { right: 16px; }
		.gallery-counter { position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.6); color: #fff; padding: 6px 12px; border-radius: 999px; font-size: 0.85rem; z-index: 1001; }

		/* Community */
		.community-section { background: #fff; }
		.testimonial-card { background: #fff; padding: 28px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); text-align: center; margin-bottom: 24px; border: 1px solid rgba(0,0,0,0.06); transition: transform 0.3s ease; }
		.testimonial-card:hover { transform: translateY(-4px); }
		.testimonial-avatar { width: 72px; height: 72px; border-radius: 50%; margin: 0 auto 16px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.6rem; font-weight: 800; }
		.stars { color: #ffc107; font-size: 1.1rem; margin-bottom: 12px; }

		/* Contact */
		.contact-section { background: var(--ink-900); color: #fff; }
		.contact-card { background: rgba(255,255,255,0.08); padding: 28px; border-radius: 20px; text-align: center; margin-bottom: 24px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.15); transition: transform 0.3s ease, background 0.3s ease; }
		.contact-card:hover { transform: translateY(-4px); background: rgba(255,255,255,0.12); }
		.contact-icon { width: 72px; height: 72px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; font-size: 1.6rem; color: #fff; }

		/* Footer */
		.footer { background: #000; color: #fff; padding: 56px 0 28px; }
		.footer-logo img { max-height: 60px; margin-bottom: 16px; }
		.social-links a { display: inline-block; width: 44px; height: 44px; background: rgba(255,255,255,0.1); border-radius: 50%; text-align: center; line-height: 44px; color: #fff; margin: 0 6px; transition: all 0.3s ease; font-size: 1rem; }
		.social-links a:hover { background: var(--primary-color); transform: translateY(-3px); }
		.footer-link { color: #bfbfbf; text-decoration: none; transition: color 0.2s ease; }
		.footer-link:hover { color: var(--primary-color); }

		/* WhatsApp Floating */
		.whatsapp-float { position: fixed; width: 60px; height: 60px; bottom: 38px; right: 38px; background-color: #25d366; color: #FFF; border-radius: 50%; text-align: center; font-size: 30px; box-shadow: 2px 2px 3px rgba(0,0,0,0.25); z-index: 1000; animation: pulse 2s infinite; display: flex; align-items: center; justify-content: center; text-decoration: none; }
		.whatsapp-float:hover { color: #FFF; background-color: #1db455; }
		@keyframes pulse { 0%{box-shadow:0 0 0 0 rgba(37,211,102,0.6)} 70%{box-shadow:0 0 0 12px rgba(37,211,102,0)} 100%{box-shadow:0 0 0 0 rgba(37,211,102,0)} }

		/* Responsive */
		@media (max-width: 768px) {
			.hero-title { font-size: 2.3rem; }
			.hero-subtitle { font-size: 1.1rem; }
			.section { padding: 64px 0; }
			.navbar-brand img { max-width: 140px; max-height: 45px; }
			.gallery-modal .modal-dialog { max-width: 95vw; margin: 12px auto; }
			.gallery-modal .modal-image { max-height: 60vh; }
			.gallery-nav-btn { width: 40px; height: 40px; font-size: 0.95rem; }
			.gallery-nav-btn.prev { left: 10px; }
			.gallery-nav-btn.next { right: 10px; }
		}
	</style>
</head>

<body>

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light fixed-top">
		<div class="container">
			<a class="navbar-brand" href="#home">
				<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto align-items-center">
					<li class="nav-item"><a class="nav-link" href="#home">Inicio</a></li>
					<li class="nav-item"><a class="nav-link" href="#about">Nosotros</a></li>
					<li class="nav-item"><a class="nav-link" href="#problems">Problemas</a></li>
					<li class="nav-item"><a class="nav-link" href="#benefits">Beneficios</a></li>
					<li class="nav-item"><a class="nav-link" href="#gallery">Productos</a></li>
					<li class="nav-item"><a class="nav-link" href="#community">Comunidad</a></li>
					<li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
					@if(isset($productosActivos) && $productosActivos > 0)
						<li class="nav-item">
							<a class="nav-link" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" style="color: var(--primary-color) !important; font-weight: 600;">
								<i class="fas fa-shopping-cart me-2"></i>Tienda Virtual
							</a>
						</li>
					@endif
					<li class="nav-item">
						<a class="btn btn-whatsapp-header" href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Quiero%20información%20sobre%20sus%20productos%20de%20marroquinería" target="_blank">
							<i class="fab fa-whatsapp me-2"></i>WhatsApp
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Hero Section -->
	<section id="home" class="hero-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6" data-aos="fade-right">
					<div class="hero-content">
						<h1 class="hero-title animate__animated animate__fadeInUp">{{ $landing->titulo_principal }}</h1>
						<h2 class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">{{ $landing->subtitulo }}</h2>
						<p class="hero-description animate__animated animate__fadeInUp animate__delay-2s">{{ $landing->descripcion }}</p>
						<div class="animate__animated animate__fadeInUp animate__delay-3s">
							<a href="#about" class="btn-primary-custom"><i class="fas fa-rocket me-2"></i>Descubrir</a>
							<a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Quiero%20comprar%20un%20producto" target="_blank" class="btn-outline-custom"><i class="fab fa-whatsapp me-2"></i>Contactar</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6" data-aos="fade-left">
					<div class="hero-image">
						@if($landing->media && $landing->media->count() > 0)
							<img src="{{ asset('storage/' . $landing->media->first()->url) }}" alt="{{ $landing->media->first()->descripcion ?? 'Producto ' . $empresa->nombre }}" class="animate__animated animate__fadeIn animate__delay-1s">
						@else
							<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="animate__animated animate__fadeIn animate__delay-1s">
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- About Section -->
	<section id="about" class="section about-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-6" data-aos="fade-right">
					<h2 class="section-title text-start">Sobre {{ $empresa->nombre }}</h2>
					<p class="section-subtitle text-start">{{ $landing->descripcion_objetivo }}</p>
					<div class="about-card">
						<div class="about-icon"><i class="fas fa-bag-shopping"></i></div>
						<h4>Marroquinería en Cuero</h4>
						<p>En <strong>{{ $empresa->nombre }}</strong> elaboramos y seleccionamos productos de cuero originales con diseño elegante y funcional para damas y caballeros: bolsos, carteras, maletines y más.</p>
						<p class="mt-3">Encuéntranos en <strong>{{ $empresa->direccion }}</strong>. Te brindamos asesoría personalizada para que elijas el complemento ideal para tu estilo.</p>
					</div>
				</div>
				<div class="col-lg-6" data-aos="fade-left">
					@if($landing->media && $landing->media->count() > 1)
						<img src="{{ asset('storage/' . $landing->media->skip(1)->first()->url) }}" alt="Sobre {{ $empresa->nombre }}" class="img-fluid rounded-4 shadow-lg">
					@else
						<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Sobre {{ $empresa->nombre }}" class="img-fluid rounded-4 shadow-lg">
					@endif
				</div>
			</div>
		</div>
	</section>

	<!-- Problems Section -->
	<section id="problems" class="section problems-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Problemas que Resolvemos</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_problemas }}</p>

			<div class="row">
				@php
					$problems = [
						[ 'icon' => 'fas fa-shield-alt', 'title' => 'Calidad y Autenticidad', 'description' => 'Evita imitaciones. Ofrecemos productos en cuero original con garantía y acabados premium.' ],
						[ 'icon' => 'fas fa-palette', 'title' => 'Estilo y Versatilidad', 'description' => 'Diseños pensados para looks casuales, modernos o clásicos, que se adaptan a cada ocasión.' ],
						[ 'icon' => 'fas fa-box-open', 'title' => 'Disponibilidad y Entrega', 'description' => 'Stock real y envíos ágiles para que recibas tu producto sin demoras.' ],
						[ 'icon' => 'fas fa-hand-holding-heart', 'title' => 'Asesoría Personalizada', 'description' => 'Te ayudamos a elegir el producto ideal según tus necesidades y estilo.' ],
					];
				@endphp

				@foreach($problems as $index => $problem)
					<div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
						<div class="problem-card">
							<div class="problem-icon"><i class="{{ $problem['icon'] }}"></i></div>
							<h5>{{ $problem['title'] }}</h5>
							<p>{{ $problem['description'] }}</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Benefits Section -->
	<section id="benefits" class="section benefits-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Beneficios Exclusivos</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_beneficios }}</p>

			<div class="row">
				@php
					$benefits = [
						[ 'icon' => 'fas fa-certificate', 'title' => 'Cuero Original', 'description' => 'Garantía de autenticidad y durabilidad en cada pieza.' ],
						[ 'icon' => 'fas fa-ruler-combined', 'title' => 'Diseño Funcional', 'description' => 'Compartimentos y acabados pensados para tu día a día.' ],
						[ 'icon' => 'fas fa-headset', 'title' => 'Soporte Dedicado', 'description' => 'Acompañamiento antes y después de tu compra.' ],
						[ 'icon' => 'fas fa-truck-fast', 'title' => 'Envíos Rápidos', 'description' => 'Logística confiable y entregas oportunas.' ],
					];
				@endphp

				@foreach($benefits as $index => $benefit)
					<div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
						<div class="benefit-card">
							<div class="benefit-icon"><i class="{{ $benefit['icon'] }}"></i></div>
							<h5>{{ $benefit['title'] }}</h5>
							<p>{{ $benefit['description'] }}</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Gallery Section -->
	<section id="gallery" class="section gallery-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Nuestra Colección</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Descubre bolsos, carteras, maletines y accesorios que combinan elegancia y funcionalidad.</p>

			<div class="row">
				@if($landing->media && $landing->media->count() > 0)
					@foreach($landing->media as $index => $media)
						<div class="col-lg-6 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
							<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $media->url) }}" data-description="{{ $media->descripcion ?? ('Producto - ' . $empresa->nombre) }}" data-index="{{ $index }}">
								<img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? ('Producto - ' . $empresa->nombre) }}">
								<div class="gallery-overlay">
									<i class="fas fa-search-plus"></i>
									<p>{{ $media->descripcion ?? 'Ver imagen' }}</p>
								</div>
							</div>
						</div>
					@endforeach
				@else
					@for($i = 0; $i < 4; $i++)
						<div class="col-lg-6 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
							<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $landing->logo_url) }}" data-description="Producto {{ $i + 1 }} - {{ $empresa->nombre }}" data-index="{{ $i }}">
								<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Producto {{ $i + 1 }} - {{ $empresa->nombre }}">
								<div class="gallery-overlay">
									<i class="fas fa-search-plus"></i>
									<p>Ver imagen</p>
								</div>
							</div>
						</div>
					@endfor
				@endif
			</div>

			@if(isset($productosActivos) && $productosActivos > 0)
				<div class="text-center mt-4" data-aos="fade-up">
					<a href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" class="btn-primary-custom">
						<i class="fas fa-shopping-cart me-2"></i>Ver Tienda Completa
					</a>
				</div>
			@endif
		</div>
	</section>

	<!-- Community Section -->
	<section id="community" class="section community-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Nuestra Comunidad</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->objetivo }}</p>

			<div class="row">
				@php
					$testimonials = [
						[ 'name' => 'Laura G.', 'avatar' => 'L', 'profession' => 'Ejecutiva Comercial', 'comment' => 'Compré un bolso en cuero precioso. Los acabados son impecables y es muy cómodo para el día a día. 100% recomendado.', 'rating' => 5 ],
						[ 'name' => 'Carlos M.', 'avatar' => 'C', 'profession' => 'Arquitecto', 'comment' => 'El maletín para portátil superó mis expectativas: elegante, resistente y con buen espacio para organizar.', 'rating' => 5 ],
						[ 'name' => 'Andrea P.', 'avatar' => 'A', 'profession' => 'Diseñadora', 'comment' => 'Excelente atención y productos auténticos. Mi cartera es hermosa y práctica.', 'rating' => 5 ],
					];
				@endphp

				@foreach($testimonials as $index => $testimonial)
					<div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
						<div class="testimonial-card">
							<div class="testimonial-avatar">{{ $testimonial['avatar'] }}</div>
							<div class="stars">
								@for($i = 0; $i < $testimonial['rating']; $i++)
									<i class="fas fa-star"></i>
								@endfor
							</div>
							<p>"{{ $testimonial['comment'] }}"</p>
							<strong>{{ $testimonial['name'] }}</strong><br>
							<small class="text-muted">{{ $testimonial['profession'] }}</small>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Contact Section -->
	<section id="contact" class="section contact-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Contáctanos</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Estamos listos para ayudarte a elegir el producto perfecto</p>

			<div class="row">
				<div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
					<div class="contact-card">
						<div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
						<h5>WhatsApp</h5>
						<p>{{ $empresa->whatsapp ?? $empresa->movil }}</p>
						<a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}" target="_blank" class="btn btn-outline-light btn-sm">Enviar Mensaje</a>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
					<div class="contact-card">
						<div class="contact-icon"><i class="fas fa-envelope"></i></div>
						<h5>Email</h5>
						<p>{{ $empresa->email }}</p>
						<a href="mailto:{{ $empresa->email }}" class="btn btn-outline-light btn-sm">Enviar Email</a>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
					<div class="contact-card">
						<div class="contact-icon"><i class="fas fa-phone"></i></div>
						<h5>Teléfono</h5>
						<p>{{ $empresa->movil }}</p>
						<a href="tel:+57{{ preg_replace('/\D/', '', $empresa->movil) }}" class="btn btn-outline-light btn-sm">Llamar</a>
					</div>
				</div>

				<div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
					<div class="contact-card">
						<div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
						<h5>Ubicación</h5>
						<p>{{ $empresa->direccion }}</p>
						<a href="https://www.google.com/maps/search/{{ urlencode($empresa->direccion) }}" target="_blank" class="btn btn-outline-light btn-sm">Ver en Google Maps</a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 mb-4">
					<div class="footer-logo">
						<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
					</div>
					<p>Marroquinería en cuero original. Productos elegantes, funcionales y con garantía de calidad.</p>
					<div class="social-links">
						@if(!empty($empresa->facebook))
							<a href="{{ $empresa->facebook }}" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
						@endif
						@if(!empty($empresa->instagram))
							<a href="{{ $empresa->instagram }}" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
						@endif
						@if(!empty($empresa->tiktok))
							<a href="{{ $empresa->tiktok }}" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
						@endif
						@if(!empty($empresa->youtube))
							<a href="{{ $empresa->youtube }}" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
						@endif
						@if(!empty($empresa->linkedin))
							<a href="{{ $empresa->linkedin }}" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
						@endif
						@if(!empty($empresa->twitter))
							<a href="{{ $empresa->twitter }}" target="_blank" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
						@endif
						@if($empresa->whatsapp ?? $empresa->movil)
							<a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
						@endif
						@if(!empty($empresa->website))
							<a href="{{ $empresa->website }}" target="_blank" aria-label="Sitio Web"><i class="fas fa-globe"></i></a>
						@endif
					</div>
				</div>
				<div class="col-lg-2 col-md-6 mb-4">
					<h5>Enlaces</h5>
					<ul class="list-unstyled">
						<li><a href="#home" class="footer-link">Inicio</a></li>
						<li><a href="#about" class="footer-link">Nosotros</a></li>
						<li><a href="#benefits" class="footer-link">Beneficios</a></li>
						<li><a href="#gallery" class="footer-link">Productos</a></li>
						<li><a href="#contact" class="footer-link">Contacto</a></li>
						@if(isset($productosActivos) && $productosActivos > 0)
							<li><a href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" class="footer-link">Tienda Virtual</a></li>
						@endif
					</ul>
				</div>
				<div class="col-lg-3 col-md-6 mb-4">
					<h5>Contacto</h5>
					<ul class="list-unstyled">
						<li>
							<i class="fas fa-map-marker-alt me-2"></i>
							<a href="https://www.google.com/maps/search/{{ urlencode($empresa->direccion) }}" target="_blank" class="footer-link">{{ $empresa->direccion }}</a>
						</li>
						<li>
							<i class="fab fa-whatsapp me-2"></i>
							<a href="https://wa.me/57{{ $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Quiero%20información%20de%20sus%20productos" target="_blank" class="footer-link">{{ $empresa->movil }}</a>
						</li>
						<li>
							<i class="fas fa-envelope me-2"></i>
							<a href="mailto:{{ $empresa->email }}" class="footer-link">{{ $empresa->email }}</a>
						</li>
					</ul>
				</div>
				<div class="col-lg-3 col-md-6 mb-4">
					<h5>Legal</h5>
					<ul class="list-unstyled">
						@if($empresa->terminos_condiciones)
							<li><a href="#" data-bs-toggle="modal" data-bs-target="#modalTerminos" class="footer-link">Términos y Condiciones</a></li>
						@endif
						@if($empresa->politica_privacidad)
							<li><a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacidad" class="footer-link">Política de Privacidad</a></li>
						@endif
						@if($empresa->politica_cookies)
							<li><a href="#" data-bs-toggle="modal" data-bs-target="#modalCookies" class="footer-link">Política de Cookies</a></li>
						@endif
					</ul>
				</div>
			</div>
			<hr class="my-3">
			<div class="row">
				<div class="col-12 text-center">
					<p class="mb-0">&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
				</div>
			</div>
		</div>
	</footer>

	<!-- WhatsApp Floating Button -->
	<a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Quiero%20información%20sobre%20sus%20productos" class="whatsapp-float" target="_blank">
		<i class="fab fa-whatsapp"></i>
	</a>

	<!-- Legal Modals -->
	@if($empresa->terminos_condiciones)
		<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header" style="background: var(--primary-color); color: #fff;">
						<h5 class="modal-title">Términos y Condiciones</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">{!! $empresa->terminos_condiciones !!}</div>
				</div>
			</div>
		</div>
	@endif

	@if($empresa->politica_privacidad)
		<div class="modal fade" id="modalPrivacidad" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header" style="background: var(--primary-color); color: #fff;">
						<h5 class="modal-title">Política de Privacidad</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">{!! $empresa->politica_privacidad !!}</div>
				</div>
			</div>
		</div>
	@endif

	@if($empresa->politica_cookies)
		<div class="modal fade" id="modalCookies" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header" style="background: var(--primary-color); color: #fff;">
						<h5 class="modal-title">Política de Cookies</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">{!! $empresa->politica_cookies !!}</div>
				</div>
			</div>
		</div>
	@endif

	<!-- Gallery Modal -->
	<div class="modal fade gallery-modal" id="galleryModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="galleryModalTitle">Producto</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<img id="galleryModalImage" src="" alt="" class="modal-image">
					<button class="gallery-nav-btn prev" id="galleryPrev"><i class="fas fa-chevron-left"></i></button>
					<button class="gallery-nav-btn next" id="galleryNext"><i class="fas fa-chevron-right"></i></button>
					<div class="gallery-counter"><span id="galleryCounter">1 / 1</span></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

	<script>
		// Initialize AOS
		AOS.init({ duration: 900, once: true, offset: 100 });

		// Navbar scroll effect
		window.addEventListener('scroll', function() {
			const navbar = document.querySelector('.navbar');
			if (window.scrollY > 50) navbar.classList.add('scrolled'); else navbar.classList.remove('scrolled');
		});

		// Smooth scrolling for anchor links
		document.querySelectorAll('a[href^="#"]').forEach(anchor => {
			anchor.addEventListener('click', function (e) {
				const href = this.getAttribute('href');
				if (!href || href === '#') return;
				const target = document.querySelector(href);
				if (target) {
					e.preventDefault();
					const offsetTop = target.offsetTop - 80;
					window.scrollTo({ top: offsetTop, behavior: 'smooth' });
				}
			});
		});

		// Auto-collapse navbar on mobile after click
		document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
			link.addEventListener('click', () => {
				const navbar = document.querySelector('.navbar-collapse');
				if (navbar && navbar.classList.contains('show')) {
					const bsCollapse = new bootstrap.Collapse(navbar);
					bsCollapse.hide();
				}
			});
		});

		// Gallery Lightbox functionality
		let galleryImages = [];
		let currentImageIndex = 0;

		// Collect all gallery images
		document.querySelectorAll('.gallery-item').forEach((item) => {
			const imageSrc = item.getAttribute('data-image');
			const description = item.getAttribute('data-description');
			galleryImages.push({ src: imageSrc, description: description });
		});

		const galleryModal = document.getElementById('galleryModal');
		const galleryModalImage = document.getElementById('galleryModalImage');
		const galleryModalTitle = document.getElementById('galleryModalTitle');
		const galleryCounter = document.getElementById('galleryCounter');
		const galleryPrev = document.getElementById('galleryPrev');
		const galleryNext = document.getElementById('galleryNext');

		// Open gallery modal
		document.querySelectorAll('.gallery-item').forEach((item) => {
			item.addEventListener('click', function() {
				currentImageIndex = parseInt(this.getAttribute('data-index')) || 0;
				showGalleryImage(currentImageIndex);
			});
		});

		function showGalleryImage(index) {
			if (galleryImages.length === 0) return;
			const image = galleryImages[index];
			galleryModalImage.src = image.src;
			galleryModalImage.alt = image.description || '';
			galleryModalTitle.textContent = image.description || 'Producto';
			galleryCounter.textContent = `${index + 1} / ${galleryImages.length}`;
			galleryPrev.style.display = galleryImages.length > 1 ? 'block' : 'none';
			galleryNext.style.display = galleryImages.length > 1 ? 'block' : 'none';
		}

		function showPreviousImage() {
			currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : galleryImages.length - 1;
			showGalleryImage(currentImageIndex);
		}

		function showNextImage() {
			currentImageIndex = currentImageIndex < galleryImages.length - 1 ? currentImageIndex + 1 : 0;
			showGalleryImage(currentImageIndex);
		}

		galleryPrev.addEventListener('click', showPreviousImage);
		galleryNext.addEventListener('click', showNextImage);

		// Keyboard navigation
		document.addEventListener('keydown', function(e) {
			const isOpen = galleryModal.classList.contains('show');
			if (!isOpen) return;
			if (e.key === 'ArrowLeft') showPreviousImage();
			else if (e.key === 'ArrowRight') showNextImage();
			else if (e.key === 'Escape') {
				const modal = bootstrap.Modal.getInstance(galleryModal);
				if (modal) modal.hide();
			}
		});

		// Prevent image dragging
		galleryModalImage.addEventListener('dragstart', function(e) { e.preventDefault(); });
	</script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{{ $landing->descripcion }}">
	<meta name="keywords" content="sangría artesanal, vino tinto, frutas naturales, tablas de queso, gourmet, La Tinta Rica">
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- AOS Animations -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

	<!-- Google Fonts (tipografía dinámica) -->
	<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;600;700&display=swap" rel="stylesheet">

	<style>
		:root {
			--primary-color: {{ $landing->color_principal }};
			--secondary-color: {{ $landing->color_secundario ?? '#6c757d' }};
			--font-family: '{{ $landing->tipografia }}', sans-serif;
			--bg-cream: #fff7f3;
			--bg-light: #f8f9fa;
			--text-dark: #2c2c2c;
		}

		* { box-sizing: border-box; }
		body {
			font-family: var(--font-family);
			color: var(--text-dark);
			background: var(--bg-cream);
			overflow-x: hidden;
		}

		/* Navbar */
		.navbar {
			background: rgba(255,255,255,0.95) !important;
			backdrop-filter: blur(16px);
			border-bottom: 1px solid rgba(0,0,0,0.06);
			box-shadow: 0 2px 18px rgba(0,0,0,0.06);
			transition: all .3s ease;
		}
		.navbar.scrolled { box-shadow: 0 6px 30px rgba(0,0,0,0.12); }
		.navbar-brand img { max-height: 56px; object-fit: contain; }
		.nav-link {
			color: var(--text-dark) !important;
			font-weight: 600;
			margin: 0 10px;
			position: relative;
		}
		.nav-link::after {
			content: '';
			position: absolute; left: 50%; bottom: -6px; height: 2px; width: 0;
			background: var(--primary-color); transform: translateX(-50%);
			transition: width .25s ease;
		}
		.nav-link:hover { color: var(--primary-color) !important; }
		.nav-link:hover::after { width: 70%; }
		.btn-whatsapp-header {
			background: var(--primary-color);
			color: #fff; border: 2px solid var(--primary-color);
			padding: 10px 20px; border-radius: 40px; font-weight: 700;
		}
		.btn-whatsapp-header:hover { background: transparent; color: var(--primary-color); }

		/* Hero */
		.hero-section {
			position: relative; min-height: 100vh; display: flex; align-items: center;
			background: radial-gradient(1200px 600px at 85% 20%, rgba(110,0,0,0.08), transparent 60%), #fff;
			padding-top: 96px;
		}
		.hero-title { font-size: clamp(2.2rem, 4vw, 3.4rem); font-weight: 800; color: var(--text-dark); }
		.hero-subtitle { color: var(--primary-color); font-weight: 700; margin-top: 10px; }
		.hero-description { color: #5a5a5a; font-size: 1.1rem; line-height: 1.8; margin: 20px 0 30px; }
		.btn-primary-custom, .btn-outline-custom {
			padding: 14px 28px; border-radius: 40px; font-weight: 700; text-decoration: none; display: inline-block; margin-right: 12px; margin-bottom: 12px;
		}
		.btn-primary-custom { background: var(--primary-color); color: #fff; border: 2px solid var(--primary-color); }
		.btn-primary-custom:hover { background: transparent; color: var(--primary-color); }
		.btn-outline-custom { background: transparent; color: var(--text-dark); border: 2px solid var(--text-dark); }
		.btn-outline-custom:hover { background: var(--text-dark); color: #fff; }

		/* Sections */
		.section { padding: 90px 0; position: relative; }
		.section-title { font-weight: 800; text-align: center; margin-bottom: 10px; color: var(--text-dark); }
		.section-subtitle { text-align: center; color: #666; max-width: 740px; margin: 0 auto 50px; }

		/* Cards */
		.about-card, .problem-card, .benefit-card {
			border-radius: 18px; padding: 32px; background: #fff; border: 1px solid rgba(0,0,0,0.06);
			box-shadow: 0 12px 32px rgba(0,0,0,0.06); height: 100%;
		}
		.about-icon, .problem-icon, .benefit-icon {
			width: 72px; height: 72px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 1.6rem; color: #fff;
		}
		.about-icon { background: linear-gradient(135deg, var(--primary-color), #b30000); }
		.problem-icon { background: linear-gradient(135deg, #ff6b6b, #ff4757); border-radius: 50%; }
		.benefit-card { background: linear-gradient(135deg, var(--primary-color), #8a0014); color: #fff; border: none; }
		.benefit-icon { background: rgba(255,255,255,0.2); border-radius: 50%; }

		/* Gallery */
		.gallery-section { background: var(--bg-light); }
		.gallery-item { border-radius: 16px; overflow: hidden; background: #fff; box-shadow: 0 16px 40px rgba(0,0,0,0.08); cursor: pointer; }
		.gallery-item img { width: 100%; height: 280px; object-fit: cover; transition: transform .3s ease; }
		.gallery-item:hover img { transform: scale(1.05); }
		.gallery-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.4), transparent 60%); color: #fff; padding: 14px; display: flex; align-items: flex-end; opacity: .0; transition: opacity .25s ease; }
		.gallery-item:hover .gallery-overlay { opacity: 1; }

		/* Contact */
		.contact-card { border-radius: 18px; padding: 28px; background: #1f1f1f; color: #fff; }
		.contact-card a { color: #fff; text-decoration: none; }
		.contact-card a:hover { color: #ffd1d6; }

		/* Footer */
		.site-footer { background: #111; color: #ddd; padding: 60px 0 30px; }
		.footer-link { color: #ddd; text-decoration: none; }
		.footer-link:hover { color: #fff; }

		/* Responsive */
		@media (max-width: 991px) {
			.section { padding: 60px 0; }
			.navbar-brand img { max-height: 44px; }
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
							<a class="nav-link" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" style="color: var(--primary-color) !important; font-weight: 700;">
								<i class="fas fa-shopping-cart me-2"></i>Tienda Virtual
							</a>
						</li>
					@endif
					<li class="nav-item">
						<a class="btn btn-whatsapp-header" href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Estoy%20interesado%20en%20{{ urlencode($landing->titulo_principal) }}" target="_blank">
							<i class="fab fa-whatsapp me-2"></i>WhatsApp
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Hero -->
	<section id="home" class="hero-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6" data-aos="fade-right">
					<h1 class="hero-title animate__animated animate__fadeInUp">{{ $landing->titulo_principal }}</h1>
					<h2 class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">{{ $landing->subtitulo }}</h2>
					<p class="hero-description animate__animated animate__fadeInUp animate__delay-2s">{{ $landing->descripcion }}</p>
					<div class="animate__animated animate__fadeInUp animate__delay-3s">
						<a href="#about" class="btn-primary-custom"><i class="fas fa-wine-bottle me-2"></i>Descubrir</a>
						@if(isset($productosActivos) && $productosActivos > 0)
							<a href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" class="btn-outline-custom"><i class="fas fa-shopping-cart me-2"></i>Comprar ahora</a>
						@else
							<a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Quiero%20comprar%20La%20Tinta%20Rica%20Sangr%C3%ADa" target="_blank" class="btn-outline-custom"><i class="fab fa-whatsapp me-2"></i>Ordenar por WhatsApp</a>
						@endif
					</div>
				</div>
				<div class="col-lg-6" data-aos="fade-left">
					<div class="position-relative">
						@if($landing->media && $landing->media->count() > 0)
							<img src="{{ asset('storage/' . $landing->media->first()->url) }}" alt="{{ $landing->media->first()->descripcion ?? ('Imagen de ' . $empresa->nombre) }}" class="img-fluid rounded-4 shadow-lg animate__animated animate__fadeIn animate__delay-1s">
						@else
							<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="img-fluid rounded-4 shadow-lg animate__animated animate__fadeIn animate__delay-1s">
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- About -->
	<section id="about" class="section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Sobre La Tinta Rica</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->descripcion_objetivo }}</p>
			<div class="row g-4">
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
					<div class="about-card h-100">
						<div class="about-icon"><i class="fas fa-leaf"></i></div>
						<h5>Artesanal y Natural</h5>
						<p>Elaborada con vino tinto semidulce y frutas naturales maceradas. Una receta ancestral perfeccionada con pasión.</p>
					</div>
				</div>
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="250">
					<div class="about-card h-100">
						<div class="about-icon"><i class="fas fa-award"></i></div>
						<h5>Calidad Premium</h5>
						<p>Presentaciones elegantes listas para servir. Ideal para eventos, regalos y momentos especiales.</p>
					</div>
				</div>
				<div class="col-md-12 col-lg-4" data-aos="fade-up" data-aos-delay="350">
					<div class="about-card h-100">
						<div class="about-icon"><i class="fas fa-location-dot"></i></div>
						<h5>Hecho en {{ $empresa->direccion }}</h5>
						<p>Apoyamos lo local y celebramos el buen gusto. Escríbenos: <strong>{{ $empresa->email }}</strong>.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Problems -->
	<section id="problems" class="section" style="background: var(--bg-light)">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">¿Qué problemas resolvemos?</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_problemas }}</p>
			<div class="row g-4">
				@php
					$problemas = [
						['icon' => 'fa-circle-exclamation', 'title' => 'Opciones poco auténticas', 'desc' => 'Productos que no transmiten calidad ni naturalidad para tus eventos.'],
						['icon' => 'fa-clock', 'title' => 'Poco tiempo para planear', 'desc' => 'Maridajes y detalles gastronómicos demandan tiempo que quizá no tienes.'],
						['icon' => 'fa-triangle-exclamation', 'title' => 'Impacto insuficiente', 'desc' => 'Necesitas sorprender a tus invitados o clientes con algo memorable.'],
					];
				@endphp
				@foreach($problemas as $i => $p)
					<div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ 150 + ($i*120) }}">
						<div class="problem-card text-center">
							<div class="problem-icon mx-auto"><i class="fas {{ $p['icon'] }}"></i></div>
							<h5 class="mt-2">{{ $p['title'] }}</h5>
							<p class="mb-0">{{ $p['desc'] }}</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Benefits -->
	<section id="benefits" class="section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Beneficios que te encantarán</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_beneficios }}</p>
			<div class="row g-4">
				@php
					$beneficios = [
						['icon' => 'fa-champagne-glasses', 'title' => 'Gourmet listo para servir', 'desc' => 'Sangría 100% natural y tablas de queso premium listas para disfrutar.'],
						['icon' => 'fa-gift', 'title' => 'Presentación elegante', 'desc' => 'Diseño premium para regalar o compartir con estilo.'],
						['icon' => 'fa-hand-holding-heart', 'title' => 'Marca con propósito', 'desc' => 'Apoyo al emprendimiento local con pasión y autenticidad.'],
					];
				@endphp
				@foreach($beneficios as $i => $b)
					<div class="col-md-6 col-lg-4" data-aos="zoom-in-up" data-aos-delay="{{ 150 + ($i*120) }}">
						<div class="benefit-card text-center h-100">
							<div class="benefit-icon mx-auto"><i class="fas {{ $b['icon'] }}"></i></div>
							<h5 class="mt-2">{{ $b['title'] }}</h5>
							<p class="mb-0">{{ $b['desc'] }}</p>
						</div>
					</div>
				@endforeach
			</div>
			<div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
				@if(isset($productosActivos) && $productosActivos > 0)
					<a href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" class="btn-primary-custom"><i class="fas fa-shopping-bag me-2"></i>Ver Tienda</a>
				@endif
				<a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Quiero%20m%C3%A1s%20informaci%C3%B3n%20sobre%20La%20Tinta%20Rica" target="_blank" class="btn-outline-custom"><i class="fab fa-whatsapp me-2"></i>Hablar por WhatsApp</a>
			</div>
		</div>
	</section>

	<!-- Gallery / Media -->
	<section id="gallery" class="section gallery-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Galería</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Así se vive la experiencia La Tinta Rica.</p>
			<div class="row g-4">
				@if($landing->media && $landing->media->count() > 0)
					@foreach($landing->media as $i => $media)
						<div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + ($i%6)*80 }}">
							<div class="gallery-item position-relative" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $media->url) }}" data-caption="{{ $media->descripcion ?? ('Imagen de ' . $empresa->nombre) }}">
								<img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? ('Imagen de ' . $empresa->nombre) }}">
								<div class="gallery-overlay">
									<div>
										<i class="fas fa-magnifying-glass me-2"></i>{{ $media->descripcion ?? 'Ver imagen' }}
									</div>
								</div>
							</div>
						</div>
					@endforeach
				@else
					<div class="col-12" data-aos="fade-up">
						<div class="gallery-item position-relative">
							<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
						</div>
					</div>
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

	<!-- Community / Testimonials -->
	<section id="community" class="section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Nuestra Comunidad</h2>
			{{-- <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->objetivo }}</p> --}}
			@php
				$testimonios = [
					['name' => 'María Fernanda', 'role' => 'Eventos Corporativos', 'comment' => 'La sangría es deliciosa y elegante. La usamos en un cóctel empresarial y fue un éxito total. Presentación impecable y sabor inolvidable.'],
					['name' => 'Carlos Jiménez', 'role' => 'Cliente Particular', 'comment' => 'Compré la presentación de 1L para una cena en casa y todos quedaron fascinados. Se siente natural y muy bien balanceada.'],
					['name' => 'Hotel Boutique La Casona', 'role' => 'Aliado', 'comment' => 'Ideal para nuestros huéspedes VIP. La combinación de calidad y estética eleva la experiencia gastronómica.'],
				];
			@endphp
			<div class="row g-4">
				@foreach($testimonios as $i => $t)
					<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 120 + ($i*120) }}">
						<div class="about-card h-100">
							<div class="d-flex align-items-center mb-2">
								<div class="about-icon me-3" style="width:54px;height:54px;border-radius:50%"><i class="fas fa-user"></i></div>
								<div>
									<h6 class="mb-0">{{ $t['name'] }}</h6>
									<small class="text-muted">{{ $t['role'] }}</small>
								</div>
							</div>
							<p class="mb-0">“{{ $t['comment'] }}”</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Contacto -->
	<section id="contact" class="section" style="background: var(--bg-light)">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Contacto</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Estamos listos para atender tus pedidos y cotizaciones.</p>
			<div class="row g-4">
				<div class="col-lg-7" data-aos="fade-right">
					<div class="about-card h-100">
						<h5 class="mb-3">Información de la empresa</h5>
						<ul class="list-unstyled mb-0">
							<li class="mb-2"><i class="fas fa-building me-2" style="color: var(--primary-color)"></i><strong>{{ $empresa->nombre }}</strong></li>
							<li class="mb-2"><i class="fas fa-location-dot me-2" style="color: var(--primary-color)"></i>{{ $empresa->direccion }}</li>
							<li class="mb-2"><i class="fas fa-phone me-2" style="color: var(--primary-color)"></i><a href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}" target="_blank">{{ $empresa->movil }}</a></li>
							<li class="mb-2"><i class="fas fa-envelope me-2" style="color: var(--primary-color)"></i><a href="mailto:{{ $empresa->email }}">{{ $empresa->email }}</a></li>
							<li class="mb-2"><i class="fab fa-instagram me-2" style="color: var(--primary-color)"></i><a href="{{ $empresa->instagram }}" target="_blank">Instagram</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-5" data-aos="fade-left">
					<div class="contact-card h-100">
						<h5 class="mb-3">¿Listo para tu pedido?</h5>
						<p class="mb-3">Haz tu orden en un clic y nos pondremos en contacto.</p>
						<div class="d-grid gap-2">
							<a class="btn btn-light btn-lg text-black" href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}?text=Hola%20{{ urlencode($empresa->nombre) }}!%20Quiero%20hacer%20un%20pedido%20de%20sangr%C3%ADa%20artesanal" target="_blank">
								<i class="fab fa-whatsapp me-2"></i>Hacer pedido por WhatsApp
							</a>
							@if(isset($productosActivos) && $productosActivos > 0)
								<a class="btn btn-outline-light btn-lg" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank">
									<i class="fas fa-shopping-cart me-2"></i>Ir a la Tienda
								</a>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="site-footer">
		<div class="container">
			<div class="row g-4 align-items-center">
				<div class="col-md-4 text-center text-md-start">
					<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" style="height: 60px; object-fit: contain;" class="mb-3">
					<p class="mb-2">{{ $empresa->nombre }}</p>
					<div class="d-flex gap-3 justify-content-center justify-content-md-start">
						@if($empresa->instagram)
							<a class="footer-link" href="{{ $empresa->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
						@endif
						@if($empresa->facebook)
							<a class="footer-link" href="{{ $empresa->facebook }}" target="_blank"><i class="fab fa-facebook"></i></a>
						@endif
						@if($empresa->tiktok)
							<a class="footer-link" href="{{ $empresa->tiktok }}" target="_blank"><i class="fab fa-tiktok"></i></a>
						@endif
						@if($empresa->linkedin)
							<a class="footer-link" href="{{ $empresa->linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a>
						@endif
						@if($empresa->youtube)
							<a class="footer-link" href="{{ $empresa->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
						@endif
						@if($empresa->twitter)
							<a class="footer-link" href="{{ $empresa->twitter }}" target="_blank"><i class="fab fa-x-twitter"></i></a>
						@endif
						@if($empresa->website)
							<a class="footer-link" href="{{ $empresa->website }}" target="_blank"><i class="fas fa-globe"></i></a>
						@endif
					</div>
				</div>
				<div class="col-md-4">
					<h6 class="mb-3 text-center text-md-start">Enlaces</h6>
					<ul class="list-unstyled d-flex flex-column gap-2 text-center text-md-start">
						<li><a href="#home" class="footer-link">Inicio</a></li>
						<li><a href="#about" class="footer-link">Nosotros</a></li>
						<li><a href="#gallery" class="footer-link">Productos</a></li>
						<li><a href="#contact" class="footer-link">Contacto</a></li>
						<li><a href="#" data-bs-toggle="modal" data-bs-target="#modalTerminos" class="footer-link">Términos y Condiciones</a></li>
						<li><a href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacidad" class="footer-link">Política de Privacidad</a></li>
						@if($empresa->politica_cookies)
							<li><a href="#" data-bs-toggle="modal" data-bs-target="#modalCookies" class="footer-link">Política de Cookies</a></li>
						@endif
					</ul>
				</div>
				<div class="col-md-4 text-center text-md-start">
					<h6 class="mb-3">Contáctanos</h6>
					<p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>{{ $empresa->direccion }}</p>
					<p class="mb-1"><i class="fas fa-envelope me-2"></i><a class="footer-link" href="mailto:{{ $empresa->email }}">{{ $empresa->email }}</a></p>
					<p class="mb-1"><i class="fab fa-whatsapp me-2"></i><a class="footer-link" href="https://wa.me/57{{ $empresa->whatsapp ?? $empresa->movil }}" target="_blank">{{ $empresa->movil }}</a></p>
					@if(isset($productosActivos) && $productosActivos > 0)
						<p class="mt-2"><a class="footer-link" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank"><i class="fas fa-shopping-cart me-2"></i>Ir a la Tienda</a></p>
					@endif
				</div>
			</div>
			<hr class="my-4" style="border-color: rgba(255,255,255,.15)">
			<div class="text-center small">© {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</div>
		</div>
	</footer>

	<!-- Gallery Modal -->
	<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content bg-dark text-white">
				<div class="modal-header border-0">
					<h5 class="modal-title">Galería</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body text-center">
					<img id="galleryModalImage" src="" alt="Imagen" class="img-fluid" style="max-height:70vh; object-fit:contain;">
					<p id="galleryModalCaption" class="mt-3 text-muted"></p>
				</div>
			</div>
		</div>
	</div>

	<!-- Modales Legales -->
	<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Términos y Condiciones</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					{!! $empresa->terminos_condiciones ?? '<p>No hay información disponible por ahora.</p>' !!}
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalPrivacidad" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Política de Privacidad</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					{!! $empresa->politica_privacidad ?? '<p>No hay información disponible por ahora.</p>' !!}
				</div>
			</div>
		</div>
	</div>

	@if($empresa->politica_cookies)
		<div class="modal fade" id="modalCookies" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-scrollable">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Política de Cookies</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
					<div class="modal-body">
						{!! $empresa->politica_cookies !!}
					</div>
				</div>
			</div>
		</div>
	@endif

	<!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		// AOS init
		AOS.init({ once: true, duration: 700, easing: 'ease-out' });

		// Navbar shadow on scroll
		document.addEventListener('scroll', function () {
			const nav = document.querySelector('.navbar');
			if (!nav) return;
			if (window.scrollY > 10) nav.classList.add('scrolled');
			else nav.classList.remove('scrolled');
		});

		// Gallery modal wiring
		const galleryModal = document.getElementById('galleryModal');
		if (galleryModal) {
			galleryModal.addEventListener('show.bs.modal', event => {
				const trigger = event.relatedTarget;
				if (!trigger) return;
				const img = trigger.getAttribute('data-image');
				const caption = trigger.getAttribute('data-caption') || '';
				galleryModal.querySelector('#galleryModalImage').src = img;
				galleryModal.querySelector('#galleryModalCaption').textContent = caption;
			});
		}
	</script>
</body>
</html>

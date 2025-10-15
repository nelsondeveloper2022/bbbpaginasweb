<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{{ $landing->descripcion }}">
	<title>{{ $landing->titulo_principal }} - {{ $empresa->nombre }}</title>

	<!-- Icons & Meta -->
	<link rel="icon" type="image/png" href="{{ asset('storage/' . $landing->logo_url) }}">
	<link rel="shortcut icon" href="{{ asset('storage/' . $landing->logo_url) }}">
	<link rel="apple-touch-icon" href="{{ asset('storage/' . $landing->logo_url) }}">
	<meta name="theme-color" content="{{ $landing->color_principal ?? '#0d6efd' }}">
	<meta property="og:image" content="{{ asset('storage/' . $landing->logo_url) }}">
	<meta property="og:title" content="{{ $landing->titulo_principal }} - {{ $empresa->nombre }}">
	<meta property="og:description" content="{{ $landing->descripcion }}">

	<!-- CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;600;700&display=swap" rel="stylesheet">

	<style>
		:root {
			--primary-color: {{ $landing->color_principal ?? '#0d6efd' }};
			--secondary-color: {{ $landing->color_secundario ?? '#ffc107' }};
			--font-family: '{{ $landing->tipografia ?? 'Inter' }}', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
			--dark: #1b1f23;
			--muted: #6c757d;
			--bg: #f5f7fb;
		}

		body { font-family: var(--font-family); color: var(--dark); background: #fff; overflow-x: hidden; }
		.navbar { background: rgba(255,255,255,.96) !important; backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,.06); box-shadow: 0 2px 16px rgba(0,0,0,.06); }
		.navbar.scrolled { box-shadow: 0 8px 26px rgba(0,0,0,.12); }
		.navbar-brand img { max-height: 56px; object-fit: contain; }
		.nav-link { color: var(--dark) !important; font-weight: 500; position: relative; }
		.nav-link:hover { color: var(--primary-color) !important; }
		.nav-link::after { content:''; position:absolute; left:50%; bottom:-6px; width:0; height:2px; background:var(--primary-color); transform:translateX(-50%); transition:width .25s; }
		.nav-link:hover::after { width:70%; }
		.btn-wa { background: var(--primary-color); border:2px solid var(--primary-color); color:#fff; border-radius: 50px; padding:10px 20px; font-weight:700; }
		.btn-wa:hover { background: transparent; color: var(--primary-color); }

		.hero { min-height: 100vh; display:flex; align-items:center; padding-top:100px; background: linear-gradient(145deg, #fff 0%, var(--bg) 100%); }
		.badge-hero { background: rgba(13,110,253,.1); color: var(--primary-color); border:1px solid rgba(13,110,253,.35); padding:6px 12px; border-radius: 50px; font-weight: 700; font-size: .85rem; display:inline-block; }
		.hero-title { font-size: 3rem; font-weight: 800; line-height: 1.1; margin-top: 12px; }
		.hero-sub { color: var(--primary-color); font-weight: 700; margin: 10px 0 14px; }
		.hero-desc { color: var(--muted); line-height: 1.8; }
		.btn-primary-custom { background: var(--primary-color); color:#fff; border:2px solid var(--primary-color); padding:14px 26px; border-radius:50px; font-weight:700; text-decoration:none; }
		.btn-primary-custom:hover { background: transparent; color: var(--primary-color); }
		.btn-outline-custom { background: transparent; color: var(--dark); border:2px solid var(--dark); padding:14px 26px; border-radius:50px; font-weight:700; text-decoration:none; }
		.btn-outline-custom:hover { background: var(--dark); color:#fff; }

		.section { padding: 90px 0; }
		.section-title { font-size: 2.3rem; font-weight: 800; text-align:center; }
		.section-subtitle { color: var(--muted); text-align:center; max-width: 760px; margin: 12px auto 56px; }

		.card-soft { background:#fff; border:1px solid rgba(0,0,0,.05); border-radius:18px; box-shadow:0 12px 36px rgba(0,0,0,.08); padding:28px; }
		.icon-square { width:72px; height:72px; border-radius:16px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.6rem; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); }

		.problems { background: var(--bg); }
		.problem-card { text-align:center; }
		.problem-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.6rem; background: linear-gradient(135deg, #ff6b6b, #ff5050); margin: 0 auto 16px; }

		.benefit-card { text-align:center; color:#fff; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-radius:16px; padding:26px; height:100%; }
		.benefit-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.6rem; background: rgba(255,255,255,.2); margin: 0 auto 16px; }

		.gallery { background: var(--bg); }
		.gallery-item { border-radius:18px; overflow:hidden; background:#fff; box-shadow:0 12px 40px rgba(0,0,0,.1); margin-bottom:24px; position:relative; cursor:pointer; }
		.gallery-item img { width:100%; height:300px; object-fit:cover; transition: transform .25s; }
		.gallery-item:hover img { transform: scale(1.04); }
		.gallery-overlay { position:absolute; inset:0; background: rgba(0,0,0,.45); display:flex; align-items:center; justify-content:center; color:#fff; opacity:0; transition: opacity .25s; text-align:center; padding:16px; }
		.gallery-item:hover .gallery-overlay { opacity:1; }

		.footer { background: #0b0e12; color: #fff; padding: 60px 0 30px; }
		.footer-link { color:#bfc6ce; text-decoration:none; }
		.footer-link:hover { color: var(--primary-color); }
		.social a { width:44px; height:44px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background: rgba(255,255,255,.08); color:#fff; text-decoration:none; margin-right:10px; }
		.social a:hover { background: var(--primary-color); }
		.wa-float { position:fixed; bottom:26px; right:26px; width:60px; height:60px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#25d366; color:#fff; font-size:1.6rem; z-index:1000; box-shadow:0 12px 28px rgba(37,211,102,.4); }
		.wa-float:hover { background:#20ba5a; color:#fff; }

		@media (max-width: 992px) { .hero-title { font-size: 2.3rem; } .navbar-brand img { max-height:48px; } .section { padding: 70px 0; } }
	</style>
</head>
<body>

@php
	// Normalizar WhatsApp/teléfono
	$raw = $empresa->whatsapp ?? $empresa->movil;
	$wa = preg_replace('/\D+/', '', $raw ?? '');
	if ($wa && substr($wa, 0, 2) !== '57') { $wa = '57' . $wa; }
	$waLink = $wa ? 'https://wa.me/' . $wa : null;
@endphp

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
				<li class="nav-item"><a class="nav-link" href="#services">Servicios</a></li>
				<li class="nav-item"><a class="nav-link" href="#problems">Problemas</a></li>
				<li class="nav-item"><a class="nav-link" href="#benefits">Beneficios</a></li>
				<li class="nav-item"><a class="nav-link" href="#gallery">Galería</a></li>
				<li class="nav-item"><a class="nav-link" href="#community">Comunidad</a></li>
				<li class="nav-item"><a class="nav-link" href="#contact">Contacto</a></li>
				@if(isset($productosActivos) && $productosActivos > 0)
					<li class="nav-item">
						<a class="nav-link" href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" style="color: var(--primary-color) !important; font-weight: 700;">
							<i class="fas fa-shopping-cart me-2"></i>Tienda Virtual
						</a>
					</li>
				@endif
				@if($waLink)
					<li class="nav-item"><a class="btn btn-wa ms-lg-2 mt-2 mt-lg-0" href="{{ $waLink }}?text={{ rawurlencode('Hola ' . $empresa->nombre . '! Estoy interesado en sus servicios de impresión y suministros.') }}" target="_blank"><i class="fab fa-whatsapp me-2"></i>WhatsApp</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>

<!-- Hero -->
<section class="hero" id="home">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6" data-aos="fade-right">
				<span class="badge-hero"><i class="fas fa-print me-2"></i>Soluciones en impresión</span>
				<h1 class="hero-title animate__animated animate__fadeInUp">{{ $landing->titulo_principal }}</h1>
				<h2 class="hero-sub animate__animated animate__fadeInUp animate__delay-1s">{{ $landing->subtitulo }}</h2>
				<p class="hero-desc animate__animated animate__fadeInUp animate__delay-2s">{{ $landing->descripcion }}</p>
				<div class="mt-3 animate__animated animate__fadeInUp animate__delay-3s">
					<a href="#services" class="btn-primary-custom me-2"><i class="fas fa-rocket me-2"></i>Conoce nuestros servicios</a>
					@if($waLink)
						<a href="{{ $waLink }}?text={{ rawurlencode('Hola ' . $empresa->nombre . '! Necesito cotización de tóners/recarga/mantenimiento.') }}" class="btn-outline-custom" target="_blank"><i class="fab fa-whatsapp me-2"></i>Solicitar cotización</a>
					@endif
				</div>
			</div>
			<div class="col-lg-6 mt-4 mt-lg-0" data-aos="fade-left">
				<div class="card-soft">
					@if($landing->media && $landing->media->count() > 0)
						<img src="{{ asset('storage/' . $landing->media->first()->url) }}" alt="{{ $landing->media->first()->descripcion ?? ('Servicios de impresión - ' . $empresa->nombre) }}" class="img-fluid rounded-3">
					@else
						<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" class="img-fluid rounded-3">
					@endif
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Services / About -->
<section id="services" class="section">
	<div class="container">
		<h2 class="section-title" data-aos="fade-up">Servicios Principales</h2>
		<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->descripcion_objetivo }}</p>

		@php
			$services = [
				['icon' => 'fas fa-tint', 'title' => 'Venta de tóners y cartuchos', 'desc' => 'Originales y compatibles para todas las marcas. Calidad y rendimiento garantizados.'],
				['icon' => 'fas fa-fill-drip', 'title' => 'Recarga de cartuchos', 'desc' => 'Recargas profesionales que cuidan tus equipos y aseguran impresiones nítidas.'],
				['icon' => 'fas fa-screwdriver-wrench', 'title' => 'Mantenimiento de impresoras', 'desc' => 'Correctivo y preventivo. Prolonga la vida útil y evita paradas.'],
				['icon' => 'fas fa-box-open', 'title' => 'Suministros de oficina', 'desc' => 'Papel, insumos y papelería para tu operación diaria.'],
			];
		@endphp
		<div class="row g-4">
			@foreach($services as $i => $s)
				<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
					<div class="card-soft h-100 text-center">
						<div class="icon-square mb-3"><i class="{{ $s['icon'] }}"></i></div>
						<h5>{{ $s['title'] }}</h5>
						<p class="mb-0">{{ $s['desc'] }}</p>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<!-- Problems -->
<section id="problems" class="section problems">
	<div class="container">
		<h2 class="section-title" data-aos="fade-up">Problemas que Resolvemos</h2>
		<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_problemas }}</p>
		@php
			$problems = [
				['icon' => 'fas fa-exclamation-triangle', 'title' => 'Impresiones de mala calidad', 'desc' => 'Manchas, rayas o colores opacos por insumos inadecuados o equipos sin mantenimiento.'],
				['icon' => 'fas fa-money-bill-wave', 'title' => 'Costos elevados', 'desc' => 'Gastos innecesarios por consumibles ineficientes y bajas duraciones.'],
				['icon' => 'fas fa-stopwatch', 'title' => 'Tiempos muertos', 'desc' => 'Equipos detenidos por fallas o recambios tardíos afectan tu operación.'],
				['icon' => 'fas fa-question-circle', 'title' => 'Falta de asesoría', 'desc' => 'Dudas sobre compatibilidad, rendimiento y el insumo ideal para cada equipo.'],
			];
		@endphp
		<div class="row g-4">
			@foreach($problems as $i => $p)
				<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
					<div class="card-soft problem-card h-100">
						<div class="problem-icon"><i class="{{ $p['icon'] }}"></i></div>
						<h5>{{ $p['title'] }}</h5>
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
		<h2 class="section-title" data-aos="fade-up">Beneficios</h2>
		<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_beneficios }}</p>
		@php
			$benefits = [
				['icon' => 'fas fa-certificate', 'title' => 'Calidad garantizada', 'desc' => 'Insumos probados para impresiones nítidas y consistentes.'],
				['icon' => 'fas fa-truck-fast', 'title' => 'Entrega rápida', 'desc' => 'Respuestas ágiles para que tu negocio no se detenga.'],
				['icon' => 'fas fa-handshake', 'title' => 'Asesoría experta', 'desc' => 'Te guiamos en la selección ideal para tu equipo y volumen.'],
				['icon' => 'fas fa-shield-halved', 'title' => 'Soporte y garantía', 'desc' => 'Respaldamos tu compra y mantenemos tus equipos operativos.'],
			];
		@endphp
		<div class="row g-4">
			@foreach($benefits as $i => $b)
				<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
					<div class="benefit-card h-100">
						<div class="benefit-icon"><i class="{{ $b['icon'] }}"></i></div>
						<h5>{{ $b['title'] }}</h5>
						<p class="mb-0">{{ $b['desc'] }}</p>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<!-- Gallery / Media -->
<section id="gallery" class="section gallery">
	<div class="container">
		<h2 class="section-title" data-aos="fade-up">Nuestros Trabajos e Insumos</h2>
		<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Explora recargas, mantenimiento y suministros en acción</p>
		<div class="row">
			@if($landing->media && $landing->media->count() > 0)
				@foreach($landing->media as $index => $media)
					<div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
						<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $media->url) }}" data-description="{{ $media->descripcion ?? ('Max Tintas - ' . $empresa->nombre) }}" data-index="{{ $index }}">
							<img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? ('Max Tintas - ' . $empresa->nombre) }}">
							<div class="gallery-overlay"><i class="fas fa-magnifying-glass-plus me-2"></i>Ver imagen</div>
						</div>
					</div>
				@endforeach
			@else
				@for($i = 0; $i < 4; $i++)
					<div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
						<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $landing->logo_url) }}" data-description="Trabajo {{ $i + 1 }} - {{ $empresa->nombre }}" data-index="{{ $i }}">
							<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Trabajo {{ $i + 1 }} - {{ $empresa->nombre }}">
							<div class="gallery-overlay"><i class="fas fa-magnifying-glass-plus me-2"></i>Ver imagen</div>
						</div>
					</div>
				@endfor
			@endif
		</div>

		@if(isset($productosActivos) && $productosActivos > 0)
			<div class="text-center mt-4" data-aos="fade-up">
				<a href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" class="btn-primary-custom"><i class="fas fa-shopping-cart me-2"></i>Ver Tienda Completa</a>
			</div>
		@endif
	</div>
</section>

<!-- Community / Testimonials -->
<section id="community" class="section">
	<div class="container">
		<h2 class="section-title" data-aos="fade-up">Lo que dicen nuestros clientes</h2>
		<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->objetivo }}</p>
		@php
			$testimonials = [
				['name' => 'Papelería La Plaza', 'avatar' => 'P', 'comment' => 'Excelente servicio y atención. Mis cartuchos quedaron como nuevos.', 'rating' => 5],
				['name' => 'Oficina Central', 'avatar' => 'O', 'comment' => 'Rápidos, confiables y con precios justos. Muy recomendados.', 'rating' => 5],
				['name' => 'Impresiones Express', 'avatar' => 'I', 'comment' => 'Nos ayudaron a reducir costos con insumos de alta duración.', 'rating' => 5],
			];
		@endphp
		<div class="row g-4">
			@foreach($testimonials as $i => $t)
				<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
					<div class="card-soft h-100 text-center">
						<div class="mx-auto mb-2" style="width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color:#fff; font-weight:800; font-size:1.6rem;">{{ $t['avatar'] }}</div>
						<div class="mb-2" style="color:#ffc107;">
							@for($s = 0; $s < $t['rating']; $s++)
								<i class="fas fa-star"></i>
							@endfor
						</div>
						<p class="mb-2">"{{ $t['comment'] }}"</p>
						<strong>{{ $t['name'] }}</strong>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<!-- Contact -->
<section id="contact" class="section" style="background:#0f1220;color:#fff;">
	<div class="container">
		<h2 class="section-title" data-aos="fade-up">Contáctanos</h2>
		<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Estamos listos para ayudarte con tus necesidades de impresión</p>
		<div class="row g-4">
			@if($waLink)
				<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
					<div class="card-soft h-100 text-center" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);">
						<div class="icon-square mb-3" style="background:var(--primary-color);"><i class="fab fa-whatsapp"></i></div>
						<h5>WhatsApp</h5>
						<p class="mb-2">{{ $empresa->whatsapp ?? $empresa->movil }}</p>
						<a href="{{ $waLink }}" target="_blank" class="btn btn-outline-light btn-sm">Enviar mensaje</a>
					</div>
				</div>
			@endif
			@if($empresa->email)
				<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
					<div class="card-soft h-100 text-center" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);">
						<div class="icon-square mb-3" style="background:var(--primary-color);"><i class="fas fa-envelope"></i></div>
						<h5>Email</h5>
						<p class="mb-2">{{ $empresa->email }}</p>
						<a href="mailto:{{ $empresa->email }}" class="btn btn-outline-light btn-sm">Enviar email</a>
					</div>
				</div>
			@endif
			@if($empresa->movil)
				<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
					<div class="card-soft h-100 text-center" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);">
						<div class="icon-square mb-3" style="background:var(--primary-color);"><i class="fas fa-phone"></i></div>
						<h5>Teléfono</h5>
						<p class="mb-2">{{ $empresa->movil }}</p>
						@if($waLink)
						<a href="{{ $waLink }}?text={{ rawurlencode('Hola ' . $empresa->nombre . '! Quiero información de tóners y mantenimiento.') }}" target="_blank" class="btn btn-outline-light btn-sm">Contactar</a>
						@endif
					</div>
				</div>
			@endif
			@if($empresa->direccion)
				<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
					<div class="card-soft h-100 text-center" style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);">
						<div class="icon-square mb-3" style="background:var(--primary-color);"><i class="fas fa-map-location-dot"></i></div>
						<h5>Ubicación</h5>
						<p class="mb-2">{{ $empresa->direccion }}</p>
						<a href="https://www.google.com/maps/search/{{ urlencode($empresa->direccion) }}" target="_blank" class="btn btn-outline-light btn-sm">Ver en Maps</a>
					</div>
				</div>
			@endif
		</div>
	</div>
</section>

<!-- Footer -->
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 mb-4">
				<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}" style="max-height:60px;" class="mb-3">
				<p>Productos y servicios especializados en impresión: tóners, recargas, mantenimiento y suministros para tu negocio.</p>
				<div class="social mt-3">
					@if($empresa->facebook)<a href="{{ $empresa->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>@endif
					@if($empresa->instagram)<a href="{{ $empresa->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>@endif
					@if($empresa->tiktok)<a href="{{ $empresa->tiktok }}" target="_blank"><i class="fab fa-tiktok"></i></a>@endif
					@if($empresa->linkedin)<a href="{{ $empresa->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
					@if($empresa->youtube)<a href="{{ $empresa->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>@endif
					@if($empresa->twitter)<a href="{{ $empresa->twitter }}" target="_blank"><i class="fab fa-x-twitter"></i></a>@endif
					@if($empresa->website)<a href="{{ $empresa->website }}" target="_blank"><i class="fas fa-globe"></i></a>@endif
					@if($waLink)<a href="{{ $waLink }}" target="_blank"><i class="fab fa-whatsapp"></i></a>@endif
				</div>
			</div>
			<div class="col-lg-2 col-md-6 mb-4">
				<h5>Enlaces</h5>
				<ul class="list-unstyled mt-3">
					<li><a href="#home" class="footer-link">Inicio</a></li>
					<li><a href="#services" class="footer-link">Servicios</a></li>
					<li><a href="#benefits" class="footer-link">Beneficios</a></li>
					<li><a href="#gallery" class="footer-link">Galería</a></li>
					<li><a href="#contact" class="footer-link">Contacto</a></li>
					@if(isset($productosActivos) && $productosActivos > 0)
						<li><a href="{{ route('public.tienda', $empresa->slug) }}" target="_blank" class="footer-link">Tienda Virtual</a></li>
					@endif
				</ul>
			</div>
			<div class="col-lg-3 col-md-6 mb-4">
				<h5>Contacto</h5>
				<ul class="list-unstyled mt-3">
					@if($empresa->direccion)
						<li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i><a href="https://www.google.com/maps/search/{{ urlencode($empresa->direccion) }}" target="_blank" class="footer-link">{{ $empresa->direccion }}</a></li>
					@endif
					@if($empresa->movil)
						<li class="mb-2"><i class="fas fa-phone me-2"></i><span class="footer-link">{{ $empresa->movil }}</span></li>
					@endif
					@if($empresa->email)
						<li class="mb-2"><i class="fas fa-envelope me-2"></i><a href="mailto:{{ $empresa->email }}" class="footer-link">{{ $empresa->email }}</a></li>
					@endif
				</ul>
			</div>
			<div class="col-lg-3 col-md-6 mb-4">
				<h5>Legal</h5>
				<ul class="list-unstyled mt-3">
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
		<hr class="my-4">
		<div class="row">
			<div class="col-12 text-center">
				<p class="mb-0">&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
			</div>
		</div>
	</div>
</footer>

@if($waLink)
	<a href="{{ $waLink }}?text={{ rawurlencode('Hola ' . $empresa->nombre . '! Me gustaría recibir información de sus servicios de impresión.') }}" class="wa-float" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
@endif

<!-- Legal Modals -->
@if($empresa->terminos_condiciones)
	<div class="modal fade" id="modalTerminos" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header" style="background: var(--primary-color); color:#fff;">
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
				<div class="modal-header" style="background: var(--primary-color); color:#fff;">
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
				<div class="modal-header" style="background: var(--primary-color); color:#fff;">
					<h5 class="modal-title">Política de Cookies</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">{!! $empresa->politica_cookies !!}</div>
			</div>
		</div>
	</div>
@endif

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content" style="background: transparent; border:none; box-shadow:none;">
			<div class="modal-header" style="background: rgba(0,0,0,.85); color:#fff; border:none;">
				<h5 class="modal-title" id="galleryModalTitle">Max Tintas</h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body position-relative" style="background: rgba(0,0,0,.92); display:flex; align-items:center; justify-content:center;">
				<img id="galleryModalImage" src="" alt="" style="width:100%; max-height:70vh; object-fit:contain;">
				<button class="btn btn-dark position-absolute" id="galleryPrev" style="left:20px; top:50%; transform: translateY(-50%); border-radius:50%; width:48px; height:48px;"><i class="fas fa-chevron-left"></i></button>
				<button class="btn btn-dark position-absolute" id="galleryNext" style="right:20px; top:50%; transform: translateY(-50%); border-radius:50%; width:48px; height:48px;"><i class="fas fa-chevron-right"></i></button>
				<div id="galleryCounter" style="position:absolute; bottom:16px; left:50%; transform:translateX(-50%); background: rgba(0,0,0,.6); color:#fff; padding:6px 12px; border-radius:16px; font-size:.9rem;">1 / 1</div>
			</div>
		</div>
	</div>
	</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
	AOS.init({ duration: 900, once: true, offset: 80 });
	window.addEventListener('scroll', () => {
		const nav = document.querySelector('.navbar');
		if (window.scrollY > 50) nav.classList.add('scrolled'); else nav.classList.remove('scrolled');
	});
	document.querySelectorAll('a[href^="#"]').forEach(a => {
		a.addEventListener('click', e => {
			const target = document.querySelector(a.getAttribute('href'));
			if (target) {
				e.preventDefault();
				const y = target.getBoundingClientRect().top + window.pageYOffset - 80;
				window.scrollTo({ top: y, behavior: 'smooth' });
			}
		});
	});
	document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
		link.addEventListener('click', () => {
			const nav = document.querySelector('.navbar-collapse');
			if (nav && nav.classList.contains('show')) new bootstrap.Collapse(nav).hide();
		});
	});

	// Gallery
	let galleryImages = [];
	let currentIndex = 0;
	document.querySelectorAll('.gallery-item').forEach((item, index) => {
		galleryImages.push({
			src: item.getAttribute('data-image'),
			desc: item.getAttribute('data-description') || 'Max Tintas'
		});
		item.addEventListener('click', () => { currentIndex = index; showImage(currentIndex); });
	});
	const galleryModal = document.getElementById('galleryModal');
	const galleryModalImage = document.getElementById('galleryModalImage');
	const galleryModalTitle = document.getElementById('galleryModalTitle');
	const galleryCounter = document.getElementById('galleryCounter');
	const galleryPrev = document.getElementById('galleryPrev');
	const galleryNext = document.getElementById('galleryNext');
	function showImage(i) {
		if (!galleryImages.length) return;
		const g = galleryImages[i];
		galleryModalImage.src = g.src;
		galleryModalImage.alt = g.desc;
		galleryModalTitle.textContent = g.desc;
		galleryCounter.textContent = `${i + 1} / ${galleryImages.length}`;
	}
	function prev() { currentIndex = currentIndex > 0 ? currentIndex - 1 : galleryImages.length - 1; showImage(currentIndex); }
	function next() { currentIndex = currentIndex < galleryImages.length - 1 ? currentIndex + 1 : 0; showImage(currentIndex); }
	if (galleryPrev) galleryPrev.addEventListener('click', prev);
	if (galleryNext) galleryNext.addEventListener('click', next);
	document.addEventListener('keydown', e => {
		if (galleryModal.classList.contains('show')) {
			if (e.key === 'ArrowLeft') prev();
			if (e.key === 'ArrowRight') next();
		}
	});
</script>
</body>
</html>

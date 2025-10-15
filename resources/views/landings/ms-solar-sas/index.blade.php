<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{{ $landing->descripcion }}">
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- AOS Animations -->
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

	<!-- Animate.css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;600;700&display=swap" rel="stylesheet">

	<style>
		:root {
			--primary-color: {{ $landing->color_principal ?? '#79be5c' }};
			--secondary-color: {{ $landing->color_secundario ?? '#f1842f' }};
			--font-family: '{{ $landing->tipografia }}', sans-serif;
			--dark: #1d1d1f;
			--muted: #666;
			--bg: #f7f9fb;
		}

		* { box-sizing: border-box; }

		body {
			font-family: var(--font-family);
			color: var(--dark);
			background: #ffffff;
			overflow-x: hidden;
		}

		/* Navbar */
		.navbar {
			background: rgba(255,255,255,0.95) !important;
			backdrop-filter: blur(16px);
			border-bottom: 1px solid rgba(0,0,0,0.06);
			box-shadow: 0 2px 16px rgba(0,0,0,0.06);
			transition: all .3s ease;
		}
		.navbar.scrolled { box-shadow: 0 6px 24px rgba(0,0,0,0.12); }
		.navbar-brand img { max-width: 25%; object-fit: contain; }
		.nav-link { color: var(--dark) !important; font-weight: 500; position: relative; }
		.nav-link:hover { color: var(--primary-color) !important; }
		.nav-link::after { content:''; position:absolute; left:50%; bottom:-6px; width:0; height:2px; background:var(--primary-color); transform:translateX(-50%); transition:width .25s; }
		.nav-link:hover::after { width:70%; }
		.btn-whatsapp-header { background:var(--primary-color); border:2px solid var(--primary-color); color:#fff; border-radius:50px; padding:10px 22px; font-weight:600; }
		.btn-whatsapp-header:hover { background:transparent; color:var(--primary-color); }

		/* Hero */
		.hero-section { min-height: 100vh; display:flex; align-items:center; padding-top:100px; background: linear-gradient(135deg, #ffffff 0%, var(--bg) 100%); position:relative; overflow:hidden; }
		.hero-badge { display:inline-block; background: rgba(121,190,92,0.12); color: var(--primary-color); border:1px solid rgba(121,190,92,0.35); padding:6px 12px; border-radius: 50px; font-weight:600; font-size:.85rem; }
		.hero-title { font-size: 3rem; font-weight: 800; line-height:1.1; margin-top:12px; }
		.hero-subtitle { color: var(--primary-color); font-weight:700; margin: 12px 0 16px; }
		.hero-description { color: var(--muted); font-size: 1.05rem; line-height:1.8; }
		.hero-image img { max-width:100%; border-radius:22px; box-shadow: 0 24px 60px rgba(0,0,0,0.12); }
		.btn-primary-custom { background:var(--primary-color); color:#fff; border:2px solid var(--primary-color); padding:14px 28px; border-radius:50px; font-weight:700; text-decoration:none; display:inline-block; }
		.btn-primary-custom:hover { background:transparent; color:var(--primary-color); }
		.btn-outline-custom { background:transparent; color:var(--dark); border:2px solid var(--dark); padding:14px 28px; border-radius:50px; font-weight:700; text-decoration:none; display:inline-block; }
		.btn-outline-custom:hover { background:var(--dark); color:#fff; }

		/* Sections */
		.section { padding: 90px 0; position:relative; }
		.section-title { font-size: 2.3rem; font-weight:800; text-align:center; }
		.section-subtitle { text-align:center; color:var(--muted); max-width: 760px; margin: 10px auto 60px; }

		/* About */
		.about-card { background:#fff; padding:36px; border-radius:18px; box-shadow:0 14px 40px rgba(0,0,0,0.08); border:1px solid rgba(0,0,0,0.05); }
		.about-icon { width:74px; height:74px; border-radius:16px; display:flex; align-items:center; justify-content:center; color:#fff; margin-bottom:18px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); font-size:1.8rem; }

		/* Problems */
		.problems-section { background: var(--bg); }
		.problem-card { background:#fff; padding:28px; border-radius:16px; box-shadow:0 10px 32px rgba(0,0,0,0.08); text-align:center; height:100%; }
		.problem-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:#fff; font-size:1.6rem; background: linear-gradient(135deg, #ff6b6b, #ff5050); }

		/* Benefits */
		.benefit-card { background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color:#fff; padding:28px; border-radius:16px; height:100%; text-align:center; }
		.benefit-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:#fff; font-size:1.6rem; background: rgba(255,255,255,0.2); }

		/* Gallery */
		.gallery-section { background: var(--bg); }
		.gallery-item { border-radius:18px; overflow:hidden; background:#fff; box-shadow:0 12px 40px rgba(0,0,0,0.1); margin-bottom:24px; position:relative; cursor:pointer; }
		.gallery-item img { width:100%; height:300px; object-fit:cover; transition: transform .3s; }
		.gallery-item:hover img { transform: scale(1.04); }
		.gallery-overlay { position:absolute; inset:0; background: rgba(0,0,0,0.45); display:flex; align-items:center; justify-content:center; color:#fff; opacity:0; transition:opacity .25s; text-align:center; padding:16px; }
		.gallery-item:hover .gallery-overlay { opacity:1; }
		.gallery-overlay i { font-size:2rem; margin-right:10px; }

		.gallery-modal .modal-content { background: transparent; border:none; box-shadow:none; }
		.gallery-modal .modal-header { background: rgba(0,0,0,0.85); color:#fff; border:none; }
		.gallery-modal .modal-body { background: rgba(0,0,0,0.92); display:flex; align-items:center; justify-content:center; }
		.modal-image { width:100%; max-height:70vh; object-fit:contain; }
		.gallery-nav-btn { position:absolute; top:50%; transform:translateY(-50%); background: rgba(0,0,0,0.55); color:#fff; border:none; width:48px; height:48px; border-radius:50%; }
		.gallery-nav-btn.prev { left:18px; }
		.gallery-nav-btn.next { right:18px; }
		.gallery-counter { position:absolute; bottom:16px; left:50%; transform:translateX(-50%); background: rgba(0,0,0,0.6); color:#fff; padding:6px 12px; border-radius:16px; font-size:.9rem; }

		/* Contact */
		.contact-section { background: #0f1f14; color:#fff; }
		.contact-card { background: rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); border-radius:16px; padding:28px; text-align:center; height:100%; }
		.contact-icon { width:72px; height:72px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 18px; background: var(--primary-color); color:#fff; font-size:1.6rem; }

		/* Footer */
		.footer { background:#000; color:#fff; padding:60px 0 30px; }
		.footer-logo img { max-height:60px; }
		.social-links a { width:44px; height:44px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; margin-right:10px; background: rgba(255,255,255,0.08); color:#fff; text-decoration:none; }
		.social-links a:hover { background: var(--primary-color); }
		.footer-link { color:#bbb; text-decoration:none; }
		.footer-link:hover { color: var(--primary-color); }

		/* Floating WhatsApp */
		.whatsapp-float { position:fixed; bottom:28px; right:28px; width:60px; height:60px; border-radius:50%; background:#25d366; color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.6rem; z-index:1000; box-shadow:0 10px 28px rgba(37,211,102,.4); }
		.whatsapp-float:hover { background:#20ba5a; color:#fff; }

		@media (max-width: 992px) {
			.hero-title { font-size: 2.3rem; }
			.navbar-brand img { max-height:48px; }
			.section { padding: 70px 0; }
		}
	</style>
</head>
<body>

	@php
		// Normalizar número de WhatsApp/móvil: solo dígitos y prefijo 57 si no existe
		$rawPhone = $empresa->whatsapp ?? $empresa->movil;
		$wa = preg_replace('/\D+/', '', $rawPhone ?? '');
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
					<li class="nav-item"><a class="nav-link" href="#about">Nosotros</a></li>
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
						<li class="nav-item">
							<a class="btn btn-whatsapp-header ms-lg-2 mt-2 mt-lg-0" href="{{ $waLink }}?text={{ rawurlencode('Hola ' . $empresa->nombre . '! Estoy interesado en soluciones de energía solar y me gustaría recibir más información.') }}" target="_blank">
								<i class="fab fa-whatsapp me-2"></i>WhatsApp
							</a>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	<!-- Hero -->
	<section id="home" class="hero-section">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6" data-aos="fade-right">
					<span class="hero-badge"><i class="fas fa-solar-panel me-2"></i>Energía solar inteligente</span>
					<h1 class="hero-title animate__animated animate__fadeInUp">{{ $landing->titulo_principal }}</h1>
					<h2 class="hero-subtitle animate__animated animate__fadeInUp animate__delay-1s">{{ $landing->subtitulo }}</h2>
					<p class="hero-description animate__animated animate__fadeInUp animate__delay-2s">{{ $landing->descripcion }}</p>
					<div class="mt-3 animate__animated animate__fadeInUp animate__delay-3s">
						<a href="#about" class="btn-primary-custom me-2"><i class="fas fa-rocket me-2"></i>Conoce más</a>
						@if($waLink)
							<a href="{{ $waLink }}?text={{ rawurlencode('Hola ' . $empresa->nombre . '! Quiero una asesoría en energía solar para mi hogar/empresa.') }}" target="_blank" class="btn-outline-custom"><i class="fab fa-whatsapp me-2"></i>Asesoría</a>
						@endif
					</div>
				</div>
				<div class="col-lg-6 mt-5 mt-lg-0" data-aos="fade-left">
					<div class="hero-image">
						@if($landing->media && $landing->media->count() > 0)
							<img src="{{ asset('storage/' . $landing->media->first()->url) }}" alt="{{ $landing->media->first()->descripcion ?? ('Soluciones Solares - ' . $empresa->nombre) }}">
						@else
							<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- About -->
	<section id="about" class="section">
		<div class="container">
			<div class="row g-4 align-items-center">
				<div class="col-lg-6" data-aos="fade-right">
					<h2 class="section-title text-start">Sobre {{ $empresa->nombre }}</h2>
					<p class="section-subtitle text-start">{{ $landing->descripcion_objetivo }}</p>
					<div class="about-card">
						<div class="about-icon"><i class="fas fa-bolt"></i></div>
						<h4>Energía limpia y ahorro real</h4>
						<p>En <strong>{{ $empresa->nombre }}</strong> diseñamos e instalamos sistemas solares a la medida para hogares y empresas. Optimizamos tu consumo energético, reducimos costos y mejoramos tu autonomía con tecnología de alta eficiencia.</p>
						<p class="mb-0 mt-2"><i class="fas fa-location-dot me-2 text-success"></i>Ubicación: <strong>{{ $empresa->direccion }}</strong></p>
						@if($empresa->email)
							<p class="mb-0"><i class="fas fa-envelope me-2 text-success"></i>Email: <a href="mailto:{{ $empresa->email }}">{{ $empresa->email }}</a></p>
						@endif
					</div>
				</div>
				<div class="col-lg-6" data-aos="fade-left">
					@if($landing->media && $landing->media->count() > 1)
						<img src="{{ asset('storage/' . $landing->media->skip(1)->first()->url) }}" class="img-fluid rounded-4 shadow" alt="Sobre {{ $empresa->nombre }}">
					@else
						<img src="{{ asset('storage/' . $landing->logo_url) }}" class="img-fluid rounded-4 shadow" alt="Sobre {{ $empresa->nombre }}">
					@endif
				</div>
			</div>
		</div>
	</section>

	<!-- Problems -->
	<section id="problems" class="section problems-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Problemas que Resolvemos</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_problemas }}</p>

			@php
				$problems = [
					['icon' => 'fas fa-bolt', 'title' => 'Altas facturas de energía', 'description' => 'Reduce hasta un 90% tu consumo eléctrico con sistemas fotovoltaicos de alto rendimiento.'],
					['icon' => 'fas fa-power-off', 'title' => 'Cortes de servicio', 'description' => 'Obtén independencia energética con respaldo y soluciones off-grid o híbridas.'],
					['icon' => 'fas fa-leaf', 'title' => 'Impacto ambiental', 'description' => 'Genera energía limpia y contribuye a un modelo sostenible y responsable.'],
					['icon' => 'fas fa-tools', 'title' => 'Mantenimiento y soporte', 'description' => 'Instalación profesional, mantenimiento y soporte técnico especializado.'],
				];
			@endphp
			<div class="row g-4 mt-1">
				@foreach($problems as $i => $pr)
					<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
						<div class="problem-card h-100">
							<div class="problem-icon"><i class="{{ $pr['icon'] }}"></i></div>
							<h5>{{ $pr['title'] }}</h5>
							<p class="mb-0">{{ $pr['description'] }}</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Benefits -->
	<section id="benefits" class="section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Beneficios Clave</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->audiencia_beneficios }}</p>
			@php
				$benefits = [
					['icon' => 'fas fa-sack-dollar', 'title' => 'Ahorro inmediato', 'description' => 'Disminuye drásticamente tu factura eléctrica desde el primer mes.'],
					['icon' => 'fas fa-solar-panel', 'title' => 'Tecnología eficiente', 'description' => 'Paneles e inversores de última generación con alto rendimiento.'],
					['icon' => 'fas fa-shield-halved', 'title' => 'Garantía y soporte', 'description' => 'Instalación certificada, garantías y acompañamiento postventa.'],
					['icon' => 'fas fa-earth-americas', 'title' => 'Sostenibilidad', 'description' => 'Energía limpia que cuida el planeta y revaloriza tus espacios.'],
				];
			@endphp
			<div class="row g-4 mt-1">
				@foreach($benefits as $i => $bf)
					<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
						<div class="benefit-card h-100">
							<div class="benefit-icon"><i class="{{ $bf['icon'] }}"></i></div>
							<h5>{{ $bf['title'] }}</h5>
							<p class="mb-0">{{ $bf['description'] }}</p>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Gallery / Media -->
	<section id="gallery" class="section gallery-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Nuestros Proyectos</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Explora instalaciones y equipos destacados</p>

			<div class="row">
				@if($landing->media && $landing->media->count() > 0)
					@foreach($landing->media as $index => $media)
						<div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
							<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $media->url) }}" data-description="{{ $media->descripcion ?? ('Proyecto solar - ' . $empresa->nombre) }}" data-index="{{ $index }}">
								<img src="{{ asset('storage/' . $media->url) }}" alt="{{ $media->descripcion ?? ('Proyecto solar - ' . $empresa->nombre) }}">
								<div class="gallery-overlay"><i class="fas fa-magnifying-glass-plus"></i> <span>Ver imagen</span></div>
							</div>
						</div>
					@endforeach
				@else
					@for($i = 0; $i < 4; $i++)
						<div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
							<div class="gallery-item" data-bs-toggle="modal" data-bs-target="#galleryModal" data-image="{{ asset('storage/' . $landing->logo_url) }}" data-description="Proyecto {{ $i + 1 }} - {{ $empresa->nombre }}" data-index="{{ $i }}">
								<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Proyecto {{ $i + 1 }} - {{ $empresa->nombre }}">
								<div class="gallery-overlay"><i class="fas fa-magnifying-glass-plus"></i> <span>Ver imagen</span></div>
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
			<h2 class="section-title" data-aos="fade-up">Nuestra Comunidad</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $landing->objetivo }}</p>

			@php
				$testimonials = [
					['name' => 'Laura G.', 'avatar' => 'L', 'profession' => 'Empresaria', 'comment' => 'Instalaron un sistema solar en mi local y la factura bajó a menos del 20%. Excelente atención y soporte.', 'rating' => 5],
					['name' => 'Diego P.', 'avatar' => 'D', 'profession' => 'Ingeniero', 'comment' => 'La asesoría fue muy clara y la instalación impecable. Recomiendo 100% por la calidad y el ahorro logrado.', 'rating' => 5],
					['name' => 'María R.', 'avatar' => 'M', 'profession' => 'Hogareña', 'comment' => 'Ahora tengo autonomía y no sufro por los cortes de luz. Excelente inversión a largo plazo.', 'rating' => 5],
				];
			@endphp

			<div class="row g-4">
				@foreach($testimonials as $i => $t)
					<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
						<div class="about-card h-100 text-center">
							<div class="testimonial-avatar mx-auto mb-2" style="width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); color:#fff; font-weight:800; font-size:1.6rem;">{{ $t['avatar'] }}</div>
							<div class="mb-2" style="color:#ffc107;">
								@for($s = 0; $s < $t['rating']; $s++)
									<i class="fas fa-star"></i>
								@endfor
							</div>
							<p class="mb-2">"{{ $t['comment'] }}"</p>
							<strong>{{ $t['name'] }}</strong><br>
							<small class="text-muted">{{ $t['profession'] }}</small>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	<!-- Contact -->
	<section id="contact" class="section contact-section">
		<div class="container">
			<h2 class="section-title" data-aos="fade-up">Contáctanos</h2>
			<p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Estamos listos para ayudarte a generar tu propia energía</p>

			<div class="row g-4">
				@if($waLink)
					<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
						<div class="contact-card h-100">
							<div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
							<h5>WhatsApp</h5>
							<p class="mb-2">{{ $empresa->whatsapp ?? $empresa->movil }}</p>
							<a href="{{ $waLink }}" target="_blank" class="btn btn-outline-light btn-sm">Enviar mensaje</a>
						</div>
					</div>
				@endif

				@if($empresa->email)
					<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
						<div class="contact-card h-100">
							<div class="contact-icon"><i class="fas fa-envelope"></i></div>
							<h5>Email</h5>
							<p class="mb-2">{{ $empresa->email }}</p>
							<a href="mailto:{{ $empresa->email }}" class="btn btn-outline-light btn-sm">Enviar email</a>
						</div>
					</div>
				@endif

				@if($empresa->movil)
					<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
						<div class="contact-card h-100">
							<div class="contact-icon"><i class="fas fa-phone"></i></div>
							<h5>Teléfono</h5>
							<p class="mb-2">{{ $empresa->movil }}</p>
							@if($waLink)
								<a href="{{ $waLink }}?text={{ rawurlencode('Hola ' . $empresa->nombre . '! Quiero más información sobre paneles solares.') }}" target="_blank" class="btn btn-outline-light btn-sm">Contactar</a>
							@endif
						</div>
					</div>
				@endif

				@if($empresa->direccion)
					<div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
						<div class="contact-card h-100">
							<div class="contact-icon"><i class="fas fa-map-location-dot"></i></div>
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
					<div class="footer-logo mb-3">
						<img src="{{ asset('storage/' . $landing->logo_url) }}" alt="{{ $empresa->nombre }}">
					</div>
					<p>Soluciones integrales de energía solar para hogares y empresas. Ahorro, eficiencia y sostenibilidad con {{ $empresa->nombre }}.</p>
					<div class="social-links mt-3">
						@if($empresa->facebook)
							<a href="{{ $empresa->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
						@endif
						@if($empresa->instagram)
							<a href="{{ $empresa->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
						@endif
						@if($empresa->tiktok)
							<a href="{{ $empresa->tiktok }}" target="_blank"><i class="fab fa-tiktok"></i></a>
						@endif
						@if($empresa->linkedin)
							<a href="{{ $empresa->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
						@endif
						@if($empresa->youtube)
							<a href="{{ $empresa->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
						@endif
						@if($empresa->twitter)
							<a href="{{ $empresa->twitter }}" target="_blank"><i class="fab fa-x-twitter"></i></a>
						@endif
						@if($empresa->website)
							<a href="{{ $empresa->website }}" target="_blank"><i class="fas fa-globe"></i></a>
						@endif
						@if($waLink)
							<a href="{{ $waLink }}" target="_blank"><i class="fab fa-whatsapp"></i></a>
						@endif
					</div>
				</div>
				<div class="col-lg-2 col-md-6 mb-4">
					<h5>Enlaces</h5>
					<ul class="list-unstyled mt-3">
						<li><a href="#home" class="footer-link">Inicio</a></li>
						<li><a href="#about" class="footer-link">Nosotros</a></li>
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
		<a href="{{ $waLink }}?text={{ rawurlencode('Hola ' . $empresa->nombre . '! Estoy interesado en soluciones solares.') }}" class="whatsapp-float" target="_blank" aria-label="Abrir WhatsApp"><i class="fab fa-whatsapp"></i></a>
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
	<div class="modal fade gallery-modal" id="galleryModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="galleryModalTitle">Proyecto solar</h5>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body position-relative">
					<img id="galleryModalImage" src="" alt="" class="modal-image">
					<button class="gallery-nav-btn prev" id="galleryPrev"><i class="fas fa-chevron-left"></i></button>
					<button class="gallery-nav-btn next" id="galleryNext"><i class="fas fa-chevron-right"></i></button>
					<div class="gallery-counter"><span id="galleryCounter">1 / 1</span></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
	<script>
		// Initialize AOS
		AOS.init({ duration: 900, once: true, offset: 80 });

		// Navbar scroll effect
		window.addEventListener('scroll', () => {
			const nav = document.querySelector('.navbar');
			if (window.scrollY > 50) nav.classList.add('scrolled'); else nav.classList.remove('scrolled');
		});

		// Smooth scrolling for anchors
		document.querySelectorAll('a[href^="#"]').forEach(a => {
			a.addEventListener('click', e => {
				const href = a.getAttribute('href');
				const target = document.querySelector(href);
				if (target) {
					e.preventDefault();
					const y = target.getBoundingClientRect().top + window.pageYOffset - 80;
					window.scrollTo({ top: y, behavior: 'smooth' });
				}
			});
		});

		// Auto-collapse navbar on mobile
		document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
			link.addEventListener('click', () => {
				const nav = document.querySelector('.navbar-collapse');
				if (nav && nav.classList.contains('show')) {
					const bsCollapse = new bootstrap.Collapse(nav);
					bsCollapse.hide();
				}
			});
		});

		// Gallery lightbox
		let galleryImages = [];
		let currentIndex = 0;

		document.querySelectorAll('.gallery-item').forEach((item, index) => {
			const src = item.getAttribute('data-image');
			const desc = item.getAttribute('data-description') || 'Proyecto solar';
			galleryImages.push({ src, desc });
			item.addEventListener('click', () => {
				currentIndex = index;
				showImage(currentIndex);
			});
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

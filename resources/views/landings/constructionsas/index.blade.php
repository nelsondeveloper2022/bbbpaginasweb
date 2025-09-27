<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Construimos tus proyectos con calidad y confianza. Desde remodelaciones hasta grandes obras, hacemos realidad tus ideas. Empresa especializada en construcción y remodelación.">
    <meta name="keywords" content="construcción, remodelación, obras, proyectos, construcción residencial, construcción comercial">
    <title>{{ $landing->titulo_principal ?? 'Construimos tus proyectos con calidad y confianza' }} | {{ $empresa->nombre }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts - Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: {{ $landing->color_principal ?? '#e0e40c' }};
            --secondary-color: {{ $landing->color_secundario ?? '#0a0a0b' }};
            --text-dark: #333333;
            --text-light: #666666;
            --bg-light: #f8f9fa;
        }
        
        * {
            font-family: 'Montserrat', sans-serif;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }
        
        .navbar-brand img {
            max-height: 45px;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--secondary-color) 0%, rgba(10, 10, 11, 0.9) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset("storage/landing/constructionsas/media/J2ySMArdRT89U7hJWiPY0cAf059rYYpt293d1NXo.jpg") }}') center/cover;
            opacity: 0.15;
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            font-weight: 400;
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            color: var(--secondary-color);
            font-weight: 600;
            padding: 15px 35px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .btn-primary-custom:hover {
            background: #c4c70a;
            color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(224, 228, 12, 0.3);
        }
        
        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            padding: 15px 35px;
            font-size: 1.1rem;
            border-radius: 50px;
            background: transparent;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-light);
            margin-bottom: 3rem;
        }
        
        .service-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
            border-top: 4px solid var(--primary-color);
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .service-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-color), #f0f40d);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }
        
        .service-icon i {
            font-size: 2rem;
            color: var(--secondary-color);
        }
        
        .benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        .benefit-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .benefit-icon i {
            color: var(--secondary-color);
            font-size: 1.2rem;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            margin-bottom: 1.5rem;
        }
        
        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color), #f0f40d);
            padding: 5rem 0;
        }
        
        .cta-section h2 {
            color: var(--secondary-color);
            font-weight: 800;
            font-size: 2.8rem;
            margin-bottom: 1rem;
        }
        
        .cta-section p {
            color: rgba(10, 10, 11, 0.8);
            font-size: 1.3rem;
            margin-bottom: 2rem;
        }
        
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: white;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1);
            color: white;
            text-decoration: none;
        }
        
        .footer {
            background: var(--secondary-color);
            color: white;
            padding: 3rem 0 1rem;
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .cta-section h2 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                @if($empresa->logo)
                    <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo {{ $empresa->nombre }}">
                @else
                    <strong style="color: var(--secondary-color); font-size: 1.5rem;">{{ $empresa->nombre }}</strong>
                @endif
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#beneficios">Beneficios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#proyectos">Proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="inicio" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">{{ $landing->titulo_principal ?? 'Construimos tus proyectos con calidad y confianza' }}</h1>
                        <p class="hero-subtitle">{{ $landing->subtitulo ?? 'Desde remodelaciones hasta grandes obras, hacemos realidad tus ideas' }}</p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#contacto" class="btn btn-primary-custom">Solicitar Cotización</a>
                            <a href="#servicios" class="btn btn-outline-custom">Ver Servicios</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="servicios" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">Nuestros Servicios</h2>
                    <p class="section-subtitle">Ofrecemos soluciones integrales para todos tus proyectos de construcción y remodelación</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <h4 class="mb-3">Construcción Residencial</h4>
                        <p>Construimos viviendas familiares con los más altos estándares de calidad, desde la cimentación hasta los acabados finales.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4 class="mb-3">Remodelaciones</h4>
                        <p>Transformamos espacios existentes para adaptarlos a tus necesidades actuales, mejorando funcionalidad y estética.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4 class="mb-3">Construcción Comercial</h4>
                        <p>Desarrollamos proyectos comerciales y empresariales que potencian tu negocio con espacios modernos y funcionales.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-drafting-compass"></i>
                        </div>
                        <h4 class="mb-3">Diseño y Planificación</h4>
                        <p>Brindamos asesoría arquitectónica y técnica desde la conceptualización hasta la ejecución del proyecto.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-hard-hat"></i>
                        </div>
                        <h4 class="mb-3">Obra Civil</h4>
                        <p>Ejecutamos proyectos de infraestructura y obra civil con maquinaria especializada y personal calificado.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h4 class="mb-3">Garantía Total</h4>
                        <p>Todos nuestros trabajos incluyen garantía en estructura y acabados, respaldando la calidad de nuestra obra.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="beneficios" class="py-5" style="background: var(--bg-light);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">¿Por qué elegirnos?</h2>
                    <p class="section-subtitle">Somos la mejor opción para tus proyectos de construcción</p>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h5>Cumplimiento de Tiempos</h5>
                            <p>Entregamos todos los proyectos en las fechas acordadas, respetando tu cronograma y presupuesto.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <div>
                            <h5>Experiencia Comprobada</h5>
                            <p>Contamos con un equipo profesional con años de experiencia en construcción y remodelación.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-gem"></i>
                        </div>
                        <div>
                            <h5>Materiales de Calidad</h5>
                            <p>Utilizamos únicamente materiales de primera calidad para garantizar la durabilidad de tu inversión.</p>
                        </div>
                    </div>
                    
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h5>Asesoría Personalizada</h5>
                            <p>Te acompañamos en todo el proceso con asesoría técnica y arquitectónica especializada.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <img src="{{ asset('storage/landing/constructionsas/media/oJz1J3603NqCAtnxHYI1x0xv0vS9nNuI153EOTCv.jpg') }}" 
                         alt="Equipo de construcción profesional" 
                         class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Gallery -->
    <section id="proyectos" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">Nuestros Proyectos</h2>
                    <p class="section-subtitle">Conoce algunos de los trabajos que hemos realizado con excelencia</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="{{ asset('storage/landing/constructionsas/media/J2ySMArdRT89U7hJWiPY0cAf059rYYpt293d1NXo.jpg') }}" 
                             alt="Proyecto de construcción residencial">
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="{{ asset('storage/landing/constructionsas/media/oJz1J3603NqCAtnxHYI1x0xv0vS9nNuI153EOTCv.jpg') }}" 
                             alt="Remodelación de espacios comerciales">
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="gallery-item">
                        <img src="{{ asset('storage/landing/constructionsas/media/XRAXdq8py21EcWRJffCcspM5V7bLB3ZpA4mDbrGA.jpg') }}" 
                             alt="Obra civil y construcción comercial">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2>¿Listo para comenzar tu proyecto?</h2>
                    <p>Contáctanos hoy mismo y recibe una cotización personalizada sin compromiso</p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="#contacto" class="btn btn-outline-custom" style="border-color: var(--secondary-color); color: var(--secondary-color);">
                            Solicitar Cotización
                        </a>
                        @if($empresa->whatsapp)
                        <a href="https://wa.me/{{ $empresa->whatsapp }}" target="_blank" class="btn btn-outline-custom" style="border-color: var(--secondary-color); color: var(--secondary-color);">
                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contacto" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">Contáctanos</h2>
                    <p class="section-subtitle">Estamos listos para hacer realidad tus proyectos de construcción</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre completo *</label>
                                        <input type="text" class="form-control" id="nombre" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono *</label>
                                        <input type="tel" class="form-control" id="telefono" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo electrónico *</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="proyecto" class="form-label">Tipo de proyecto</label>
                                    <select class="form-select" id="proyecto">
                                        <option value="">Selecciona una opción</option>
                                        <option value="construccion-residencial">Construcción Residencial</option>
                                        <option value="remodelacion">Remodelación</option>
                                        <option value="construccion-comercial">Construcción Comercial</option>
                                        <option value="obra-civil">Obra Civil</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mensaje" class="form-label">Mensaje *</label>
                                    <textarea class="form-control" id="mensaje" rows="4" placeholder="Cuéntanos sobre tu proyecto..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary-custom w-100">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Solicitud
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow h-100">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Información de Contacto</h5>
                            
                            @if($empresa->email)
                            <div class="d-flex align-items-center mb-3">
                                <div class="benefit-icon me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-envelope" style="font-size: 1rem;"></i>
                                </div>
                                <div>
                                    <small class="text-muted">Email</small>
                                    <div>{{ $empresa->email }}</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($empresa->telefono)
                            <div class="d-flex align-items-center mb-3">
                                <div class="benefit-icon me-3" style="width: 40px; height: 40px;">
                                    <i class="fas fa-phone" style="font-size: 1rem;"></i>
                                </div>
                                <div>
                                    <small class="text-muted">Teléfono</small>
                                    <div>{{ $empresa->telefono }}</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($empresa->whatsapp)
                            <div class="d-flex align-items-center mb-3">
                                <div class="benefit-icon me-3" style="width: 40px; height: 40px; background: #25d366;">
                                    <i class="fab fa-whatsapp" style="font-size: 1rem; color: white;"></i>
                                </div>
                                <div>
                                    <small class="text-muted">WhatsApp</small>
                                    <div>{{ $empresa->whatsapp }}</div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="mt-4">
                                <h6>Horarios de Atención</h6>
                                <small class="text-muted">
                                    Lunes a Viernes: 8:00 AM - 6:00 PM<br>
                                    Sábados: 8:00 AM - 2:00 PM
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h5>{{ $empresa->nombre }}</h5>
                    <p>{{ $landing->descripcion ?? 'Especialistas en construcción y remodelación con calidad garantizada' }}</p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    @if($empresa->whatsapp)
    <a href="https://wa.me/{{ $empresa->whatsapp }}" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling for navigation links
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

        // Form submission handling
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect form data
            const formData = {
                nombre: document.getElementById('nombre').value,
                telefono: document.getElementById('telefono').value,
                email: document.getElementById('email').value,
                proyecto: document.getElementById('proyecto').value,
                mensaje: document.getElementById('mensaje').value
            };
            
            // Here you would typically send the data to your backend
            alert('¡Gracias por tu interés! Nos pondremos en contacto contigo muy pronto.');
            
            // Reset form
            this.reset();
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Páginas Web" style="height: 40px; width: auto; margin-right: 15px;">
                    <h5 class="mb-0" style="font-weight: 600;">
                        <span style="color: #d22e23 !important;">bbb</span><span style="color: #f0ac21 !important;">paginasweb</span>
                    </h5>
                </div>
                <p class="mb-3">
                    Potenciamos tu presencia digital con páginas web profesionales que impulsan tu negocio hacia el éxito.
                </p>
                <div class="social-links" id="footer-social-links">
                    <!-- Social links will be populated dynamically -->
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5>Enlaces</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('about') }}">Acerca de</a></li>
                    <li><a href="{{ route('plans') }}">Planes</a></li>
                    <li><a href="{{ route('testimonials') }}">Testimonios</a></li>
                    <li><a href="{{ route('contact') }}">Contacto</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Servicios</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('plans') }}#servicios">Diseño Web</a></li>
                    <li><a href="{{ route('plans') }}#servicios">SEO & Marketing</a></li>
                    <li><a href="{{ route('plans') }}#servicios">Desarrollo Web</a></li>
                    <li><a href="{{ route('plans') }}#servicios">Mantenimiento</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5>Información de Contacto</h5>
                <ul class="list-unstyled">
                    <li>
                        <i class="fas fa-envelope me-2"></i>
                        <a href="mailto:{{ config('app.support.email') }}" id="footer-empresa-email">
                            {{ config('app.support.email') }}
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-phone me-2"></i>
                        <a
                            href="https://wa.me/{{ config('app.support.mobile') }}?text=Hola, estoy interesado en los servicios de BBB"
                            target="_blank"
                            id="footer-empresa-movil"
                        >
                            +57 318 969 6117
                        </a>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <a
                            href="https://maps.app.goo.gl/8VKxocfAiEawJHsX9"
                            target="_blank"
                            id="footer-empresa-direccion"
                        >
                            Vía Nacional, Km 6 Vía Puente Nacional, Puente Nacional, Santander
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4" style="border-color: var(--medium-gray);">

        <!-- Bottom Footer -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0">&copy; 2025 <span id="footer-empresa-nombre">bbbpaginasweb</span>. Todos los derechos reservados.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('terms') }}" class="me-3">Términos y Condiciones</a>
                <a href="{{ route('privacy') }}" class="me-3">Política de Privacidad</a>
                <a href="{{ route('cookies') }}">Política de Cookies</a>
            </div>
        </div>
    </div>
</footer>


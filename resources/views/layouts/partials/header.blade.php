<!-- Navigation Header -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand" href="{{ route('home') }}" style="text-decoration: none !important;">
            <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Páginas Web" style="height: 40px; width: auto; margin-right: 10px;">
            <span style="font-weight: 600; font-size: 1.7rem;">
                <span style="color: #d22e23 !important;">bbb</span><span style="color: #f0ac21 !important;">paginasweb</span>
            </span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#inicio">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">Acerca de</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('plans') }}">Planes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('testimonials') }}">Testimonios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Contacto</a>
                </li>
            </ul>

            <!-- Language Selector -->
            <div class="d-flex align-items-center ms-3">
                <!-- Authentication Links -->
                @auth
                    <div class="dropdown me-3">
                        <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <span class="dropdown-item-text small text-muted">
                                    {{ Auth::user()->empresa->nombre ?? 'Sin empresa' }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a href="{{ route('dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="d-flex me-3">
                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-sm me-2">
                            <i class="fas fa-user-plus me-1"></i>Registro
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-primary-custom btn-sm" style="background-color: var(--primary-red); color: white; border: none;">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </div>
                @endauth

                {{-- <div class="dropdown">
                    <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(app()->getLocale() == 'es')
                            🇪🇸 {{ __('general.languages.spanish') }}
                        @else
                            🇺🇸 {{ __('general.languages.english') }}
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'es' ? 'active' : '' }}" 
                               href="{{ switch_locale_url('es') }}">
                                🇪🇸 {{ __('general.languages.spanish') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" 
                               href="{{ switch_locale_url('en') }}">
                                🇺🇸 {{ __('general.languages.english') }}
                            </a>
                        </li>
                    </ul>
                </div> --}}
            </div>
        </div>
    </div>
</nav>
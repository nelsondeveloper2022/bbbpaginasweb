<?php

namespace App\Console\Commands;

use App\Models\BbbEmpresa;
use App\Models\BbbLanding;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MigrateLandingFilesToSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'landing:migrate-files-to-slug {--dry-run : Show what would be migrated without actually doing it}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Migrate landing files from idEmpresa folder structure to slug-based structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('DRY RUN MODE - No files will be moved');
            $this->newLine();
        }

        $this->info('Starting migration of landing files to slug-based structure...');
        $this->newLine();

        // Get all companies
        $empresas = BbbEmpresa::all();
        $migratedCount = 0;
        $errorCount = 0;

        foreach ($empresas as $empresa) {
            try {
                $this->info("Processing: {$empresa->nombre} (ID: {$empresa->idEmpresa})");
                
                // Generate slug if not exists
                if (empty($empresa->slug)) {
                    $empresa->updateSlug();
                    
                    if (!$dryRun) {
                        $empresa->save();
                    }
                    
                    $this->line("  Generated slug: {$empresa->slug}");
                }

                // Create landing views directory
                if (!$dryRun) {
                    $empresa->createLandingViews();
                    $this->createLandingIndexView($empresa);
                }
                $this->line("  Views directory: resources/views/landings/{$empresa->slug}/");

                // Check for existing files
                $oldPath = storage_path('app/public/landing/' . $empresa->idEmpresa);
                $newPath = storage_path('app/public/landing/' . $empresa->slug);

                if (is_dir($oldPath)) {
                    $this->line("  Found files in: landing/{$empresa->idEmpresa}");
                    
                    if (!$dryRun) {
                        // Create new directory
                        if (!is_dir($newPath)) {
                            mkdir($newPath, 0755, true);
                        }

                        // Move files
                        $this->moveDirectory($oldPath, $newPath);
                        
                        // Update database paths
                        $this->updateDatabasePaths($empresa);
                    }
                    
                    $this->line("  Files would be moved to: landing/{$empresa->slug}");
                    $migratedCount++;
                } else {
                    $this->line("  No files to migrate");
                }

                $this->newLine();

            } catch (\Exception $e) {
                $this->error("  Error processing {$empresa->nombre}: " . $e->getMessage());
                $errorCount++;
            }
        }

        $this->newLine();
        $this->info("Migration summary:");
        $this->line("- Companies processed: " . $empresas->count());
        $this->line("- Companies with files migrated: " . $migratedCount);
        $this->line("- Errors: " . $errorCount);

        if ($dryRun) {
            $this->newLine();
            $this->comment('This was a dry run. To execute the migration, run without --dry-run flag.');
        }

        return Command::SUCCESS;
    }

    /**
     * Move directory contents recursively.
     */
    private function moveDirectory($source, $destination)
    {
        if (!is_dir($source)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $relativePath = str_replace($source . DIRECTORY_SEPARATOR, '', $item->getPathname());
            $target = $destination . DIRECTORY_SEPARATOR . $relativePath;
            
            if ($item->isDir()) {
                if (!is_dir($target)) {
                    mkdir($target, 0755, true);
                }
            } else {
                if (!is_dir(dirname($target))) {
                    mkdir(dirname($target), 0755, true);
                }
                copy($item->getPathname(), $target);
            }
        }

        // Remove old directory
        $this->removeDirectory($source);
    }

    /**
     * Remove directory recursively.
     */
    private function removeDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                rmdir($item->getPathname());
            } else {
                unlink($item->getPathname());
            }
        }

        rmdir($dir);
    }

    /**
     * Update database file paths from idEmpresa to slug.
     */
    private function updateDatabasePaths($empresa)
    {
        // Update landing logo path
        $landing = BbbLanding::where('idEmpresa', $empresa->idEmpresa)->first();
        if ($landing && $landing->logo_url) {
            $oldPath = 'landing/' . $empresa->idEmpresa . '/';
            $newPath = 'landing/' . $empresa->slug . '/';
            
            if (str_contains($landing->logo_url, $oldPath)) {
                $landing->logo_url = str_replace($oldPath, $newPath, $landing->logo_url);
                $landing->save();
                $this->line("    Updated logo path in database");
            }
        }

        // Update media paths
        if ($landing) {
            foreach ($landing->media as $media) {
                if ($media->url) {
                    $oldPath = 'landing/' . $empresa->idEmpresa . '/';
                    $newPath = 'landing/' . $empresa->slug . '/';
                    
                    if (str_contains($media->url, $oldPath)) {
                        $media->url = str_replace($oldPath, $newPath, $media->url);
                        $media->save();
                        $this->line("    Updated media path in database: {$media->url}");
                    }
                }
            }
        }
    }

    /**
     * Create the landing index view file for a company.
     */
    private function createLandingIndexView($empresa)
    {
        $viewPath = $empresa->getLandingViewsPath();
        $indexFile = $viewPath . '/index.blade.php';

        // Only create if it doesn't exist
        if (!file_exists($indexFile)) {
            $viewContent = $this->getLandingViewTemplate();
            file_put_contents($indexFile, $viewContent);
        }
    }

    /**
     * Get the template content for landing index view.
     */
    private function getLandingViewTemplate()
    {
        return <<<'BLADE'
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->titulo_principal ?? $empresa->nombre }} - {{ $empresa->nombre }}</title>
    <meta name="description" content="{{ $landing->descripcion ?? 'Bienvenido a ' . $empresa->nombre }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="{{ $landing->titulo_principal ?? $empresa->nombre }}">
    <meta property="og:description" content="{{ $landing->descripcion ?? 'Bienvenido a ' . $empresa->nombre }}">
    @if($landing->logo_url)
        <meta property="og:image" content="{{ asset('storage/' . $landing->logo_url) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="{{ $landing->titulo_principal ?? $empresa->nombre }}">
    <meta property="twitter:description" content="{{ $landing->descripcion ?? 'Bienvenido a ' . $empresa->nombre }}">
    @if($landing->logo_url)
        <meta property="twitter:image" content="{{ asset('storage/' . $landing->logo_url) }}">
    @endif

    <!-- Favicon -->
    @if($landing->logo_url)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $landing->logo_url) }}">
    @endif
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    @if($landing->tipografia)
        <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @endif
    
    <style>
        :root {
            --color-primary: {{ $landing->color_principal ?: '#007bff' }};
            --color-secondary: {{ $landing->color_secundario ?: '#6c757d' }};
            --font-family: {{ $landing->tipografia ? "'".$landing->tipografia."', " : '' }}system-ui, -apple-system, sans-serif;
        }
        
        body {
            font-family: var(--font-family);
            line-height: 1.6;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }
        
        .btn-primary:hover {
            background-color: color-mix(in srgb, var(--color-primary) 85%, black);
            border-color: color-mix(in srgb, var(--color-primary) 85%, black);
        }
        
        .text-primary {
            color: var(--color-primary) !important;
        }
        
        .bg-primary {
            background-color: var(--color-primary) !important;
        }
        
        .text-secondary {
            color: var(--color-secondary) !important;
        }
        
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--color-primary) 0%, color-mix(in srgb, var(--color-primary) 80%, black) 100%);
        }
        
        .hero-content {
            color: white;
        }
        
        .logo-container {
            max-width: 200px;
            margin-bottom: 2rem;
        }
        
        .feature-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .media-gallery img {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 768px) {
            .hero-section {
                min-height: 80vh;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        @if($landing->logo_url)
                            <div class="logo-container">
                                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Logo {{ $empresa->nombre }}" class="img-fluid">
                            </div>
                        @endif
                        
                        @if($landing->titulo_principal)
                            <h1 class="display-4 fw-bold mb-4">{{ $landing->titulo_principal }}</h1>
                        @else
                            <h1 class="display-4 fw-bold mb-4">Bienvenido a {{ $empresa->nombre }}</h1>
                        @endif
                        
                        @if($landing->subtitulo)
                            <h2 class="h4 mb-4 opacity-90">{{ $landing->subtitulo }}</h2>
                        @endif
                        
                        @if($landing->descripcion)
                            <p class="lead mb-5 opacity-90">{{ $landing->descripcion }}</p>
                        @endif
                        
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="#contacto" class="btn btn-light btn-lg px-4">
                                @switch($landing->objetivo)
                                    @case('vender_producto')
                                        <i class="bi bi-cart-plus me-2"></i>Comprar Ahora
                                        @break
                                    @case('captar_leads')
                                        <i class="bi bi-envelope me-2"></i>Obtener Información
                                        @break
                                    @case('reservas')
                                        <i class="bi bi-calendar-check me-2"></i>Hacer Reserva
                                        @break
                                    @case('descargas')
                                        <i class="bi bi-download me-2"></i>Descargar Gratis
                                        @break
                                    @default
                                        <i class="bi bi-arrow-right me-2"></i>Comenzar
                                @endswitch
                            </a>
                            @if($empresa->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $empresa->whatsapp) }}" 
                                   class="btn btn-outline-light btn-lg px-4" 
                                   target="_blank">
                                    <i class="bi bi-whatsapp me-2"></i>WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($landing->images->count() > 0)
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $landing->images->first()->url) }}" 
                                 alt="Imagen principal" 
                                 class="img-fluid rounded shadow-lg"
                                 style="max-height: 400px;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Features Section -->
    @if($landing->audiencia_problemas || $landing->audiencia_beneficios)
        <section class="py-5">
            <div class="container">
                <div class="row">
                    @if($landing->audiencia_problemas)
                        <div class="col-lg-6 mb-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-exclamation-triangle text-danger"></i>
                                        </div>
                                        <h3 class="h5 mb-0">Problemas que Resolvemos</h3>
                                    </div>
                                    <p class="text-muted mb-0">{{ $landing->audiencia_problemas }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($landing->audiencia_beneficios)
                        <div class="col-lg-6 mb-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-check-circle text-success"></i>
                                        </div>
                                        <h3 class="h5 mb-0">Beneficios que Obtienes</h3>
                                    </div>
                                    <p class="text-muted mb-0">{{ $landing->audiencia_beneficios }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery Section -->
    @if($landing->images->count() > 1)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="h3 mb-3">Galería</h2>
                    <p class="text-muted">Conoce más sobre nosotros</p>
                </div>
                
                <div class="row g-4">
                    @foreach($landing->images->skip(1) as $image)
                        <div class="col-md-6 col-lg-4">
                            <div class="media-gallery">
                                <img src="{{ asset('storage/' . $image->url) }}" 
                                     alt="{{ $image->descripcion ?: 'Imagen de galería' }}" 
                                     class="img-fluid w-100"
                                     style="height: 250px; object-fit: cover;">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Contact Section -->
    <section class="py-5" style="background-color: var(--color-primary);" id="contacto">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="text-white">
                        <h2 class="h3 mb-3">¿Listo para Comenzar?</h2>
                        @if($landing->descripcion_objetivo)
                            <p class="mb-4 opacity-90">{{ $landing->descripcion_objetivo }}</p>
                        @endif
                        
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                @if($empresa->email)
                                    <div class="mb-3">
                                        <i class="bi bi-envelope me-2"></i>
                                        <a href="mailto:{{ $empresa->email }}" class="text-white text-decoration-none">
                                            {{ $empresa->email }}
                                        </a>
                                    </div>
                                @endif
                                
                                @if($empresa->movil)
                                    <div class="mb-3">
                                        <i class="bi bi-telephone me-2"></i>
                                        <a href="tel:{{ $empresa->movil }}" class="text-white text-decoration-none">
                                            {{ $empresa->movil }}
                                        </a>
                                    </div>
                                @endif
                                
                                @if($empresa->direccion)
                                    <div class="mb-3">
                                        <i class="bi bi-geo-alt me-2"></i>
                                        <span>{{ $empresa->direccion }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Social Media Links -->
                        @if($empresa->hasSocialMedia())
                            <div class="mt-4">
                                <h4 class="h6 mb-3">Síguenos</h4>
                                <div class="d-flex justify-content-center gap-3">
                                    @if($empresa->facebook)
                                        <a href="{{ $empresa->facebook }}" target="_blank" class="text-white">
                                            <i class="bi bi-facebook fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->instagram)
                                        <a href="{{ $empresa->instagram }}" target="_blank" class="text-white">
                                            <i class="bi bi-instagram fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->linkedin)
                                        <a href="{{ $empresa->linkedin }}" target="_blank" class="text-white">
                                            <i class="bi bi-linkedin fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->twitter)
                                        <a href="{{ $empresa->twitter }}" target="_blank" class="text-white">
                                            <i class="bi bi-twitter fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->tiktok)
                                        <a href="{{ $empresa->tiktok }}" target="_blank" class="text-white">
                                            <i class="bi bi-tiktok fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->youtube)
                                        <a href="{{ $empresa->youtube }}" target="_blank" class="text-white">
                                            <i class="bi bi-youtube fs-4"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    @if($landing->logo_url)
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Logo" style="max-height: 40px;" class="mb-2">
                    @endif
                    <p class="mb-0 text-muted">
                        © {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    @if($empresa->website)
                        <a href="{{ $empresa->website }}" target="_blank" class="text-muted text-decoration-none">
                            {{ $empresa->website }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling
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
        
        // Simple animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.feature-card, .media-gallery img').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>
BLADE;
    }
}
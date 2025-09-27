<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BbbPlan;

class BbbPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planes = [
            [
                'nombre' => 'Página Web en Arriendo',
                'slug' => 'web-en-arriendo',
                'descripcion' => '<ul class="mb-0">'
                    .'<li><i class="fas fa-check"></i> Diseño moderno y atractivo</li>'
                    .'<li><i class="fas fa-check"></i> Formularios de contacto y captura de leads</li>'
                    .'<li><i class="fas fa-check"></i> Información de contacto y mapa</li>'
                    .'<li><i class="fas fa-check"></i> Diseño 100% responsive</li>'
                    .'<li><i class="fas fa-check"></i> URL: <strong>bbbpaginasweb.com/tuempresa</strong></li>'
                    .'<li><i class="fas fa-times" style="color:#dc3545"></i> No incluye dominio propio</li>'
                    .'<li><i class="fas fa-info-circle" style="color:#6c757d"></i> Pago <strong>trimestral</strong>. Ideal para empezar sin gran inversión.</li>'
                .'</ul>',
                'precioPesos' => 45000.00,
                'preciosDolar' => 12.00,
                'orden' => 1,
                'destacado' => 0,
                'idioma' => 'spanish',
                'idEmpresa' => 1,
            ],
            [
                'nombre' => 'Plan Básico – Landing Page',
                'slug' => 'plan-basico-landing',
                'descripcion' => '<ul class="mb-0">'
                    .'<li><i class="fas fa-check"></i> Diseño moderno y de alto impacto</li>'
                    .'<li><i class="fas fa-check"></i> Formularios de contacto y WhatsApp</li>'
                    .'<li><i class="fas fa-check"></i> Captura leads eficientemente</li>'
                    .'<li><i class="fas fa-check"></i> SSL + Hosting <strong>incluidos (1er año)</strong></li>'
                    .'<li><i class="fas fa-check"></i> Mail corporativo <strong>incluido</strong></li>'
                    .'<li><i class="fas fa-check"></i> <strong>Incluye dominio propio</strong></li>'
                    .'<li><i class="fas fa-info-circle" style="color:#6c757d"></i> Único pago inicial. Renovación anual dominio + hosting por <strong>$80.000</strong> desde el segundo año.</li>'
                .'</ul>',
                'precioPesos' => 199000.00,
                'preciosDolar' => 49.00,
                'orden' => 2,
                'destacado' => 1,
                'idioma' => 'spanish',
                'idEmpresa' => 1,
            ],
            [
                'nombre' => 'Plan Plus – Landing + Carrito',
                'slug' => 'plan-plus-landing-carrito',
                'descripcion' => '<ul class="mb-0">'
                    .'<li><i class="fas fa-check"></i> Todo lo del Plan Básico</li>'
                    .'<li><i class="fas fa-check"></i> <strong>Carrito de compras integrado</strong></li>'
                    .'<li><i class="fas fa-check"></i> Gestión de productos y categorías</li>'
                    .'<li><i class="fas fa-check"></i> Pagos en línea (pasarelas disponibles)</li>'
                    .'<li><i class="fas fa-check"></i> SSL + Hosting <strong>incluidos (1er año)</strong></li>'
                    .'<li><i class="fas fa-check"></i> Mail corporativo y dominio propio</li>'
                .'</ul>',
                'precioPesos' => 899000.00,
                'preciosDolar' => 229.00,
                'orden' => 3,
                'destacado' => 0,
                'idioma' => 'spanish',
                'idEmpresa' => 1,
            ],
        ];

        foreach ($planes as $plan) {
            BbbPlan::updateOrCreate(
                ['nombre' => $plan['nombre']],
                $plan
            );
        }
    }
}

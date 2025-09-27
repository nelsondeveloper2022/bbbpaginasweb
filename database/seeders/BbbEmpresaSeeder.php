<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BbbEmpresa;

class BbbEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BbbEmpresa::create([
            'nombre' => 'Tech Solutions S.A.S',
            'email' => 'info@techsolutions.com',
            'movil' => '+57 300 123 4567',
            'direccion' => 'Calle 123 #45-67, Bogotá, Colombia',
            'facebook' => 'https://facebook.com/techsolutions',
            'instagram' => 'https://instagram.com/techsolutions',
            'linkedin' => 'https://linkedin.com/company/techsolutions',
            'website' => 'https://www.techsolutions.com',
            'whatsapp' => '+57 300 123 4567',
            'terminos_condiciones' => 'Términos y condiciones de Tech Solutions...',
            'politica_privacidad' => 'Política de privacidad de Tech Solutions...',
            'politica_cookies' => 'Política de cookies de Tech Solutions...',
        ]);

        BbbEmpresa::create([
            'nombre' => 'Marketing Digital Pro',
            'email' => 'contacto@marketingdigitalpro.com',
            'movil' => '+57 301 987 6543',
            'direccion' => 'Carrera 45 #23-12, Medellín, Colombia',
            'facebook' => 'https://facebook.com/marketingdigitalpro',
            'instagram' => 'https://instagram.com/marketingdigitalpro',
            'tiktok' => 'https://tiktok.com/@marketingdigitalpro',
            'linkedin' => 'https://linkedin.com/company/marketingdigitalpro',
            'youtube' => 'https://youtube.com/@marketingdigitalpro',
            'website' => 'https://www.marketingdigitalpro.com',
            'whatsapp' => '+57 301 987 6543',
            'terminos_condiciones' => 'Términos y condiciones de Marketing Digital Pro...',
            'politica_privacidad' => 'Política de privacidad de Marketing Digital Pro...',
            'politica_cookies' => 'Política de cookies de Marketing Digital Pro...',
        ]);

        BbbEmpresa::create([
            'nombre' => 'Restaurante El Buen Sabor',
            'email' => 'info@elbuensabor.com',
            'movil' => '+57 302 456 7890',
            'direccion' => 'Avenida 68 #12-34, Cali, Colombia',
            'facebook' => 'https://facebook.com/elbuensabor',
            'instagram' => 'https://instagram.com/elbuensabor',
            'website' => 'https://www.elbuensabor.com',
            'whatsapp' => '+57 302 456 7890',
            'terminos_condiciones' => 'Términos y condiciones de Restaurante El Buen Sabor...',
            'politica_privacidad' => 'Política de privacidad de Restaurante El Buen Sabor...',
        ]);
    }
}
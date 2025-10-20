<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Crear administrador Nelson
        User::updateOrCreate(
            ['email' => 'nelson@bbbpaginasweb.com'],
            [
                'name' => 'Nelson Moncada',
                'email' => 'nelson@bbbpaginasweb.com',
                'password' => Hash::make('Admin2024*Nelson'),
                'is_admin' => true,
                'emailValidado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Crear administrador Juan
        User::updateOrCreate(
            ['email' => 'juan@bbbpaginasweb.com'],
            [
                'name' => 'Juan Carlos',
                'email' => 'juan@bbbpaginasweb.com',
                'password' => Hash::make('Admin2024*Juan'),
                'is_admin' => true,
                'emailValidado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('✅ Administradores creados exitosamente:');
        $this->command->info('👤 Nelson: nelson@bbbpaginasweb.com / Admin2024*Nelson');
        $this->command->info('👤 Juan: juan@bbbpaginasweb.com / Admin2024*Juan');
    }
}

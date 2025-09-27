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

        // Crear administrador Nelson        // Crear administrador Nelson

        User::updateOrCreate(        User::updateOrCreate(

            ['email' => 'nelson@bbbpaginasweb.com'],            ['email' => 'nelson@bbbpaginasweb.com'],

            [            [

                'name' => 'Nelson Moncada',                'name' => 'Nelson Moncada',

                'email' => 'nelson@bbbpaginasweb.com',                'email' => 'nelson@bbbpaginasweb.com',

                'password' => Hash::make('Admin2024*Nelson'),                'password' => Hash::make('Admin2024*Nelson'),

                'is_admin' => true,                'is_admin' => true,

                'emailValidado' => true,                'emailValidado' => true,

                'created_at' => now(),                'created_at' => now(),

                'updated_at' => now(),                'updated_at' => now(),

            ]            ]

        );        );



        // Crear administrador Juan        // Crear administrador Juan

        User::updateOrCreate(        User::updateOrCreate(

            ['email' => 'juan@bbbpaginasweb.com'],            ['email' => 'juan@bbbpaginasweb.com'],

            [            [

                'name' => 'Juan Carlos',                'name' => 'Juan Carlos',

                'email' => 'juan@bbbpaginasweb.com',                'email' => 'juan@bbbpaginasweb.com',

                'password' => Hash::make('Admin2024*Juan'),                'password' => Hash::make('Admin2024*Juan'),

                'is_admin' => true,                'is_admin' => true,

                'emailValidado' => true,                'emailValidado' => true,

                'created_at' => now(),                'created_at' => now(),

                'updated_at' => now(),                'updated_at' => now(),

            ]            ]

        );        );



        $this->command->info('✅ Administradores creados exitosamente:');        $this->command->info('✅ Administradores creados exitosamente:');

        $this->command->info('👤 Nelson: nelson@bbbpaginasweb.com / Admin2024*Nelson');        $this->command->info('👤 Nelson: nelson@bbbpaginasweb.com / Admin2024*Nelson');

        $this->command->info('👤 Juan: juan@bbbpaginasweb.com / Admin2024*Juan');        $this->command->info('👤 Juan: juan@bbbpaginasweb.com / Admin2024*Juan');

    }    }

}}Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}

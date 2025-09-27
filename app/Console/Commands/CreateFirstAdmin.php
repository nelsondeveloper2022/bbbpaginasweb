<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateFirstAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-first';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear el primer usuario administrador del sistema';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Creación del Primer Administrador ===');
        $this->newLine();

        // Verificar si ya existe un administrador
        if (User::where('is_admin', true)->exists()) {
            $this->error('Ya existe al menos un administrador en el sistema.');
            $this->info('Para crear más administradores, usa el panel de administración.');
            return 1;
        }

        // Solicitar datos
        $name = $this->ask('Nombre completo del administrador');
        $email = $this->ask('Email del administrador');
        $password = $this->secret('Contraseña (mínimo 8 caracteres)');
        $passwordConfirmation = $this->secret('Confirmar contraseña');

        // Validar datos
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $this->error('Error en los datos proporcionados:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('- ' . $error);
            }
            return 1;
        }

        // Crear el administrador
        try {
            $admin = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
                'emailValidado' => true,
            ]);

            $this->newLine();
            $this->info('✅ Administrador creado exitosamente!');
            $this->newLine();
            $this->table(
                ['Campo', 'Valor'],
                [
                    ['ID', $admin->id],
                    ['Nombre', $admin->name],
                    ['Email', $admin->email],
                    ['Tipo', 'Administrador'],
                    ['Creado', $admin->created_at->format('d/m/Y H:i:s')],
                ]
            );
            $this->newLine();
            $this->info('Puedes acceder al panel de administración en: /login-admin');
            
            return 0;

        } catch (\Exception $e) {
            $this->error('Error al crear el administrador: ' . $e->getMessage());
            return 1;
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesYUsuariosSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $secretaria = Role::firstOrCreate(['name' => 'secretaria']);

        // Crear usuario admin
        $userAdmin = User::firstOrCreate(
            ['email' => 'darwin@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('8310894'), // Cambia luego por seguridad
            ]
        );
        $userAdmin->assignRole($admin);

        // Crear usuario secretaria
        $userSecretaria = User::firstOrCreate(
            ['email' => 'secretaria@gmail.com'],
            [
                'name' => 'Secretaria',
                'password' => Hash::make('secretaria1234'), // Cambia luego por seguridad
            ]
        );
        $userSecretaria->assignRole($secretaria);
    }
}

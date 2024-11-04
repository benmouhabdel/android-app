<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Créez ou mettez à jour l'utilisateur admin
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '1234567890', // Set admin phone number
                'annee' => 5, // Exemple d'année pour admin
                'classe' => 'Classe spéciale', // Exemple de classe pour admin
                'filiere' => 'Ingénierie', // Exemple de filière pour admin
            ]
        );

        // Créez ou mettez à jour un utilisateur normal
        User::firstOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'user',
                'password' => bcrypt('password'),
                'role' => 'user',
                'registration_key' => 'Shifters@Heec143',
                'phone' => '0987654321', // Set user phone number
                'annee' => 3, // Exemple d'année pour utilisateur
                'classe' => 'Classe A', // Exemple de classe pour utilisateur
                'filiere' => 'Marketing', // Exemple de filière pour utilisateur
            ]
        );
    }
}

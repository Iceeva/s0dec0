<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création d'un administrateur
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@sodeco.com',
            'password' => Hash::make('password123'),//$2y$12$15uf7TkvHXZG8xqJyFKrj.heonO4l9yKLoqgIEB/4smFexD0D1h/q
            'role' => 'admin',
        ]);

        // Création d'un agent
        User::create([
            'name' => 'Agent smith',
            'email' => 'agent@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'agent',
        ]);

        // Création d'un acheteur
        User::create([
            'name' => 'Acheteur Mich',
            'email' => 'acheteur@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'buyer',
        ]);
    }
}

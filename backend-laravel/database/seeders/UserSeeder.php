<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@indigo.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Vendedor',
            'email' => 'vendedor@indigo.com',
            'password' => Hash::make('password'),
        ]);
    }
}

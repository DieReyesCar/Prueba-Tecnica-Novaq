<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Cliente Uno',
            'email'    => 'cliente1@novaq.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name'     => 'Cliente Dos',
            'email'    => 'cliente2@novaq.com',
            'password' => Hash::make('password123'),
        ]);
    }
} 
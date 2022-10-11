<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $user = User::create([
            'name' => 'Tsukasa',
            'email' => 'correo@correo.com',
            'password' => Hash::make('12345678'),
            'url' => 'http"//www.google.com',
        ]);

        // $user->perfil()->create();

        $user2 = User::create([
            'name' => 'Chris',
            'email' => 'correo2@correo.com',
            'password' => Hash::make('12345678'),
            'url' => 'http"//www.google.com',
        ]);

        // $user2->perfil()->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users[] = [
            'name' => "Usuário de teste",
            'email' => "test@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // senha padrão
            'remember_token' => Str::random(10),
        ];

        $users[] = [
            'name' => "Usuário de teste 2",
            'email' => "test2@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // senha padrão
            'remember_token' => Str::random(10),
        ];


        foreach ($users as $user) {
            User::create($user);
        }
    }
}

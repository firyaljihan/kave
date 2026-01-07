<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun ADMIN
        User::create([
            'name' => 'Admin Kave',
            'email' => 'admin@kave.com',
            'password' => Hash::make('12345'),
            'role' => 'admin',
        ]);

        // Akun PENYELENGGARA
        User::create([
            'name' => 'Himpunan Mahasiswa Sistem Informasi',
            'email' => 'hmsi@telkomuniversity.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'penyelenggara',
        ]);

        // MAHASISWA
        User::create([
            'name' => 'Firyal Jihan',
            'email' => 'firyaljihan@student.telkomuniversity.ac.id',
            'password' => Hash::make('12345'),
            'role' => 'mahasiswa',
        ]);

        // KATEGORI Event
        Category::create(['name' => 'Seminar']);
        Category::create(['name' => 'Workshop']);
        Category::create(['name' => 'Lomba']);
        Category::create(['name' => 'Konser']);
    }
}

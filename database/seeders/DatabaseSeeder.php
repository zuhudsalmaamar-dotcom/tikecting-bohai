<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Buat Akun Teknisi
        User::create([
            'name' => 'Teknisi IT',
            'email' => 'technician@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'technician',
        ]);

        // 3. Buat Akun User Biasa
        User::create([
            'name' => 'User Pelapor',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 4. Buat Kategori Tiket
        $categories = [
            [
                'name' => 'Hardware',
                'description' => 'Masalah perangkat keras seperti PC, Printer, Monitor, dsb.',
            ],
            [
                'name' => 'Software',
                'description' => 'Masalah aplikasi, install ulang OS, lisensi software, dsb.',
            ],
            [
                'name' => 'Network',
                'description' => 'Masalah koneksi Wi-Fi, kabel LAN, internet lambat, dsb.',
            ],
            [
                'name' => 'Account & Access',
                'description' => 'Lupa password, reset akun, akses email/sistem, dsb.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
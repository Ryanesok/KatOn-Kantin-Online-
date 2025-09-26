<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kantin;
use App\Models\User;
use App\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Kantin
        $kantinA = Kantin::create(['nama_kantin' => 'Kantin Sejahtera']);
        $kantinB = Kantin::create(['nama_kantin' => 'Kantin Bahagia']);

        // 2. Buat User Admin Kantin
        $adminA = User::create([
            'name' => 'Admin Kantin A',
            'email' => 'admin_a@kantin.com',
            'password' => Hash::make('password'),
            'role' => 'admin_kantin',
            'kantin_id' => $kantinA->id
        ]);

        $adminB = User::create([
            'name' => 'Admin Kantin B',
            'email' => 'admin_b@kantin.com',
            'password' => Hash::make('password'),
            'role' => 'admin_kantin',
            'kantin_id' => $kantinB->id
        ]);

        // 3. Buat User Pembeli (Mahasiswa)
        $pembeli = User::create([
            'name' => 'Budi Mahasiswa',
            'nim' => '12345678',
            'email' => 'budi@mahasiswa.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli'
        ]);

        // 4. Buat Menu untuk masing-masing kantin
        Menu::create([
            'kantin_id' => $kantinA->id,
            'nama' => 'Nasi Goreng Spesial',
            'deskripsi' => 'Nasi goreng dengan telur, ayam, dan sosis.',
            'harga' => 15000,
            'stok' => 50,
            'status' => 'tersedia'
        ]);

        Menu::create([
            'kantin_id' => $kantinA->id,
            'nama' => 'Es Teh Manis',
            'deskripsi' => 'Minuman teh manis dingin menyegarkan.',
            'harga' => 3000,
            'stok' => 100,
            'status' => 'tersedia'
        ]);

        Menu::create([
            'kantin_id' => $kantinB->id,
            'nama' => 'Soto Ayam Lamongan',
            'deskripsi' => 'Soto ayam dengan koya gurih.',
            'harga' => 12000,
            'stok' => 30,
            'status' => 'tersedia'
        ]);
    }
}
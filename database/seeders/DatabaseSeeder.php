<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 2 Petugas Kantin
        User::create([
            'name' => 'Admin Kantin 1',
            'email' => 'admin1@kantin.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'petugas_kantin',
        ]);

        User::create([
            'name' => 'Admin Kantin 2',
            'email' => 'admin2@kantin.com',
            'phone_number' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'petugas_kantin',
        ]);

        // Buat 10 User
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@kantin.com',
                'phone_number' => '0812345678' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Buat 15 Menu
        $menus = [
            ['name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar', 'price' => 15000, 'stock' => 20],
            ['name' => 'Mie Ayam Bakso', 'description' => 'Mie ayam dengan bakso sapi pilihan', 'price' => 12000, 'stock' => 25],
            ['name' => 'Ayam Geprek', 'description' => 'Ayam goreng crispy dengan sambal level 1-5', 'price' => 13000, 'stock' => 18],
            ['name' => 'Soto Ayam', 'description' => 'Soto ayam tradisional dengan rempah pilihan', 'price' => 11000, 'stock' => 22],
            ['name' => 'Gado-Gado', 'description' => 'Sayuran segar dengan bumbu kacang', 'price' => 10000, 'stock' => 15],
            ['name' => 'Nasi Pecel', 'description' => 'Nasi dengan sayuran dan sambal pecel', 'price' => 9000, 'stock' => 20],
            ['name' => 'Bakso Malang', 'description' => 'Bakso sapi dengan mie dan pangsit goreng', 'price' => 14000, 'stock' => 17],
            ['name' => 'Sate Ayam', 'description' => '10 tusuk sate ayam dengan bumbu kacang', 'price' => 16000, 'stock' => 12],
            ['name' => 'Es Teh Manis', 'description' => 'Es teh segar dengan gula pas', 'price' => 3000, 'stock' => 50],
            ['name' => 'Es Jeruk', 'description' => 'Jus jeruk segar dingin', 'price' => 5000, 'stock' => 40],
            ['name' => 'Kopi Susu', 'description' => 'Kopi robusta dengan susu segar', 'price' => 8000, 'stock' => 30],
            ['name' => 'Jus Alpukat', 'description' => 'Jus alpukat segar dengan coklat', 'price' => 10000, 'stock' => 25],
            ['name' => 'Air Mineral', 'description' => 'Air mineral 600ml', 'price' => 3000, 'stock' => 100],
            ['name' => 'Kentang Goreng', 'description' => 'French fries crispy dengan saus', 'price' => 8000, 'stock' => 30],
            ['name' => 'Pisang Goreng', 'description' => 'Pisang goreng crispy 5 potong', 'price' => 6000, 'stock' => 35],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        // Buat 20 Orders untuk beberapa user
        $userIds = User::where('role', 'user')->pluck('id')->toArray();
        $menuIds = Menu::pluck('id')->toArray();
        $statuses = ['Diproses', 'Selesai', 'Dibatalkan'];

        for ($i = 1; $i <= 20; $i++) {
            $userId = $userIds[array_rand($userIds)];
            $menuId = $menuIds[array_rand($menuIds)];
            $menu = Menu::find($menuId);
            $quantity = rand(1, 3);

            Order::create([
                'user_id' => $userId,
                'menu_id' => $menuId,
                'quantity' => $quantity,
                'total_price' => $menu->price * $quantity,
                'status' => $statuses[array_rand($statuses)],
                'order_date' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
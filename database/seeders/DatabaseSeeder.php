<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Kantin;
use App\Models\Topping;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Kantins dulu
        $kantinA = Kantin::create([
            'name' => 'Kantin Fakultas Teknik',
            'fakultas' => 'Fakultas Teknik',
            'location' => 'Lantai 1 Gedung Teknik',
            'description' => 'Kantin yang melayani civitas akademika Fakultas Teknik',
            'is_active' => true,
        ]);

        $kantinB = Kantin::create([
            'name' => 'Kantin Fakultas Ekonomi',
            'fakultas' => 'Fakultas Ekonomi',
            'location' => 'Lantai Dasar Gedung Ekonomi',
            'description' => 'Kantin yang melayani civitas akademika Fakultas Ekonomi',
            'is_active' => true,
        ]);

        $kantinC = Kantin::create([
            'name' => 'Kantin Fakultas Kedokteran',
            'fakultas' => 'Fakultas Kedokteran',
            'location' => 'Lantai 2 Gedung Kedokteran',
            'description' => 'Kantin yang melayani civitas akademika Fakultas Kedokteran',
            'is_active' => true,
        ]);

        // Buat Petugas Kantin dengan kantin masing-masing
        User::create([
            'name' => 'Admin Kantin Teknik',
            'email' => 'admin.teknik@kantin.com',
            'phone_number' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'petugas_kantin',
            'kantin_id' => $kantinA->id,
        ]);

        User::create([
            'name' => 'Admin Kantin Ekonomi',
            'email' => 'admin.ekonomi@kantin.com',
            'phone_number' => '081234567891',
            'password' => Hash::make('password'),
            'role' => 'petugas_kantin',
            'kantin_id' => $kantinB->id,
        ]);

        User::create([
            'name' => 'Admin Kantin Kedokteran',
            'email' => 'admin.kedokteran@kantin.com',
            'phone_number' => '081234567892',
            'password' => Hash::make('password'),
            'role' => 'petugas_kantin',
            'kantin_id' => $kantinC->id,
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

        // Buat Toppings untuk masing-masing kantin
        $toppingsA = [
            ['name' => 'Extra Keju', 'price' => 3000, 'description' => 'Keju mozzarella extra'],
            ['name' => 'Telur Mata Sapi', 'price' => 4000, 'description' => 'Telur ayam mata sapi fresh'],
            ['name' => 'Ayam Extra', 'price' => 8000, 'description' => 'Potongan ayam tambahan'],
            ['name' => 'Level Pedas Extra', 'price' => 1000, 'description' => 'Tambahan sambal pedas level 10'],
        ];

        $toppingsB = [
            ['name' => 'Keju Kraft', 'price' => 2500, 'description' => 'Keju kraft slice'],
            ['name' => 'Sosis Bratwurst', 'price' => 5000, 'description' => 'Sosis premium bratwurst'],
            ['name' => 'Mayones Extra', 'price' => 1500, 'description' => 'Mayones original extra'],
            ['name' => 'Bawang Goreng', 'price' => 2000, 'description' => 'Bawang goreng crispy'],
        ];

        $toppingsC = [
            ['name' => 'Alpukat Fresh', 'price' => 4000, 'description' => 'Potongan alpukat segar'],
            ['name' => 'Kacang Mede', 'price' => 3500, 'description' => 'Kacang mede panggang'],
            ['name' => 'Coklat Chip', 'price' => 2500, 'description' => 'Coklat chip premium'],
            ['name' => 'Whipped Cream', 'price' => 3000, 'description' => 'Whipped cream fresh'],
        ];

        foreach ($toppingsA as $topping) {
            Topping::create(array_merge($topping, ['kantin_id' => $kantinA->id]));
        }

        foreach ($toppingsB as $topping) {
            Topping::create(array_merge($topping, ['kantin_id' => $kantinB->id]));
        }

        foreach ($toppingsC as $topping) {
            Topping::create(array_merge($topping, ['kantin_id' => $kantinC->id]));
        }

        // Buat Menu untuk masing-masing kantin
        $menusA = [
            ['name' => 'Nasi Goreng Spesial Teknik', 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar ala teknik', 'price' => 15000, 'stock' => 20],
            ['name' => 'Mie Ayam Bakso Teknik', 'description' => 'Mie ayam dengan bakso sapi pilihan khas teknik', 'price' => 12000, 'stock' => 25],
            ['name' => 'Ayam Geprek Programmer', 'description' => 'Ayam goreng crispy dengan sambal level 1-5 untuk programmer', 'price' => 13000, 'stock' => 18],
            ['name' => 'Soto Ayam Engineer', 'description' => 'Soto ayam tradisional dengan rempah pilihan engineer', 'price' => 11000, 'stock' => 22],
            ['name' => 'Es Teh Coding', 'description' => 'Es teh segar untuk coding marathon', 'price' => 3000, 'stock' => 50],
        ];

        $menusB = [
            ['name' => 'Nasi Gudeg Ekonomis', 'description' => 'Nasi gudeg dengan harga ekonomis untuk mahasiswa ekonomi', 'price' => 12000, 'stock' => 20],
            ['name' => 'Gado-Gado Bisnis', 'description' => 'Sayuran segar dengan bumbu kacang untuk pebisnis muda', 'price' => 10000, 'stock' => 15],
            ['name' => 'Bakso Investasi', 'description' => 'Bakso sapi dengan mie, investasi terbaik untuk kenyang', 'price' => 14000, 'stock' => 17],
            ['name' => 'Sate Entrepreneur', 'description' => '10 tusuk sate ayam dengan bumbu kacang khas entrepreneur', 'price' => 16000, 'stock' => 12],
            ['name' => 'Kopi Bisnis', 'description' => 'Kopi robusta dengan susu segar untuk meeting bisnis', 'price' => 8000, 'stock' => 30],
        ];

        $menusC = [
            ['name' => 'Salad Sehat Dokter', 'description' => 'Salad sayuran segar sehat untuk calon dokter', 'price' => 13000, 'stock' => 15],
            ['name' => 'Jus Multivitamin', 'description' => 'Jus buah campur kaya vitamin untuk mahasiswa kedokteran', 'price' => 12000, 'stock' => 25],
            ['name' => 'Sandwich Protein', 'description' => 'Sandwich dengan protein tinggi untuk stamina belajar', 'price' => 15000, 'stock' => 20],
            ['name' => 'Smoothie Antioksidan', 'description' => 'Smoothie buah dengan antioksidan tinggi', 'price' => 14000, 'stock' => 18],
            ['name' => 'Air Infused Water', 'description' => 'Air mineral dengan infused lemon dan mint', 'price' => 5000, 'stock' => 50],
        ];

        foreach ($menusA as $menu) {
            Menu::create(array_merge($menu, ['kantin_id' => $kantinA->id]));
        }

        foreach ($menusB as $menu) {
            Menu::create(array_merge($menu, ['kantin_id' => $kantinB->id]));
        }

        foreach ($menusC as $menu) {
            Menu::create(array_merge($menu, ['kantin_id' => $kantinC->id]));
        }

        // Attach some toppings to menus (examples)
        $menusWithToppings = Menu::all();
        $allToppings = Topping::all();
        
        foreach ($menusWithToppings as $menu) {
            // Get toppings from the same kantin
            $kantinToppings = $allToppings->where('kantin_id', $menu->kantin_id);
            
            // Randomly attach 0-3 toppings to each menu
            $randomToppings = $kantinToppings->random(min(rand(0, 3), $kantinToppings->count()));
            
            foreach ($randomToppings as $topping) {
                $menu->toppings()->attach($topping->id);
            }
        }

        // Buat 20 Orders untuk beberapa user
        $userIds = User::where('role', 'user')->pluck('id')->toArray();
        $menus = Menu::all();
        $statuses = ['Diproses', 'Selesai', 'Dibatalkan'];

        for ($i = 1; $i <= 20; $i++) {
            $userId = $userIds[array_rand($userIds)];
            $menu = $menus->random();
            $quantity = rand(1, 3);

            Order::create([
                'user_id' => $userId,
                'menu_id' => $menu->id,
                'kantin_id' => $menu->kantin_id, // Ambil kantin_id dari menu
                'quantity' => $quantity,
                'total_price' => $menu->price * $quantity,
                'status' => $statuses[array_rand($statuses)],
                'order_date' => now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
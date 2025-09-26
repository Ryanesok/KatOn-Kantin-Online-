<?php

namespace App\Http\Controllers\Pembeli;

use Illuminate\Routing\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    // Menampilkan semua menu yang tersedia dari semua kantin
    public function index()
    {
        $menus = Menu::with('kantin') // Mengambil data kantin juga (eager loading)
            ->where('status', 'tersedia')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pembeli.menu', compact('menus'));
    }
}
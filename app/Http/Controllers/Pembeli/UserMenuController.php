<?php

namespace App\Http\Controllers\Pembeli;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;

class UserMenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kantin')->get();
        return view('user.dashboard', compact('menus'));
    }

    public function order(Request $request, Menu $menu)
    {
        $request->validate([
            'jumlah' => "required|integer|min:1|max:{$menu->stok}",
        ]);

        if ($menu->stok < 1) {
            return redirect()->back()->withErrors(['jumlah' => 'Menu tidak tersedia atau stok habis.']);
        }

        DB::transaction(function () use ($request, $menu) {
            Order::create([
                'user_id' => auth()->user()->id,
                'menu_id' => $menu->id,
                'jumlah' => $request->jumlah,
                'status' => 'pending',
            ]);

            // Kurangi stok menu secara atomik
            $menu->decrement('stok', $request->jumlah);
        });

        return redirect()->route('user.dashboard')->with('success', 'Pesanan berhasil dibuat!');
    }
}


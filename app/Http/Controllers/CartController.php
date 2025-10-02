<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);

        if ($menu->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('menu_id', $validated['menu_id'])
            ->first();

        if ($cart) {
            $cart->quantity += $validated['quantity'];
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'menu_id' => $validated['menu_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        return back()->with('success', 'Item berhasil ditambahkan ke keranjang!');
    }

    public function index()
    {
        $carts = Cart::with('menu')->where('user_id', auth()->id())->get();
        $total = $carts->sum(function ($cart) {
            return $cart->menu->price * $cart->quantity;
        });

        return view('user.cart', compact('carts', 'total'));
    }

    public function update(Request $request, Cart $cart)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cart->menu->stock < $validated['quantity']) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart->update($validated);

        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item dihapus dari keranjang!');
    }
}

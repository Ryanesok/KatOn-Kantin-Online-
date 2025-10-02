<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $carts = Cart::with('menu')->where('user_id', auth()->id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('user.cart')->with('error', 'Keranjang kosong!');
        }

        DB::transaction(function () use ($carts) {
            foreach ($carts as $cart) {
                if ($cart->menu->stock < $cart->quantity) {
                    throw new \Exception('Stok ' . $cart->menu->name . ' tidak mencukupi!');
                }

                Order::create([
                    'user_id' => auth()->id(),
                    'menu_id' => $cart->menu_id,
                    'quantity' => $cart->quantity,
                    'total_price' => $cart->menu->price * $cart->quantity,
                    'status' => 'Diproses',
                    'order_date' => now(),
                ]);

                $cart->menu->decrement('stock', $cart->quantity);
                $cart->delete();
            }
        });

        return redirect()->route('user.orders')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function index(Request $request)
    {
        $query = Order::with('menu')->where('user_id', auth()->id());

        if ($request->has('search')) {
            $query->whereHas('menu', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $orders = $query->orderBy('order_date', 'desc')->paginate(10);

        return view('user.orders', compact('orders'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id() || $order->status !== 'Diproses') {
            return back()->with('error', 'Tidak dapat membatalkan pesanan!');
        }

        $order->update(['status' => 'Dibatalkan']);
        $order->menu->increment('stock', $order->quantity);

        return back()->with('success', 'Pesanan berhasil dibatalkan!');
    }
}

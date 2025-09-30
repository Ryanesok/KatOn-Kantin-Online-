<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'petugas_kantin') {
            $data = [
                'totalMenus' => Menu::count(),
                'todayOrders' => Order::whereDate('order_date', today())->count(),
                'totalUsers' => User::where('role', 'user')->count(),
                'todayRevenue' => Order::whereDate('order_date', today())
                    ->where('status', '!=', 'Dibatalkan')
                    ->sum('total_price'),
            ];
            
            return view('petugas.dashboard', $data);
        }
        
        return redirect()->route('user.menu');
    }
}
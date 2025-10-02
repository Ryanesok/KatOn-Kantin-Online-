<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ToppingController;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes untuk Petugas Kantin
    Route::middleware('role:petugas_kantin')->prefix('petugas')->name('petugas.')->group(function () {
        // Menu management
        Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
        Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
        Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
        Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
        Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');
        
        // Topping management
        Route::get('/toppings', [ToppingController::class, 'index'])->name('toppings.index');
        Route::get('/toppings/create', [ToppingController::class, 'create'])->name('toppings.create');
        Route::post('/toppings', [ToppingController::class, 'store'])->name('toppings.store');
        Route::get('/toppings/{topping}/edit', [ToppingController::class, 'edit'])->name('toppings.edit');
        Route::put('/toppings/{topping}', [ToppingController::class, 'update'])->name('toppings.update');
        Route::delete('/toppings/{topping}', [ToppingController::class, 'destroy'])->name('toppings.destroy');
    });
    
    // Routes untuk User
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/menu', [MenuController::class, 'userIndex'])->name('menu');
        Route::get('/menu/{id}/detail', [MenuController::class, 'getMenuDetail'])->name('menu.detail');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    });
});

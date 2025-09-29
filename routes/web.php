<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Pembeli\MenuController as PembeliMenuController;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;


// --- Rute Autentikasi ---
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// Halaman utama: Arahkan ke halaman yang sesuai jika sudah login, atau ke login jika belum
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role == 'admin_kantin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role == 'pembeli') {
            return redirect()->route('pembeli.menu');
        }
    }
    return redirect()->route('login');
});


// --- Rute untuk Pembeli ---
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('/menu', [PembeliMenuController::class, 'index'])->name('pembeli.menu');
});


// --- Rute untuk Admin Kantin ---
Route::middleware(['auth', 'role:admin_kantin'])->prefix('admin')->group(function () {
    // Dashboard adalah halaman utama untuk CRUD menu
    Route::get('/dashboard', [AdminMenuController::class, 'index'])->name('admin.dashboard');
    
    // Rute untuk proses CRUD Menu
    Route::get('/menu/create', [AdminMenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/menu', [AdminMenuController::class, 'store'])->name('admin.menu.store');
    Route::get('/menu/{menu}/edit', [AdminMenuController::class, 'edit'])->name('admin.menu.edit');
    Route::put('/menu/{menu}', [AdminMenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/menu/{menu}', [AdminMenuController::class, 'destroy'])->name('admin.menu.destroy');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserMenuController::class, 'index'])->name('user.dashboard');
    Route::post('/menu/{menu}/order', [UserMenuController::class, 'order'])->name('user.menu.order');
});
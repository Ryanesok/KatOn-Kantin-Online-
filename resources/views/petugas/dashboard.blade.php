<!-- resources/views/petugas/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="py-4">
                <h6 class="px-3 text-muted text-uppercase mb-3">Menu Navigasi</h6>
                <nav class="nav flex-column">
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('petugas.menus.index') }}">
                        <i class="fas fa-utensils me-2"></i>Kelola Menu
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Dashboard Petugas Kantin</h2>
                <span class="badge bg-success px-3 py-2">
                    <i class="fas fa-user-tie me-2"></i>Petugas
                </span>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Menu</h6>
                                    <h2 class="fw-bold mb-0">{{ $totalMenus }}</h2>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-utensils"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white" style="background-color: #d4af37;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Pesanan Hari Ini</h6>
                                    <h2 class="fw-bold mb-0">{{ $todayOrders }}</h2>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Total Pengguna</h6>
                                    <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-white-50 mb-1">Pendapatan Hari Ini</h6>
                                    <h2 class="fw-bold mb-0">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h2>
                                </div>
                                <div class="fs-1 opacity-50">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">
                        <i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('petugas.menus.index') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-list me-2"></i>Lihat Semua Menu
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('petugas.menus.create') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-plus me-2"></i>Tambah Menu Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
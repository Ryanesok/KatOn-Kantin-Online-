<!-- resources/views/user/menu.blade.php -->
@extends('layouts.app')

@section('title', 'Menu Kantin')

@push('styles')
<style>
    .menu-card {
        transition: all 0.3s ease;
        height: 100%;
    }
    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }
    .menu-img {
        height: 200px;
        object-fit: cover;
        border-radius: 12px 12px 0 0;
    }
    .price-tag {
        background: linear-gradient(135deg, #0d7a3d, #0a5c2e);
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
    }
    .stock-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold mb-2">
                <i class="fas fa-utensils text-success me-2"></i>Menu Kantin
            </h2>
            <p class="text-muted">Pilih menu favoritmu dan pesan sekarang!</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('user.cart') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang
                @if(auth()->user()->carts->count() > 0)
                    <span class="badge bg-danger">{{ auth()->user()->carts->count() }}</span>
                @endif
            </a>
            <a href="{{ route('user.orders') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-receipt me-2"></i>Pesanan Saya
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('user.menu') }}" method="GET">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari menu..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Menu Cards -->
    <div class="row g-4">
        @forelse($menus as $menu)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card menu-card">
                <div class="position-relative">
                    @if($menu->image_path)
                        <img src="{{ asset('storage/' . $menu->image_path) }}" 
                             class="card-img-top menu-img" 
                             alt="{{ $menu->name }}">
                    @else
                        <div class="menu-img bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-utensils fa-4x text-muted"></i>
                        </div>
                    @endif
                    
                    <span class="stock-badge {{ $menu->stock > 10 ? 'bg-success' : ($menu->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                        Stok: {{ $menu->stock }}
                    </span>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $menu->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($menu->description, 60) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="price-tag">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('user.cart.add') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <div class="input-group mb-2">
                            <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty(this)">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" name="quantity" class="form-control text-center" 
                                   value="1" min="1" max="{{ $menu->stock }}" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="increaseQty(this)">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" 
                                {{ $menu->stock == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus me-2"></i>
                            {{ $menu->stock == 0 ? 'Habis' : 'Pesan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-5x text-muted mb-3"></i>
                <h4 class="text-muted">Menu tidak ditemukan</h4>
                <p class="text-muted">Coba kata kunci pencarian lain</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $menus->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
function increaseQty(btn) {
    const input = $(btn).siblings('input[name="quantity"]');
    const max = parseInt(input.attr('max'));
    const current = parseInt(input.val());
    if (current < max) {
        input.val(current + 1);
    }
}

function decreaseQty(btn) {
    const input = $(btn).siblings('input[name="quantity"]');
    const current = parseInt(input.val());
    if (current > 1) {
        input.val(current - 1);
    }
}
</script>
@endpush
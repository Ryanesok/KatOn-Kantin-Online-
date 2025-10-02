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

    <!-- Filter dan Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('user.menu') }}" method="GET" id="filterForm">
                <!-- Filter Kantin -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="kantin_id" class="form-label">
                            <i class="fas fa-store me-1"></i>Pilih Kantin
                        </label>
                        <select name="kantin_id" class="form-select" id="kantin_id" onchange="this.form.submit()">
                            <option value="">Semua Kantin</option>
                            @foreach($kantins as $kantin)
                                <option value="{{ $kantin->id }}" {{ request('kantin_id') == $kantin->id ? 'selected' : '' }}>
                                    {{ $kantin->name }} ({{ $kantin->fakultas }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @if(request('kantin_id'))
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="alert alert-info mb-0 w-100">
                                <i class="fas fa-info-circle me-1"></i>
                                Menampilkan menu dari: <strong>{{ $kantins->find(request('kantin_id'))->name ?? 'Kantin' }}</strong>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Search Bar -->
                <div class="input-group input-group-lg">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari menu... (ketik minimal 2 karakter)" value="{{ request('search') }}">
                    <span class="input-group-text d-none" id="searchLoader">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </span>
                    <button type="submit" class="btn btn-primary">Cari</button>
                    @if(request('search') || request('kantin_id'))
                        <a href="{{ route('user.menu') }}" class="btn btn-outline-danger">Reset</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results Info -->
    @if(request('search'))
    <div class="alert alert-info">
        <i class="fas fa-search me-2"></i>
        Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
        ({{ $menus->total() }} menu ditemukan)
    </div>
    @endif

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
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-bold mb-0">{{ $menu->name }}</h5>
                        <span class="badge bg-secondary small">{{ $menu->kantin->name }}</span>
                    </div>
                    <p class="card-text text-muted small mb-2">{{ Str::limit($menu->description, 60) }}</p>
                    
                    @if($menu->toppings->count() > 0)
                        <div class="mb-2">
                            <small class="text-success">
                                <i class="fas fa-plus-circle me-1"></i>{{ $menu->toppings->count() }} topping tersedia
                            </small>
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="price-tag">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-3">
                        <button type="button" 
                                class="btn btn-outline-primary w-100 mb-2" 
                                onclick="showMenuDetail({{ $menu->id }})"
                                {{ $menu->stock == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-info-circle me-2"></i>
                            Detail & Pilih Topping
                        </button>
                        
                        <form action="{{ route('user.cart.add') }}" method="POST" class="quick-order-form">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success w-100" 
                                    {{ $menu->stock == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-cart-plus me-2"></i>
                                {{ $menu->stock == 0 ? 'Habis' : 'Pesan Cepat' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                @if(request('search'))
                    <i class="fas fa-search fa-5x text-muted mb-3"></i>
                    <h4 class="text-muted">Menu tidak ditemukan</h4>
                    <p class="text-muted">Tidak ada menu yang cocok dengan pencarian "{{ request('search') }}"</p>
                    <a href="{{ route('user.menu') }}" class="btn btn-primary">Lihat Semua Menu</a>
                @else
                    <i class="fas fa-inbox fa-5x text-muted mb-3"></i>
                    <h4 class="text-muted">Belum ada menu tersedia</h4>
                    <p class="text-muted">Menu akan segera tersedia</p>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $menus->appends(request()->query())->links() }}
    </div>
</div>

<!-- Modal Detail Menu -->
<div class="modal fade" id="menuDetailModal" tabindex="-1" aria-labelledby="menuDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuDetailModalLabel">Detail Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="menuDetailContent">
                <!-- Content will be loaded via AJAX -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat detail menu...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let searchTimeout;

$(document).ready(function() {
    const searchLoader = $('#searchLoader');
    
    // Live Search dengan debouncing
    $('input[name="search"]').on('input', function() {
        const searchValue = $(this).val();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Hide loader
        searchLoader.addClass('d-none');
        
        // Set new timeout untuk menghindari terlalu banyak request
        searchTimeout = setTimeout(function() {
            // Jika kosong, redirect ke halaman utama
            if (searchValue.length === 0) {
                searchLoader.removeClass('d-none'); // Show loader
                window.location.href = '{{ route("user.menu") }}';
                return;
            }
            
            // Jika ada value dan minimal 2 karakter, lakukan search
            if (searchValue.length >= 2) {
                searchLoader.removeClass('d-none'); // Show loader
                
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('search', searchValue);
                currentUrl.searchParams.delete('page'); // Reset ke halaman 1
                
                // Preserve kantin_id filter
                const kantinId = $('#kantin_id').val();
                if (kantinId) {
                    currentUrl.searchParams.set('kantin_id', kantinId);
                }
                
                // Update URL dan load halaman
                window.location.href = currentUrl.toString();
            }
        }, 500); // Delay 500ms untuk menghindari spam request
    });
    
    // Auto focus pada search input dan set cursor di akhir
    const searchInput = $('input[name="search"]');
    if (searchInput.val()) {
        searchInput.focus();
        const val = searchInput.val();
        searchInput.val('').val(val); // Trick untuk set cursor di akhir
    }
});

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

function showMenuDetail(menuId) {
    const modal = new bootstrap.Modal(document.getElementById('menuDetailModal'));
    const modalContent = document.getElementById('menuDetailContent');
    
    // Show loading state
    modalContent.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memuat detail menu...</p>
        </div>
    `;
    
    modal.show();
    
    // Load menu detail via AJAX
    fetch(`/user/menu/${menuId}/detail`)
        .then(response => response.json())
        .then(data => {
            modalContent.innerHTML = data.html;
        })
        .catch(error => {
            modalContent.innerHTML = `
                <div class="text-center text-danger">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <p>Gagal memuat detail menu. Silakan coba lagi.</p>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            `;
        });
}
</script>
@endpush
<!-- resources/views/user/cart.blade.php -->
@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('user.menu') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Menu
        </a>
        <h2 class="fw-bold">
            <i class="fas fa-shopping-cart text-success me-2"></i>Keranjang Belanja
        </h2>
    </div>

    @if($carts->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
            <h4 class="text-muted">Keranjang Kosong</h4>
            <p class="text-muted mb-4">Belum ada item di keranjang Anda</p>
            <a href="{{ route('user.menu') }}" class="btn btn-primary">
                <i class="fas fa-utensils me-2"></i>Lihat Menu
            </a>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Item Pesanan</h5>
                    
                    @foreach($carts as $cart)
                    <div class="row align-items-center border-bottom py-3">
                        <div class="col-md-2">
                            @if($cart->menu->image_path)
                                <img src="{{ asset('storage/' . $cart->menu->image_path) }}" 
                                     alt="{{ $cart->menu->name }}" 
                                     class="img-fluid rounded"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-utensils text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold mb-1">{{ $cart->menu->name }}</h6>
                            <p class="text-muted small mb-1">Rp {{ number_format($cart->menu->price, 0, ',', '.') }}</p>
                            
                            @if($cart->toppings->count() > 0)
                                <div class="small">
                                    <span class="badge bg-warning text-dark">Toppings:</span>
                                    @foreach($cart->toppings as $topping)
                                        <span class="text-muted">{{ $topping->name }} (+Rp {{ number_format($topping->pivot->price, 0, ',', '.') }})</span>
                                        @if(!$loop->last), @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('user.cart.update', $cart) }}" method="POST" class="update-cart-form">
                                @csrf
                                @method('PUT')
                                <div class="input-group input-group-sm">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseCartQty(this)">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" class="form-control text-center" 
                                           value="{{ $cart->quantity }}" min="1" max="{{ $cart->menu->stock }}" 
                                           onchange="this.form.submit()">
                                    <button type="button" class="btn btn-outline-secondary" onclick="increaseCartQty(this)">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2 text-end">
                            <p class="fw-bold mb-0">
                                Rp {{ number_format($cart->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-md-1 text-end">
                            <form action="{{ route('user.cart.destroy', $cart) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Hapus item ini dari keranjang?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card sticky-top" style="top: 80px;">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Ringkasan Pesanan</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal ({{ $carts->sum('quantity') }} item)</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong class="text-success fs-4">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </div>

                    <form action="{{ route('user.checkout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 btn-lg">
                            <i class="fas fa-check me-2"></i>Checkout
                        </button>
                    </form>

                    <a href="{{ route('user.menu') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="fas fa-plus me-2"></i>Tambah Menu Lain
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function increaseCartQty(btn) {
    const input = $(btn).siblings('input[name="quantity"]');
    const max = parseInt(input.attr('max'));
    const current = parseInt(input.val());
    if (current < max) {
        input.val(current + 1);
        input.closest('form').submit();
    }
}

function decreaseCartQty(btn) {
    const input = $(btn).siblings('input[name="quantity"]');
    const current = parseInt(input.val());
    if (current > 1) {
        input.val(current - 1);
        input.closest('form').submit();
    }
}
</script>
@endpush
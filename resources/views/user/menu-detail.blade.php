<!-- resources/views/user/menu-detail.blade.php -->
<div class="row">
    <!-- Menu Image -->
    <div class="col-md-5">
        @if($menu->image_path)
            <img src="{{ asset('storage/' . $menu->image_path) }}" 
                 class="img-fluid rounded" 
                 alt="{{ $menu->name }}"
                 style="width: 100%; height: 300px; object-fit: cover;">
        @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                 style="width: 100%; height: 300px;">
                <i class="fas fa-utensils fa-5x text-muted"></i>
            </div>
        @endif
    </div>
    
    <!-- Menu Info -->
    <div class="col-md-7">
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h4 class="fw-bold mb-0">{{ $menu->name }}</h4>
                <span class="badge bg-secondary">{{ $menu->kantin->name }}</span>
            </div>
            <p class="text-muted">{{ $menu->description }}</p>
        </div>

        <!-- Price Info -->
        <div class="mb-3">
            <span class="h5 text-success fw-bold" id="menuBasePrice" data-price="{{ $menu->price }}">
                Rp {{ number_format($menu->price, 0, ',', '.') }}
            </span>
            <small class="text-muted d-block">Harga dasar menu</small>
        </div>

        <!-- Stock Info -->
        <div class="mb-3">
            <span class="badge {{ $menu->stock > 10 ? 'bg-success' : ($menu->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                Stok: {{ $menu->stock }}
            </span>
        </div>

        <!-- Order Form -->
        <form action="{{ route('user.cart.add') }}" method="POST" id="orderForm">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
            
            <!-- Quantity Selection -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Jumlah Pesanan</label>
                <div class="input-group" style="width: 150px;">
                    <button type="button" class="btn btn-outline-secondary qty-btn-minus">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" name="quantity" class="form-control text-center" 
                           value="1" min="1" max="{{ $menu->stock }}" required>
                    <button type="button" class="btn btn-outline-secondary qty-btn-plus">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <!-- Toppings Selection -->
            @if($menu->toppings->count() > 0)
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    <i class="fas fa-plus-circle me-1"></i>Pilih Topping (Opsional)
                </label>
                <div class="toppings-list" style="max-height: 200px; overflow-y: auto;">
                    @foreach($menu->toppings as $topping)
                    <div class="form-check border rounded p-2 mb-2">
                        <input class="form-check-input topping-checkbox" 
                               type="checkbox" 
                               name="toppings[]" 
                               value="{{ $topping->id }}" 
                               id="topping_{{ $topping->id }}"
                               data-price="{{ $topping->price }}">
                        <label class="form-check-label w-100" for="topping_{{ $topping->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $topping->name }}</strong>
                                    @if($topping->description)
                                        <br><small class="text-muted">{{ $topping->description }}</small>
                                    @endif
                                </div>
                                <span class="text-success fw-bold">
                                    +Rp {{ number_format($topping->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Total Price -->
            <div class="mb-3 p-3 bg-light rounded">
                <div class="d-flex justify-content-between align-items-center">
                    <strong>Total Harga:</strong>
                    <strong class="text-success h5" id="totalPrice">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </strong>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary flex-fill" 
                        {{ $menu->stock == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-cart-plus me-2"></i>
                    {{ $menu->stock == 0 ? 'Habis' : 'Tambah ke Keranjang' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Initialize total price calculation
$(document).ready(function() {
    updateTotalPrice();
});
</script>
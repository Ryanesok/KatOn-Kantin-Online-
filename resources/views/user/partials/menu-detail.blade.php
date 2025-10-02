<!-- resources/views/user/partials/menu-detail.blade.php -->
<form id="detailOrderForm" action="{{ route('user.cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
    
    <div class="row">
        <div class="col-md-5">
            <!-- Menu Image -->
            <div class="position-relative">
                @if($menu->image_path)
                    <img src="{{ asset('storage/' . $menu->image_path) }}" 
                         class="img-fluid rounded" 
                         alt="{{ $menu->name }}"
                         style="width: 100%; height: 250px; object-fit: cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                         style="width: 100%; height: 250px;">
                        <i class="fas fa-utensils fa-4x text-muted"></i>
                    </div>
                @endif
                
                <span class="position-absolute top-0 start-0 m-2 badge bg-secondary">
                    {{ $menu->kantin->name }}
                </span>
                
                <span class="position-absolute top-0 end-0 m-2 badge {{ $menu->stock > 10 ? 'bg-success' : ($menu->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                    Stok: {{ $menu->stock }}
                </span>
            </div>
        </div>
        
        <div class="col-md-7">
            <!-- Menu Info -->
            <h4 class="fw-bold">{{ $menu->name }}</h4>
            <p class="text-muted">{{ $menu->description }}</p>
            
            <div class="mb-3">
                <span class="fs-4 fw-bold text-success">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </span>
            </div>
            
            <!-- Quantity Selection -->
            <div class="mb-4">
                <label class="form-label fw-semibold">Jumlah Pesanan</label>
                <div class="input-group" style="width: 150px;">
                    <button type="button" class="btn btn-outline-secondary" onclick="decreaseModalQty()">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" name="quantity" id="modalQuantity" class="form-control text-center" 
                           value="1" min="1" max="{{ $menu->stock }}" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="increaseModalQty()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            
            <!-- Toppings Selection -->
            @if($menu->toppings->count() > 0)
            <div class="mb-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-plus-circle text-warning me-1"></i>
                    Pilih Topping (Opsional)
                </label>
                <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                    @foreach($menu->toppings as $topping)
                    <div class="form-check mb-2">
                        <input class="form-check-input topping-checkbox" 
                               type="checkbox" 
                               name="toppings[]" 
                               value="{{ $topping->id }}" 
                               id="topping{{ $topping->id }}"
                               data-price="{{ $topping->price }}">
                        <label class="form-check-label w-100" for="topping{{ $topping->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $topping->name }}</strong>
                                    @if($topping->description)
                                        <br><small class="text-muted">{{ $topping->description }}</small>
                                    @endif
                                </div>
                                <span class="badge bg-warning text-dark">
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
            <div class="mb-3">
                <div class="card bg-light">
                    <div class="card-body py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Total Harga:</span>
                            <span class="fs-5 fw-bold text-success" id="totalPrice">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <small class="text-muted" id="priceBreakdown">
                            Menu: Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-secondary flex-fill" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary flex-fill" 
                        {{ $menu->stock == 0 ? 'disabled' : '' }}>
                    <i class="fas fa-cart-plus me-2"></i>
                    {{ $menu->stock == 0 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                </button>
            </div>
        </div>
    </div>
</form>

<script>
// Price calculation variables
const basePrice = {{ $menu->price }};
const maxStock = {{ $menu->stock }};

function updateTotalPrice() {
    const quantity = parseInt(document.getElementById('modalQuantity').value) || 1;
    let toppingsTotal = 0;
    let toppingsText = '';
    
    // Calculate toppings total
    document.querySelectorAll('.topping-checkbox:checked').forEach(checkbox => {
        const price = parseFloat(checkbox.dataset.price);
        toppingsTotal += price;
    });
    
    const menuTotal = basePrice * quantity;
    const toppingsSubtotal = toppingsTotal * quantity;
    const grandTotal = menuTotal + toppingsSubtotal;
    
    // Update total price display
    document.getElementById('totalPrice').textContent = 
        'Rp ' + grandTotal.toLocaleString('id-ID');
    
    // Update breakdown
    let breakdown = `Menu: Rp ${menuTotal.toLocaleString('id-ID')}`;
    if (toppingsSubtotal > 0) {
        breakdown += ` | Topping: Rp ${toppingsSubtotal.toLocaleString('id-ID')}`;
    }
    document.getElementById('priceBreakdown').textContent = breakdown;
}

function decreaseModalQty() {
    const input = document.getElementById('modalQuantity');
    const current = parseInt(input.value);
    if (current > 1) {
        input.value = current - 1;
        updateTotalPrice();
    }
}

function increaseModalQty() {
    const input = document.getElementById('modalQuantity');
    const current = parseInt(input.value);
    if (current < maxStock) {
        input.value = current + 1;
        updateTotalPrice();
    }
}

// Event listeners for topping checkboxes
document.querySelectorAll('.topping-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateTotalPrice);
});

// Event listener for quantity input
document.getElementById('modalQuantity').addEventListener('input', updateTotalPrice);
</script>
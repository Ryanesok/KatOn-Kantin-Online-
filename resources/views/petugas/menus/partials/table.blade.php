<!-- Table content untuk AJAX loading -->
<table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>Gambar</th>
            <th>Nama Menu</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Toppings</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="menuTableBody">
        @forelse($menus as $menu)
    <tr>
        <td>
            @if($menu->image_path)
                <img src="{{ asset('storage/' . $menu->image_path) }}" 
                     alt="{{ $menu->name }}" 
                     class="rounded" 
                     style="width: 60px; height: 60px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px;">
                    <i class="fas fa-utensils text-muted"></i>
                </div>
            @endif
        </td>
        <td class="fw-semibold">{{ $menu->name }}</td>
        <td>{{ Str::limit($menu->description, 50) }}</td>
        <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
        <td>
            <span class="badge {{ $menu->stock > 10 ? 'bg-success' : ($menu->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                {{ $menu->stock }}
            </span>
        </td>
        <td>
            @if($menu->toppings->count() > 0)
                <small class="text-muted">{{ $menu->toppings->count() }} topping(s)</small>
            @else
                <small class="text-muted">Tidak ada</small>
            @endif
        </td>
        <td>
            <a href="{{ route('petugas.menus.edit', $menu) }}" 
               class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </a>
            <button class="btn btn-sm btn-danger" 
                    onclick="confirmDelete({{ $menu->id }})">
                <i class="fas fa-trash"></i>
            </button>
            <form id="delete-form-{{ $menu->id }}" 
                  action="{{ route('petugas.menus.destroy', $menu) }}" 
                  method="POST" 
                  class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center text-muted py-4">
            @if(request('search'))
                <i class="fas fa-search fa-3x mb-3 d-block"></i>
                Tidak ditemukan menu dengan kata kunci "{{ request('search') }}"
            @else
                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                Belum ada menu
            @endif
        </td>
    </tr>
        @endforelse
    </tbody>
</table>
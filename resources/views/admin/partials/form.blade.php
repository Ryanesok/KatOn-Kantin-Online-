@csrf

<div class="space-y-6">
    {{-- Nama Menu --}}
    <div>
        <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama Menu</label>
        <input type="text" name="nama" id="nama"
               value="{{ old('nama', $menu->nama ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2 shadow-sm"
               placeholder="Masukkan nama menu">
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" rows="3"
                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2 shadow-sm resize-none"
                  placeholder="Tuliskan deskripsi menu">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
    </div>

    {{-- Harga --}}
    <div class="form-group">
        <label for="harga">Harga</label>
        <div class="input-wrapper">
            <span class="prefix">Rp</span>
            <input type="number" name="harga" id="harga" class="form-control" 
                value="{{ old('harga', $menu->harga ?? '') }}" 
                placeholder="Masukkan harga menu" required>
        </div>
    </div>


    {{-- Stok --}}
    <div>
        <label for="stok" class="block text-sm font-semibold text-gray-700 mb-1">Stok</label>
        <input type="number" name="stok" id="stok"
               value="{{ old('stok', $menu->stok ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2 shadow-sm"
               placeholder="Jumlah stok tersedia">
    </div>

    {{-- Status --}}
    <div>
        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
        <select name="status" id="status"
                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm px-4 py-2 shadow-sm">
            <option value="tersedia" {{ old('status', $menu->status ?? '') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="habis" {{ old('status', $menu->status ?? '') === 'habis' ? 'selected' : '' }}>Habis</option>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="nama">Nama Menu</label>
    <input type="text" name="nama" id="nama" value="{{ old('nama', $menu->nama ?? '') }}" required>
</div>

<div class="form-group">
    <label for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi">{{ old('deskripsi', $menu->deskripsi ?? '') }}</textarea>
</div>

<div class="form-group">
    <label for="harga">Harga</label>
    <input type="number" name="harga" id="harga" value="{{ old('harga', $menu->harga ?? '') }}" required>
</div>

<div class="form-group">
    <label for="stok">Stok</label>
    <input type="number" name="stok" id="stok" value="{{ old('stok', $menu->stok ?? '') }}" required>
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select name="status" id="status" required>
        <option value="tersedia" {{ old('status', $menu->status ?? '') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="habis" {{ old('status', $menu->status ?? '') == 'habis' ? 'selected' : '' }}>Habis</option>
    </select>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<button type="submit" class="btn btn-primary">Simpan Menu</button>
<a href="{{ route('admin.dashboard') }}" style="margin-left: 10px;">Batal</a>
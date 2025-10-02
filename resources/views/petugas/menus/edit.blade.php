<!-- resources/views/petugas/menus/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="py-4">
                <h6 class="px-3 text-muted text-uppercase mb-3">Menu Navigasi</h6>
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i>Dashboard
                    </a>
                    <a class="nav-link active" href="{{ route('petugas.menus.index') }}">
                        <i class="fas fa-utensils me-2"></i>Kelola Menu
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-md-4 py-4">
            <div class="mb-4">
                <a href="{{ route('petugas.menus.index') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <h2 class="fw-bold">Edit Menu</h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('petugas.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Menu</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="{{ old('name', $menu->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Deskripsi</label>
                                    <textarea name="description" rows="4" class="form-control" required>{{ old('description', $menu->description) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Harga (Rp)</label>
                                        <input type="number" name="price" class="form-control" 
                                               value="{{ old('price', $menu->price) }}" min="0" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Stok</label>
                                        <input type="number" name="stock" class="form-control" 
                                               value="{{ old('stock', $menu->stock) }}" min="0" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Upload Gambar Baru</label>
                                    <input type="file" name="image" class="form-control" 
                                           accept="image/*" onchange="previewImage(this)">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                </div>
                                @if($menu->image_path)
                                <div class="mt-3">
                                    <p class="fw-semibold">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $menu->image_path) }}" 
                                         alt="{{ $menu->name }}" 
                                         class="img-fluid rounded">
                                </div>
                                @endif
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <p class="fw-semibold">Preview Baru:</p>
                                    <img id="preview" src="" alt="Preview" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Menu
                            </button>
                            <a href="{{ route('petugas.menus.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').show();
            $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
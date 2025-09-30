<!-- resources/views/petugas/menus/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Menu')

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
                <h2 class="fw-bold">Tambah Menu Baru</h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('petugas.menus.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama Menu <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="description" rows="4" 
                                              class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                                               value="{{ old('price') }}" min="0" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                               value="{{ old('stock') }}" min="0" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Upload Gambar</label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                           accept="image/*" onchange="previewImage(this)">
                                    <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <img id="preview" src="" alt="Preview" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Menu
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
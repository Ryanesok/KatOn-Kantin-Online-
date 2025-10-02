<!-- resources/views/petugas/toppings/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Topping')

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
                    <a class="nav-link" href="{{ route('petugas.menus.index') }}">
                        <i class="fas fa-utensils me-2"></i>Kelola Menu
                    </a>
                    <a class="nav-link" href="{{ route('petugas.toppings.index') }}">
                        <i class="fas fa-plus-circle me-2"></i>Kelola Topping
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">Edit Topping</h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-store me-1"></i>{{ auth()->user()->kantin->name ?? 'Kantin' }}
                    </p>
                </div>
                <a href="{{ route('petugas.toppings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('petugas.toppings.update', $topping) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Topping</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $topping->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               id="price" 
                                               name="price" 
                                               value="{{ old('price', $topping->price) }}" 
                                               min="0" 
                                               required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Masukkan deskripsi topping...">{{ old('description', $topping->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_available" 
                                       name="is_available" 
                                       value="1"
                                       {{ old('is_available', $topping->is_available) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_available">
                                    Topping tersedia untuk dijual
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('petugas.toppings.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Topping
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
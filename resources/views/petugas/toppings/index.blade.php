<!-- resources/views/petugas/toppings/index.blade.php -->
@extends('layouts.app')

@section('title', 'Kelola Topping')

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
                    <a class="nav-link active" href="{{ route('petugas.toppings.index') }}">
                        <i class="fas fa-plus-circle me-2"></i>Kelola Topping
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold">Kelola Topping</h2>
                    <p class="text-muted mb-0">
                        <i class="fas fa-store me-1"></i>{{ auth()->user()->kantin->name ?? 'Kantin' }}
                    </p>
                </div>
                <a href="{{ route('petugas.toppings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Tambah Topping
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Toppings Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Topping</th>
                                    <th>Harga</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($toppings as $topping)
                                <tr>
                                    <td class="fw-semibold">{{ $topping->name }}</td>
                                    <td>Rp {{ number_format($topping->price, 0, ',', '.') }}</td>
                                    <td>{{ Str::limit($topping->description ?? '-', 50) }}</td>
                                    <td>
                                        <span class="badge {{ $topping->is_available ? 'bg-success' : 'bg-danger' }}">
                                            {{ $topping->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('petugas.toppings.edit', $topping) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger" 
                                                onclick="confirmDelete({{ $topping->id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $topping->id }}" 
                                              action="{{ route('petugas.toppings.destroy', $topping) }}" 
                                              method="POST" 
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                        Belum ada topping
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $toppings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus topping ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush
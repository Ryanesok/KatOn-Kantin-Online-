<!-- resources/views/user/orders.blade.php -->
@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('user.menu') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Menu
        </a>
        <h2 class="fw-bold">
            <i class="fas fa-receipt text-success me-2"></i>Riwayat Pesanan
        </h2>
    </div>

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('user.orders') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari pesanan..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body">
            @if($orders->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-5x text-muted mb-3"></i>
                <h4 class="text-muted">Belum Ada Pesanan</h4>
                <p class="text-muted mb-4">Anda belum melakukan pesanan apapun</p>
                <a href="{{ route('user.menu') }}" class="btn btn-primary">
                    <i class="fas fa-utensils me-2"></i>Pesan Sekarang
                </a>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Menu</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_date->format('d M Y, H:i') }}</td>
                            <td class="fw-semibold">{{ $order->menu->name }}</td>
                            <td>{{ $order->quantity }}x</td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($order->status == 'Diproses')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>{{ $order->status }}
                                    </span>
                                @elseif($order->status == 'Selesai')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>{{ $order->status }}
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>{{ $order->status }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($order->status == 'Diproses')
                                <form action="{{ route('user.orders.cancel', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Batalkan pesanan ini?')">
                                        <i class="fas fa-times me-1"></i>Batalkan
                                    </button>
                                </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
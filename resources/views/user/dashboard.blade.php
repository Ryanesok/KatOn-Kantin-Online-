@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
    <h2>Daftar Menu Tersedia</h2>
    <p>Halo, {{ Auth::user()->name }}! Silakan pilih menu favoritmu.</p>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($menus->isEmpty())
        <p>Saat ini belum ada menu yang tersedia.</p>
    @else
        <div class="card-grid">
            @foreach ($menus as $menu)
                <div class="card">
                    <img src="{{ $menu->gambar ? asset('storage/'.$menu->gambar) : asset('images/no-image.png') }}" 
                        alt="{{ $menu->nama }}" class="menu-image">
                    
                    <h3>{{ $menu->nama }}</h3>
                    <p><strong>Kantin:</strong> {{ $menu->kantin->nama_kantin }}</p>
                    <p>{{ $menu->deskripsi }}</p>
                    <p class="price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    <p class="status">Stok: {{ $menu->stok }} | Status: <strong>{{ ucfirst($menu->status) }}</strong></p>

                    @if($menu->stok > 0 && $menu->status == 'tersedia')
                        <form action="{{ route('user.menu.order', $menu) }}" method="POST" class="order-form">
                            @csrf
                            <input type="number" name="jumlah" min="1" max="{{ $menu->stok }}" value="1" required>
                            <button type="submit" class="btn btn-primary">Pesan</button>
                        </form>
                    @else
                        <p class="out-of-stock">Tidak tersedia</p>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
@endsection

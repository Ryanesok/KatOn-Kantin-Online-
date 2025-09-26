@extends('layouts.app')

@section('title', 'Daftar Menu')

@section('content')
    <h2>Daftar Menu Tersedia</h2>
    <p>Halo, {{ Auth::user()->name }}! Selamat menikmati menu yang ada.</p>
    <hr>
    
    @if($menus->isEmpty())
        <p>Saat ini belum ada menu yang tersedia.</p>
    @else
        <div class="card-grid">
            @foreach ($menus as $menu)
                <div class="card">
                    <h3>{{ $menu->nama }}</h3>
                    <p><strong>Kantin:</strong> {{ $menu->kantin->nama_kantin }}</p>
                    <p>{{ $menu->deskripsi }}</p>
                    <p class="price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    <p class="status">Stok: {{ $menu->stok }} | Status: <strong>{{ ucfirst($menu->status) }}</strong></p>
                </div>
            @endforeach
        </div>
    @endif
@endsection
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2>Manajemen Menu Kantin: {{ Auth::user()->kantin->nama_kantin }}</h2>
    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">Tambah Menu Baru</a>

    @if (session('success'))
        <div class="alert alert-success" style="margin-top: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($menus as $menu)
                <tr>
                    <td>{{ $menu->nama }}</td>
                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td>{{ $menu->stok }}</td>
                    <td>{{ ucfirst($menu->status) }}</td>
                    <td>
                        <a href="{{ route('admin.menu.edit', $menu) }}" class="btn btn-warning" style="margin-right: 5px;">Edit</a>
                        <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada menu di kantin Anda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
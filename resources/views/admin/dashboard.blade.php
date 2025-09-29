@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <h2>Manajemen Menu Kantin: {{ Auth::user()->kantin->nama_kantin }}</h2>

    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary mb-4">Tambah Menu Baru</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive-wrapper">
        <table>
            <thead>
                <tr>
                    @php
                        function sortable_link($column, $label, $current_sort, $current_order) {
                            $next_order = ($column == $current_sort && $current_order == 'asc') ? 'desc' : 'asc';
                            $url = route('admin.dashboard', array_merge(request()->query(), ['sort_by' => $column, 'order' => $next_order]));
                            $indicator = ($column == $current_sort) ? ($current_order == 'asc' ? ' &#9650;' : ' &#9660;') : '';
                            return '<a href="' . $url . '">' . $label . $indicator . '</a>';
                        }
                    @endphp

                    <th>{!! sortable_link('nama', 'Nama', $current_sort, $current_order) !!}</th>
                    <th>{!! sortable_link('harga', 'Harga', $current_sort, $current_order) !!}</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>{!! sortable_link('created_at', 'Waktu Dibuat', $current_sort, $current_order) !!}</th>
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
                        <td>{{ $menu->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.menu.edit', $menu) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('admin.menu.destroy', $menu) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Belum ada menu di kantin Anda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <x-pagination :paginator="$menus" />
    </div>
@endsection
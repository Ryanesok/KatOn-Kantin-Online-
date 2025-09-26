<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    // Tampilkan semua menu dari kantin milik admin yang sedang login
    public function index()
    {
        $kantinId = Auth::user()->kantin_id;
        $menus = Menu::where('kantin_id', $kantinId)->get();
        return view('admin.dashboard', compact('menus'));
    }

    // Tampilkan form untuk menambah menu baru
    public function create()
    {
        return view('admin.create');
    }

    // Simpan menu baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
        ]);

        Menu::create([
            'kantin_id' => Auth::user()->kantin_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil ditambahkan!');
    }

    // Tampilkan form untuk mengedit menu
    public function edit(Menu $menu)
    {
        // Pastikan admin hanya bisa mengedit menu miliknya
        if ($menu->kantin_id !== Auth::user()->kantin_id) {
            abort(403);
        }
        return view('admin.edit', compact('menu'));
    }

    // Update data menu di database
    public function update(Request $request, Menu $menu)
    {
        // Pastikan admin hanya bisa mengupdate menu miliknya
        if ($menu->kantin_id !== Auth::user()->kantin_id) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,habis',
        ]);

        $menu->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil diperbarui!');
    }

    // Hapus menu dari database
    public function destroy(Menu $menu)
    {
        // Pastikan admin hanya bisa menghapus menu miliknya
        if ($menu->kantin_id !== Auth::user()->kantin_id) {
            abort(403);
        }

        $menu->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil dihapus!');
    }
}
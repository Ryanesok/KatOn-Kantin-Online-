<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kantin;
use App\Models\Topping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Untuk Petugas Kantin
    public function index(Request $request)
    {
        // Hanya tampilkan menu dari kantin petugas yang login
        $query = Menu::with('toppings')->where('kantin_id', auth()->user()->kantin_id);
        
        if ($request->has('search')) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }
        
        $menus = $query->paginate(10);
        
        // Jika request AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('petugas.menus.partials.table', compact('menus'))->render(),
                'pagination' => $menus->appends(request()->query())->links()->render(),
                'total' => $menus->total()
            ]);
        }
        
        return view('petugas.menus.index', compact('menus'));
    }

    public function create()
    {
        // Ambil toppings untuk kantin yang sama
        $toppings = Topping::where('kantin_id', auth()->user()->kantin_id)
                          ->where('is_available', true)
                          ->get();
        
        return view('petugas.menus.create', compact('toppings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'toppings' => 'nullable|array',
            'toppings.*' => 'exists:toppings,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('menus', 'public');
        }

        // Tambahkan kantin_id dari user yang login
        $validated['kantin_id'] = auth()->user()->kantin_id;

        $menu = Menu::create($validated);

        // Attach toppings jika ada
        if ($request->has('toppings')) {
            $menu->toppings()->attach($request->toppings);
        }

        return redirect()->route('petugas.menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        // Pastikan menu milik kantin yang sama
        if ($menu->kantin_id !== auth()->user()->kantin_id) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil toppings untuk kantin yang sama
        $toppings = Topping::where('kantin_id', auth()->user()->kantin_id)
                          ->where('is_available', true)
                          ->get();
        
        return view('petugas.menus.edit', compact('menu', 'toppings'));
    }

    public function update(Request $request, Menu $menu)
    {
        // Pastikan menu milik kantin yang sama
        if ($menu->kantin_id !== auth()->user()->kantin_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'toppings' => 'nullable|array',
            'toppings.*' => 'exists:toppings,id',
        ]);

        if ($request->hasFile('image')) {
            if ($menu->image_path) {
                Storage::disk('public')->delete($menu->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($validated);

        // Sync toppings
        if ($request->has('toppings')) {
            $menu->toppings()->sync($request->toppings);
        } else {
            $menu->toppings()->detach();
        }

        return redirect()->route('petugas.menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        // Pastikan menu milik kantin yang sama
        if ($menu->kantin_id !== auth()->user()->kantin_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($menu->image_path) {
            Storage::disk('public')->delete($menu->image_path);
        }
        
        $menu->delete();

        return redirect()->route('petugas.menus.index')->with('success', 'Menu berhasil dihapus!');
    }

    // Untuk User
    public function userIndex(Request $request)
    {
        $query = Menu::with(['kantin', 'toppings'])->where('stock', '>', 0);
        
        // Filter berdasarkan kantin jika dipilih
        if ($request->has('kantin_id') && $request->kantin_id) {
            $query->where('kantin_id', $request->kantin_id);
        }
        
        if ($request->has('search')) {
            $query->where('name', 'ilike', '%' . $request->search . '%');
        }
        
        $menus = $query->paginate(12);
        
        // Ambil semua kantin yang aktif untuk filter
        $kantins = Kantin::active()->get();
        
        return view('user.menu', compact('menus', 'kantins'));
    }

    // Method untuk mendapatkan detail menu via AJAX
    public function getMenuDetail($id)
    {
        $menu = Menu::with(['kantin', 'toppings' => function($query) {
            $query->where('is_available', true);
        }])->findOrFail($id);
        
        return response()->json([
            'menu' => $menu,
            'html' => view('user.partials.menu-detail', compact('menu'))->render()
        ]);
    }
}
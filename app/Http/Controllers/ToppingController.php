<?php

namespace App\Http\Controllers;

use App\Models\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    public function index()
    {
        $toppings = Topping::where('kantin_id', auth()->user()->kantin_id)
                          ->paginate(10);
        
        return view('petugas.toppings.index', compact('toppings'));
    }

    public function create()
    {
        return view('petugas.toppings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $validated['kantin_id'] = auth()->user()->kantin_id;

        Topping::create($validated);

        return redirect()->route('petugas.toppings.index')->with('success', 'Topping berhasil ditambahkan!');
    }

    public function edit(Topping $topping)
    {
        // Pastikan topping milik kantin yang sama
        if ($topping->kantin_id !== auth()->user()->kantin_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('petugas.toppings.edit', compact('topping'));
    }

    public function update(Request $request, Topping $topping)
    {
        // Pastikan topping milik kantin yang sama
        if ($topping->kantin_id !== auth()->user()->kantin_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_available' => 'boolean',
        ]);

        $topping->update($validated);

        return redirect()->route('petugas.toppings.index')->with('success', 'Topping berhasil diperbarui!');
    }

    public function destroy(Topping $topping)
    {
        // Pastikan topping milik kantin yang sama
        if ($topping->kantin_id !== auth()->user()->kantin_id) {
            abort(403, 'Unauthorized action.');
        }

        $topping->delete();

        return redirect()->route('petugas.toppings.index')->with('success', 'Topping berhasil dihapus!');
    }
}

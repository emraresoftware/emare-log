<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Depo;

class StokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Stok::with('depo');

        if ($request->filled('depo_id')) {
            $query->where('depo_id', $request->depo_id);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('arama')) {
            $query->where('ad', 'like', '%' . $request->arama . '%');
        }

        $stoklar = $query->latest()->paginate(25);
        $depolar = Depo::all();

        return view('stok.index', compact('stoklar', 'depolar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'miktar' => 'required|integer|min:0',
            'birim' => 'required|string|max:50',
            'birim_fiyat' => 'required|numeric|min:0',
            'depo_id' => 'required|exists:depolar,id',
            'aciklama' => 'nullable|string',
            'barkod' => 'nullable|string|max:100',
        ]);

        Stok::create($validated);

        return redirect()->route('stoklar.index')
            ->with('success', 'Stok başarıyla eklendi.');
    }
}

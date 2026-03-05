<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GelirGider;

class GelirGiderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = GelirGider::with('user');

        if ($request->filled('tip')) {
            $query->where('tip', $request->tip);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('baslangic')) {
            $query->whereDate('tarih', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('tarih', '<=', $request->bitis);
        }

        $kayitlar = $query->latest()->paginate(25);

        $toplamGelir = GelirGider::where('tip', 'gelir')->sum('tutar');
        $toplamGider = GelirGider::where('tip', 'gider')->sum('tutar');

        return view('kasa.gelir_gider', compact('kayitlar', 'toplamGelir', 'toplamGider'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tip' => 'required|in:gelir,gider',
            'kategori' => 'required|string|max:100',
            'tutar' => 'required|numeric|min:0.01',
            'tarih' => 'required|date',
            'aciklama' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = auth()->id();

        GelirGider::create($validated);

        return redirect()->route('gelir-gider.index')
            ->with('success', 'Kayıt başarıyla eklendi.');
    }
}

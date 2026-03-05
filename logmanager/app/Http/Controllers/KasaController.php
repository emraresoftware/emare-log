<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasa;
use App\Models\KasaHareketi;

class KasaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $kasalar = Kasa::latest()->get();

        $query = KasaHareketi::with('kasa', 'user');

        if ($request->filled('kasa_id')) {
            $query->where('kasa_id', $request->kasa_id);
        }
        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $hareketler = $query->latest()->paginate(25);

        $toplamGelir = KasaHareketi::where('tip', 'gelir')->sum('tutar');
        $toplamGider = KasaHareketi::where('tip', 'gider')->sum('tutar');

        return view('kasa.index', compact('kasalar', 'hareketler', 'toplamGelir', 'toplamGider'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kasa_id' => 'required|exists:kasalar,id',
            'tip' => 'required|in:gelir,gider',
            'tutar' => 'required|numeric|min:0.01',
            'aciklama' => 'required|string|max:500',
            'kategori' => 'nullable|string|max:100',
        ]);

        $validated['user_id'] = auth()->id();

        KasaHareketi::create($validated);

        $kasa = Kasa::find($validated['kasa_id']);
        if ($validated['tip'] === 'gelir') {
            $kasa->increment('bakiye', $validated['tutar']);
        } else {
            $kasa->decrement('bakiye', $validated['tutar']);
        }

        return redirect()->route('kasa.index')
            ->with('success', 'Kasa hareketi başarıyla kaydedildi.');
    }
}

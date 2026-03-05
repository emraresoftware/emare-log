<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AramaEmri;
use App\Models\Musteri;

class AramaEmriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $aramaEmirleri = AramaEmri::with('musteri')->latest()->paginate(25);

        return view('arama_emirleri.index', compact('aramaEmirleri'));
    }

    public function create()
    {
        $musteriler = Musteri::select('id', 'isim', 'soyisim', 'abone_no')->get();

        return view('arama_emirleri.create', compact('musteriler'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'musteri_id' => 'required|exists:musteriler,id',
            'baslik' => 'required|string|max:255',
            'aciklama' => 'nullable|string',
            'oncelik' => 'required|string',
            'durum' => 'required|string',
        ]);

        $validated['olusturan_id'] = auth()->id();

        AramaEmri::create($validated);

        return redirect()->route('arama-emirleri.index')
            ->with('success', 'Arama emri başarıyla oluşturuldu.');
    }

    public function show($id)
    {
        $aramaEmri = AramaEmri::with('musteri')->findOrFail($id);

        return view('arama_emirleri.show', compact('aramaEmri'));
    }

    public function edit($id)
    {
        $aramaEmri = AramaEmri::findOrFail($id);
        $musteriler = Musteri::select('id', 'isim', 'soyisim', 'abone_no')->get();

        return view('arama_emirleri.edit', compact('aramaEmri', 'musteriler'));
    }

    public function update(Request $request, $id)
    {
        $aramaEmri = AramaEmri::findOrFail($id);

        $validated = $request->validate([
            'musteri_id' => 'required|exists:musteriler,id',
            'baslik' => 'required|string|max:255',
            'aciklama' => 'nullable|string',
            'oncelik' => 'required|string',
            'durum' => 'required|string',
        ]);

        $aramaEmri->update($validated);

        return redirect()->route('arama-emirleri.index')
            ->with('success', 'Arama emri başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $aramaEmri = AramaEmri::findOrFail($id);
        $aramaEmri->delete();

        return redirect()->route('arama-emirleri.index')
            ->with('success', 'Arama emri başarıyla silindi.');
    }
}

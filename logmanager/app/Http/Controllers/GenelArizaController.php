<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GenelAriza;

class GenelArizaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = GenelAriza::with('olusturan');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('oncelik')) {
            $query->where('oncelik', $request->oncelik);
        }

        $arizalar = $query->latest()->paginate(25);

        return view('genel_ariza.index', compact('arizalar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'baslik' => 'required|string|max:255',
            'aciklama' => 'required|string',
            'oncelik' => 'required|string',
            'bolge' => 'nullable|string|max:255',
            'etkilenen_musteri_sayisi' => 'nullable|integer|min:0',
            'baslangic_tarihi' => 'required|date',
            'tahmini_cozum_tarihi' => 'nullable|date',
        ]);

        $validated['durum'] = 'aktif';
        $validated['olusturan_id'] = auth()->id();

        GenelAriza::create($validated);

        return redirect()->route('genel-ariza.index')
            ->with('success', 'Genel arıza kaydı başarıyla oluşturuldu.');
    }

    public function update(Request $request, $id)
    {
        $ariza = GenelAriza::findOrFail($id);

        $validated = $request->validate([
            'baslik' => 'required|string|max:255',
            'aciklama' => 'required|string',
            'oncelik' => 'required|string',
            'durum' => 'required|string',
            'cozum_aciklamasi' => 'nullable|string',
            'cozum_tarihi' => 'nullable|date',
        ]);

        if ($validated['durum'] === 'cozuldu' && empty($validated['cozum_tarihi'])) {
            $validated['cozum_tarihi'] = now();
        }

        $ariza->update($validated);

        return redirect()->route('genel-ariza.index')
            ->with('success', 'Genel arıza kaydı başarıyla güncellendi.');
    }
}

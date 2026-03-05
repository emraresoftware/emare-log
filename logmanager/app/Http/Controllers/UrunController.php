<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urun;
use App\Models\Musteri;

class UrunController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Urun::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }

        $urunler = $query->latest()->paginate(25);

        return view('stok.urunler', compact('urunler'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'marka' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'seri_no' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:100',
            'durum' => 'required|string',
            'fiyat' => 'nullable|numeric|min:0',
            'aciklama' => 'nullable|string',
        ]);

        Urun::create($validated);

        return redirect()->route('urunler.index')
            ->with('success', 'Ürün başarıyla eklendi.');
    }

    public function musteridekiUrunler()
    {
        $urunler = Urun::whereNotNull('musteri_id')
            ->with('musteri')
            ->paginate(25);

        return view('stok.musterideki_urunler', compact('urunler'));
    }

    public function arizaliUrunler()
    {
        $urunler = Urun::where('durum', 'arizali')
            ->paginate(25);

        return view('stok.arizali_urunler', compact('urunler'));
    }

    public function sokumListesi()
    {
        $urunler = Urun::where('durum', 'sokum')
            ->paginate(25);

        return view('stok.sokum_listesi', compact('urunler'));
    }

    public function urunGonder(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'urun_id' => 'required|exists:urunler,id',
                'musteri_id' => 'required|exists:musteriler,id',
                'aciklama' => 'nullable|string',
            ]);

            $urun = Urun::findOrFail($validated['urun_id']);
            $urun->update([
                'musteri_id' => $validated['musteri_id'],
                'durum' => 'musteride',
                'teslim_tarihi' => now(),
            ]);

            return redirect()->route('urunler.musterideki')
                ->with('success', 'Ürün müşteriye gönderildi.');
        }

        $urunler = Urun::where('durum', 'depoda')->get();
        $musteriler = Musteri::select('id', 'isim', 'soyisim', 'abone_no')->get();

        return view('stok.urun_gonder', compact('urunler', 'musteriler'));
    }
}

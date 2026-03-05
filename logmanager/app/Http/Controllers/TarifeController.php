<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarife;
use App\Models\Hizmet;
use App\Models\Kampanya;
use App\Models\Musteri;

class TarifeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tarifeler = Tarife::withCount('musteriler')->latest()->paginate(25);

        return view('tarifeler.index', compact('tarifeler'));
    }

    public function create()
    {
        return view('tarifeler.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'hiz' => 'required|string|max:50',
            'indirme_hizi' => 'required|integer|min:1',
            'yukleme_hizi' => 'required|integer|min:1',
            'fiyat' => 'required|numeric|min:0',
            'kdv_orani' => 'required|numeric|min:0|max:100',
            'kota' => 'nullable|string|max:50',
            'durum' => 'required|string',
            'aciklama' => 'nullable|string',
        ]);

        Tarife::create($validated);

        return redirect()->route('tarifeler.index')
            ->with('success', 'Tarife başarıyla oluşturuldu.');
    }

    public function istatistik()
    {
        $tarifeler = Tarife::withCount('musteriler')
            ->get()
            ->map(function ($tarife) {
                $tarife->aktif_musteri = Musteri::where('tarife_id', $tarife->id)
                    ->where('durum', 'aktif')->count();
                $tarife->pasif_musteri = Musteri::where('tarife_id', $tarife->id)
                    ->where('durum', 'pasif')->count();
                return $tarife;
            });

        return view('tarifeler.istatistik', compact('tarifeler'));
    }

    public function edit($id)
    {
        $tarife = Tarife::findOrFail($id);

        return view('tarifeler.edit', compact('tarife'));
    }

    public function update(Request $request, $id)
    {
        $tarife = Tarife::findOrFail($id);

        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'hiz' => 'required|string|max:50',
            'indirme_hizi' => 'required|integer|min:1',
            'yukleme_hizi' => 'required|integer|min:1',
            'fiyat' => 'required|numeric|min:0',
            'kdv_orani' => 'required|numeric|min:0|max:100',
            'kota' => 'nullable|string|max:50',
            'durum' => 'required|string',
            'aciklama' => 'nullable|string',
        ]);

        $tarife->update($validated);

        return redirect()->route('tarifeler.index')
            ->with('success', 'Tarife başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $tarife = Tarife::findOrFail($id);

        if ($tarife->musteriler()->count() > 0) {
            return redirect()->route('tarifeler.index')
                ->with('error', 'Bu tarifede aktif müşteri bulunmaktadır. Önce müşterileri başka tarifeye taşıyın.');
        }

        $tarife->delete();

        return redirect()->route('tarifeler.index')
            ->with('success', 'Tarife başarıyla silindi.');
    }

    public function topluDegistir(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'eski_tarife_id' => 'required|exists:tarifeler,id',
                'yeni_tarife_id' => 'required|exists:tarifeler,id|different:eski_tarife_id',
            ]);

            $etkilenen = Musteri::where('tarife_id', $validated['eski_tarife_id'])
                ->update(['tarife_id' => $validated['yeni_tarife_id']]);

            return redirect()->route('tarifeler.index')
                ->with('success', "{$etkilenen} müşterinin tarifesi değiştirildi.");
        }

        $tarifeler = Tarife::all();

        return view('tarifeler.toplu_degistir', compact('tarifeler'));
    }

    public function hizmetler()
    {
        $hizmetler = Hizmet::latest()->paginate(25);

        return view('tarifeler.hizmetler', compact('hizmetler'));
    }

    public function kampanyalar()
    {
        $kampanyalar = Kampanya::latest()->paginate(25);

        return view('tarifeler.kampanyalar', compact('kampanyalar'));
    }
}

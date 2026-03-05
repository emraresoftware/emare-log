<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Istasyon;
use App\Models\Verici;

class IstasyonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $istasyonlar = Istasyon::withCount('vericiler')
            ->latest()
            ->paginate(25);

        return view('istasyon.index', compact('istasyonlar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'konum' => 'nullable|string|max:255',
            'enlem' => 'nullable|numeric',
            'boylam' => 'nullable|numeric',
            'adres' => 'nullable|string',
            'durum' => 'required|string',
            'aciklama' => 'nullable|string',
        ]);

        Istasyon::create($validated);

        return redirect()->route('istasyonlar.index')
            ->with('success', 'İstasyon başarıyla eklendi.');
    }

    public function vericiler(Request $request)
    {
        $query = Verici::with('istasyon');

        if ($request->filled('istasyon_id')) {
            $query->where('istasyon_id', $request->istasyon_id);
        }
        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }

        $vericiler = $query->latest()->paginate(25);
        $istasyonlar = Istasyon::all();

        return view('istasyon.vericiler', compact('vericiler', 'istasyonlar'));
    }

    public function vericiStore(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'istasyon_id' => 'required|exists:istasyonlar,id',
            'marka' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'frekans' => 'nullable|string|max:50',
            'kapasite' => 'nullable|integer|min:0',
            'durum' => 'required|string',
            'ip_adresi' => 'nullable|ip',
        ]);

        Verici::create($validated);

        return redirect()->route('istasyonlar.vericiler')
            ->with('success', 'Verici başarıyla eklendi.');
    }

    public function agHaritasi()
    {
        $istasyonlar = Istasyon::with('vericiler')
            ->whereNotNull('enlem')
            ->whereNotNull('boylam')
            ->get();

        return view('istasyon.ag_haritasi', compact('istasyonlar'));
    }
}

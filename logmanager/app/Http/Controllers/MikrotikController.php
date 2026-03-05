<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mikrotik;
use App\Models\VpnKullanici;
use App\Models\MikrotikLogu;

class MikrotikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $mikrotikler = Mikrotik::latest()->paginate(25);

        return view('mikrotik.index', compact('mikrotikler'));
    }

    public function create()
    {
        return view('mikrotik.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'ip_adresi' => 'required|ip',
            'api_port' => 'required|integer|min:1|max:65535',
            'kullanici_adi' => 'required|string|max:255',
            'sifre' => 'required|string|max:255',
            'durum' => 'required|string',
            'aciklama' => 'nullable|string',
        ]);

        Mikrotik::create($validated);

        return redirect()->route('mikrotik.index')
            ->with('success', 'Mikrotik başarıyla eklendi.');
    }

    public function show($id)
    {
        $mikrotik = Mikrotik::findOrFail($id);

        return view('mikrotik.show', compact('mikrotik'));
    }

    public function edit($id)
    {
        $mikrotik = Mikrotik::findOrFail($id);
        $bolgeler = \App\Models\Bolge::all();

        return view('mikrotik.edit', compact('mikrotik', 'bolgeler'));
    }

    public function update(Request $request, $id)
    {
        $mikrotik = Mikrotik::findOrFail($id);

        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'ip_adresi' => 'required|ip',
            'api_port' => 'required|integer|min:1|max:65535',
            'kullanici_adi' => 'required|string|max:255',
            'sifre' => 'nullable|string|max:255',
            'durum' => 'required|string',
            'aciklama' => 'nullable|string',
        ]);

        if (empty($validated['sifre'])) {
            unset($validated['sifre']);
        }

        $mikrotik->update($validated);

        return redirect()->route('mikrotik.show', $mikrotik->id)
            ->with('success', 'Mikrotik başarıyla güncellendi.');
    }

    public function hataRaporu()
    {
        $hatalar = MikrotikLogu::where('tip', 'hata')
            ->with('mikrotik')
            ->latest()
            ->paginate(25);

        return view('mikrotik.hata_raporu', compact('hatalar'));
    }

    public function vpnListesi()
    {
        $vpnKullanicilar = VpnKullanici::with('musteri', 'mikrotik')
            ->paginate(25);

        return view('mikrotik.vpn_listesi', compact('vpnKullanicilar'));
    }

    public function pppListesi()
    {
        $pppKullanicilar = \App\Models\Mikrotik::all();

        return view('mikrotik.ppp_listesi', compact('pppKullanicilar'));
    }
}

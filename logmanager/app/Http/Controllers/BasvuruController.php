<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basvuru;
use App\Models\Musteri;
use App\Models\Tarife;
use App\Models\Bolge;

class BasvuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $basvurular = Basvuru::latest()->paginate(25);

        return view('basvurular.index', compact('basvurular'));
    }

    public function bekleyenBasvurular()
    {
        $basvurular = Basvuru::where('durum', 'beklemede')
            ->latest()
            ->paginate(25);

        return view('basvurular.index', compact('basvurular'));
    }

    public function create()
    {
        $tarifeler = Tarife::all();
        $bolgeler = Bolge::all();

        return view('basvurular.create', compact('tarifeler', 'bolgeler'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isim' => 'required|string|max:255',
            'soyisim' => 'required|string|max:255',
            'tc_no' => 'required|string|max:11',
            'telefon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'adres' => 'required|string',
            'tarife_id' => 'required|exists:tarifeler,id',
            'bolge_id' => 'nullable|exists:bolgeler,id',
            'not' => 'nullable|string',
        ]);

        $validated['durum'] = 'beklemede';
        $validated['basvuru_tarihi'] = now();

        Basvuru::create($validated);

        return redirect()->route('basvurular.bekleyen')
            ->with('success', 'Başvuru başarıyla oluşturuldu.');
    }

    public function show($id)
    {
        $basvuru = Basvuru::findOrFail($id);

        return view('basvurular.show', compact('basvuru'));
    }

    public function onayla($id)
    {
        $basvuru = Basvuru::findOrFail($id);
        $basvuru->update([
            'durum' => 'onaylandi',
            'onaylayan_id' => auth()->id(),
            'onay_tarihi' => now(),
        ]);

        $musteri = Musteri::create([
            'isim' => $basvuru->isim,
            'soyisim' => $basvuru->soyisim,
            'tc_no' => $basvuru->tc_no,
            'telefon' => $basvuru->telefon,
            'email' => $basvuru->email,
            'adres' => $basvuru->adres,
            'tarife_id' => $basvuru->tarife_id,
            'bolge_id' => $basvuru->bolge_id,
            'durum' => 'aktif',
            'tip' => 'bireysel',
            'uyelik_tarihi' => now(),
        ]);

        return redirect()->route('musteriler.show', $musteri->id)
            ->with('success', 'Başvuru onaylandı ve müşteri oluşturuldu.');
    }

    public function reddet($id)
    {
        $basvuru = Basvuru::findOrFail($id);
        $basvuru->update([
            'durum' => 'reddedildi',
            'onaylayan_id' => auth()->id(),
            'onay_tarihi' => now(),
        ]);

        return redirect()->route('basvurular.bekleyen')
            ->with('success', 'Başvuru reddedildi.');
    }
}

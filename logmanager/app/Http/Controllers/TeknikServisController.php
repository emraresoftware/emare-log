<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeknikServis;
use App\Models\IsEmri;
use App\Models\IsTanimi;
use App\Models\Musteri;
use App\Models\User;

class TeknikServisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = TeknikServis::with('musteri', 'atananUser');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('oncelik')) {
            $query->where('oncelik', $request->oncelik);
        }
        if ($request->filled('atanan_id')) {
            $query->where('atanan_user_id', $request->atanan_id);
        }

        $servisler = $query->latest()->paginate(25);
        $teknisyenler = User::where('tip', 'teknisyen')->get();

        return view('teknik_servis.index', compact('servisler', 'teknisyenler'));
    }

    public function create()
    {
        $musteriler = Musteri::select('id', 'isim', 'soyisim', 'abone_no')->get();
        $teknisyenler = User::where('tip', 'teknisyen')->get();
        $isTanimlari = IsTanimi::all();

        return view('teknik_servis.create', compact('musteriler', 'teknisyenler', 'isTanimlari'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'musteri_id' => 'required|exists:musteriler,id',
            'baslik' => 'required|string|max:255',
            'aciklama' => 'nullable|string',
            'oncelik' => 'required|string',
            'atanan_user_id' => 'nullable|exists:users,id',
            'is_tanimi_id' => 'nullable|exists:is_tanimlari,id',
            'planlanan_tarih' => 'nullable|date',
        ]);

        $validated['durum'] = 'acik';
        $validated['olusturan_id'] = auth()->id();

        $servis = TeknikServis::create($validated);

        IsEmri::create([
            'teknik_servis_id' => $servis->id,
            'musteri_id' => $validated['musteri_id'],
            'atanan_user_id' => $validated['atanan_user_id'],
            'baslik' => $validated['baslik'],
            'aciklama' => $validated['aciklama'],
            'durum' => 'acik',
            'planlanan_tarih' => $validated['planlanan_tarih'],
        ]);

        return redirect()->route('teknik-servis.index')
            ->with('success', 'Teknik servis kaydı ve iş emri oluşturuldu.');
    }

    public function show($id)
    {
        $servis = TeknikServis::with('musteri', 'atananUser', 'isEmirleri')->findOrFail($id);

        return view('teknik_servis.show', compact('servis'));
    }

    public function update(Request $request, $id)
    {
        $servis = TeknikServis::findOrFail($id);

        $validated = $request->validate([
            'baslik' => 'required|string|max:255',
            'aciklama' => 'nullable|string',
            'oncelik' => 'required|string',
            'durum' => 'required|string',
            'atanan_user_id' => 'nullable|exists:users,id',
            'cozum_aciklamasi' => 'nullable|string',
        ]);

        if ($validated['durum'] === 'kapali') {
            $validated['tamamlanma_tarihi'] = now();
        }

        $servis->update($validated);

        return redirect()->route('teknik-servis.show', $servis->id)
            ->with('success', 'Teknik servis kaydı güncellendi.');
    }

    public function isTanimlari()
    {
        $tanimlar = IsTanimi::latest()->paginate(25);

        return view('teknik_servis.is_tanimlari', compact('tanimlar'));
    }

    public function rapor(Request $request)
    {
        $query = TeknikServis::with('musteri', 'atananUser');

        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $toplamAcik = TeknikServis::where('durum', 'acik')->count();
        $toplamKapali = TeknikServis::where('durum', 'kapali')->count();
        $toplamBeklemede = TeknikServis::where('durum', 'beklemede')->count();

        $servisler = $query->latest()->paginate(25);

        return view('teknik_servis.rapor', compact('servisler', 'toplamAcik', 'toplamKapali', 'toplamBeklemede'));
    }
}

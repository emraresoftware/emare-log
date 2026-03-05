<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Musteri;
use App\Models\MusteriGrubu;
use App\Models\MusteriNotu;
use App\Models\Tarife;
use App\Models\Bolge;
use App\Models\User;
use App\Models\Basvuru;
use App\Models\YasaklananTc;
use App\Models\Odeme;

class MusteriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Musteri::with('tarife', 'bolge');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('tip')) {
            $query->where('tip', $request->tip);
        }
        if ($request->filled('grup_id')) {
            $query->where('grup_id', $request->grup_id);
        }
        if ($request->filled('bayi_id')) {
            $query->where('bayi_id', $request->bayi_id);
        }
        if ($request->filled('taahhut_durum')) {
            $query->where('taahhutlu', $request->taahhut_durum);
        }
        if ($request->filled('tarife_id')) {
            $query->where('tarife_id', $request->tarife_id);
        }
        if ($request->filled('bolge_id')) {
            $query->where('bolge_id', $request->bolge_id);
        }
        if ($request->filled('arama')) {
            $arama = $request->arama;
            $query->where(function ($q) use ($arama) {
                $q->where('isim', 'like', "%{$arama}%")
                  ->orWhere('soyisim', 'like', "%{$arama}%")
                  ->orWhere('tc_no', 'like', "%{$arama}%")
                  ->orWhere('abone_no', 'like', "%{$arama}%")
                  ->orWhere('telefon', 'like', "%{$arama}%")
                  ->orWhere('cep_telefon', 'like', "%{$arama}%");
            });
        }

        $musteriler = $query->latest()->paginate(25);
        $tarifeler = Tarife::all();
        $bolgeler = Bolge::all();
        $bayiler = User::where('tip', 'bayi')->get();
        $gruplar = MusteriGrubu::all();

        return view('musteriler.index', compact('musteriler', 'tarifeler', 'bolgeler', 'bayiler', 'gruplar'));
    }

    public function create()
    {
        $tarifeler = Tarife::all();
        $bolgeler = Bolge::all();
        $bayiler = User::where('rol', 'bayi')->get();
        $gruplar = MusteriGrubu::all();
        $mikrotikler = \App\Models\Mikrotik::where('aktif', true)->get();
        $hatlar = \App\Models\Hat::where('aktif', true)->get();

        return view('musteriler.create', compact('tarifeler', 'bolgeler', 'bayiler', 'gruplar', 'mikrotikler', 'hatlar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isim' => 'required|string|max:255',
            'soyisim' => 'required|string|max:255',
            'tc_no' => 'required|string|max:11|unique:musteriler,tc_no',
            'telefon' => 'nullable|string|max:20',
            'cep_telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'tarife_id' => 'required|exists:tarifeler,id',
            'bolge_id' => 'nullable|exists:bolgeler,id',
            'bayi_id' => 'nullable|exists:users,id',
            'tip' => 'required|string',
            'durum' => 'required|string',
            'il' => 'nullable|string|max:100',
            'ilce' => 'nullable|string|max:100',
            'mahalle' => 'nullable|string|max:255',
            'cadde_sokak' => 'nullable|string|max:255',
            'bina_no' => 'nullable|string|max:20',
            'daire_no' => 'nullable|string|max:20',
            'adres' => 'nullable|string',
            'kullanici_adi' => 'nullable|string|max:255',
            'kullanici_sifre' => 'nullable|string|max:255',
        ]);

        $validated['admin_onayli'] = true;
        $musteri = Musteri::create($validated);

        return redirect()->route('musteriler.show', $musteri->id)
            ->with('success', 'Müşteri başarıyla oluşturuldu.');
    }

    public function show($id)
    {
        $musteri = Musteri::with('tarife', 'bolge', 'faturalar', 'odemeler', 'notlar')->findOrFail($id);

        return view('musteriler.show', compact('musteri'));
    }

    public function edit($id)
    {
        $musteri = Musteri::findOrFail($id);
        $tarifeler = Tarife::all();
        $bolgeler = Bolge::all();
        $bayiler = User::where('tip', 'bayi')->get();
        $gruplar = MusteriGrubu::all();

        return view('musteriler.edit', compact('musteri', 'tarifeler', 'bolgeler', 'bayiler', 'gruplar'));
    }

    public function update(Request $request, $id)
    {
        $musteri = Musteri::findOrFail($id);

        $validated = $request->validate([
            'isim' => 'required|string|max:255',
            'soyisim' => 'required|string|max:255',
            'tc_no' => 'required|string|max:11|unique:musteriler,tc_no,' . $id,
            'telefon' => 'nullable|string|max:20',
            'cep_telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'tarife_id' => 'required|exists:tarifeler,id',
            'bolge_id' => 'nullable|exists:bolgeler,id',
            'bayi_id' => 'nullable|exists:users,id',
            'tip' => 'required|string',
            'durum' => 'required|string',
            'il' => 'nullable|string|max:100',
            'ilce' => 'nullable|string|max:100',
            'adres' => 'nullable|string',
            'kullanici_adi' => 'nullable|string|max:255',
            'kullanici_sifre' => 'nullable|string|max:255',
        ]);

        $musteri->update($validated);

        return redirect()->route('musteriler.show', $musteri->id)
            ->with('success', 'Müşteri başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $musteri = Musteri::findOrFail($id);
        $musteri->delete();

        return redirect()->route('musteriler.index')
            ->with('success', 'Müşteri başarıyla silindi.');
    }

    public function onlineMusteriler()
    {
        $onlineMusteriler = Musteri::where('durum', 'aktif')
            ->where('online', true)
            ->with('tarife', 'bolge')
            ->paginate(25);

        return view('musteriler.online', compact('onlineMusteriler'));
    }

    public function offlineMusteriler()
    {
        $offlineMusteriler = Musteri::where('durum', 'aktif')
            ->where('online', false)
            ->with('tarife', 'bolge')
            ->paginate(25);

        return view('musteriler.offline', compact('offlineMusteriler'));
    }

    public function musteriNotlari()
    {
        $notlar = MusteriNotu::with('musteri', 'user')->latest()->paginate(25);

        return view('musteriler.notlar', compact('notlar'));
    }

    public function tarifeGecisIstekleri()
    {
        $istekler = Musteri::whereNotNull('tarife_gecis_istegi')
            ->with('tarife')
            ->paginate(25);

        return view('musteriler.tarife_gecis_istekleri', compact('istekler'));
    }

    public function onlineBasvurular()
    {
        $basvurular = Basvuru::where('kaynak', 'online')
            ->latest()
            ->paginate(25);

        return view('musteriler.online_basvurular', compact('basvurular'));
    }

    public function onBasvurular()
    {
        $basvurular = Basvuru::where('kaynak', 'on_basvuru')
            ->latest()
            ->paginate(25);

        return view('musteriler.on_basvurular', compact('basvurular'));
    }

    public function internetiKesilenler()
    {
        $musteriler = Musteri::where('borctan_kapali', true)
            ->with('tarife', 'bolge')
            ->paginate(25);

        return view('musteriler.interneti_kesilenler', compact('musteriler'));
    }

    public function onayBekleyen()
    {
        $musteriler = Musteri::where('admin_onayli', false)
            ->with('tarife', 'bolge')
            ->latest()
            ->paginate(25);

        return view('musteriler.onay_bekleyen', compact('musteriler'));
    }

    public function yabanciMusteriler()
    {
        $musteriler = Musteri::where('kimlik_tipi', 'yabanci')
            ->with('tarife', 'bolge')
            ->paginate(25);

        return view('musteriler.yabanci', compact('musteriler'));
    }

    public function yasaklananTcler()
    {
        $yasaklar = YasaklananTc::latest()->paginate(25);

        return view('musteriler.yasaklanan_tcler', compact('yasaklar'));
    }

    public function grupListesi()
    {
        $gruplar = MusteriGrubu::withCount('musteriler')->get();

        return view('musteriler.gruplar', compact('gruplar'));
    }

    public function macArama(Request $request)
    {
        $musteriler = collect();

        if ($request->filled('mac')) {
            $musteriler = Musteri::where('mac_adresi', 'like', '%' . $request->mac . '%')
                ->with('tarife', 'bolge')
                ->paginate(25);
        }

        return view('musteriler.mac_arama', compact('musteriler'));
    }

    public function eDevletBasvurular()
    {
        $basvurular = Basvuru::where('kaynak', 'e_devlet')
            ->latest()
            ->paginate(25);

        return view('musteriler.e_devlet_basvurular', compact('basvurular'));
    }

    public function vlanMusteriler()
    {
        $musteriler = Musteri::whereNotNull('vlan_id')
            ->with('tarife', 'bolge')
            ->paginate(25);

        return view('musteriler.vlan', compact('musteriler'));
    }

    public function odemeLoglari(Request $request)
    {
        $query = Odeme::with('musteri', 'user');

        if ($request->filled('musteri_id')) {
            $query->where('musteri_id', $request->musteri_id);
        }
        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $odemeler = $query->latest()->paginate(25);

        return view('musteriler.odeme_loglari', compact('odemeler'));
    }
}

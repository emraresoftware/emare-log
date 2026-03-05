<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fatura;
use App\Models\Odeme;
use App\Models\Musteri;
use App\Models\HavaleBildirimi;
use App\Models\OtomatikCekim;

class FaturaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $musteriler = Musteri::select('id', 'isim', 'soyisim', 'abone_no')->get();
        $tarifeler = \App\Models\Tarife::where('aktif', true)->get();

        return view('faturalar.ekle', compact('musteriler', 'tarifeler'));
    }

    public function index(Request $request)
    {
        $query = Fatura::with('musteri');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('bayi_id')) {
            $query->where('bayi_id', $request->bayi_id);
        }
        if ($request->filled('baslangic')) {
            $query->whereDate('fatura_tarihi', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('fatura_tarihi', '<=', $request->bitis);
        }
        if ($request->filled('arama')) {
            $arama = $request->arama;
            $query->where(function ($q) use ($arama) {
                $q->where('fatura_no', 'like', "%{$arama}%")
                  ->orWhereHas('musteri', function ($mq) use ($arama) {
                      $mq->where('isim', 'like', "%{$arama}%")
                         ->orWhere('soyisim', 'like', "%{$arama}%")
                         ->orWhere('abone_no', 'like', "%{$arama}%");
                  });
            });
        }

        $faturalar = $query->latest('fatura_tarihi')->paginate(25);

        return view('faturalar.index', compact('faturalar'));
    }

    public function odemeAl($faturaId = null)
    {
        if ($faturaId) {
            $fatura = Fatura::with('musteri')->findOrFail($faturaId);
        } else {
            $fatura = null;
        }
        $faturalar = Fatura::where('durum', 'odenmedi')->with('musteri')->get();

        return view('faturalar.odeme_al', compact('fatura', 'faturalar'));
    }

    public function odemeKaydet(Request $request)
    {
        $validated = $request->validate([
            'fatura_id' => 'required|exists:faturalar,id',
            'tutar' => 'required|numeric|min:0.01',
            'odeme_yontemi' => 'required|string',
            'aciklama' => 'nullable|string',
        ]);

        $fatura = Fatura::findOrFail($validated['fatura_id']);

        Odeme::create([
            'fatura_id' => $fatura->id,
            'musteri_id' => $fatura->musteri_id,
            'tutar' => $validated['tutar'],
            'odeme_yontemi' => $validated['odeme_yontemi'],
            'aciklama' => $validated['aciklama'],
            'user_id' => auth()->id(),
        ]);

        if ($validated['tutar'] >= $fatura->toplam_tutar) {
            $fatura->update([
                'durum' => 'odenmis',
                'odeme_tarihi' => now(),
            ]);
        }

        return redirect()->route('faturalar.index')
            ->with('success', 'Ödeme başarıyla kaydedildi.');
    }

    public function eFaturalar(Request $request)
    {
        $query = Fatura::where('e_fatura', true)->with('musteri');

        if ($request->filled('durum')) {
            $query->where('e_fatura_durum', $request->durum);
        }

        $faturalar = $query->latest()->paginate(25);

        return view('faturalar.efatura', compact('faturalar'));
    }

    public function faturaTahsilat(Request $request)
    {
        $query = Odeme::with('musteri', 'fatura', 'user');

        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }
        if ($request->filled('odeme_yontemi')) {
            $query->where('odeme_yontemi', $request->odeme_yontemi);
        }

        $tahsilatlar = $query->latest()->paginate(25);
        $toplamTutar = $query->sum('tutar');

        return view('faturalar.tahsilat', compact('tahsilatlar', 'toplamTutar'));
    }

    public function odenmisFaturalar()
    {
        $faturalar = Fatura::where('durum', 'odenmis')
            ->with('musteri')
            ->latest('odeme_tarihi')
            ->paginate(25);

        return view('faturalar.odenmis', compact('faturalar'));
    }

    public function faturaliIptal()
    {
        $faturalar = Fatura::where('durum', 'iptal')
            ->with('musteri')
            ->latest()
            ->paginate(25);

        return view('faturalar.iptal', compact('faturalar'));
    }

    public function taahhutluMusteriler()
    {
        $musteriler = Musteri::where('taahhutlu', true)
            ->with('tarife')
            ->paginate(25);

        return view('faturalar.taahhutlu', compact('musteriler'));
    }

    public function bekleyenSiparisler()
    {
        $faturalar = Fatura::where('durum', 'beklemede')
            ->with('musteri')
            ->latest()
            ->paginate(25);

        return view('faturalar.bekleyen_siparisler', compact('faturalar'));
    }

    public function havaleBildirimleri()
    {
        $bildirimler = HavaleBildirimi::with('musteri', 'fatura')
            ->latest()
            ->paginate(25);

        return view('faturalar.havale_bildirimleri', compact('bildirimler'));
    }

    public function eFaturaHata()
    {
        $faturalar = Fatura::where('e_fatura', true)
            ->where('e_fatura_durum', 'hata')
            ->with('musteri')
            ->latest()
            ->paginate(25);

        return view('faturalar.e_fatura_hata', compact('faturalar'));
    }

    public function offlineTahsilatlar()
    {
        $tahsilatlar = Odeme::where('odeme_yontemi', 'offline')
            ->with('musteri', 'fatura', 'user')
            ->latest()
            ->paginate(25);

        return view('faturalar.offline_tahsilatlar', compact('tahsilatlar'));
    }

    public function otomatikCekimler()
    {
        $cekimler = OtomatikCekim::with('musteri')
            ->latest()
            ->paginate(25);

        return view('faturalar.otomatik_cekimler', compact('cekimler'));
    }

    public function otomatikTalimatlar()
    {
        $talimatlar = OtomatikCekim::where('durum', 'aktif')
            ->with('musteri')
            ->paginate(25);

        return view('faturalar.otomatik_talimatlar', compact('talimatlar'));
    }

    public function paynkolayRapor(Request $request)
    {
        $query = Odeme::where('odeme_yontemi', 'paynkolay')->with('musteri', 'fatura');

        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $odemeler = $query->latest()->paginate(25);
        $toplam = $query->sum('tutar');

        return view('faturalar.paynkolay_rapor', compact('odemeler', 'toplam'));
    }

    public function issFaturalar()
    {
        $faturalar = Fatura::where('tip', 'iss')
            ->with('musteri')
            ->latest()
            ->paginate(25);

        return view('faturalar.iss_faturalar', compact('faturalar'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Musteri;
use App\Models\Fatura;
use App\Models\Odeme;
use App\Models\User;
use App\Models\Tarife;
use App\Models\Bolge;
use App\Models\IsEmri;
use Illuminate\Support\Facades\DB;

class RaporController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function satisRaporlari(Request $request)
    {
        $baslangic = $request->get('baslangic', now()->startOfMonth()->toDateString());
        $bitis = $request->get('bitis', now()->toDateString());

        $satislar = Fatura::whereBetween('fatura_tarihi', [$baslangic, $bitis])
            ->select(
                DB::raw('DATE(fatura_tarihi) as tarih'),
                DB::raw('COUNT(*) as adet'),
                DB::raw('SUM(toplam_tutar) as toplam')
            )
            ->groupBy('tarih')
            ->orderBy('tarih')
            ->get();

        $toplamTutar = $satislar->sum('toplam');
        $toplamAdet = $satislar->sum('adet');

        return view('raporlar.satis', compact('satislar', 'toplamTutar', 'toplamAdet', 'baslangic', 'bitis'));
    }

    public function kdvRaporlari(Request $request)
    {
        $baslangic = $request->get('baslangic', now()->startOfMonth()->toDateString());
        $bitis = $request->get('bitis', now()->toDateString());

        $kdvRapor = Fatura::whereBetween('fatura_tarihi', [$baslangic, $bitis])
            ->select(
                DB::raw('kdv_orani'),
                DB::raw('SUM(kdv_tutar) as toplam_kdv'),
                DB::raw('SUM(tutar) as toplam_matrah'),
                DB::raw('COUNT(*) as fatura_adet')
            )
            ->groupBy('kdv_orani')
            ->get();

        return view('raporlar.kdv', compact('kdvRapor', 'baslangic', 'bitis'));
    }

    public function trafikRaporlari(Request $request)
    {
        $tarih = $request->get('tarih', now()->toDateString());

        return view('raporlar.trafik', compact('tarih'));
    }

    public function genelTrafikRaporlari()
    {
        return view('raporlar.genel_trafik');
    }

    public function gunSonuRaporlari(Request $request)
    {
        $tarih = $request->get('tarih', now()->toDateString());

        $tahsilatlar = Odeme::whereDate('created_at', $tarih)
            ->select(
                'odeme_yontemi',
                DB::raw('COUNT(*) as adet'),
                DB::raw('SUM(tutar) as toplam')
            )
            ->groupBy('odeme_yontemi')
            ->get();

        $toplamTahsilat = $tahsilatlar->sum('toplam');
        $yeniMusteri = Musteri::whereDate('created_at', $tarih)->count();
        $kesilenFatura = Fatura::whereDate('fatura_tarihi', $tarih)->count();

        return view('raporlar.gun_sonu', compact('tahsilatlar', 'toplamTahsilat', 'yeniMusteri', 'kesilenFatura', 'tarih'));
    }

    public function musteriRaporlari()
    {
        $durumDagilimi = Musteri::select('durum', DB::raw('COUNT(*) as adet'))
            ->groupBy('durum')
            ->get();

        $tipDagilimi = Musteri::select('tip', DB::raw('COUNT(*) as adet'))
            ->groupBy('tip')
            ->get();

        $aylikYeniMusteri = Musteri::select(
                DB::raw("strftime('%Y', created_at) as yil"),
                DB::raw("strftime('%m', created_at) as ay"),
                DB::raw('COUNT(*) as adet')
            )
            ->groupBy('yil', 'ay')
            ->orderByDesc('yil')
            ->orderByDesc('ay')
            ->take(12)
            ->get();

        return view('raporlar.musteri', compact('durumDagilimi', 'tipDagilimi', 'aylikYeniMusteri'));
    }

    public function adresRapor(Request $request)
    {
        $query = Musteri::query();

        if ($request->filled('il')) {
            $query->where('il', $request->il);
        }
        if ($request->filled('ilce')) {
            $query->where('ilce', $request->ilce);
        }
        if ($request->filled('mahalle')) {
            $query->where('mahalle', 'like', '%' . $request->mahalle . '%');
        }

        $musteriler = $query->paginate(25);
        $iller = Musteri::select('il')->distinct()->pluck('il');

        return view('raporlar.adres', compact('musteriler', 'iller'));
    }

    public function binadakiMusteriler(Request $request)
    {
        $musteriler = collect();

        if ($request->filled('adres')) {
            $musteriler = Musteri::where('adres', 'like', '%' . $request->adres . '%')
                ->orWhere(function ($q) use ($request) {
                    $q->where('mahalle', 'like', '%' . $request->adres . '%')
                      ->orWhere('cadde_sokak', 'like', '%' . $request->adres . '%');
                })
                ->with('tarife')
                ->paginate(25);
        }

        return view('raporlar.binadaki_musteriler', compact('musteriler'));
    }

    public function bayilerGenelRaporlari()
    {
        $bayiler = User::where('tip', 'bayi')
            ->withCount(['musteriler', 'musteriler as aktif_musteri_count' => function ($q) {
                $q->where('durum', 'aktif');
            }])
            ->get();

        return view('raporlar.bayiler_genel', compact('bayiler'));
    }

    public function bayiBakiyeRaporlari()
    {
        $bayiler = User::where('tip', 'bayi')
            ->get()
            ->map(function ($bayi) {
                $bayi->toplam_tahsilat = Odeme::where('user_id', $bayi->id)->sum('tutar');
                $bayi->toplam_fatura = Fatura::where('bayi_id', $bayi->id)->sum('toplam_tutar');
                return $bayi;
            });

        return view('raporlar.bayi_bakiye', compact('bayiler'));
    }

    public function veresiyeRaporlari()
    {
        $musteriler = Musteri::where('borc', '>', 0)
            ->orderByDesc('borc')
            ->with('tarife')
            ->paginate(25);

        $toplamBorc = Musteri::where('borc', '>', 0)->sum('borc');

        return view('raporlar.veresiye', compact('musteriler', 'toplamBorc'));
    }

    public function tarifeRaporlari()
    {
        $tarifeler = Tarife::withCount([
            'musteriler',
            'musteriler as aktif_count' => fn($q) => $q->where('durum', 'aktif'),
            'musteriler as pasif_count' => fn($q) => $q->where('durum', 'pasif'),
        ])->get();

        return view('raporlar.tarife', compact('tarifeler'));
    }

    public function tahsilatRaporlari(Request $request)
    {
        $baslangic = $request->get('baslangic', now()->startOfMonth()->toDateString());
        $bitis = $request->get('bitis', now()->toDateString());

        $tahsilatlar = Odeme::whereBetween('created_at', [$baslangic, $bitis . ' 23:59:59'])
            ->select(
                DB::raw('DATE(created_at) as tarih'),
                DB::raw('SUM(tutar) as toplam'),
                DB::raw('COUNT(*) as adet')
            )
            ->groupBy('tarih')
            ->orderBy('tarih')
            ->get();

        $toplamTahsilat = $tahsilatlar->sum('toplam');

        return view('raporlar.tahsilat', compact('tahsilatlar', 'toplamTahsilat', 'baslangic', 'bitis'));
    }

    public function eFaturaDurumRaporu()
    {
        $durum = Fatura::where('e_fatura', true)
            ->select('e_fatura_durum', DB::raw('COUNT(*) as adet'))
            ->groupBy('e_fatura_durum')
            ->get();

        return view('raporlar.e_fatura_durum', compact('durum'));
    }

    public function eksikEvrakRaporu()
    {
        $musteriler = Musteri::where(function ($q) {
            $q->where('kimlik_onayli', false)
              ->orWhere('sozlesme_onayli', false);
        })->with('tarife')->paginate(25);

        return view('raporlar.eksik_evrak', compact('musteriler'));
    }

    public function bayiHakedisRaporu(Request $request)
    {
        $baslangic = $request->get('baslangic', now()->startOfMonth()->toDateString());
        $bitis = $request->get('bitis', now()->toDateString());

        $bayiler = User::where('tip', 'bayi')->get()->map(function ($bayi) use ($baslangic, $bitis) {
            $bayi->donem_tahsilat = Odeme::where('user_id', $bayi->id)
                ->whereBetween('created_at', [$baslangic, $bitis . ' 23:59:59'])
                ->sum('tutar');
            $bayi->hakedis = $bayi->donem_tahsilat * ($bayi->komisyon_orani / 100);
            return $bayi;
        });

        return view('raporlar.bayi_hakedis', compact('bayiler', 'baslangic', 'bitis'));
    }

    public function cagriIstatistikleri()
    {
        $isEmirleri = IsEmri::select('durum', DB::raw('COUNT(*) as adet'))
            ->groupBy('durum')
            ->get();

        $gunlukIsEmri = IsEmri::select(
                DB::raw('DATE(created_at) as tarih'),
                DB::raw('COUNT(*) as adet')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('tarih')
            ->orderBy('tarih')
            ->get();

        return view('raporlar.cagri_istatistikleri', compact('isEmirleri', 'gunlukIsEmri'));
    }
}

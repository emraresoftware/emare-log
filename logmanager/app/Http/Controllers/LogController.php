<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PanelLogu;
use App\Models\OturumLogu;
use App\Models\MikrotikLogu;
use App\Models\AboneLogu;
use App\Models\Mikrotik;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function portLoglari(Request $request)
    {
        $query = MikrotikLogu::where('tip', 'port')->with('mikrotik');

        if ($request->filled('mikrotik_id')) {
            $query->where('mikrotik_id', $request->mikrotik_id);
        }
        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $loglar = $query->latest()->paginate(25);
        $mikrotikler = Mikrotik::all();

        return view('loglar.port', compact('loglar', 'mikrotikler'));
    }

    public function oturumLoglari(Request $request)
    {
        $query = OturumLogu::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $loglar = $query->latest()->paginate(25);

        return view('loglar.oturum', compact('loglar'));
    }

    public function mikrotikLoglari(Request $request)
    {
        $query = MikrotikLogu::with('mikrotik');

        if ($request->filled('mikrotik_id')) {
            $query->where('mikrotik_id', $request->mikrotik_id);
        }
        if ($request->filled('tip')) {
            $query->where('tip', $request->tip);
        }

        $loglar = $query->latest()->paginate(25);
        $mikrotikler = Mikrotik::all();

        return view('loglar.mikrotik', compact('loglar', 'mikrotikler'));
    }

    public function log5651(Request $request)
    {
        $query = AboneLogu::query();

        if ($request->filled('ip_adresi')) {
            $query->where('ip_adresi', $request->ip_adresi);
        }
        if ($request->filled('musteri_id')) {
            $query->where('musteri_id', $request->musteri_id);
        }
        if ($request->filled('baslangic')) {
            $query->whereDate('tarih', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('tarih', '<=', $request->bitis);
        }

        $loglar = $query->latest()->paginate(25);

        return view('loglar.log5651', compact('loglar'));
    }

    public function aboneLoglari(Request $request)
    {
        $query = AboneLogu::with('musteri');

        if ($request->filled('musteri_id')) {
            $query->where('musteri_id', $request->musteri_id);
        }
        if ($request->filled('islem_tipi')) {
            $query->where('islem_tipi', $request->islem_tipi);
        }

        $loglar = $query->latest()->paginate(25);

        return view('loglar.abone', compact('loglar'));
    }

    public function aboneRehberLoglari(Request $request)
    {
        $query = AboneLogu::where('tip', 'rehber')->with('musteri');

        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $loglar = $query->latest()->paginate(25);

        return view('loglar.abone_rehber', compact('loglar'));
    }

    public function aboneHareketLoglari(Request $request)
    {
        $query = AboneLogu::where('tip', 'hareket')->with('musteri');

        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $loglar = $query->latest()->paginate(25);

        return view('loglar.abone_hareket', compact('loglar'));
    }

    public function panelLoglari(Request $request)
    {
        $query = PanelLogu::with('user');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('islem')) {
            $query->where('islem', 'like', '%' . $request->islem . '%');
        }

        $loglar = $query->latest()->paginate(25);

        return view('loglar.panel', compact('loglar'));
    }

    public function sunucuDurum()
    {
        $mikrotikler = Mikrotik::all()->map(function ($mikrotik) {
            $mikrotik->son_log = MikrotikLogu::where('mikrotik_id', $mikrotik->id)
                ->latest()->first();
            return $mikrotik;
        });

        return view('loglar.sunucu_durum', compact('mikrotikler'));
    }

    public function logHataDurumu()
    {
        $hatalar = MikrotikLogu::where('tip', 'hata')
            ->select('mikrotik_id', DB::raw('COUNT(*) as hata_sayisi'))
            ->groupBy('mikrotik_id')
            ->with('mikrotik')
            ->get();

        return view('loglar.hata_durum', compact('hatalar'));
    }

    public function veriTarama(Request $request)
    {
        $sonuclar = collect();

        if ($request->filled('sorgu')) {
            $sorgu = $request->sorgu;
            $sonuclar = AboneLogu::where('icerik', 'like', '%' . $sorgu . '%')
                ->orWhere('ip_adresi', 'like', '%' . $sorgu . '%')
                ->with('musteri')
                ->latest()
                ->paginate(25);
        }

        return view('loglar.veri_tarama', compact('sonuclar'));
    }

    public function sasVeri(Request $request)
    {
        $query = AboneLogu::where('tip', 'sas');

        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $veriler = $query->latest()->paginate(25);

        return view('loglar.sas_veri', compact('veriler'));
    }

    public function btkHata()
    {
        $hatalar = AboneLogu::where('tip', 'btk_hata')
            ->latest()
            ->paginate(25);

        return view('loglar.btk_hata', compact('hatalar'));
    }
}

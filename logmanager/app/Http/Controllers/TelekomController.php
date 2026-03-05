<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelekomBasvuru;
use App\Models\GenelAriza;
use App\Models\Fatura;

class TelekomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $basvurular = TelekomBasvuru::with('musteri')->latest()->paginate(25);

        return view('telekom.index', compact('basvurular'));
    }

    public function basvurular(Request $request)
    {
        $query = TelekomBasvuru::with('musteri');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('tip')) {
            $query->where('tip', $request->tip);
        }

        $basvurular = $query->latest()->paginate(25);

        return view('telekom.index', compact('basvurular'));
    }

    public function vaeFaturalar(Request $request)
    {
        $query = Fatura::where('tip', 'vae')->with('musteri');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }

        $faturalar = $query->latest()->paginate(25);

        return view('telekom.vae_faturalar', compact('faturalar'));
    }

    public function churnSorgu(Request $request)
    {
        $sonuclar = collect();

        if ($request->filled('tc_no') || $request->filled('abone_no')) {
            $query = TelekomBasvuru::query();
            if ($request->filled('tc_no')) {
                $query->where('tc_no', $request->tc_no);
            }
            if ($request->filled('abone_no')) {
                $query->where('abone_no', $request->abone_no);
            }
            $sonuclar = $query->with('musteri')->get();
        }

        return view('telekom.churn_sorgu', compact('sonuclar'));
    }

    public function churnListesi()
    {
        $churnlar = TelekomBasvuru::where('tip', 'churn')
            ->with('musteri')
            ->latest()
            ->paginate(25);

        return view('telekom.churn_listesi', compact('churnlar'));
    }

    public function oloArizaListesi()
    {
        $arizalar = TelekomBasvuru::where('tip', 'olo_ariza')
            ->with('musteri')
            ->latest()
            ->paginate(25);

        return view('telekom.olo_ariza_listesi', compact('arizalar'));
    }

    public function oloArizaTeyit(Request $request, $id = null)
    {
        if ($id) {
            $basvuru = TelekomBasvuru::findOrFail($id);
            $basvuru->update([
                'teyit_durumu' => 'teyit_edildi',
                'teyit_tarihi' => now(),
                'teyit_eden_id' => auth()->id(),
            ]);

            return redirect()->route('telekom.olo-ariza-listesi')
                ->with('success', 'Arıza teyit edildi.');
        }

        $bekleyenler = TelekomBasvuru::where('tip', 'olo_ariza')
            ->whereNull('teyit_durumu')
            ->with('musteri')
            ->paginate(25);

        return view('telekom.olo_ariza_teyit', compact('bekleyenler'));
    }

    public function genelAriza()
    {
        $arizalar = GenelAriza::where('kaynak', 'telekom')
            ->latest()
            ->paginate(25);

        return view('telekom.genel_ariza', compact('arizalar'));
    }

    public function degisiklikBasvurulari()
    {
        $basvurular = TelekomBasvuru::where('tip', 'degisiklik')
            ->with('musteri')
            ->latest()
            ->paginate(25);

        return view('telekom.degisiklik_basvurulari', compact('basvurular'));
    }

    public function durumRaporu()
    {
        $toplamBasvuru = TelekomBasvuru::count();
        $bekleyen = TelekomBasvuru::where('durum', 'beklemede')->count();
        $onaylanan = TelekomBasvuru::where('durum', 'onaylandi')->count();
        $reddedilen = TelekomBasvuru::where('durum', 'reddedildi')->count();

        $tipDagilimi = TelekomBasvuru::select('tip', \DB::raw('COUNT(*) as adet'))
            ->groupBy('tip')
            ->get();

        return view('telekom.durum_raporu', compact(
            'toplamBasvuru', 'bekleyen', 'onaylanan', 'reddedilen', 'tipDagilimi'
        ));
    }
}

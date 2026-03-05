<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Musteri;
use App\Models\Fatura;
use App\Models\IsEmri;
use App\Models\TeknikServis;
use App\Models\Basvuru;
use App\Models\Ticket;
use App\Models\GenelAriza;
use App\Models\Odeme;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $musteriAktif = Musteri::where('durum', 'aktif')->count();
        $musteriPasif = Musteri::where('durum', 'pasif')->count();
        $musteriAskida = Musteri::where('durum', 'dondurulmus')->count();
        $musteriToplam = Musteri::count();

        $faturaOdenmemis = Fatura::where('durum', 'odenmedi')->count();
        $faturaOdenmemisTutar = Fatura::where('durum', 'odenmedi')->sum('toplam_tutar');
        $faturaOdenmis = Fatura::where('durum', 'odendi')->count();
        $faturaOdenmisTutar = Fatura::where('durum', 'odendi')->sum('toplam_tutar');
        $faturaAylikToplam = Fatura::whereMonth('fatura_tarihi', now()->month)
            ->whereYear('fatura_tarihi', now()->year)
            ->sum('toplam_tutar');

        $isEmriAcik = IsEmri::where('durum', 'acik')->count();
        $isEmriKapali = IsEmri::where('durum', 'tamamlandi')->count();
        $isEmriBekleyen = IsEmri::where('durum', 'bekliyor')->count();

        $teknikServisAcik = TeknikServis::where('durum', 'acik')->count();
        $bekleyenBasvuru = Basvuru::where('durum', 'bekliyor')->count();
        $acikTicket = Ticket::where('durum', 'acik')->count();
        $aktifAriza = GenelAriza::where('durum', 'acik')->count();

        $bugunTahsilat = Odeme::whereDate('created_at', today())->sum('tutar');
        $aylikTahsilat = Odeme::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('tutar');

        $sonMusteriler = Musteri::latest()->take(10)->get();
        $sonOdemeler = Odeme::with('musteri')->latest()->take(10)->get();
        $sonIsEmirleri = IsEmri::with('musteri')->latest()->take(10)->get();

        return view('home', compact(
            'musteriAktif', 'musteriPasif', 'musteriAskida', 'musteriToplam',
            'faturaOdenmemis', 'faturaOdenmemisTutar', 'faturaOdenmis', 'faturaOdenmisTutar', 'faturaAylikToplam',
            'isEmriAcik', 'isEmriKapali', 'isEmriBekleyen',
            'teknikServisAcik', 'bekleyenBasvuru', 'acikTicket', 'aktifAriza',
            'bugunTahsilat', 'aylikTahsilat',
            'sonMusteriler', 'sonOdemeler', 'sonIsEmirleri'
        ));
    }
}

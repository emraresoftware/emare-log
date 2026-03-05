<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SmsAyari;
use App\Models\SmsSablonu;
use App\Models\SmsGonderimi;
use App\Models\Musteri;

class SmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ayarlar()
    {
        $ayarlar = SmsAyari::first();

        return view('sms.ayarlar', compact('ayarlar'));
    }

    public function ayarKaydet(Request $request)
    {
        $validated = $request->validate([
            'saglayici' => 'required|string',
            'api_anahtari' => 'required|string',
            'kullanici_adi' => 'nullable|string',
            'sifre' => 'nullable|string',
            'baslik' => 'required|string|max:11',
            'aktif' => 'required|boolean',
        ]);

        SmsAyari::updateOrCreate(['id' => 1], $validated);

        return redirect()->route('sms.ayarlar')
            ->with('success', 'SMS ayarları başarıyla kaydedildi.');
    }

    public function rapor(Request $request)
    {
        $query = SmsGonderimi::with('musteri');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('baslangic')) {
            $query->whereDate('created_at', '>=', $request->baslangic);
        }
        if ($request->filled('bitis')) {
            $query->whereDate('created_at', '<=', $request->bitis);
        }

        $gonderimler = $query->latest()->paginate(25);

        $toplamGonderilen = SmsGonderimi::where('durum', 'gonderildi')->count();
        $toplamBasarisiz = SmsGonderimi::where('durum', 'basarisiz')->count();

        return view('sms.rapor', compact('gonderimler', 'toplamGonderilen', 'toplamBasarisiz'));
    }

    public function sablonlar()
    {
        $sablonlar = SmsSablonu::latest()->get();

        return view('sms.sablonlar', compact('sablonlar'));
    }

    public function sablonKaydet(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'icerik' => 'required|string',
            'tip' => 'nullable|string|max:100',
        ]);

        SmsSablonu::create($validated);

        return redirect()->route('sms.sablonlar')
            ->with('success', 'SMS şablonu başarıyla kaydedildi.');
    }

    public function smsGonder()
    {
        $sablonlar = SmsSablonu::all();
        $musteriler = Musteri::where('durum', 'aktif')
            ->select('id', 'isim', 'soyisim', 'cep_telefon')
            ->get();

        return view('sms.gonder', compact('sablonlar', 'musteriler'));
    }

    public function smsGonderKaydet(Request $request)
    {
        $validated = $request->validate([
            'musteri_ids' => 'required|array',
            'musteri_ids.*' => 'exists:musteriler,id',
            'mesaj' => 'required|string|max:918',
        ]);

        $musteriler = Musteri::whereIn('id', $validated['musteri_ids'])->get();

        foreach ($musteriler as $musteri) {
            SmsGonderimi::create([
                'musteri_id' => $musteri->id,
                'telefon' => $musteri->cep_telefon,
                'mesaj' => $validated['mesaj'],
                'durum' => 'kuyrukta',
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('sms.rapor')
            ->with('success', count($musteriler) . ' kişiye SMS gönderim kuyruğuna eklendi.');
    }
}

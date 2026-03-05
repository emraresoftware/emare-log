<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ayar;

class AyarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function genelAyarlar()
    {
        $ayarlar = Ayar::all()->pluck('deger', 'anahtar');

        return view('ayarlar.genel', compact('ayarlar'));
    }

    public function genelAyarlarKaydet(Request $request)
    {
        $validated = $request->validate([
            'firma_adi' => 'nullable|string|max:255',
            'firma_telefon' => 'nullable|string|max:20',
            'firma_email' => 'nullable|email|max:255',
            'firma_adres' => 'nullable|string',
            'firma_vergi_dairesi' => 'nullable|string|max:255',
            'firma_vergi_no' => 'nullable|string|max:20',
            'logo' => 'nullable|string',
            'varsayilan_kdv_orani' => 'nullable|numeric|min:0|max:100',
            'fatura_notu' => 'nullable|string',
            'musteri_sozlesme_suresi' => 'nullable|integer|min:1',
            'otomatik_fatura' => 'nullable|boolean',
            'borc_kesme_gun' => 'nullable|integer|min:1',
            'bakiye_uyari_limiti' => 'nullable|numeric',
        ]);

        foreach ($validated as $anahtar => $deger) {
            Ayar::updateOrCreate(
                ['anahtar' => $anahtar],
                ['deger' => $deger ?? '']
            );
        }

        return redirect()->route('ayarlar.genel')
            ->with('success', 'Ayarlar başarıyla kaydedildi.');
    }
}

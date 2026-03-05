<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappAyari;

class WhatsappController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ayarlar()
    {
        $ayarlar = WhatsappAyari::first();

        return view('whatsapp.ayarlar', compact('ayarlar'));
    }

    public function ayarKaydet(Request $request)
    {
        $validated = $request->validate([
            'api_url' => 'nullable|url|max:500',
            'api_anahtari' => 'nullable|string|max:500',
            'telefon_no' => 'nullable|string|max:20',
            'aktif' => 'required|boolean',
            'bildirim_sablonu' => 'nullable|string',
            'fatura_bildirimi' => 'nullable|boolean',
            'ariza_bildirimi' => 'nullable|boolean',
            'hosgeldin_mesaji' => 'nullable|string',
        ]);

        WhatsappAyari::updateOrCreate(['id' => 1], $validated);

        return redirect()->route('whatsapp.ayarlar')
            ->with('success', 'WhatsApp ayarları başarıyla kaydedildi.');
    }
}

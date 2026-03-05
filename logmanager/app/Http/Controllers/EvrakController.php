<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evrak;
use App\Models\Ayar;

class EvrakController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Evrak::with('musteri');

        if ($request->filled('tip')) {
            $query->where('tip', $request->tip);
        }
        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('musteri_id')) {
            $query->where('musteri_id', $request->musteri_id);
        }

        $evraklar = $query->latest()->paginate(25);

        return view('evrak.index', compact('evraklar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'musteri_id' => 'required|exists:musteriler,id',
            'tip' => 'required|string|max:100',
            'dosya_yolu' => 'required|string',
            'aciklama' => 'nullable|string',
            'durum' => 'required|string',
        ]);

        $validated['yukleyen_id'] = auth()->id();

        Evrak::create($validated);

        return redirect()->route('evraklar.index')
            ->with('success', 'Evrak başarıyla yüklendi.');
    }

    public function ayarlar(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'zorunlu_evraklar' => 'nullable|string',
                'maksimum_dosya_boyutu' => 'nullable|integer|min:1',
                'izin_verilen_uzantilar' => 'nullable|string',
            ]);

            foreach ($validated as $anahtar => $deger) {
                Ayar::updateOrCreate(
                    ['anahtar' => 'evrak_' . $anahtar],
                    ['deger' => $deger ?? '']
                );
            }

            return redirect()->route('evraklar.ayarlar')
                ->with('success', 'Evrak ayarları kaydedildi.');
        }

        $ayarlar = Ayar::where('anahtar', 'like', 'evrak_%')
            ->pluck('deger', 'anahtar');

        return view('evrak.ayarlar', compact('ayarlar'));
    }

    public function show($id)
    {
        $evrak = Evrak::with('musteri')->findOrFail($id);
        return view('evrak.show', compact('evrak'));
    }

    public function download($id)
    {
        $evrak = Evrak::findOrFail($id);
        $path = storage_path('app/' . $evrak->dosya_yolu);

        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'Dosya bulunamadı.');
        }

        return response()->download($path);
    }

    public function destroy($id)
    {
        $evrak = Evrak::findOrFail($id);
        $evrak->delete();

        return redirect()->route('evrak.index')
            ->with('success', 'Evrak başarıyla silindi.');
    }
}

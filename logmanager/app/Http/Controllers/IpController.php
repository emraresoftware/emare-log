<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IpAdresi;
use App\Models\Musteri;

class IpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = IpAdresi::with('musteri');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('tip')) {
            $query->where('tip', $request->tip);
        }
        if ($request->filled('arama')) {
            $query->where('ip_adresi', 'like', '%' . $request->arama . '%');
        }

        $ipler = $query->orderBy('ip_adresi')->paginate(25);

        return view('ip.index', compact('ipler'));
    }

    public function borcluIpler()
    {
        $ipler = IpAdresi::whereHas('musteri', function ($q) {
            $q->where('borctan_kapali', true);
        })->with('musteri')->paginate(25);

        return view('ip.borclu', compact('ipler'));
    }

    public function ipYonetim(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'ip_adresi' => 'required|ip',
                'musteri_id' => 'nullable|exists:musteriler,id',
                'tip' => 'required|string',
                'durum' => 'required|string',
                'aciklama' => 'nullable|string',
            ]);

            IpAdresi::create($validated);

            return redirect()->route('ip.index')
                ->with('success', 'IP adresi başarıyla eklendi.');
        }

        $musteriler = Musteri::select('id', 'isim', 'soyisim', 'abone_no')->get();

        return view('mikrotik.ip_yonetim', compact('musteriler'));
    }
}

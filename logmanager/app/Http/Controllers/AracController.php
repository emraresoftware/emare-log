<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Arac;

class AracController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $araclar = Arac::with('sorumlu')->latest()->paginate(25);

        return view('araclar.index', compact('araclar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plaka' => 'required|string|max:20|unique:araclar,plaka',
            'marka' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'yil' => 'nullable|integer|min:1990|max:2030',
            'renk' => 'nullable|string|max:50',
            'sorumlu_id' => 'nullable|exists:users,id',
            'durum' => 'required|string',
            'aciklama' => 'nullable|string',
        ]);

        Arac::create($validated);

        return redirect()->route('araclar.index')
            ->with('success', 'Araç başarıyla eklendi.');
    }

    public function takipAyar(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'arac_id' => 'required|exists:araclar,id',
                'takip_aktif' => 'required|boolean',
                'takip_suresi' => 'nullable|integer|min:1',
            ]);

            $arac = Arac::findOrFail($validated['arac_id']);
            $arac->update([
                'takip_aktif' => $validated['takip_aktif'],
                'takip_suresi' => $validated['takip_suresi'] ?? 60,
            ]);

            return redirect()->back()->with('success', 'Takip ayarları güncellendi.');
        }

        $araclar = Arac::all();

        return view('araclar.takip_ayar', compact('araclar'));
    }
}

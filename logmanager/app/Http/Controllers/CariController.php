<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cari;
use App\Models\CariFatura;

class CariController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cariler = Cari::latest()->paginate(25);

        return view('kasa.cariler', compact('cariler'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unvan' => 'required|string|max:255',
            'yetkili' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adres' => 'nullable|string',
            'vergi_dairesi' => 'nullable|string|max:255',
            'vergi_no' => 'nullable|string|max:20',
            'tip' => 'required|string',
        ]);

        Cari::create($validated);

        return redirect()->route('cariler.index')
            ->with('success', 'Cari başarıyla oluşturuldu.');
    }

    public function faturalar(Request $request)
    {
        $query = CariFatura::with('cari');

        if ($request->filled('cari_id')) {
            $query->where('cari_id', $request->cari_id);
        }
        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }

        $faturalar = $query->latest()->paginate(25);
        $cariler = Cari::all();

        return view('kasa.cari_faturalar', compact('faturalar', 'cariler'));
    }
}

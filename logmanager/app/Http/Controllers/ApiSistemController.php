<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiAnahtari;

class ApiSistemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $anahtarlar = ApiAnahtari::latest()->paginate(25);

        return view('api_sistem.index', compact('anahtarlar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'aciklama' => 'nullable|string',
            'yetkiler' => 'nullable|array',
            'ip_sinirlamasi' => 'nullable|string',
            'aktif' => 'required|boolean',
        ]);

        $validated['anahtar'] = bin2hex(random_bytes(32));
        $validated['olusturan_id'] = auth()->id();
        $validated['yetkiler'] = json_encode($validated['yetkiler'] ?? []);

        ApiAnahtari::create($validated);

        return redirect()->route('api-sistem.index')
            ->with('success', 'API anahtarı başarıyla oluşturuldu.');
    }
}

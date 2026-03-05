<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Depo;

class DepoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $depolar = Depo::latest()->paginate(25);

        return view('stok.depolar', compact('depolar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'adres' => 'nullable|string',
            'sorumlu_id' => 'nullable|exists:users,id',
            'aciklama' => 'nullable|string',
        ]);

        Depo::create($validated);

        return redirect()->route('depolar.index')
            ->with('success', 'Depo başarıyla oluşturuldu.');
    }
}

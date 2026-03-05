<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personel;
use App\Models\Hakedis;
use App\Models\User;

class PersonelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $personeller = Personel::with('user')->latest()->paginate(25);

        return view('personel.index', compact('personeller'));
    }

    public function create()
    {
        return view('personel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'soyad' => 'required|string|max:255',
            'tc_no' => 'required|string|max:11',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adres' => 'nullable|string',
            'departman' => 'nullable|string|max:100',
            'pozisyon' => 'nullable|string|max:100',
            'maas' => 'nullable|numeric|min:0',
            'ise_giris_tarihi' => 'required|date',
        ]);

        Personel::create($validated);

        return redirect()->route('personeller.index')
            ->with('success', 'Personel başarıyla eklendi.');
    }

    public function show($id)
    {
        $personel = Personel::with('hakedisler')->findOrFail($id);

        return view('personel.show', compact('personel'));
    }

    public function edit($id)
    {
        $personel = Personel::findOrFail($id);

        return view('personel.edit', compact('personel'));
    }

    public function update(Request $request, $id)
    {
        $personel = Personel::findOrFail($id);

        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'soyad' => 'required|string|max:255',
            'tc_no' => 'required|string|max:11',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adres' => 'nullable|string',
            'departman' => 'nullable|string|max:100',
            'pozisyon' => 'nullable|string|max:100',
            'maas' => 'nullable|numeric|min:0',
        ]);

        $personel->update($validated);

        return redirect()->route('personeller.show', $personel->id)
            ->with('success', 'Personel başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $personel = Personel::findOrFail($id);
        $personel->delete();

        return redirect()->route('personeller.index')
            ->with('success', 'Personel başarıyla silindi.');
    }

    public function hakedis(Request $request)
    {
        $query = Hakedis::with('personel', 'user');

        if ($request->filled('personel_id')) {
            $query->where('personel_id', $request->personel_id);
        }
        if ($request->filled('ay')) {
            $query->where('ay', $request->ay);
        }
        if ($request->filled('yil')) {
            $query->where('yil', $request->yil);
        }

        $hakedisler = $query->latest()->paginate(25);
        $personeller = Personel::all();

        return view('personel.hakedis', compact('hakedisler', 'personeller'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hat;
use App\Models\Mikrotik;

class HatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Hat::with('mikrotik');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('mikrotik_id')) {
            $query->where('mikrotik_id', $request->mikrotik_id);
        }

        $hatlar = $query->latest()->paginate(25);
        $mikrotikler = Mikrotik::all();

        return view('hatlar.index', compact('hatlar', 'mikrotikler'));
    }

    public function create()
    {
        $mikrotikler = Mikrotik::all();

        return view('hatlar.create', compact('mikrotikler'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'mikrotik_id' => 'required|exists:mikrotikler,id',
            'port' => 'nullable|string|max:50',
            'kapasite' => 'nullable|string|max:100',
            'durum' => 'required|string',
            'aciklama' => 'nullable|string',
        ]);

        Hat::create($validated);

        return redirect()->route('hatlar.index')
            ->with('success', 'Hat başarıyla eklendi.');
    }

    public function kapasite()
    {
        $hatlar = Hat::with('mikrotik')
            ->get();

        return view('hatlar.kapasite', compact('hatlar'));
    }

    public function edit($id)
    {
        $hat = Hat::findOrFail($id);
        $mikrotikler = Mikrotik::all();

        return view('hatlar.edit', compact('hat', 'mikrotikler'));
    }

    public function hatIpHatali()
    {
        $hatlar = Hat::where('ip_hatali', true)
            ->with('mikrotik')
            ->paginate(25);

        return view('hatlar.ip_hatali', compact('hatlar'));
    }
}

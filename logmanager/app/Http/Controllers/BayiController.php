<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Musteri;
use App\Models\Kasa;
use App\Models\KasaHareketi;
use App\Models\Duyuru;
use App\Models\Ticket;
use App\Models\Bolge;
use App\Models\Devre;

class BayiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bayiler = User::where('tip', 'bayi')
            ->withCount('musteriler')
            ->paginate(25);

        return view('bayi.index', compact('bayiler'));
    }

    public function create()
    {
        $bolgeler = Bolge::all();

        return view('bayi.create', compact('bolgeler'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'telefon' => 'nullable|string|max:20',
            'adres' => 'nullable|string',
            'bolge_id' => 'nullable|exists:bolgeler,id',
            'komisyon_orani' => 'nullable|numeric|min:0|max:100',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['tip'] = 'bayi';

        User::create($validated);

        return redirect()->route('bayiler.index')
            ->with('success', 'Bayi başarıyla oluşturuldu.');
    }

    public function kasaKullanici(Request $request)
    {
        $bayiId = $request->get('bayi_id', auth()->id());
        $bayi = User::findOrFail($bayiId);

        $kasalar = Kasa::where('user_id', $bayiId)->get();

        return view('bayi.kasa_kullanici', compact('bayi', 'kasalar'));
    }

    public function kasaHareket(Request $request)
    {
        $bayiId = $request->get('bayi_id', auth()->id());

        $hareketler = KasaHareketi::whereHas('kasa', function ($q) use ($bayiId) {
            $q->where('user_id', $bayiId);
        })->with('kasa')->latest()->paginate(25);

        return view('bayi.kasa_hareket', compact('hareketler', 'bayiId'));
    }

    public function bayiMusteriler(Request $request)
    {
        $bayiId = $request->get('bayi_id', auth()->id());
        $bayi = User::findOrFail($bayiId);
        $musteriler = Musteri::where('bayi_id', $bayiId)
            ->with('tarife')
            ->paginate(25);

        return view('bayi.musteriler', compact('bayi', 'musteriler'));
    }

    public function musteriTasima(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'musteri_ids' => 'required|array',
                'musteri_ids.*' => 'exists:musteriler,id',
                'hedef_bayi_id' => 'required|exists:users,id',
            ]);

            Musteri::whereIn('id', $validated['musteri_ids'])
                ->update(['bayi_id' => $validated['hedef_bayi_id']]);

            return redirect()->back()->with('success', 'Müşteriler başarıyla taşındı.');
        }

        $bayiler = User::where('tip', 'bayi')->get();

        return view('bayi.musteri_tasima', compact('bayiler'));
    }

    public function duyurular()
    {
        $duyurular = Duyuru::latest()->paginate(25);

        return view('bayi.duyurular', compact('duyurular'));
    }

    public function tickets()
    {
        $tickets = Ticket::where('user_id', auth()->id())
            ->latest()
            ->paginate(25);

        return view('bayi.tickets', compact('tickets'));
    }

    public function bolgeler()
    {
        $bolgeler = Bolge::withCount('musteriler')->get();

        return view('bayi.bolgeler', compact('bolgeler'));
    }

    public function bolgeStore(Request $request)
    {
        $validated = $request->validate([
            'ad' => 'required|string|max:255',
            'aciklama' => 'nullable|string',
        ]);

        Bolge::create($validated);

        return redirect()->route('bayiler.bolgeler')
            ->with('success', 'Bölge başarıyla oluşturuldu.');
    }

    public function yetkiAtama(Request $request)
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'yetkiler' => 'required|array',
            ]);

            $user = User::findOrFail($validated['user_id']);
            $user->update(['yetkiler' => json_encode($validated['yetkiler'])]);

            return redirect()->back()->with('success', 'Yetkiler başarıyla güncellendi.');
        }

        $bayiler = User::where('tip', 'bayi')->get();

        return view('bayi.yetki_atama', compact('bayiler'));
    }

    public function devreListesi()
    {
        $devreler = Devre::with('musteri', 'bayi')->paginate(25);

        return view('bayi.devreler', compact('devreler'));
    }

    public function kasa(Request $request)
    {
        $bayiId = $request->get('bayi_id', auth()->id());
        $kasalar = Kasa::where('user_id', $bayiId)->latest()->paginate(25);

        return view('bayi.kasa', compact('kasalar'));
    }

    public function yetkiler()
    {
        $bayiler = User::where('tip', 'bayi')->get();

        return view('bayi.yetkiler', compact('bayiler'));
    }
}

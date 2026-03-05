<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketCevap;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Ticket::with('user');

        if ($request->filled('durum')) {
            $query->where('durum', $request->durum);
        }
        if ($request->filled('oncelik')) {
            $query->where('oncelik', $request->oncelik);
        }
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $tickets = $query->latest()->paginate(25);

        return view('destek.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'konu' => 'required|string|max:255',
            'mesaj' => 'required|string',
            'oncelik' => 'required|string',
            'kategori' => 'nullable|string|max:100',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['durum'] = 'acik';

        $ticket = Ticket::create($validated);

        return redirect()->route('tickets.show', $ticket->id)
            ->with('success', 'Destek talebi başarıyla oluşturuldu.');
    }

    public function show($id)
    {
        $ticket = Ticket::with('user', 'cevaplar.user')->findOrFail($id);

        return view('destek.show', compact('ticket'));
    }

    public function cevapla(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'mesaj' => 'required|string',
        ]);

        TicketCevap::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'mesaj' => $validated['mesaj'],
        ]);

        $ticket->update(['durum' => 'cevaplandi']);

        return redirect()->route('tickets.show', $ticket->id)
            ->with('success', 'Cevabınız başarıyla gönderildi.');
    }
}

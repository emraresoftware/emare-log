<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogYazisi;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $yazilar = BlogYazisi::with('user')->latest()->paginate(25);

        return view('blog.index', compact('yazilar'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'baslik' => 'required|string|max:255',
            'icerik' => 'required|string',
            'ozet' => 'nullable|string|max:500',
            'kategori' => 'nullable|string|max:100',
            'etiketler' => 'nullable|string|max:255',
            'durum' => 'required|in:taslak,yayinda',
            'gorsel' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = \Str::slug($validated['baslik']);

        if ($validated['durum'] === 'yayinda') {
            $validated['yayin_tarihi'] = now();
        }

        BlogYazisi::create($validated);

        return redirect()->route('blog.index')
            ->with('success', 'Blog yazısı başarıyla oluşturuldu.');
    }

    public function show($id)
    {
        $yazi = BlogYazisi::with('user')->findOrFail($id);

        return view('blog.show', compact('yazi'));
    }

    public function edit($id)
    {
        $yazi = BlogYazisi::findOrFail($id);

        return view('blog.edit', compact('yazi'));
    }

    public function update(Request $request, $id)
    {
        $yazi = BlogYazisi::findOrFail($id);

        $validated = $request->validate([
            'baslik' => 'required|string|max:255',
            'icerik' => 'required|string',
            'ozet' => 'nullable|string|max:500',
            'kategori' => 'nullable|string|max:100',
            'etiketler' => 'nullable|string|max:255',
            'durum' => 'required|in:taslak,yayinda',
            'gorsel' => 'nullable|string',
        ]);

        $validated['slug'] = \Str::slug($validated['baslik']);

        if ($validated['durum'] === 'yayinda' && !$yazi->yayin_tarihi) {
            $validated['yayin_tarihi'] = now();
        }

        $yazi->update($validated);

        return redirect()->route('blog.show', $yazi->id)
            ->with('success', 'Blog yazısı başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $yazi = BlogYazisi::findOrFail($id);
        $yazi->delete();

        return redirect()->route('blog.index')
            ->with('success', 'Blog yazısı başarıyla silindi.');
    }
}

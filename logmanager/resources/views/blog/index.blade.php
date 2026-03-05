@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Blog Yazıları</h1>
        <a href="{{ route('blog.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Blog Yazısı Ekle
        </a>
    </div>

    {{-- Blog Kartları --}}
    <div class="row g-4">
        @forelse($yazilar ?? [] as $yazi)
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                @if($yazi->kapak_gorseli)
                <img src="{{ asset('storage/' . $yazi->kapak_gorseli) }}" class="card-img-top" alt="{{ $yazi->baslik }}" style="height: 200px; object-fit: cover;">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-image fa-3x text-muted"></i>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-{{ $yazi->durum == 'yayinda' ? 'success' : 'secondary' }}">
                            {{ $yazi->durum == 'yayinda' ? 'Yayında' : 'Taslak' }}
                        </span>
                        <small class="text-muted">{{ $yazi->created_at ? $yazi->created_at->format('d.m.Y') : '-' }}</small>
                    </div>
                    <h5 class="card-title">{{ $yazi->baslik }}</h5>
                    <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($yazi->icerik), 150) }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>{{ $yazi->yazar->name ?? '-' }}
                        </small>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('blog.edit', $yazi->id) }}" class="btn btn-warning" title="Düzenle">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('blog.destroy', $yazi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu yazıyı silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" title="Sil"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center text-muted py-5">
                <i class="fas fa-newspaper fa-3x mb-3 d-block"></i>
                Henüz blog yazısı bulunmamaktadır.
            </div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if(isset($yazilar) && $yazilar->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $yazilar->links() }}
    </div>
    @endif
</div>
@endsection

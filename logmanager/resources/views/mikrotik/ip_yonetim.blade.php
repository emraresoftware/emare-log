@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">IP Yönetim</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-project-diagram text-primary me-2"></i>IP Yönetimi</h1>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ipEkleModal">
                <i class="fas fa-plus me-1"></i> IP Ekle
            </button>
            <a href="{{ route('mikrotik.ip.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> IP Listesi
            </a>
        </div>
    </div>

    {{-- Toplu IP Ekleme Kartı --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0"><i class="fas fa-layer-group me-2"></i>Toplu IP Ekleme</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('mikrotik.ip_yonetim') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Başlangıç IP <span class="text-danger">*</span></label>
                        <input type="text" name="ip_baslangic" class="form-control" placeholder="10.0.0.1" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bitiş IP <span class="text-danger">*</span></label>
                        <input type="text" name="ip_bitis" class="form-control" placeholder="10.0.0.254" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Subnet</label>
                        <select name="subnet" class="form-select">
                            <option value="/24">/24 (255.255.255.0)</option>
                            <option value="/25">/25 (255.255.255.128)</option>
                            <option value="/26">/26 (255.255.255.192)</option>
                            <option value="/27">/27 (255.255.255.224)</option>
                            <option value="/28">/28 (255.255.255.240)</option>
                            <option value="/29">/29 (255.255.255.248)</option>
                            <option value="/30">/30 (255.255.255.252)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tip <span class="text-danger">*</span></label>
                        <select name="tip" class="form-select" required>
                            <option value="dinamik">Dinamik</option>
                            <option value="statik">Statik</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus-circle me-1"></i> Toplu Ekle
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Mevcut IP Blokları --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0"><i class="fas fa-th me-2"></i>Mevcut IP Adresleri</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="ipYonetimTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>IP Adresi</th>
                            <th>Subnet</th>
                            <th>Atanan Müşteri</th>
                            <th>Tip</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ipler = \App\Models\IpAdresi::with('musteri', 'mikrotik')->orderBy('ip_adresi')->limit(100)->get();
                        @endphp
                        @forelse($ipler as $ip)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $ip->id }}</span></td>
                            <td><code>{{ $ip->ip_adresi }}</code></td>
                            <td>{{ $ip->subnet ?? '-' }}</td>
                            <td>
                                @if($ip->musteri)
                                    <a href="{{ route('musteri.show', $ip->musteri->id) }}">
                                        {{ $ip->musteri->isim }} {{ $ip->musteri->soyisim }}
                                    </a>
                                @else
                                    <span class="text-muted">Atanmamış</span>
                                @endif
                            </td>
                            <td>
                                @if($ip->statik)
                                    <span class="badge bg-info">Statik</span>
                                @else
                                    <span class="badge bg-secondary">Dinamik</span>
                                @endif
                            </td>
                            <td>
                                @if($ip->durum == 'bos')
                                    <span class="badge bg-success">Boş</span>
                                @elseif($ip->durum == 'kullaniliyor')
                                    <span class="badge bg-primary">Kullanılıyor</span>
                                @else
                                    <span class="badge bg-warning text-dark">Rezerve</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="Sil">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Tekli IP Ekle Modal --}}
<div class="modal fade" id="ipEkleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('mikrotik.ip_yonetim') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-globe me-2"></i>IP Adresi Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">IP Adresi <span class="text-danger">*</span></label>
                            <input type="text" name="ip_adresi" class="form-control" placeholder="10.0.0.1" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tip <span class="text-danger">*</span></label>
                            <select name="tip" class="form-select" required>
                                <option value="dinamik">Dinamik</option>
                                <option value="statik">Statik</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Durum <span class="text-danger">*</span></label>
                            <select name="durum" class="form-select" required>
                                <option value="bos">Boş</option>
                                <option value="rezerve">Rezerve</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Müşteri</label>
                            <select name="musteri_id" class="form-select select2">
                                <option value="">Atanmamış</option>
                                @foreach($musteriler ?? [] as $musteri)
                                    <option value="{{ $musteri->id }}">{{ $musteri->abone_no }} - {{ $musteri->isim }} {{ $musteri->soyisim }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Açıklama</label>
                            <textarea name="aciklama" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#ipYonetimTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[1, 'asc']],
        pageLength: 50
    });
    $('.select2').select2({ theme: 'bootstrap-5', placeholder: 'Müşteri Seçin', allowClear: true, dropdownParent: $('#ipEkleModal') });
});
</script>
@endpush
@endsection

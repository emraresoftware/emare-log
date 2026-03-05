@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">IP Listesi</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">IP Listesi</h1>
    </div>

    {{-- Filtreler --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('ip.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Mikrotik</label>
                    <select name="mikrotik_id" class="form-select">
                        <option value="">Tümü</option>
                        @foreach($mikrotikler ?? [] as $mikrotik)
                            <option value="{{ $mikrotik->id }}" {{ request('mikrotik_id') == $mikrotik->id ? 'selected' : '' }}>
                                {{ $mikrotik->ad }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hat</label>
                    <select name="hat_id" class="form-select">
                        <option value="">Tümü</option>
                        @foreach($hatlar ?? [] as $hat)
                            <option value="{{ $hat->id }}" {{ request('hat_id') == $hat->id ? 'selected' : '' }}>
                                {{ $hat->ad }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Durum</label>
                    <select name="durum" class="form-select">
                        <option value="">Tümü</option>
                        <option value="bos" {{ request('durum') == 'bos' ? 'selected' : '' }}>Boş</option>
                        <option value="kullaniliyor" {{ request('durum') == 'kullaniliyor' ? 'selected' : '' }}>Kullanılıyor</option>
                        <option value="rezerve" {{ request('durum') == 'rezerve' ? 'selected' : '' }}>Rezerve</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('ip.index') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-undo me-1"></i> Sıfırla</a>
                </div>
            </form>
        </div>
    </div>

    {{-- IP Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="ipTable">
                    <thead class="table-light">
                        <tr>
                            <th>IP Adresi</th>
                            <th>Mikrotik</th>
                            <th>Hat</th>
                            <th>Müşteri</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ipler ?? [] as $ip)
                        <tr>
                            <td><code>{{ $ip->ip_adresi }}</code></td>
                            <td>{{ $ip->mikrotik->ad ?? '-' }}</td>
                            <td>{{ $ip->hat->ad ?? '-' }}</td>
                            <td>{{ $ip->musteri->ad_soyad ?? '-' }}</td>
                            <td>
                                @if($ip->durum == 'bos')
                                    <span class="badge bg-success">Boş</span>
                                @elseif($ip->durum == 'kullaniliyor')
                                    <span class="badge bg-primary">Kullanılıyor</span>
                                @elseif($ip->durum == 'rezerve')
                                    <span class="badge bg-warning text-dark">Rezerve</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if($ip->durum == 'bos')
                                    <button type="button" class="btn btn-outline-warning" onclick="ipRezerveEt({{ $ip->id }})" title="Rezerve Et">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                    @endif
                                    @if($ip->durum == 'rezerve')
                                    <button type="button" class="btn btn-outline-success" onclick="ipSerbestBirak({{ $ip->id }})" title="Serbest Bırak">
                                        <i class="fas fa-unlock"></i>
                                    </button>
                                    @endif
                                    @if($ip->durum == 'kullaniliyor')
                                    <a href="{{ route('musteri.show', $ip->musteri_id ?? 0) }}" class="btn btn-outline-info" title="Müşteri Detay">
                                        <i class="fas fa-user"></i>
                                    </a>
                                    @endif
                                    <button type="button" class="btn btn-outline-primary" onclick="ipDuzenle({{ $ip->id }})" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($ipler) && $ipler->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $ipler->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#ipTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[0, 'asc']],
            pageLength: 50
        });
    });

    function ipRezerveEt(ipId) {
        if (confirm('Bu IP adresini rezerve etmek istediğinize emin misiniz?')) {
            $.post('/ip/' + ipId + '/rezerve', {_token: '{{ csrf_token() }}'}, function(response) {
                if (response.success) {
                    toastr.success('IP adresi rezerve edildi.');
                    location.reload();
                } else {
                    toastr.error(response.message || 'Bir hata oluştu.');
                }
            }).fail(function() {
                toastr.error('İşlem sırasında bir hata oluştu.');
            });
        }
    }

    function ipSerbestBirak(ipId) {
        if (confirm('Bu IP adresini serbest bırakmak istediğinize emin misiniz?')) {
            $.post('/ip/' + ipId + '/serbest', {_token: '{{ csrf_token() }}'}, function(response) {
                if (response.success) {
                    toastr.success('IP adresi serbest bırakıldı.');
                    location.reload();
                } else {
                    toastr.error(response.message || 'Bir hata oluştu.');
                }
            }).fail(function() {
                toastr.error('İşlem sırasında bir hata oluştu.');
            });
        }
    }

    function ipDuzenle(ipId) {
        window.location.href = '/ip/' + ipId + '/duzenle';
    }
</script>
@endpush
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fatura.index') }}">Faturalar</a></li>
            <li class="breadcrumb-item active">Fatura Tahsilat</li>
        </ol>
    </nav>

    <h1 class="h3 mb-4">Fatura Tahsilat</h1>

    {{-- Filtreler --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('fatura.tahsilat') }}" class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Başlangıç Tarihi</label>
                    <input type="date" name="baslangic" class="form-control" value="{{ request('baslangic') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bitiş Tarihi</label>
                    <input type="date" name="bitis" class="form-control" value="{{ request('bitis') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bölge</label>
                    <select name="bolge_id" class="form-select">
                        <option value="">Tümü</option>
                        @foreach($bolgeler ?? [] as $bolge)
                            <option value="{{ $bolge->id }}" {{ request('bolge_id') == $bolge->id ? 'selected' : '' }}>{{ $bolge->ad }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Personel</label>
                    <select name="personel_id" class="form-select">
                        <option value="">Tümü</option>
                        @foreach($personeller ?? [] as $personel)
                            <option value="{{ $personel->id }}" {{ request('personel_id') == $personel->id ? 'selected' : '' }}>{{ $personel->ad_soyad }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filtrele</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('fatura.tahsilat') }}" class="btn btn-outline-secondary w-100"><i class="fas fa-undo me-1"></i> Sıfırla</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tahsilat Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tahsilatTable">
                    <thead class="table-light">
                        <tr>
                            <th>Müşteri</th>
                            <th>Fatura No</th>
                            <th>Tutar</th>
                            <th>Ödenen</th>
                            <th>Kalan</th>
                            <th>Tahsilat Tarihi</th>
                            <th>Tahsilatçı</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tahsilatlar ?? [] as $tahsilat)
                        <tr>
                            <td>{{ $tahsilat->musteri->ad_soyad ?? '-' }}</td>
                            <td><strong>{{ $tahsilat->fatura_no }}</strong></td>
                            <td>₺{{ number_format($tahsilat->tutar, 2, ',', '.') }}</td>
                            <td class="text-success">₺{{ number_format($tahsilat->odenen, 2, ',', '.') }}</td>
                            <td class="text-danger">₺{{ number_format($tahsilat->kalan, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($tahsilat->tahsilat_tarihi)->format('d.m.Y H:i') }}</td>
                            <td>{{ $tahsilat->tahsilatci->ad_soyad ?? '-' }}</td>
                        </tr>
                        @empty
                    @endforelse
                    </tbody>
                    @if(isset($tahsilatlar) && count($tahsilatlar) > 0)
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="2" class="text-end">Toplam:</td>
                            <td>₺{{ number_format($toplamTutar ?? 0, 2, ',', '.') }}</td>
                            <td class="text-success">₺{{ number_format($toplamOdenen ?? 0, 2, ',', '.') }}</td>
                            <td class="text-danger">₺{{ number_format($toplamKalan ?? 0, 2, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            @if(isset($tahsilatlar) && $tahsilatlar->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $tahsilatlar->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tahsilatTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[5, 'desc']],
            pageLength: 25
        });
    });
</script>
@endpush
@endsection

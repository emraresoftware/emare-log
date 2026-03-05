@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">Hat Listesi</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Hat Listesi</h1>
        <a href="{{ route('hat.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Hat Ekle
        </a>
    </div>

    {{-- Hat Tablosu --}}
    <div class="table-card card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="hatlarTable">
                    <thead class="table-light">
                        <tr>
                            <th>Hat Adı</th>
                            <th>Mikrotik</th>
                            <th>Kapasite</th>
                            <th>Kullanılan</th>
                            <th>Boş</th>
                            <th>Doluluk (%)</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hatlar ?? [] as $hat)
                        @php
                            $doluluk = $hat->kapasite > 0 ? round(($hat->kullanilan / $hat->kapasite) * 100, 1) : 0;
                            $bos = $hat->kapasite - $hat->kullanilan;
                            $barClass = $doluluk > 90 ? 'bg-danger' : ($doluluk > 70 ? 'bg-warning' : 'bg-success');
                        @endphp
                        <tr>
                            <td><strong>{{ $hat->ad }}</strong></td>
                            <td>{{ $hat->mikrotik->ad ?? '-' }}</td>
                            <td>{{ $hat->kapasite }}</td>
                            <td>{{ $hat->kullanilan }}</td>
                            <td>{{ $bos }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                        <div class="progress-bar {{ $barClass }}" style="width: {{ $doluluk }}%"></div>
                                    </div>
                                    <span class="fw-bold" style="min-width: 45px;">%{{ $doluluk }}</span>
                                </div>
                            </td>
                            <td>
                                @if($hat->durum == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('hat.edit', $hat->id) }}" class="btn btn-outline-primary" title="Düzenle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" onclick="hatSil({{ $hat->id }})" title="Sil">
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

{{-- Silme Onay Modal --}}
<div class="modal fade" id="silModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hat Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="silForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Bu hattı silmek istediğinize emin misiniz?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" class="btn btn-danger">Sil</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#hatlarTable').DataTable({
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
            order: [[0, 'asc']],
            pageLength: 25
        });
    });

    function hatSil(hatId) {
        $('#silForm').attr('action', '/hatlar/' + hatId);
        new bootstrap.Modal(document.getElementById('silModal')).show();
    }
</script>
@endpush
@endsection

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Evrak Yönetimi</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#evrakYukleModal">
            <i class="fas fa-upload me-1"></i> Evrak Yükle
        </button>
    </div>

    {{-- Evrak Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="evrakTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Evrak Adı</th>
                        <th>Müşteri</th>
                        <th>Tip</th>
                        <th>Yükleme Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evraklar ?? [] as $evrak)
                    <tr>
                        <td>
                            <i class="fas fa-file-alt text-primary me-1"></i>
                            {{ $evrak->ad }}
                        </td>
                        <td>{{ $evrak->musteri->ad_soyad ?? '-' }}</td>
                        <td>
                            @php
                                $tipRenk = match($evrak->tip) {
                                    'sozlesme' => 'primary',
                                    'kimlik' => 'info',
                                    'dilekce' => 'warning',
                                    default => 'secondary'
                                };
                                $tipMetin = match($evrak->tip) {
                                    'sozlesme' => 'Sözleşme',
                                    'kimlik' => 'Kimlik',
                                    'dilekce' => 'Dilekçe',
                                    'diger' => 'Diğer',
                                    default => $evrak->tip
                                };
                            @endphp
                            <span class="badge bg-{{ $tipRenk }}">{{ $tipMetin }}</span>
                        </td>
                        <td>{{ $evrak->created_at ? $evrak->created_at->format('d.m.Y H:i') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $evrak->durum ? 'success' : 'secondary' }}">
                                {{ $evrak->durum ? 'Aktif' : 'Arşiv' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('evrak.download', $evrak->id) }}" class="btn btn-success" title="İndir">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="{{ route('evrak.show', $evrak->id) }}" class="btn btn-info" title="Görüntüle" target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('evrak.destroy', $evrak->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu evrakı silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" title="Sil"><i class="fas fa-trash"></i></button>
                                </form>
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

{{-- Evrak Yükle Modal --}}
<div class="modal fade" id="evrakYukleModal" tabindex="-1" aria-labelledby="evrakYukleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('evrak.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="evrakYukleModalLabel">Evrak Yükle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ev_musteri" class="form-label">Müşteri <span class="text-danger">*</span></label>
                        <select class="form-select select2" id="ev_musteri" name="musteri_id" required>
                            <option value="">Müşteri seçiniz</option>
                            @foreach($musteriler ?? [] as $musteri)
                            <option value="{{ $musteri->id }}">{{ $musteri->ad_soyad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ev_tip" class="form-label">Evrak Tipi <span class="text-danger">*</span></label>
                        <select class="form-select" id="ev_tip" name="tip" required>
                            <option value="">Seçiniz</option>
                            <option value="sozlesme">Sözleşme</option>
                            <option value="kimlik">Kimlik</option>
                            <option value="dilekce">Dilekçe</option>
                            <option value="diger">Diğer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ev_dosya" class="form-label">Dosya <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="ev_dosya" name="dosya" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <div class="form-text">Kabul edilen formatlar: PDF, JPG, PNG, DOC, DOCX (Maks. 10MB)</div>
                    </div>
                    <div class="mb-3">
                        <label for="ev_aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="ev_aciklama" name="aciklama" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-1"></i> Yükle</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#evrakTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[3, 'desc']],
        responsive: true
    });
    $('.select2').select2({ theme: 'bootstrap-5', dropdownParent: $('#evrakYukleModal') });
});
</script>
@endpush

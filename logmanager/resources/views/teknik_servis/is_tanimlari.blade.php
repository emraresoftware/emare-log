@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">İş Tanımları</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#isTanimiEkleModal">
            <i class="fas fa-plus me-1"></i> İş Tanımı Ekle
        </button>
    </div>

    {{-- İş Tanımları Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="isTanimlariTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>İş Tanımı Adı</th>
                        <th>Açıklama</th>
                        <th>Ortalama Süre</th>
                        <th>Ücret (₺)</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($isTanimlari ?? [] as $isTanimi)
                    <tr>
                        <td class="fw-bold">{{ $isTanimi->ad }}</td>
                        <td>{{ Str::limit($isTanimi->aciklama, 60) }}</td>
                        <td>{{ $isTanimi->tahmini_sure ? $isTanimi->tahmini_sure . ' dk' : '-' }}</td>
                        <td class="fw-bold">₺{{ number_format($isTanimi->ucret ?? 0, 2, ',', '.') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-warning btn-duzenle"
                                    data-id="{{ $isTanimi->id }}"
                                    data-ad="{{ $isTanimi->ad }}"
                                    data-aciklama="{{ $isTanimi->aciklama }}"
                                    data-sure="{{ $isTanimi->tahmini_sure }}"
                                    data-ucret="{{ $isTanimi->ucret }}"
                                    title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('is_tanimi.destroy', $isTanimi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu iş tanımını silmek istediğinize emin misiniz?')">
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

{{-- İş Tanımı Ekle Modal --}}
<div class="modal fade" id="isTanimiEkleModal" tabindex="-1" aria-labelledby="isTanimiEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('is_tanimi.store') }}" method="POST" id="isTanimiForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="isTanimiEkleModalLabel">İş Tanımı Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="it_ad" class="form-label">Ad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="it_ad" name="ad" required>
                    </div>
                    <div class="mb-3">
                        <label for="it_aciklama" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="it_aciklama" name="aciklama" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="it_sure" class="form-label">Tahmini Süre (dk)</label>
                        <input type="number" class="form-control" id="it_sure" name="tahmini_sure" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="it_ucret" class="form-label">Ücret (₺)</label>
                        <input type="number" step="0.01" class="form-control" id="it_ucret" name="ucret" value="0.00">
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#isTanimlariTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        responsive: true
    });

    // Düzenle
    $(document).on('click', '.btn-duzenle', function() {
        var id = $(this).data('id');
        $('#it_ad').val($(this).data('ad'));
        $('#it_aciklama').val($(this).data('aciklama'));
        $('#it_sure').val($(this).data('sure'));
        $('#it_ucret').val($(this).data('ucret'));
        $('#isTanimiForm').attr('action', '/is-tanimi/' + id);
        if (!$('#isTanimiForm input[name="_method"]').length) {
            $('#isTanimiForm').append('<input type="hidden" name="_method" value="PUT">');
        }
        $('#isTanimiEkleModalLabel').text('İş Tanımı Düzenle');
        $('#isTanimiEkleModal').modal('show');
    });

    $('#isTanimiEkleModal').on('hidden.bs.modal', function() {
        $('#isTanimiForm')[0].reset();
        $('#isTanimiForm').attr('action', '{{ route("is_tanimi.store") }}');
        $('#isTanimiForm input[name="_method"]').remove();
        $('#isTanimiEkleModalLabel').text('İş Tanımı Ekle');
    });
});
</script>
@endpush

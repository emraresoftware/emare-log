@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Teknik Destek / Ticket</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ticketEkleModal">
            <i class="fas fa-plus me-1"></i> Ticket Aç
        </button>
    </div>

    {{-- Ticket Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="ticketTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Ticket No</th>
                        <th>Konu</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th>Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ticketlar ?? [] as $ticket)
                    <tr>
                        <td><strong>#{{ $ticket->ticket_no }}</strong></td>
                        <td>{{ $ticket->konu }}</td>
                        <td>
                            @php
                                $oncelikRenk = match($ticket->oncelik) {
                                    'dusuk' => 'secondary',
                                    'normal' => 'info',
                                    'yuksek' => 'warning',
                                    'acil' => 'danger',
                                    default => 'dark'
                                };
                                $oncelikMetin = match($ticket->oncelik) {
                                    'dusuk' => 'Düşük',
                                    'normal' => 'Normal',
                                    'yuksek' => 'Yüksek',
                                    'acil' => 'Acil',
                                    default => $ticket->oncelik
                                };
                            @endphp
                            <span class="badge bg-{{ $oncelikRenk }}">{{ $oncelikMetin }}</span>
                        </td>
                        <td>
                            @php
                                $durumRenk = match($ticket->durum) {
                                    'acik' => 'warning',
                                    'yanitlandi' => 'info',
                                    'kapatildi' => 'success',
                                    default => 'secondary'
                                };
                                $durumMetin = match($ticket->durum) {
                                    'acik' => 'Açık',
                                    'yanitlandi' => 'Yanıtlandı',
                                    'kapatildi' => 'Kapatıldı',
                                    default => $ticket->durum
                                };
                            @endphp
                            <span class="badge bg-{{ $durumRenk }}">{{ $durumMetin }}</span>
                        </td>
                        <td>{{ $ticket->created_at ? $ticket->created_at->format('d.m.Y H:i') : '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('destek.show', $ticket->id) }}" class="btn btn-info" title="Detay / Yanıtla">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($ticket->durum != 'kapatildi')
                                <form action="{{ route('destek.kapat', $ticket->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success" title="Kapat"><i class="fas fa-check"></i></button>
                                </form>
                                @endif
                                <form action="{{ route('destek.destroy', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu ticket\'ı silmek istediğinize emin misiniz?')">
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

{{-- Ticket Aç Modal --}}
<div class="modal fade" id="ticketEkleModal" tabindex="-1" aria-labelledby="ticketEkleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('destek.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="ticketEkleModalLabel">Yeni Ticket Aç</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tk_konu" class="form-label">Konu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tk_konu" name="konu" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="tk_kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="tk_kategori" name="kategori">
                                <option value="">Seçiniz</option>
                                <option value="genel">Genel</option>
                                <option value="teknik">Teknik</option>
                                <option value="fatura">Fatura</option>
                                <option value="baglanti">Bağlantı</option>
                                <option value="diger">Diğer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tk_oncelik" class="form-label">Öncelik</label>
                            <select class="form-select" id="tk_oncelik" name="oncelik">
                                <option value="dusuk">Düşük</option>
                                <option value="normal" selected>Normal</option>
                                <option value="yuksek">Yüksek</option>
                                <option value="acil">Acil</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tk_mesaj" class="form-label">Mesaj <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="tk_mesaj" name="mesaj" rows="6" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#ticketTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush

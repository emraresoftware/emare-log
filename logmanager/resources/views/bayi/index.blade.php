@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Bölge / Kullanıcı Listesi</h1>
        <a href="{{ route('bayi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Kullanıcı Ekle
        </a>
    </div>

    {{-- Kullanıcı Tablosu --}}
    <div class="table-card card shadow-sm">
        <div class="card-body">
            <table id="bayiTable" class="table table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Kullanıcı Adı</th>
                        <th>Ad Soyad</th>
                        <th>Bölge</th>
                        <th>Rol</th>
                        <th>Müşteri Sayısı</th>
                        <th>Son Giriş</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kullanicilar ?? [] as $kullanici)
                    <tr>
                        <td><strong>{{ $kullanici->username }}</strong></td>
                        <td>{{ $kullanici->name }}</td>
                        <td>{{ $kullanici->bolge->ad ?? '-' }}</td>
                        <td>
                            @php
                                $rolRenk = match($kullanici->rol) {
                                    'admin' => 'danger',
                                    'bayi' => 'primary',
                                    'personel' => 'info',
                                    'tekniker' => 'warning',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $rolRenk }}">{{ ucfirst($kullanici->rol) }}</span>
                        </td>
                        <td>{{ $kullanici->musteriler_count ?? 0 }}</td>
                        <td>{{ $kullanici->last_login_at ? $kullanici->last_login_at->format('d.m.Y H:i') : '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $kullanici->durum ? 'success' : 'secondary' }}">
                                {{ $kullanici->durum ? 'Aktif' : 'Pasif' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('bayi.edit', $kullanici->id) }}" class="btn btn-warning" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('bayi.yetkiler', $kullanici->id) }}" class="btn btn-info" title="Yetkiler">
                                    <i class="fas fa-shield-alt"></i>
                                </a>
                                <a href="{{ route('bayi.kasa', $kullanici->id) }}" class="btn btn-success" title="Kasa">
                                    <i class="fas fa-wallet"></i>
                                </a>
                                <a href="{{ route('bayi.musteriler', $kullanici->id) }}" class="btn btn-primary" title="Müşterileri Gör">
                                    <i class="fas fa-users"></i>
                                </a>
                                <form action="{{ route('bayi.destroy', $kullanici->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?')">
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#bayiTable').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json' },
        order: [[0, 'asc']],
        responsive: true
    });
});
</script>
@endpush

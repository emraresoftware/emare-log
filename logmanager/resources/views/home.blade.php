@extends('layouts.app')

@section('title', 'Anasayfa')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h4><i class="fas fa-home me-2 text-muted"></i>Dashboard</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Anasayfa</li>
            </ol>
        </nav>
    </div>
    <div>
        <span class="text-muted fs-13"><i class="fas fa-calendar-alt me-1"></i>{{ now()->translatedFormat('d F Y, l') }}</span>
    </div>
</div>

<!-- ===================== TOP STATS ROW ===================== -->
<div class="row g-3 mb-4">
    <!-- Toplam Müşteri -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Toplam Müşteri</div>
                        <div class="stat-value">{{ number_format($toplamMusteri ?? 0) }}</div>
                    </div>
                    <div class="stat-icon" style="background: rgba(52,152,219,0.1); color: #3498db;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="mt-2 fs-12 text-muted">
                    <i class="fas fa-info-circle me-1"></i>Kayıtlı tüm müşteriler
                </div>
            </div>
        </div>
    </div>

    <!-- Aktif Müşteri -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Aktif Müşteri</div>
                        <div class="stat-value" style="color: #27ae60;">{{ number_format($aktifMusteri ?? 0) }}</div>
                    </div>
                    <div class="stat-icon" style="background: rgba(39,174,96,0.1); color: #27ae60;">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
                <div class="mt-2 fs-12 text-muted">
                    <i class="fas fa-arrow-up text-success me-1"></i>Aktif abonelikler
                </div>
            </div>
        </div>
    </div>

    <!-- Aylık Gelir -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Aylık Gelir</div>
                        <div class="stat-value" style="color: #f39c12;">{{ number_format($aylikGelir ?? 0, 2, ',', '.') }} ₺</div>
                    </div>
                    <div class="stat-icon" style="background: rgba(243,156,18,0.1); color: #f39c12;">
                        <i class="fas fa-turkish-lira-sign"></i>
                    </div>
                </div>
                <div class="mt-2 fs-12 text-muted">
                    <i class="fas fa-chart-line text-warning me-1"></i>Bu ayki toplam tahsilat
                </div>
            </div>
        </div>
    </div>

    <!-- Açık İş Emri -->
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="stat-label">Açık İş Emri</div>
                        <div class="stat-value" style="color: #e74c3c;">{{ number_format($acikIsEmri ?? 0) }}</div>
                    </div>
                    <div class="stat-icon" style="background: rgba(231,76,60,0.1); color: #e74c3c;">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                </div>
                <div class="mt-2 fs-12 text-muted">
                    <i class="fas fa-exclamation-circle text-danger me-1"></i>Bekleyen iş emirleri
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== QUICK STATUS CARDS ===================== -->
<div class="row g-3 mb-4">
    <!-- Row 1 -->
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #17a2b8 !important;">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;background:rgba(23,162,184,0.1);">
                        <i class="fas fa-exchange-alt text-info fs-13"></i>
                    </div>
                    <div>
                        <div class="fs-11 text-muted">Tarife Geçiş Talebi</div>
                        <div class="fw-bold">{{ $tarifeGecis ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #f39c12 !important;">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;background:rgba(243,156,18,0.1);">
                        <i class="fas fa-file-signature text-warning fs-13"></i>
                    </div>
                    <div>
                        <div class="fs-11 text-muted">Müşteri Başvuruları</div>
                        <div class="fw-bold">{{ $musteriBasvurulari ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #3498db !important;">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;background:rgba(52,152,219,0.1);">
                        <i class="fas fa-hourglass-half text-primary fs-13"></i>
                    </div>
                    <div>
                        <div class="fs-11 text-muted">Onay Bekleyen</div>
                        <div class="fw-bold">{{ $onayBekleyen ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2 -->
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #27ae60 !important;">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;background:rgba(39,174,96,0.1);">
                        <i class="fas fa-money-bill-transfer text-success fs-13"></i>
                    </div>
                    <div>
                        <div class="fs-11 text-muted">Havale Bildirimleri</div>
                        <div class="fw-bold">{{ $havaleBildirimleri ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #6c757d !important;">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;background:rgba(108,117,125,0.1);">
                        <i class="fas fa-user-slash text-secondary fs-13"></i>
                    </div>
                    <div>
                        <div class="fs-11 text-muted">Pasif Müşteriler</div>
                        <div class="fw-bold">{{ $pasifMusteriler ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="card border-0 shadow-sm" style="border-left: 4px solid #e74c3c !important;">
            <div class="card-body py-3 px-3">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-2" style="width:36px;height:36px;background:rgba(231,76,60,0.1);">
                        <i class="fas fa-user-xmark text-danger fs-13"></i>
                    </div>
                    <div>
                        <div class="fs-11 text-muted">İptal Edilen</div>
                        <div class="fw-bold">{{ $iptalEdilen ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== CHARTS ROW ===================== -->
<div class="row g-3 mb-4">
    <!-- Aylık Tahsilat Grafiği -->
    <div class="col-xl-8">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fas fa-chart-line me-2 text-primary"></i>Aylık Tahsilat Grafiği</span>
                <span class="badge bg-light text-dark fs-11">{{ date('Y') }}</span>
            </div>
            <div class="card-body">
                <canvas id="tahsilatChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Müşteri Durumları -->
    <div class="col-xl-4">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fas fa-chart-pie me-2 text-info"></i>Müşteri Durumları</span>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="musteriDurumChart" height="220"></canvas>
            </div>
            <div class="card-footer bg-white border-top-0 pb-3">
                <div class="row text-center fs-12">
                    <div class="col-3">
                        <span class="d-inline-block rounded-circle me-1" style="width:10px;height:10px;background:#27ae60;"></span>
                        Aktif
                    </div>
                    <div class="col-3">
                        <span class="d-inline-block rounded-circle me-1" style="width:10px;height:10px;background:#e74c3c;"></span>
                        Pasif
                    </div>
                    <div class="col-3">
                        <span class="d-inline-block rounded-circle me-1" style="width:10px;height:10px;background:#f39c12;"></span>
                        İptal
                    </div>
                    <div class="col-3">
                        <span class="d-inline-block rounded-circle me-1" style="width:10px;height:10px;background:#3498db;"></span>
                        Dondurulmuş
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== TABLES ROW ===================== -->
<div class="row g-3 mb-4">
    <!-- Son İş Emirleri -->
    <div class="col-xl-6">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fas fa-clipboard-list me-2 text-warning"></i>Son İş Emirleri</span>
                <a href="#" class="btn btn-sm btn-outline-primary fs-12">Tümünü Gör</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Müşteri</th>
                                <th>İş Tanımı</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sonIsEmirleri ?? [] as $isEmri)
                            <tr>
                                <td class="fw-semibold">{{ $isEmri->id }}</td>
                                <td>{{ $isEmri->musteri->ad_soyad ?? '-' }}</td>
                                <td>{{ $isEmri->is_tanimi ?? '-' }}</td>
                                <td>
                                    @switch($isEmri->durum ?? '')
                                        @case('Açık')
                                            <span class="badge bg-warning text-dark">Açık</span>
                                            @break
                                        @case('Tamamlandı')
                                            <span class="badge bg-success">Tamamlandı</span>
                                            @break
                                        @case('Beklemede')
                                            <span class="badge bg-info">Beklemede</span>
                                            @break
                                        @case('İptal')
                                            <span class="badge bg-danger">İptal</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $isEmri->durum ?? '-' }}</span>
                                    @endswitch
                                </td>
                                <td class="fs-12 text-muted">{{ $isEmri->created_at ? $isEmri->created_at->format('d.m.Y H:i') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Henüz iş emri bulunmuyor
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Son Faturalar -->
    <div class="col-xl-6">
        <div class="card table-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fas fa-file-invoice-dollar me-2 text-success"></i>Son Faturalar</span>
                <a href="#" class="btn btn-sm btn-outline-primary fs-12">Tümünü Gör</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Müşteri</th>
                                <th>Tutar</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sonFaturalar ?? [] as $fatura)
                            <tr>
                                <td class="fw-semibold">{{ $fatura->id }}</td>
                                <td>{{ $fatura->musteri->ad_soyad ?? '-' }}</td>
                                <td class="fw-semibold">{{ number_format($fatura->tutar ?? 0, 2, ',', '.') }} ₺</td>
                                <td>
                                    @switch($fatura->durum ?? '')
                                        @case('Ödendi')
                                            <span class="badge bg-success">Ödendi</span>
                                            @break
                                        @case('Ödenmedi')
                                            <span class="badge bg-danger">Ödenmedi</span>
                                            @break
                                        @case('Kısmi')
                                            <span class="badge bg-warning text-dark">Kısmi</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $fatura->durum ?? '-' }}</span>
                                    @endswitch
                                </td>
                                <td class="fs-12 text-muted">{{ $fatura->created_at ? $fatura->created_at->format('d.m.Y') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Henüz fatura bulunmuyor
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===================== SYSTEM INFO ROW ===================== -->
<div class="row g-3 mb-4">
    <!-- Disk Kullanımı -->
    <div class="col-xl-3 col-md-6">
        <div class="card table-card h-100">
            <div class="card-header">
                <i class="fas fa-hdd me-2 text-info"></i>Disk Kullanımı
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                @php
                    $diskTotal = disk_total_space('/');
                    $diskFree = disk_free_space('/');
                    $diskUsed = $diskTotal - $diskFree;
                    $diskPercent = $diskTotal > 0 ? round(($diskUsed / $diskTotal) * 100) : 0;
                @endphp
                <div class="position-relative d-inline-flex align-items-center justify-content-center mb-3">
                    <svg width="120" height="120" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="52" fill="none" stroke="#e9ecef" stroke-width="10"/>
                        <circle cx="60" cy="60" r="52" fill="none"
                                stroke="{{ $diskPercent > 85 ? '#e74c3c' : ($diskPercent > 60 ? '#f39c12' : '#27ae60') }}"
                                stroke-width="10"
                                stroke-dasharray="{{ 2 * 3.14159 * 52 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 52 * (1 - $diskPercent / 100) }}"
                                stroke-linecap="round"
                                transform="rotate(-90 60 60)"/>
                    </svg>
                    <div class="position-absolute text-center">
                        <div class="fw-bold fs-4">%{{ $diskPercent }}</div>
                        <div class="fs-11 text-muted">Kullanılan</div>
                    </div>
                </div>
                <div class="text-center fs-12 text-muted">
                    {{ number_format($diskUsed / 1073741824, 1) }} GB / {{ number_format($diskTotal / 1073741824, 1) }} GB
                </div>
            </div>
        </div>
    </div>

    <!-- Sistem Bilgileri -->
    <div class="col-xl-4 col-md-6">
        <div class="card table-card h-100">
            <div class="card-header">
                <i class="fas fa-server me-2 text-primary"></i>Sistem Bilgileri
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush fs-13">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                        <span class="text-muted"><i class="fab fa-php me-2"></i>PHP Sürümü</span>
                        <span class="fw-semibold">{{ phpversion() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                        <span class="text-muted"><i class="fab fa-laravel me-2"></i>Laravel Sürümü</span>
                        <span class="fw-semibold">{{ app()->version() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                        <span class="text-muted"><i class="fas fa-database me-2"></i>Veritabanı</span>
                        <span class="fw-semibold">{{ config('database.default') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                        <span class="text-muted"><i class="fas fa-clock me-2"></i>Sunucu Saati</span>
                        <span class="fw-semibold">{{ now()->format('H:i:s') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                        <span class="text-muted"><i class="fas fa-memory me-2"></i>Bellek Kullanımı</span>
                        <span class="fw-semibold">{{ number_format(memory_get_usage(true) / 1048576, 1) }} MB</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                        <span class="text-muted"><i class="fas fa-globe me-2"></i>Ortam</span>
                        <span class="badge {{ app()->environment('production') ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ app()->environment() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                        <span class="text-muted"><i class="fas fa-shield-halved me-2"></i>Cache Driver</span>
                        <span class="fw-semibold">{{ config('cache.default') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Son Loglar -->
    <div class="col-xl-5">
        <div class="card table-card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fas fa-scroll me-2 text-secondary"></i>Son Panel Logları</span>
                <a href="#" class="btn btn-sm btn-outline-secondary fs-12">Tümü</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="max-height: 330px; overflow-y: auto;">
                    @forelse($sonLoglar ?? [] as $log)
                    <div class="list-group-item py-2 px-3">
                        <div class="d-flex align-items-start">
                            <div class="me-2 mt-1">
                                @if(($log->islem ?? '') == 'giriş')
                                    <i class="fas fa-sign-in-alt text-success fs-12"></i>
                                @elseif(($log->islem ?? '') == 'ekleme')
                                    <i class="fas fa-plus-circle text-primary fs-12"></i>
                                @elseif(($log->islem ?? '') == 'silme')
                                    <i class="fas fa-trash-alt text-danger fs-12"></i>
                                @elseif(($log->islem ?? '') == 'güncelleme')
                                    <i class="fas fa-edit text-warning fs-12"></i>
                                @else
                                    <i class="fas fa-circle text-muted fs-12"></i>
                                @endif
                            </div>
                            <div class="flex-fill">
                                <div class="fs-13">{{ $log->aciklama ?? '-' }}</div>
                                <div class="fs-11 text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $log->kullanici->kullanici_adi ?? 'Sistem' }}
                                    <span class="mx-1">·</span>
                                    <i class="fas fa-clock me-1"></i>{{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted py-5">
                        <i class="fas fa-scroll fa-2x mb-2 d-block opacity-50"></i>
                        Henüz log kaydı bulunmuyor
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== Aylık Tahsilat Grafiği ==========
    const tahsilatCtx = document.getElementById('tahsilatChart').getContext('2d');

    const aylar = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran',
                   'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];

    const tahsilatData = {!! json_encode($aylikTahsilatVerisi ?? [45000, 52000, 61000, 58000, 67000, 72000, 69000, 75000, 80000, 78000, 85000, 90000]) !!};

    const tahsilatGradient = tahsilatCtx.createLinearGradient(0, 0, 0, 300);
    tahsilatGradient.addColorStop(0, 'rgba(52, 152, 219, 0.25)');
    tahsilatGradient.addColorStop(1, 'rgba(52, 152, 219, 0.02)');

    new Chart(tahsilatCtx, {
        type: 'line',
        data: {
            labels: aylar,
            datasets: [{
                label: 'Tahsilat (₺)',
                data: tahsilatData,
                borderColor: '#3498db',
                backgroundColor: tahsilatGradient,
                borderWidth: 2.5,
                pointBackgroundColor: '#3498db',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(ctx) {
                            return '₺' + ctx.parsed.y.toLocaleString('tr-TR');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: { size: 11 },
                        callback: function(value) {
                            return '₺' + (value / 1000) + 'K';
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });

    // ========== Müşteri Durumları Doughnut ==========
    const durumCtx = document.getElementById('musteriDurumChart').getContext('2d');

    const durumData = {!! json_encode($musteriDurumlari ?? [320, 45, 28, 12]) !!};

    new Chart(durumCtx, {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Pasif', 'İptal', 'Dondurulmuş'],
            datasets: [{
                data: durumData,
                backgroundColor: ['#27ae60', '#e74c3c', '#f39c12', '#3498db'],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#2c3e50',
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(ctx) {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                            return ctx.label + ': ' + ctx.parsed + ' (%' + pct + ')';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush

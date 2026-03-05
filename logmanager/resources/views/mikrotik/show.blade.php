@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Ana Sayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mikrotik.index') }}">Mikrotik</a></li>
            <li class="breadcrumb-item active">{{ $mikrotik->ad }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="fas fa-server me-2"></i>{{ $mikrotik->ad }}</h1>
        <div>
            <a href="{{ route('mikrotik.edit', $mikrotik->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Düzenle
            </a>
            <a href="{{ route('mikrotik.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Listeye Dön
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Cihaz Bilgileri --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Cihaz Bilgileri</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" style="width:40%">Ad</td>
                            <td><strong>{{ $mikrotik->ad }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">IP Adresi</td>
                            <td><code>{{ $mikrotik->ip_adresi }}</code></td>
                        </tr>
                        <tr>
                            <td class="text-muted">API Port</td>
                            <td>{{ $mikrotik->api_port }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kullanıcı Adı</td>
                            <td>{{ $mikrotik->kullanici_adi }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Durum</td>
                            <td>
                                @if($mikrotik->durum == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($mikrotik->durum == 'hata')
                                    <span class="badge bg-danger">Hata</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Bölge</td>
                            <td>{{ $mikrotik->bolge->ad ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">RADIUS</td>
                            <td>
                                @if($mikrotik->radius)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Accounting</td>
                            <td>
                                @if($mikrotik->accounting)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Accept</td>
                            <td>
                                @if($mikrotik->accept)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Pasif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Interim</td>
                            <td>{{ $mikrotik->interim }} dk</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Mesaj</td>
                            <td>{{ $mikrotik->mesaj ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Açıklama</td>
                            <td>{{ $mikrotik->aciklama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Eklenme</td>
                            <td>{{ $mikrotik->created_at?->format('d.m.Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Bağlı Hatlar --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-network-wired text-info me-2"></i>Bağlı Hatlar</h5>
                    <span class="badge bg-info">{{ $mikrotik->hatlar->count() ?? 0 }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Hat Adı</th>
                                    <th>Kapasite</th>
                                    <th>Kullanılan</th>
                                    <th>Doluluk</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mikrotik->hatlar ?? [] as $hat)
                                @php
                                    $doluluk = $hat->kapasite > 0 ? round(($hat->kullanilan / $hat->kapasite) * 100, 1) : 0;
                                @endphp
                                <tr>
                                    <td><strong>{{ $hat->ad }}</strong></td>
                                    <td>{{ $hat->kapasite }}</td>
                                    <td>{{ $hat->kullanilan }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px; width: 80px;">
                                                <div class="progress-bar {{ $doluluk > 90 ? 'bg-danger' : ($doluluk > 70 ? 'bg-warning' : 'bg-success') }}"
                                                     style="width: {{ $doluluk }}%"></div>
                                            </div>
                                            <small>%{{ $doluluk }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($hat->aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Pasif</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-muted">Bağlı hat bulunmamaktadır.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- IP Adresleri --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-globe text-success me-2"></i>IP Adresleri</h5>
                    <span class="badge bg-success">{{ $mikrotik->ipAdresleri->count() ?? 0 }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>IP Adresi</th>
                                    <th>Subnet</th>
                                    <th>Müşteri</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mikrotik->ipAdresleri->take(20) ?? [] as $ip)
                                <tr>
                                    <td><code>{{ $ip->ip_adresi }}</code></td>
                                    <td>{{ $ip->subnet ?? '-' }}</td>
                                    <td>{{ $ip->musteri ? $ip->musteri->isim . ' ' . $ip->musteri->soyisim : '-' }}</td>
                                    <td>
                                        @if($ip->durum == 'bos')
                                            <span class="badge bg-success">Boş</span>
                                        @elseif($ip->durum == 'kullaniliyor')
                                            <span class="badge bg-primary">Kullanılıyor</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Rezerve</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">IP adresi bulunmamaktadır.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if(($mikrotik->ipAdresleri->count() ?? 0) > 20)
                    <div class="text-center mt-2">
                        <a href="{{ route('mikrotik.ip.index') }}?mikrotik_id={{ $mikrotik->id }}" class="btn btn-sm btn-outline-primary">
                            Tümünü Görüntüle ({{ $mikrotik->ipAdresleri->count() }})
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- VPN Kullanıcıları --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="fas fa-shield-alt text-warning me-2"></i>VPN Kullanıcıları</h5>
                    <span class="badge bg-warning text-dark">{{ $mikrotik->vpnKullanicilari->count() ?? 0 }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kullanıcı Adı</th>
                                    <th>Profil</th>
                                    <th>Remote IP</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mikrotik->vpnKullanicilari ?? [] as $vpn)
                                <tr>
                                    <td><strong>{{ $vpn->kullanici_adi }}</strong></td>
                                    <td>{{ $vpn->profil ?? '-' }}</td>
                                    <td><code>{{ $vpn->remote_address ?? '-' }}</code></td>
                                    <td>
                                        @if($vpn->aktif)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Pasif</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">VPN kullanıcısı bulunmamaktadır.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

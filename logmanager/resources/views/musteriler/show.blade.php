@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title">
            {{ $musteri->musteri_tipi === 'kurumsal' ? $musteri->firma_unvani : $musteri->ad . ' ' . $musteri->soyad }}
            @switch($musteri->durum)
                @case('aktif')
                    <span class="badge status-aktif ms-2">Aktif</span>
                    @break
                @case('pasif')
                    <span class="badge status-pasif ms-2">Pasif</span>
                    @break
                @case('iptal')
                    <span class="badge status-iptal ms-2">İptal</span>
                    @break
                @case('dondurulmus')
                    <span class="badge status-dondurulmus ms-2">Dondurulmuş</span>
                    @break
                @case('potansiyel')
                    <span class="badge status-potansiyel ms-2">Potansiyel</span>
                    @break
            @endswitch
            @if($musteri->online)
                <span class="badge bg-success ms-1"><i class="fas fa-circle me-1"></i> Online</span>
            @else
                <span class="badge bg-danger ms-1"><i class="fas fa-circle me-1"></i> Offline</span>
            @endif
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('anasayfa') }}">Ana Sayfa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('musteriler.index') }}">Müşteriler</a></li>
                <li class="breadcrumb-item active">{{ $musteri->abone_no }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('musteriler.edit', $musteri->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Düzenle
        </a>
        <a href="{{ route('faturalar.create', ['musteri_id' => $musteri->id]) }}" class="btn btn-info">
            <i class="fas fa-file-invoice me-1"></i> Fatura Kes
        </a>
        <a href="{{ route('sms.create', ['musteri_id' => $musteri->id]) }}" class="btn btn-primary">
            <i class="fas fa-sms me-1"></i> SMS Gönder
        </a>
        <button class="btn btn-outline-danger" onclick="internetToggle({{ $musteri->id }}, '{{ $musteri->durum }}')">
            @if($musteri->durum === 'aktif')
                <i class="fas fa-ban me-1"></i> İnternet Kes
            @else
                <i class="fas fa-check-circle me-1"></i> İnternet Aç
            @endif
        </button>
        <button class="btn btn-outline-secondary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> Yazdır
        </button>
    </div>
</div>

{{-- Finansal Özet --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-title">Abone No</div>
            <div class="stat-card-value">{{ $musteri->abone_no }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-title">Toplam Borç</div>
            <div class="stat-card-value text-danger">{{ number_format($musteri->faturalar->where('durum', 'odenmedi')->sum('tutar'), 2, ',', '.') }} ₺</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-title">Toplam Ödeme</div>
            <div class="stat-card-value text-success">{{ number_format($musteri->odemeler->sum('tutar'), 2, ',', '.') }} ₺</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-title">Bakiye</div>
            <div class="stat-card-value {{ $musteri->bakiye >= 0 ? 'text-success' : 'text-danger' }}">
                {{ number_format($musteri->bakiye, 2, ',', '.') }} ₺
            </div>
        </div>
    </div>
</div>

{{-- Tab Navigasyonu --}}
<ul class="nav nav-tabs mb-3" id="musteriTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="genel-tab" data-bs-toggle="tab" data-bs-target="#genel" type="button" role="tab">
            <i class="fas fa-info-circle me-1"></i> Genel Bilgiler
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="teknik-tab" data-bs-toggle="tab" data-bs-target="#teknik" type="button" role="tab">
            <i class="fas fa-server me-1"></i> Teknik Bilgiler
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="faturalar-tab" data-bs-toggle="tab" data-bs-target="#faturalar" type="button" role="tab">
            <i class="fas fa-file-invoice me-1"></i> Faturalar
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="odemeler-tab" data-bs-toggle="tab" data-bs-target="#odemeler" type="button" role="tab">
            <i class="fas fa-money-bill me-1"></i> Ödemeler
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="notlar-tab" data-bs-toggle="tab" data-bs-target="#notlar" type="button" role="tab">
            <i class="fas fa-sticky-note me-1"></i> Notlar
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="loglar-tab" data-bs-toggle="tab" data-bs-target="#loglar" type="button" role="tab">
            <i class="fas fa-history me-1"></i> Loglar
        </button>
    </li>
</ul>

<div class="tab-content" id="musteriTabContent">
    {{-- Genel Bilgiler --}}
    <div class="tab-pane fade show active" id="genel" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-id-card me-2"></i> Kimlik Bilgileri</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="40%">Müşteri Tipi</th>
                                    <td>{{ $musteri->musteri_tipi === 'kurumsal' ? 'Kurumsal' : 'Bireysel' }}</td>
                                </tr>
                                <tr>
                                    <th>TC Kimlik No</th>
                                    <td>{{ $musteri->tc_kimlik_no ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Ad Soyad</th>
                                    <td>{{ $musteri->ad }} {{ $musteri->soyad }}</td>
                                </tr>
                                @if($musteri->musteri_tipi === 'kurumsal')
                                <tr>
                                    <th>Firma Ünvanı</th>
                                    <td>{{ $musteri->firma_unvani ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Vergi Dairesi</th>
                                    <td>{{ $musteri->vergi_dairesi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Vergi No</th>
                                    <td>{{ $musteri->vergi_no ?? '-' }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Doğum Tarihi</th>
                                    <td>{{ $musteri->dogum_tarihi ? \Carbon\Carbon::parse($musteri->dogum_tarihi)->format('d.m.Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Cinsiyet</th>
                                    <td>{{ $musteri->cinsiyet === 'erkek' ? 'Erkek' : ($musteri->cinsiyet === 'kadin' ? 'Kadın' : '-') }}</td>
                                </tr>
                                <tr>
                                    <th>Telefon</th>
                                    <td><a href="tel:{{ $musteri->telefon }}">{{ $musteri->telefon }}</a></td>
                                </tr>
                                <tr>
                                    <th>E-Posta</th>
                                    <td><a href="mailto:{{ $musteri->eposta }}">{{ $musteri->eposta ?? '-' }}</a></td>
                                </tr>
                                <tr>
                                    <th>Uyruk</th>
                                    <td>{{ $musteri->uyruk === 'tc' ? 'T.C.' : 'Yabancı' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-map-marker-alt me-2"></i> Adres Bilgileri</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="40%">İl</th>
                                    <td>{{ $musteri->il ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>İlçe</th>
                                    <td>{{ $musteri->ilce ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Mahalle</th>
                                    <td>{{ $musteri->mahalle ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Cadde / Sokak</th>
                                    <td>{{ $musteri->cadde_sokak ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Bina No</th>
                                    <td>{{ $musteri->bina_no ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Daire No</th>
                                    <td>{{ $musteri->daire_no ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Posta Kodu</th>
                                    <td>{{ $musteri->posta_kodu ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($musteri->adres_aciklama)
                        <div class="mt-2 p-2 bg-light rounded">
                            <small class="text-muted">Adres Açıklama:</small><br>
                            {{ $musteri->adres_aciklama }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-wifi me-2"></i> Abonelik Bilgileri</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th width="40%">Tarife</th>
                                    <td>{{ $musteri->tarife->ad ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kampanya</th>
                                    <td>{{ $musteri->kampanya->ad ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Bölge</th>
                                    <td>{{ $musteri->bolge->ad ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Hizmet Başlangıç</th>
                                    <td>{{ $musteri->hizmet_baslangic_tarihi ? \Carbon\Carbon::parse($musteri->hizmet_baslangic_tarihi)->format('d.m.Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Sözleşme Süresi</th>
                                    <td>{{ $musteri->sozlesme_suresi ?? '-' }} Ay</td>
                                </tr>
                                <tr>
                                    <th>Taahhüt</th>
                                    <td>
                                        @if($musteri->taahhut)
                                            <span class="text-success">Var</span>
                                            @if($musteri->taahhut_bitis_tarihi)
                                                - {{ \Carbon\Carbon::parse($musteri->taahhut_bitis_tarihi)->format('d.m.Y') }}
                                            @endif
                                        @else
                                            <span class="text-muted">Yok</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Ödeme Yöntemi</th>
                                    <td>
                                        @switch($musteri->odeme_yontemi)
                                            @case('nakit') Nakit @break
                                            @case('havale') Havale / EFT @break
                                            @case('kredi_karti') Kredi Kartı @break
                                            @case('otomatik_cekim') Otomatik Çekim @break
                                            @default {{ $musteri->odeme_yontemi ?? '-' }}
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fatura Tipi</th>
                                    <td>
                                        @switch($musteri->fatura_tipi)
                                            @case('e-fatura') E-Fatura @break
                                            @case('e-arsiv') E-Arşiv @break
                                            @case('matbu') Matbu @break
                                            @default {{ $musteri->fatura_tipi ?? '-' }}
                                        @endswitch
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Teknik Bilgiler --}}
    <div class="tab-pane fade" id="teknik" role="tabpanel">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-server me-2"></i> Teknik Bilgiler</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="40%">Mikrotik</th>
                                    <td>{{ $musteri->mikrotik->ad ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Hat</th>
                                    <td>{{ $musteri->hat->ad ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>IP Adresi</th>
                                    <td><code>{{ $musteri->ip_adresi ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <th>MAC Adresi</th>
                                    <td><code>{{ $musteri->mac_adresi ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <th>PPPoE Kullanıcı</th>
                                    <td>{{ $musteri->pppoe_kullanici ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>PPPoE Şifre</th>
                                    <td>
                                        <span id="pppoePassword" style="display:none;">{{ $musteri->pppoe_sifre }}</span>
                                        <span id="pppoeHidden">••••••••</span>
                                        <button class="btn btn-sm btn-outline-secondary ms-2" onclick="togglePppoePassword()">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th width="40%">Download Hızı</th>
                                    <td>{{ $musteri->download_hizi ?? '-' }} Mbps</td>
                                </tr>
                                <tr>
                                    <th>Upload Hızı</th>
                                    <td>{{ $musteri->upload_hizi ?? '-' }} Mbps</td>
                                </tr>
                                <tr>
                                    <th>VLAN ID</th>
                                    <td>{{ $musteri->vlan_id ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Modem Marka/Model</th>
                                    <td>{{ $musteri->modem_marka_model ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Modem Seri No</th>
                                    <td>{{ $musteri->modem_sn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Bağlantı Durumu</th>
                                    <td>
                                        @if($musteri->online)
                                            <span class="text-success"><i class="fas fa-circle me-1"></i> Online</span>
                                        @else
                                            <span class="text-danger"><i class="fas fa-circle me-1"></i> Offline</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Faturalar --}}
    <div class="tab-pane fade" id="faturalar" role="tabpanel">
        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="fas fa-file-invoice me-2"></i> Faturalar</h5>
                <a href="{{ route('faturalar.create', ['musteri_id' => $musteri->id]) }}" class="btn btn-sm btn-info">
                    <i class="fas fa-plus me-1"></i> Yeni Fatura
                </a>
            </div>
            <div class="card-body">
                @if($musteri->faturalar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Fatura No</th>
                                <th>Dönem</th>
                                <th>Tutar</th>
                                <th>Son Ödeme</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($musteri->faturalar as $fatura)
                            <tr>
                                <td>{{ $fatura->fatura_no }}</td>
                                <td>{{ $fatura->donem }}</td>
                                <td>{{ number_format($fatura->tutar, 2, ',', '.') }} ₺</td>
                                <td>{{ $fatura->son_odeme_tarihi ? \Carbon\Carbon::parse($fatura->son_odeme_tarihi)->format('d.m.Y') : '-' }}</td>
                                <td>
                                    @if($fatura->durum === 'odendi')
                                        <span class="badge bg-success">Ödendi</span>
                                    @elseif($fatura->durum === 'odenmedi')
                                        <span class="badge bg-danger">Ödenmedi</span>
                                    @elseif($fatura->durum === 'kismi')
                                        <span class="badge bg-warning">Kısmi Ödeme</span>
                                    @elseif($fatura->durum === 'iptal')
                                        <span class="badge bg-secondary">İptal</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('faturalar.show', $fatura->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-file-invoice fa-2x mb-2"></i>
                    <p>Henüz fatura kaydı bulunmuyor.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Ödemeler --}}
    <div class="tab-pane fade" id="odemeler" role="tabpanel">
        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="fas fa-money-bill me-2"></i> Ödemeler</h5>
                <a href="{{ route('odemeler.create', ['musteri_id' => $musteri->id]) }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus me-1"></i> Ödeme Ekle
                </a>
            </div>
            <div class="card-body">
                @if($musteri->odemeler->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Makbuz No</th>
                                <th>Tarih</th>
                                <th>Tutar</th>
                                <th>Ödeme Yöntemi</th>
                                <th>Açıklama</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($musteri->odemeler as $odeme)
                            <tr>
                                <td>{{ $odeme->makbuz_no ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($odeme->tarih)->format('d.m.Y') }}</td>
                                <td>{{ number_format($odeme->tutar, 2, ',', '.') }} ₺</td>
                                <td>{{ $odeme->odeme_yontemi }}</td>
                                <td>{{ Str::limit($odeme->aciklama, 50) }}</td>
                                <td>
                                    <a href="{{ route('odemeler.show', $odeme->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-money-bill fa-2x mb-2"></i>
                    <p>Henüz ödeme kaydı bulunmuyor.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Notlar --}}
    <div class="tab-pane fade" id="notlar" role="tabpanel">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-plus me-2"></i> Not Ekle</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('musteri-notlari.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="musteri_id" value="{{ $musteri->id }}">
                    <div class="row g-3">
                        <div class="col-md-10">
                            <textarea class="form-control" name="not" rows="2" placeholder="Müşteri notu ekle..." required></textarea>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-1"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-sticky-note me-2"></i> Müşteri Notları</h5>
            </div>
            <div class="card-body">
                @if($musteri->notlar->count() > 0)
                    @foreach($musteri->notlar->sortByDesc('created_at') as $not)
                    <div class="border rounded p-3 mb-2">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1">{{ $not->not }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i> {{ $not->yazan->name ?? 'Bilinmiyor' }}
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-clock me-1"></i> {{ $not->created_at->format('d.m.Y H:i') }}
                                </small>
                            </div>
                            <form action="{{ route('musteri-notlari.destroy', $not->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu notu silmek istediğinize emin misiniz?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-sticky-note fa-2x mb-2"></i>
                    <p>Henüz not bulunmuyor.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Loglar --}}
    <div class="tab-pane fade" id="loglar" role="tabpanel">
        <div class="card table-card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-history me-2"></i> İşlem Logları</h5>
            </div>
            <div class="card-body">
                @if(isset($musteri->loglar) && $musteri->loglar->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>İşlem</th>
                                <th>Açıklama</th>
                                <th>Kullanıcı</th>
                                <th>IP Adresi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($musteri->loglar as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d.m.Y H:i:s') }}</td>
                                <td><span class="badge bg-info">{{ $log->islem }}</span></td>
                                <td>{{ $log->aciklama }}</td>
                                <td>{{ $log->kullanici->name ?? '-' }}</td>
                                <td><code>{{ $log->ip_adresi }}</code></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-history fa-2x mb-2"></i>
                    <p>Henüz log kaydı bulunmuyor.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePppoePassword() {
        let pw = document.getElementById('pppoePassword');
        let hidden = document.getElementById('pppoeHidden');
        if (pw.style.display === 'none') {
            pw.style.display = 'inline';
            hidden.style.display = 'none';
        } else {
            pw.style.display = 'none';
            hidden.style.display = 'inline';
        }
    }

    function internetToggle(id, durum) {
        let eylem = durum === 'aktif' ? 'kapatmak' : 'açmak';
        Swal.fire({
            title: 'İnternet ' + (durum === 'aktif' ? 'Kesme' : 'Açma'),
            text: 'Bu müşterinin internetini ' + eylem + ' istediğinize emin misiniz?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: durum === 'aktif' ? '#d33' : '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Evet, ' + (durum === 'aktif' ? 'Kes' : 'Aç') + '!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/musteriler/' + id + '/internet-toggle',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        Swal.fire('Başarılı!', response.message, 'success').then(() => { location.reload(); });
                    },
                    error: function() {
                        Swal.fire('Hata!', 'İşlem sırasında bir hata oluştu.', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Hiper Log') - ISP Yönetim Paneli</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --header-height: 60px;
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --info-color: #17a2b8;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        /* ===================== SIDEBAR ===================== */
        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #ecf0f1;
            z-index: 1030;
            overflow-y: auto;
            overflow-x: hidden;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .app-sidebar::-webkit-scrollbar { width: 5px; }
        .app-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

        .sidebar-brand {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }
        .sidebar-brand h5 { margin: 0; font-size: 16px; font-weight: 700; color: #fff; }
        .sidebar-brand small { font-size: 10px; color: rgba(255,255,255,0.6); }

        .sidebar-menu { padding: 10px 0; }

        .menu-section {
            padding: 8px 20px 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            letter-spacing: 1px;
        }

        .sidebar-menu .nav-link {
            padding: 8px 20px;
            color: rgba(255,255,255,0.75);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
            border-left: 3px solid transparent;
            text-decoration: none;
        }
        .sidebar-menu .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: var(--accent-color);
        }
        .sidebar-menu .nav-link.active {
            color: #fff;
            background: rgba(52, 152, 219, 0.2);
            border-left-color: var(--accent-color);
        }
        .sidebar-menu .nav-link i { width: 20px; text-align: center; font-size: 14px; }
        .sidebar-menu .nav-link .badge { margin-left: auto; font-size: 10px; }

        .sidebar-submenu { display: none; background: rgba(0,0,0,0.15); }
        .sidebar-submenu .nav-link { padding-left: 50px; font-size: 12px; }
        .nav-item.open > .sidebar-submenu { display: block; }

        .nav-item.has-submenu > .nav-link::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin-left: auto;
            transition: transform 0.3s;
            font-size: 11px;
        }
        .nav-item.has-submenu.open > .nav-link::after { transform: rotate(180deg); }

        /* ===================== HEADER ===================== */
        .app-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background: #fff;
            z-index: 1020;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: left 0.3s ease;
        }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .header-right { margin-left: auto; display: flex; align-items: center; gap: 15px; }

        .sidebar-toggle {
            background: none; border: none; font-size: 20px; color: #666; cursor: pointer; padding: 5px;
        }
        .sidebar-toggle:hover { color: var(--accent-color); }

        .search-box { position: relative; }
        .search-box input {
            border: 1px solid #e0e0e0; border-radius: 20px;
            padding: 6px 15px 6px 35px; width: 300px; font-size: 13px; transition: all 0.3s;
        }
        .search-box input:focus { border-color: var(--accent-color); box-shadow: 0 0 0 3px rgba(52,152,219,0.1); outline: none; }
        .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999; }

        .header-notification { position: relative; cursor: pointer; color: #666; font-size: 18px; }
        .header-notification .badge { position: absolute; top: -5px; right: -8px; font-size: 9px; }

        .user-dropdown .dropdown-toggle {
            display: flex; align-items: center; gap: 8px;
            background: none; border: none; color: #333; font-size: 13px; cursor: pointer;
        }
        .user-dropdown .dropdown-toggle::after { display: none; }

        .user-avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--accent-color); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 600;
        }

        /* ===================== CONTENT ===================== */
        .app-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            padding: 20px;
            min-height: calc(100vh - var(--header-height));
            transition: margin-left 0.3s ease;
        }

        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .page-header h4 { margin: 0; font-weight: 600; color: #333; }
        .breadcrumb { margin: 0; background: none; padding: 0; font-size: 13px; }

        /* ===================== CARDS ===================== */
        .stat-card {
            border: none; border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 5px 20px rgba(0,0,0,0.1); }
        .stat-card .card-body { padding: 20px; }
        .stat-card .stat-icon {
            width: 50px; height: 50px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 22px;
        }
        .stat-card .stat-value { font-size: 24px; font-weight: 700; color: #333; }
        .stat-card .stat-label { font-size: 12px; color: #888; margin-top: 2px; }

        /* ===================== TABLE ===================== */
        .table-card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .table-card .card-header { background: #fff; border-bottom: 1px solid #eee; padding: 15px 20px; font-weight: 600; }
        .table thead th { font-size: 12px; font-weight: 600; text-transform: uppercase; color: #666; border-bottom-width: 1px; }
        .table tbody td { font-size: 13px; vertical-align: middle; }

        /* ===================== STATUS BADGES ===================== */
        .status-aktif { background: #d4edda; color: #155724; }
        .status-pasif { background: #f8d7da; color: #721c24; }
        .status-potansiyel { background: #fff3cd; color: #856404; }
        .status-iptal { background: #f5c6cb; color: #721c24; }
        .status-dondurulmus { background: #d1ecf1; color: #0c5460; }

        .online-indicator { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 5px; }
        .online-indicator.online { background: #27ae60; }
        .online-indicator.offline { background: #e74c3c; }

        /* ===================== SIDEBAR COLLAPSED ===================== */
        body.sidebar-collapsed .app-sidebar { width: var(--sidebar-collapsed-width); }
        body.sidebar-collapsed .app-sidebar .sidebar-brand h5,
        body.sidebar-collapsed .app-sidebar .sidebar-brand small,
        body.sidebar-collapsed .app-sidebar .nav-link span,
        body.sidebar-collapsed .app-sidebar .menu-section,
        body.sidebar-collapsed .app-sidebar .nav-link .badge,
        body.sidebar-collapsed .app-sidebar .nav-item.has-submenu>.nav-link::after { display: none; }
        body.sidebar-collapsed .app-sidebar .nav-link { justify-content: center; padding: 12px; }
        body.sidebar-collapsed .app-header { left: var(--sidebar-collapsed-width); }
        body.sidebar-collapsed .app-content { margin-left: var(--sidebar-collapsed-width); }

        @media (max-width: 768px) {
            .app-sidebar { transform: translateX(-100%); }
            .app-sidebar.show { transform: translateX(0); }
            .app-header { left: 0; }
            .app-content { margin-left: 0; }
            .search-box input { width: 200px; }
        }

        .cursor-pointer { cursor: pointer; }
        .fs-11 { font-size: 11px; }
        .fs-12 { font-size: 12px; }
        .fs-13 { font-size: 13px; }
        .modal-header { background: var(--primary-color); color: #fff; }
        .modal-header .btn-close { filter: brightness(0) invert(1); }
    </style>
    @stack('styles')
</head>
<body>
    <!-- ===================== SIDEBAR ===================== -->
    <aside class="app-sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center">
                <i class="fas fa-network-wired fa-lg text-info me-2"></i>
                <div>
                    <h5>Hiper Log</h5>
                    <small>ISP Yönetim Paneli</small>
                </div>
            </div>
        </div>

        <nav class="sidebar-menu">
            <ul class="nav flex-column">
                <!-- Anasayfa -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <span>Anasayfa</span>
                    </a>
                </li>

                <!-- Başvuru -->
                <li class="menu-section">Başvuru</li>
                <li class="nav-item has-submenu {{ request()->is('basvurular*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-file-alt"></i>
                        <span>Başvuru Al</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('basvurular.create') }}"><span>Tam Başvuru Al</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.on_basvurular') }}"><span>Ön Başvuru</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('basvurular.bekleyen') }}"><span>Bekleyen Başvurular</span></a></li>
                    </ul>
                </li>

                <!-- Müşteri İşlemleri -->
                <li class="menu-section">Müşteri İşlemleri</li>
                <li class="nav-item has-submenu {{ request()->is('musteriler*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-users"></i>
                        <span>Müşteriler</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('musteriler.index') ? 'active' : '' }}" href="{{ route('musteriler.index') }}"><span>Müşteriler</span></a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('musteriler.create') ? 'active' : '' }}" href="{{ route('musteriler.create') }}"><span>Müşteri Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('basvurular.bekleyen') }}"><span>Bekleyen Başvurular</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.online') }}"><span>Online Müşteriler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.offline') }}"><span>Offline Müşteriler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.notlar') }}"><span>Müşteri Notları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.tarife_gecis') }}"><span>Tarife Geçiş İstekleri</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.online_basvurular') }}"><span>Online Başvurular</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.on_basvurular') }}"><span>Ön Başvurular</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.interneti_kesilenler') }}"><span>İnterneti Kesilenler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.onay_bekleyen') }}"><span>Onay Bekleyen İşlemler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.yabanci') }}"><span>Yabancı Müşteri Kontrol</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.yasaklanan_tc') }}"><span>Yasaklanan T.C.ler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.gruplar') }}"><span>Grup Oluştur, Listele</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.mac_arama') }}"><span>Cihaz Ara (MAC)</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.e_devlet') }}"><span>E-Kayıt Başvurular</span></a></li>
                    </ul>
                </li>

                <!-- Arama Emirleri -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('arama_emirleri*') ? 'active' : '' }}" href="{{ route('arama_emirleri.index') }}">
                        <i class="fas fa-phone"></i>
                        <span>Arama Emirleri</span>
                    </a>
                </li>

                <!-- WhatsApp -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('whatsapp*') ? 'active' : '' }}" href="{{ route('whatsapp.ayarlar') }}">
                        <i class="fab fa-whatsapp"></i>
                        <span>Whatsapp</span>
                    </a>
                </li>

                <!-- Kasa İşlemleri -->
                <li class="menu-section">Kasa İşlemleri</li>
                <li class="nav-item has-submenu {{ request()->is('kasa*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-cash-register"></i>
                        <span>Kasa</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('kasa.index') }}"><span>Kasa Listesi, Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.kasa_kullanici') }}"><span>Kullanıcı Kasaları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.kasa_hareket') }}"><span>Kasa Hareketleri</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('kasa.cariler') }}"><span>Cariler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('kasa.cari_faturalar') }}"><span>Cari Fatura İşlemleri</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('kasa.gelir_gider') }}"><span>Gider ve Gelir Yönetimi</span></a></li>
                    </ul>
                </li>

                <!-- Stok -->
                <li class="nav-item has-submenu {{ request()->is('stok*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-boxes-stacked"></i>
                        <span>Stok</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('stok.index') }}"><span>Stok Listesi, Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('kasa.depolar') }}"><span>Depo Yönetimi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('stok.urunler.index') }}"><span>Ürün Listesi, Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('stok.urunler.musterideki') }}"><span>Müşterideki Ürünler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('stok.urunler.arizali') }}"><span>Arızalı Ürünler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('stok.urunler.sokum') }}"><span>Söküm Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('stok.urunler.gonder') }}"><span>Stok Gönder</span></a></li>
                    </ul>
                </li>

                <!-- Fatura İşlemleri -->
                <li class="menu-section">Fatura İşlemleri</li>
                <li class="nav-item has-submenu {{ request()->is('fatura*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Faturalar</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.odeme_al') }}"><span>Ödeme Al</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.index') }}"><span>Tüm Faturalar</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.efatura') }}"><span>E-Faturalar</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.tahsilat') }}"><span>Fatura Tahsilat</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.odenmis') }}"><span>Ödenmiş Faturalar</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.iptal') }}"><span>Faturalı İptal</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.taahhutlu') }}"><span>Taahhütü Bitmiş</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.havale') }}"><span>Havale Bildirimleri</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.efatura_hata') }}"><span>E-Fatura Gönderim Hataları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('fatura.otomatik_cekim') }}"><span>Otomatik Çekimler</span></a></li>
                    </ul>
                </li>

                <!-- Personel & Araç -->
                <li class="menu-section">Personel & Araç</li>
                <li class="nav-item has-submenu {{ request()->is('personel*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-user-tie"></i>
                        <span>Personel</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('personel.index') }}"><span>Personel Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('personel.hakedis') }}"><span>Hakedişler, Primler</span></a></li>
                    </ul>
                </li>
                <li class="nav-item has-submenu {{ request()->is('arac*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-car"></i>
                        <span>Araç İşlemleri</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('arac.index') }}"><span>Araç Listesi, Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('arac.takip') }}"><span>Araç Takip Ayarı</span></a></li>
                    </ul>
                </li>

                <!-- SMS -->
                <li class="menu-section">SMS İşlemleri</li>
                <li class="nav-item has-submenu {{ request()->is('sms*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-sms"></i>
                        <span>SMS</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('sms.rapor') }}"><span>SMS Raporları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('sms.sablonlar') }}"><span>SMS Şablonları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('sms.gonder') }}"><span>SMS Gönder</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('sms.ayarlar') }}"><span>SMS Ayarları</span></a></li>
                    </ul>
                </li>

                <!-- Altyapı -->
                <li class="menu-section">Altyapı</li>
                <li class="nav-item has-submenu {{ request()->is('mikrotik*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-server"></i>
                        <span>Mikrotik</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.index') }}"><span>Mikrotik Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.create') }}"><span>Mikrotik Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.hata_raporu') }}"><span>Hata Raporu</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.ppp') }}"><span>PPP Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.vpn') }}"><span>VPN (CHAP)</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.hat.index') }}"><span>Hat Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.hat.create') }}"><span>Hat Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.hat.kapasite') }}"><span>Hat Kapasiteleri</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.hat.hatali') }}"><span>IP Hatalı Hatlar</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.ip.index') }}"><span>IP Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.ip.borclu') }}"><span>Borçlu IP'ler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('mikrotik.ip_yonetim') }}"><span>IP Yönetim</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('musteriler.vlan') }}"><span>VLAN Müşteriler</span></a></li>
                    </ul>
                </li>

                <li class="nav-item has-submenu {{ request()->is('istasyon*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-broadcast-tower"></i>
                        <span>İstasyon & Vericiler</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('istasyon.index') }}"><span>İstasyon Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('istasyon.vericiler') }}"><span>Verici Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('istasyon.harita') }}"><span>Ağ Haritası</span></a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('genelariza*') ? 'active' : '' }}" href="{{ route('ariza.index') }}">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Genel Arıza</span>
                    </a>
                </li>

                <!-- Kullanıcı İşlemleri -->
                <li class="menu-section">Kullanıcı İşlemleri</li>
                <li class="nav-item has-submenu {{ request()->is('bayi*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-user-cog"></i>
                        <span>Kullanıcılar</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.create') }}"><span>Kullanıcı Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.index') }}"><span>Bölge/Kullanıcı Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.musteriler') }}"><span>Kullanıcı Müşterileri</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.musteri_tasima') }}"><span>Müşteri Taşıma</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.duyurular') }}"><span>Duyurular</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.tickets') }}"><span>Ticket</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.bolgeler') }}"><span>Bölgeler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('bayi.yetki_atama') }}"><span>Toplu Yetki Atama</span></a></li>
                    </ul>
                </li>

                <!-- Teknik Servis -->
                <li class="menu-section">Teknik Servis</li>
                <li class="nav-item has-submenu {{ request()->is('teknik_servis*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-tools"></i>
                        <span>Teknik Servis</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('teknik_servis.index') }}"><span>Listesi, Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teknik_servis.is_tanimlari') }}"><span>İş Tanımları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teknik_servis.rapor') }}"><span>Rapor</span></a></li>
                    </ul>
                </li>

                <!-- Tarifeler -->
                <li class="menu-section">Tarifeler</li>
                <li class="nav-item has-submenu {{ request()->is('tarifeler*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-tags"></i>
                        <span>Tarifeler</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('tarife.create') }}"><span>Tarife Ekle</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tarife.index') }}"><span>Tarife Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tarife.istatistik') }}"><span>Tarife İstatistiği</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tarife.toplu_degistir') }}"><span>Toplu Tarife Değiştir</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tarife.hizmetler') }}"><span>Hizmetler</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tarife.kampanyalar') }}"><span>Kampanyalar</span></a></li>
                    </ul>
                </li>

                <!-- Raporlar -->
                <li class="menu-section">Raporlar</li>
                <li class="nav-item has-submenu {{ request()->is('raporlar*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-chart-bar"></i>
                        <span>Raporlar</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.satis') }}"><span>Satış Raporları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.kdv') }}"><span>KDV Raporları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.trafik') }}"><span>Trafik Raporu</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.gun_sonu') }}"><span>Gün Sonu</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.musteri') }}"><span>Müşteri Raporu</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.bayiler') }}"><span>Bayiler Genel</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.tahsilat') }}"><span>Tahsilat Raporu</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.tarife') }}"><span>Tarife Raporu</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('rapor.efatura') }}"><span>E-Fatura Durumu</span></a></li>
                    </ul>
                </li>

                <!-- Loglar -->
                <li class="menu-section">Loglar</li>
                <li class="nav-item has-submenu {{ request()->is('loglar*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Loglar</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('log.port') }}"><span>IPDR Logları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('log.oturum') }}"><span>Oturum Logları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('log.mikrotik') }}"><span>Mikrotik Logları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('log.5651') }}"><span>5651 Logları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('log.abone') }}"><span>Abone Logları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('log.panel') }}"><span>Panel Logları</span></a></li>
                    </ul>
                </li>

                <!-- Telekom -->
                <li class="menu-section">Telekom</li>
                <li class="nav-item has-submenu {{ request()->is('telekom*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-satellite-dish"></i>
                        <span>Telekom</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('telekom.basvurular') }}"><span>Başvuru Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('telekom.vae_faturalar') }}"><span>VAE Faturalar</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('telekom.churn_sorgu') }}"><span>Churn Sorgu</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('telekom.olo_ariza') }}"><span>OLO Arıza</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('telekom.degisiklik') }}"><span>Değişiklik Başvuruları</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('telekom.durum_rapor') }}"><span>Durum Raporu</span></a></li>
                    </ul>
                </li>

                <!-- Sistem -->
                <li class="menu-section">Sistem</li>
                <li class="nav-item"><a class="nav-link {{ request()->is('ayarlar*') ? 'active' : '' }}" href="{{ route('ayar.genel') }}"><i class="fas fa-cog"></i><span>Genel Ayarlar</span></a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('teknik_destek*') ? 'active' : '' }}" href="{{ route('destek.index') }}"><i class="fas fa-headset"></i><span>Teknik Destek</span></a></li>
                <li class="nav-item"><a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ route('blog.index') }}"><i class="fas fa-blog"></i><span>Blog</span></a></li>
                <li class="nav-item has-submenu {{ request()->is('evrak*') ? 'open' : '' }}">
                    <a class="nav-link" href="javascript:void(0)">
                        <i class="fas fa-folder-open"></i><span>Evrak</span>
                    </a>
                    <ul class="nav flex-column sidebar-submenu">
                        <li class="nav-item"><a class="nav-link" href="{{ route('evrak.index') }}"><span>Evrak Listesi</span></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('evrak.ayarlar') }}"><span>Evrak Ayarları</span></a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->is('api*') ? 'active' : '' }}" href="{{ route('api.index') }}"><i class="fas fa-plug"></i><span>API Bilgileri</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bayi.devreler') }}"><i class="fas fa-network-wired"></i><span>Omurga</span></a></li>
            </ul>
        </nav>
    </aside>

    <!-- ===================== HEADER ===================== -->
    <header class="app-header" id="header">
        <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <div class="search-box d-none d-md-block">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Müşteri, Abone No, TC No ara..." id="globalSearch">
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('basvurular.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Başvuru Al
            </a>
            <div class="header-notification" title="Bildirimler">
                <i class="fas fa-bell"></i>
                <span class="badge bg-danger rounded-pill">3</span>
            </div>
            <div class="dropdown user-dropdown">
                <button class="dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="user-avatar">{{ substr(auth()->user()->ad ?? 'U', 0, 1) }}</div>
                    <span class="d-none d-md-inline">{{ auth()->user()->kullanici_adi ?? 'Kullanıcı' }}</span>
                    <i class="fas fa-chevron-down fs-11"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('ayar.genel') }}"><i class="fas fa-cog me-2"></i>Ayarlar</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- ===================== MAIN CONTENT ===================== -->
    <main class="app-content" id="content">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
        });

        document.querySelectorAll('.has-submenu > .nav-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                this.closest('.has-submenu').classList.toggle('open');
            });
        });

        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('.datatable').DataTable({
                    language: { url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json' },
                    responsive: true, pageLength: 25
                });
            }
            if ($.fn.select2) {
                $('.select2').select2({ theme: 'bootstrap-5', placeholder: 'Seçiniz...', allowClear: true });
            }
        });

        function confirmDelete(formId) {
            Swal.fire({
                title: 'Emin misiniz?', text: 'Bu işlem geri alınamaz!', icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#e74c3c', cancelButtonColor: '#6c757d',
                confirmButtonText: 'Evet, sil!', cancelButtonText: 'İptal'
            }).then((result) => { if (result.isConfirmed) document.getElementById(formId).submit(); });
        }

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); document.getElementById('globalSearch').focus(); }
        });
    </script>
    @stack('scripts')
</body>
</html>

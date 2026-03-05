<?php
$cookies = '';
$ch = curl_init('http://127.0.0.1:8000/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
$resp = curl_exec($ch);
preg_match_all('/Set-Cookie: ([^;]+)/', $resp, $m);
$cookies = implode('; ', $m[1]);
preg_match('/name="_token" value="([^"]+)"/', $resp, $t);
$token = $t[1] ?? '';
curl_close($ch);

$ch2 = curl_init('http://127.0.0.1:8000/login');
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_POST, true);
curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query(['_token'=>$token,'kullanici_adi'=>'admin','password'=>'123456']));
curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Cookie: '.$cookies]);
curl_setopt($ch2, CURLOPT_HEADER, true);
curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, false);
$resp2 = curl_exec($ch2);
preg_match_all('/Set-Cookie: ([^;]+)/', $resp2, $m2);
foreach($m2[1] as $c) {
    $parts = explode('=', $c, 2);
    $cookies = preg_replace('/'.preg_quote($parts[0]).'=[^;]*/', $c, $cookies);
    if(strpos($cookies, $parts[0]) === false) $cookies .= '; '.$c;
}
curl_close($ch2);

$urls = [
    '/mikrotik' => 'Mikrotik Listesi',
    '/mikrotik/ekle' => 'Mikrotik Ekle',
    '/mikrotik/3/duzenle' => 'Mikrotik Duzenle',
    '/mikrotik/hata-raporu' => 'Hata Raporu',
    '/mikrotik/ppp' => 'PPP Listesi',
    '/mikrotik/vpn_islemleri' => 'VPN Listesi',
    '/mikrotik/hat_islemleri/hat_listesi' => 'Hat Listesi',
    '/mikrotik/hat_islemleri/ekle' => 'Hat Ekle',
    '/mikrotik/hat_islemleri/kapasite' => 'Hat Kapasiteleri',
    '/mikrotik/hat_islemleri/hat_ip_hatali' => 'IP Hatali Hatlar',
    '/mikrotik/ip_islemleri' => 'IP Listesi',
    '/mikrotik/ip_islemleri/borclu_ipler' => 'Borclu IPler',
    '/mikrotik/ip_yonetim' => 'IP Yonetim',
];

echo "\n=== MIKROTIK SAYFA TESTLERİ ===\n\n";
$ok = 0; $fail = 0;
foreach($urls as $url => $name) {
    $ch3 = curl_init('http://127.0.0.1:8000'.$url);
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch3, CURLOPT_HTTPHEADER, ['Cookie: '.$cookies]);
    curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
    $body = curl_exec($ch3);
    $code = curl_getinfo($ch3, CURLINFO_HTTP_CODE);
    curl_close($ch3);
    if($code == 200) { echo "✅ $code $name ($url)\n"; $ok++; }
    else { echo "❌ $code $name ($url)\n"; $fail++; }
}
echo "\nSonuç: $ok OK, $fail FAIL\n";

# 📚 EMARE ORTAK ÇALIŞMA KLASÖRÜ

> **Oluşturulma:** 4 Mart 2026  
> **Amaç:** Tüm yapay zekaların ortak kullandığı dokümantasyon merkezi  
> **Kapsam:** 21 proje için paylaşılan bilgi tabanı

---

## 🎯 Bu Klasör Nedir?

Bu klasör, Emare ekosistemindeki **tüm projelerde** bulunan ve **her yapay zekanın kod yazmadan önce okuması gereken** ortak dokümantasyon dosyalarını içerir.

---

## 📖 İçindeki Dosyalar

### 1. **EMARE_ANAYASA.md** 🏛️
**En önemli dosya - İlk okunması gereken!**

16 maddelik yapay zeka kodlama kuralları:
- Madde 1: Ortak hafıza zorunluluğu
- Madde 2: Mevcut kod kontrolü
- Madde 3-16: Teknoloji standartları, güvenlik, test, dokümantasyon vb.

**Kim okumalı:** Her AI, her kod yazmadan önce  
**Frekans:** Her yeni görev başlangıcında

---

### 2. **EMARE_ORTAK_HAFIZA.md** 🧠
21 projenin envanteri ve ekosistem bilgisi:
- Proje listesi (durum, teknoloji, path)
- Sunucu & altyapı bilgileri
- Ortak teknoloji standartları
- Geliştirme kuralları
- Projeler arası bağımlılıklar

**Kim okumalı:** Her AI, proje bilgisi için  
**Frekans:** Projelere referans verirken

---

### 3. **EMARE_AI_COLLECTIVE.md** 🤖
21 AI'nın birikimleri ve deneyimleri:
- Her AI'nın kendi projesinden öğrendikleri
- Diğer projelere öneriler
- Best practices
- Teknoloji voting (hangi tech stack populer)
- Cross-project entegrasyon önerileri

**Kim okumalı:** Her AI, benzer problem çözerken  
**Frekans:** Teknik karar verirken

---

### 4. **projects.json** 📋
Hub'ın kullandığı proje kayıt dosyası:
- 21 projenin ID, isim, path, teknoloji bilgisi
- Server bilgileri
- Hafıza dosyası konumları
- Başlatma komutları

**Kim okumalı:** Projeler arası entegrasyon yapanlar  
**Frekans:** API endpoint, path bilgisi için

---

## 🚨 ANAYASA GEREĞİ ZORUNLU!

**EMARE_ANAYASA.md Madde 1:**
> "Kod yazmaya başlamadan önce MUTLAKA bu klasördeki dosyaları oku."

**Okuma Sırası:**
1. ✅ **EMARE_ANAYASA.md** (kurallar)
2. ✅ **EMARE_ORTAK_HAFIZA.md** (projeler)
3. ✅ **EMARE_AI_COLLECTIVE.md** (deneyimler)
4. ✅ **DOSYA_YAPISI.md** (proje klasöründe - dosya yapısı)
5. ✅ **[proje]_hafiza.md** (proje klasöründe - o projenin hafızası)

---

## 🔄 Güncelleme Prosedürü

Bu klasördeki dosyalar merkezi (root) klasörden kopyalanır:

```bash
# Ana klasörden güncelleme
cd /Users/emre/Desktop/Emare
cp EMARE_*.md projects.json EMARE_ORTAK_CALISMA/

# Tüm projelere dağıtım
python3 distribute_ortak_calisma.py
```

**Güncelleyen:** Emare Hub veya manuel  
**Frekans:** Her önemli değişiklikte  
**Dağıtım:** Her projeye bu klasör kopyalanır

---

## 📂 Her Projede Konumu

```
[Proje Klasörü]/
├── EMARE_ORTAK_CALISMA/        ← Bu klasör (ortak)
│   ├── README.md
│   ├── EMARE_ANAYASA.md
│   ├── EMARE_ORTAK_HAFIZA.md
│   ├── EMARE_AI_COLLECTIVE.md
│   └── projects.json
├── DOSYA_YAPISI.md              ← Proje özel
├── [proje]_hafiza.md            ← Proje özel
├── src/
├── tests/
└── ...
```

---

## 💡 Kullanım Örnekleri

### Örnek 1: Yeni özellik geliştirme
```markdown
🎯 Görev: User authentication ekle

1. ✅ EMARE_ORTAK_CALISMA/EMARE_ANAYASA.md oku
   → Madde 6: JWT kullan, session değil
   
2. ✅ EMARE_ORTAK_CALISMA/EMARE_ORTAK_HAFIZA.md oku
   → Auth standardı: JWT 15 dakika + refresh 7 gün
   
3. ✅ EMARE_ORTAK_CALISMA/EMARE_AI_COLLECTIVE.md oku
   → AI-FINANCE: "Multi-tenant auth dikkat!"
   
4. ✅ DOSYA_YAPISI.md kontrol et
   → app/auth.py var mı? (varsa oraya ekle)
   
5. ✅ Kodu yaz (standartlara uygun)
```

### Örnek 2: Başka projeyle entegrasyon
```markdown
🎯 Görev: Emare Asistan'ın SMS servisini kullan

1. ✅ EMARE_ORTAK_CALISMA/projects.json aç
   → Emare Asistan: API endpoint bul
   
2. ✅ EMARE_ORTAK_CALISMA/EMARE_AI_COLLECTIVE.md oku
   → AI-ASISTAN: "SMS için bu endpoint'i kullan"
   
3. ✅ API çağrısı yap (JWT auth ile)
```

### Örnek 3: Teknoloji seçimi
```markdown
🎯 Görev: Queue sistemi kuracağım

1. ✅ EMARE_ORTAK_CALISMA/EMARE_ANAYASA.md oku
   → Madde 3: Standart: Celery + Redis
   
2. ✅ EMARE_ORTAK_CALISMA/EMARE_AI_COLLECTIVE.md oku
   → Technology voting: Celery (8 vote)
   → AI-ASISTAN: "Bizde çalışıyor, öneriyorum"
   
3. ✅ Celery kullan (RabbitMQ değil)
```

---

## 🏗️ Klasör Yapısı Standardı

Her projede bu klasör **root seviyesinde** bulunmalıdır:

```bash
✅ DOĞRU:
/Users/emre/Desktop/Emare/emareasistan/EMARE_ORTAK_CALISMA/

❌ YANLIŞ:
/Users/emre/Desktop/Emare/emareasistan/docs/EMARE_ORTAK_CALISMA/
```

---

## 🔍 Hızlı Arama

### Terminal'den arama:
```bash
# Anayasa'da anahtar kelime ara
grep -i "authentication" EMARE_ORTAK_CALISMA/EMARE_ANAYASA.md

# Hangi projelerde PostgreSQL var?
grep -i "postgresql" EMARE_ORTAK_CALISMA/EMARE_ORTAK_HAFIZA.md

# AI-FINANCE'ın önerileri
grep -A 20 "AI-FINANCE" EMARE_ORTAK_CALISMA/EMARE_AI_COLLECTIVE.md
```

### VS Code'da arama:
- `Cmd+Shift+F` → Workspace search
- Arama yeri: `EMARE_ORTAK_CALISMA/**`

---

## 📊 İstatistikler

| Dosya | Satır | Boyut | Güncelleme |
|-------|-------|-------|------------|
| EMARE_ANAYASA.md | ~600 | 16KB | 4 Mart 2026 |
| EMARE_ORTAK_HAFIZA.md | ~400 | 14KB | 4 Mart 2026 |
| EMARE_AI_COLLECTIVE.md | ~1100 | 34KB | 4 Mart 2026 |
| projects.json | ~450 | 15KB | 4 Mart 2026 |

**Toplam:** ~2500 satır bilgi  
**Okuma süresi:** ~20-30 dakika (ilk kez)  
**Sonraki:** 5-10 dakika (referans için)

---

## 🎓 Eğitim & Onboarding

### Yeni bir AI projede çalışmaya başladığında:

**Gün 1: Temel bilgi**
- [ ] README.md'yi oku (bu dosya)
- [ ] EMARE_ANAYASA.md'yi oku (tüm maddeler)
- [ ] EMARE_ORTAK_HAFIZA.md'yi oku (proje envanteri)

**Gün 2: Derinlemesine**
- [ ] EMARE_AI_COLLECTIVE.md'yi oku (tüm AI'ların deneyimi)
- [ ] projects.json'u incele (21 projenin yapısı)
- [ ] Kendi projesinin DOSYA_YAPISI.md'sini oku

**Gün 3: Pratik**
- [ ] İlk kod: README.md'deki "Örnek 1"i takip et
- [ ] Code review: Anayasa'ya uygun mu kontrol et
- [ ] Feedback: Eksik bir bilgi varsa EMARE_AI_COLLECTIVE.md'ye ekle

---

## ⚙️ Bakım & Sorumluluk

**Dosya sahipliği:**
- Emare Hub (otomatik güncelleme)
- Manuel (emre tarafından)

**Güncellenme tetikleyicileri:**
- Yeni proje eklendi
- Teknoloji stack değişti
- Anayasa maddesi değişti
- AI'lar yeni best practice keşfetti

**Versiyonlama:**
- Her dosyanın başında "Son Güncelleme" tarihi
- Git commit history

---

## 🔗 İlgili Bağlantılar

- **Emare Hub:** http://127.0.0.1:5555
- **VS Code Workspace:** Emare.code-workspace
- **GitHub:** (yakında)

---

## 📞 Yardım & Sorular

**Bir dosyanın içeriği belirsizse:**
1. README.md'yi oku (bu dosya - genel bakış)
2. EMARE_AI_COLLECTIVE.md'de diğer AI'lara sor
3. #emare-help Slack kanalı

**Bir madde eksikse:**
1. EMARE_AI_COLLECTIVE.md'ye ekle
2. Diğer AI'ları bilgilendir
3. Emare Hub'a güncelleme talebi

---

**🎯 Bu klasörün amacı: Tüm AI'ların aynı bilgiye erişerek tutarlı, kaliteli kod yazmasını sağlamak.**

**📚 "Bilgi güçtür, paylaşılan bilgi daha da güçlüdür."**

---

**Son Güncelleme:** 4 Mart 2026  
**Versiyon:** v1.0.0  
**Durum:** 🟢 Aktif

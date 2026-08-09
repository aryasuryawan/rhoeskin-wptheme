# Instagram Feed - Setup Guide

## 📋 3 Mode yang Tersedia

### ✅ Mode 1: Manual URLs (REKOMENDASI - Paling Reliable)

**Cara pakai:**
1. Buka `Appearance → Customize → Instagram Feed`
2. Pilih Mode: **"Manual URLs (Input Post Links)"**
3. Copy URL post Instagram (contoh: `https://www.instagram.com/p/ABC123/`)
4. Paste ke field Post URL #1 sampai #6
5. Klik **Publish**

**Kelebihan:**
- ✅ Paling reliable dan stabil
- ✅ Tidak perlu API atau token
- ✅ Tidak ada batasan rate limit
- ✅ Foto otomatis diambil dari Instagram
- ✅ Link langsung ke post asli

**Cara dapat URL post:**
1. Buka Instagram di browser/app
2. Buka post yang mau ditampilkan
3. Klik "..." (titik tiga)
4. Pilih "Copy Link"
5. Paste ke customizer

---

### 🎨 Mode 2: Manual Upload (Via ACF)

**Cara pakai:**
1. Pilih Mode: **"Manual Upload (ACF)"**
2. Upload foto sendiri via ACF field `alya_instagram_images`
3. Kontrol penuh atas foto yang ditampilkan

**Kelebihan:**
- Full control
- Custom image optimization
- Tidak bergantung Instagram

---

### ⚠️ Mode 3: Live Fetch (Experimental)

**Status:** Tidak berfungsi karena Instagram memblokir scraping

Instagram telah menutup akses public scraping untuk melindungi privasi user. Mode ini tidak akan berfungsi kecuali:
- Menggunakan official Instagram API (butuh approval Facebook)
- Setup RSS Bridge server sendiri
- Menggunakan paid service pihak ketiga

**Tidak direkomendasikan untuk production.**

---

## 🎯 Rekomendasi

Gunakan **Mode 1: Manual URLs** karena:
- Setup mudah (tinggal copy-paste URL)
- Tidak perlu upload manual
- Foto selalu update sesuai Instagram
- Official Instagram oEmbed API (gratis & legal)
- Paling reliable untuk jangka panjang

---

## 🔧 Settings Lain

### Cache Duration
- Default: 3600 detik (1 jam)
- Foto di-cache untuk performa lebih cepat
- Auto clear cache saat update setting

### Jumlah Post
- Min: 1 post
- Max: 6 post
- Sesuaikan dengan layout grid

---

## 🐛 Troubleshooting

**Instagram tidak muncul?**
1. Pastikan mode sudah dipilih dengan benar
2. Clear browser cache (Ctrl+Shift+Del)
3. Hard refresh (Ctrl+F5)
4. Cek URL post sudah benar format
5. Pastikan post Instagram adalah public

**Foto loading lama?**
- Normal, foto di-load dari Instagram CDN
- Sudah ada lazy loading
- Cache akan mempercepat load berikutnya

---

## 📝 Notes

- Design sudah match dengan manual upload
- Support video indicator
- Hover effect dengan caption
- Responsive di mobile
- Link langsung ke Instagram post asli

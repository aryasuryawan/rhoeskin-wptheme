# Language Switcher Control - Cara Aktifkan/Nonaktifkan

## 🎛️ Cara Mengontrol Language Switcher

Language switcher di header dapat diaktifkan/nonaktifkan dengan cara berikut:

---

## ✅ Option 1: Disable via Code (Permanent)

### Nonaktifkan Language Switcher

Edit file: `header.php` (line ~60)

**Ubah dari:**
```php
<?php if (function_exists('pll_the_languages')) : ?>
    <div class="lang-switcher-custom">
        ...
    </div>
<?php endif; ?>
```

**Menjadi:**
```php
<?php if (false && function_exists('pll_the_languages')) : ?>
    <div class="lang-switcher-custom">
        ...
    </div>
<?php endif; ?>
```

Atau **comment out** seluruh block:
```php
<?php /* Language Switcher - Disabled
if (function_exists('pll_the_languages')) : ?>
    <div class="lang-switcher-custom">
        ...
    </div>
<?php endif; */ ?>
```

### Aktifkan Kembali

Kembalikan kode ke kondisi semula (hapus `false &&` atau uncomment).

---

## ✅ Option 2: Disable via Theme Customizer (Recommended)

Tambahkan setting di `functions.php` untuk kontrol via WP Customizer:

### 1. Tambahkan Customizer Setting

Edit `functions.php`, tambahkan setelah function `alya_customizer_settings()`:

```php
/**
 * Add Language Switcher Control to Customizer
 */
function alya_language_switcher_customizer($wp_customize) {
    // Add Section
    $wp_customize->add_section('alya_language_settings', [
        'title'    => __('Language Switcher', 'alya-esthetic'),
        'priority' => 35,
    ]);
    
    // Add Setting: Enable/Disable
    $wp_customize->add_setting('alya_show_language_switcher', [
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
    ]);
    
    // Add Control: Checkbox
    $wp_customize->add_control('alya_show_language_switcher', [
        'type'    => 'checkbox',
        'section' => 'alya_language_settings',
        'label'   => __('Show Language Switcher in Header', 'alya-esthetic'),
        'description' => __('Enable to display flag-based language switcher', 'alya-esthetic'),
    ]);
}
add_action('customize_register', 'alya_language_switcher_customizer');
```

### 2. Update header.php

Ubah kondisi di `header.php`:

**Dari:**
```php
<?php if (function_exists('pll_the_languages')) : ?>
```

**Menjadi:**
```php
<?php if (get_theme_mod('alya_show_language_switcher', true) && function_exists('pll_the_languages')) : ?>
```

### 3. Cara Menggunakan

1. Navigate ke **Appearance → Customize**
2. Cari section **"Language Switcher"**
3. **Check** = Language switcher muncul
4. **Uncheck** = Language switcher disembunyikan
5. Click **Publish**

---

## ✅ Option 3: Disable via CSS (Hide Only)

Edit `assets/css/main.css`, tambahkan:

```css
/* Hide language switcher */
.lang-switcher-custom {
    display: none !important;
}
```

**Untuk aktifkan kembali:** Hapus atau comment CSS tersebut.

---

## ✅ Option 4: Conditional Display (By Page/Template)

Edit `header.php`, tambahkan kondisi:

### Hanya tampilkan di homepage:
```php
<?php if (is_front_page() && function_exists('pll_the_languages')) : ?>
```

### Sembunyikan di halaman tertentu:
```php
<?php if (!is_page('kontak') && function_exists('pll_the_languages')) : ?>
```

### Hanya tampilkan untuk user yang login:
```php
<?php if (is_user_logged_in() && function_exists('pll_the_languages')) : ?>
```

---

## 📋 Quick Reference

| Method | Location | Permanent? | Easy to Toggle? |
|--------|----------|------------|-----------------|
| Code (false &&) | header.php | ✅ Yes | ❌ No (need edit file) |
| Customizer | functions.php + header.php | ❌ No | ✅ Yes (via WP Admin) |
| CSS | main.css | ❌ No | ✅ Yes (via stylesheet) |
| Conditional | header.php | ❌ No | ⚠️ Medium (need logic) |

---

## 🔄 Cara Mengaktifkan/Nonaktifkan Polylang Plugin

Untuk disable seluruh Polylang functionality (termasuk language switcher):

### Via WP Admin:
1. Navigate ke **Plugins → Installed Plugins**
2. Find **Polylang**
3. Click **Deactivate**

Untuk aktifkan kembali: Click **Activate**

### Via Code (wp-config.php):
Tambahkan di `wp-config.php`:

```php
// Disable Polylang temporarily
define('POLYLANG_DEACTIVATE', true);
```

Remove atau comment untuk aktifkan kembali.

---

## 🎨 Custom Styling Language Switcher

Edit `assets/css/main.css` untuk customize appearance:

```css
/* Change flag size */
.lang-switcher-btn img,
.lang-option img {
    width: 28px; /* default: 24px */
}

/* Change button padding */
.lang-switcher-btn {
    padding: 10px 14px; /* default: 8px 12px */
}

/* Change dropdown position */
.lang-switcher-dropdown {
    right: auto; /* change alignment */
    left: 0;
}
```

---

## ✨ Summary

**Recommended Method:** **Option 2 (Theme Customizer)**
- Easy untuk non-technical users
- Toggle on/off via WP Admin
- No need to edit code setiap kali
- Reversible tanpa risk breaking site

**Quickest Method:** **Option 3 (CSS)**
- Just add/remove satu line CSS
- Instant effect
- Easy untuk developer

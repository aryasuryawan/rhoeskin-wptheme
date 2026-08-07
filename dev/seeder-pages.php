<?php
/**
 * Page Content Seeder — Fills all pages with content matching original HTML
 *
 * Run via: php seeder-pages.php
 *
 * @package Alya_Esthetic
 */

if (!defined('ABSPATH')) {
    $wp_root = 'D:/laragon/www/alya-test';
    define('ABSPATH', $wp_root . '/');
    define('WPINC', 'wp-includes');
    require_once ABSPATH . 'wp-load.php';
}

echo "=== Alya Esthetic Page Content Seeder ===\n\n";

// Helper: get attachment ID by filename pattern
function seed_get_attach($key) {
    $posts = get_posts([
        'post_type'    => 'attachment',
        'post_title'   => 'seed-' . $key,
        'posts_per_page' => 1,
        'post_status'  => 'inherit',
    ]);
    return !empty($posts) ? $posts[0]->ID : 0;
}

// Helper: get attachment URL by ID
function seed_attach_url($id) {
    if (!$id) return '';
    $url = wp_get_attachment_url($id);
    return $url ?: '';
}

/**
 * Main seeder function — can be called from preinstall.php
 */
function alya_seed_pages() {
    // ═══════════════════════════════════════════
    // 1. TENTANG KAMI
    // ═══════════════════════════════════════════
    echo "1. Updating Tentang Kami page...\n";
    $tentang_id = 0;
    $pages = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => -1]);
    foreach ($pages as $p) {
        if (stripos($p->post_title, 'Tentang') !== false) { $tentang_id = $p->ID; break; }
    }
    if ($tentang_id) {
        // Set template
        update_post_meta($tentang_id, '_wp_page_template', 'templates/page-about.php');
        
        // Clear post_content (remove HTML static content)
        wp_update_post(['ID' => $tentang_id, 'post_content' => '']);
        
        // Set ACF fields for editable page
        $hero_img_id = seed_get_attach('hero-v1');
        $about_img_id = seed_get_attach('about-v1');
        $cta_bg_id = seed_get_attach('seed-filler'); // fallback
        
        update_field('alya_hero_bg', $hero_img_id ?: null, $tentang_id);
        update_field('alya_hero_title', 'Mengenal Lebih Dekat Alya Esthetic Center', $tentang_id);
        update_field('alya_hero_subtitle', 'Tentang Kami', $tentang_id);
        update_field('alya_about_image', $about_img_id ?: null, $tentang_id);
        update_field('alya_about_badge_title', 'One Stop', $tentang_id);
        update_field('alya_about_badge_desc', 'Semua solusi kecantikan di satu tempat', $tentang_id);
        update_field('alya_about_title', 'Hospitality, Kesehatan, dan Solusi Satu Pintu', $tentang_id);
        update_field('alya_about_text', '<p>Alya Esthetic Center hadir sebagai klinik kecantikan yang mengedepankan hospitality, kesehatan, dan solusi satu pintu untuk semua orang. Kami percaya bahwa kecantikan sejati dimulai dari rasa nyaman dan aman selama menjalani perawatan.</p><p>Berlokasi di Jakarta Selatan, kami membangun kepercayaan Sahabat Alya melalui tim dokter profesional, teknologi terkini, dan pendekatan yang personal untuk setiap kebutuhan kulit dan tubuh — mulai dari perawatan wajah, tubuh, hingga program pelangsingan dan wellness.</p><p>Kenyamanan dan kepuasan pasien merupakan prioritas utama kami, begitu pula dengan menjaga kerahasiaan setiap Sahabat Alya yang berkonsultasi dan menjalani perawatan bersama kami.</p>', $tentang_id);
        update_field('alya_about_points', "Tim dokter berpengalaman\nPerawatan efektif & personal\nKerahasiaan terjamin\nRamah keluarga", $tentang_id);
        
        // Stats (JSON)
        update_field('alya_stats', json_encode([
            ['number' => '10+', 'label' => 'Tahun Pengalaman'],
            ['number' => '15+', 'label' => 'Dokter & Terapis'],
            ['number' => '30+', 'label' => 'Jenis Treatment'],
            ['number' => '1000+', 'label' => 'Sahabat Alya Puas'],
        ], JSON_UNESCAPED_UNICODE), $tentang_id);
        
        // Visi & Misi
        update_field('alya_vision_title', 'Visi', $tentang_id);
        update_field('alya_vision_text', 'Menjadi klinik kecantikan terpercaya dan terdepan di Indonesia yang menghadirkan solusi kecantikan satu pintu, aman, dan berbasis hospitality bagi setiap Sahabat Alya.', $tentang_id);
        update_field('alya_mission_title', 'Misi', $tentang_id);
        update_field('alya_mission_points', "Memberikan pelayanan yang ramah, personal, dan mengutamakan kenyamanan pasien.\nMenghadirkan tim dokter dan terapis profesional yang terus mengikuti perkembangan teknologi kecantikan.\nMenjaga kerahasiaan dan kepercayaan setiap Sahabat Alya.\nMenyediakan solusi kecantikan yang efektif, aman, dan terjangkau.", $tentang_id);
        
        // Values
        update_field('alya_values', json_encode([
            ['icon' => 'heart', 'title' => 'Hospitality', 'description' => 'Keramahan dan kenyamanan pasien menjadi dasar dari setiap interaksi di klinik kami.'],
            ['icon' => 'user', 'title' => 'Keamanan', 'description' => 'Setiap prosedur dijalankan sesuai standar medis oleh dokter dan tenaga profesional bersertifikat.'],
            ['icon' => 'star', 'title' => 'Kualitas', 'description' => 'Kami hanya menggunakan produk dan teknologi terkini yang teruji untuk hasil yang optimal.'],
            ['icon' => 'lock', 'title' => 'Kerahasiaan', 'description' => 'Privasi dan kerahasiaan setiap Sahabat Alya selama berkonsultasi dan menjalani perawatan selalu kami jaga.'],
        ], JSON_UNESCAPED_UNICODE), $tentang_id);
        
        // CTA
        update_field('alya_cta_title', 'Rawat Kulit Terbaik, Satu Pintu di Alya Esthetic', $tentang_id);
        update_field('alya_cta_desc', 'Konsultasikan kebutuhan kecantikan Anda bersama tim dokter profesional kami di Jakarta Selatan.', $tentang_id);
        update_field('alya_cta_btn_text', 'Buat Janji Temu', $tentang_id);
        update_field('alya_cta_btn_url', home_url('/kontak/'), $tentang_id);

        echo "  [UPDATE] Tentang Kami #" . $tentang_id . "\n";
    } else {
        echo "  [SKIP] Tentang Kami page not found\n";
    }
    echo "\n";

    // ═══════════════════════════════════════════
    // 2. TEKNOLOGI
    // ═══════════════════════════════════════════
    echo "2. Updating Teknologi page...\n";
    $teknologi_id = 0;
    $pages = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => -1]);
    foreach ($pages as $p) {
        if (stripos($p->post_title, 'Teknologi') !== false) { $teknologi_id = $p->ID; break; }
    }
    if ($teknologi_id) {
        $img_laser    = seed_attach_url(seed_get_attach('svc-skin'));
        $img_hair     = seed_attach_url(seed_get_attach('svc-bar'));
        $img_co2      = seed_attach_url(seed_get_attach('svc-beauty'));
        $img_pico     = seed_attach_url(seed_get_attach('svc-slimming'));
        $img_hifu     = seed_attach_url(seed_get_attach('svc-beauty'));
        $img_thermage = seed_attach_url(seed_get_attach('svc-skin'));
        $img_cool     = seed_attach_url(seed_get_attach('svc-slimming'));
        $img_ems      = seed_attach_url(seed_get_attach('svc-bar'));

        $content = '
<!-- PAGE HERO -->
<div class="page-hero page-hero--bg">
    <div class="container">
        <div class="page-hero__inner">
            <span class="eyebrow">Medical Innovation</span>
            <h1 class="page-hero__title">Teknologi &amp; Medical Devices Berstandar Internasional</h1>
            <p class="page-hero__subtitle">Alya Esthetic berkomitmen menghadirkan perangkat medis terkini yang telah tersertifikasi BPOM, FDA, dan CE Mark demi hasil perawatan yang aman dan optimal.</p>
            <div class="stats-row" style="margin-top:24px;justify-content:center">
                <div class="stat"><b class="stat__number">20+</b><span class="stat__label">Perangkat Medis</span></div>
                <div class="stat"><b class="stat__number">100%</b><span class="stat__label">Bersertifikat Resmi</span></div>
                <div class="stat"><b class="stat__number">15+</b><span class="stat__label">Brand Premium</span></div>
            </div>
        </div>
    </div>
</div>

<!-- CATEGORY NAV -->
<div class="alya-section" style="padding:0;position:sticky;top:0;z-index:100;background:#fff;box-shadow:0 2px 8px rgba(0,0,0,.08)">
    <div class="container">
        <div style="display:flex;gap:0;overflow-x:auto;-webkit-overflow-scrolling:touch">
            <a href="#laser" style="padding:16px 24px;white-space:nowrap;font-weight:600;color:var(--brand);border-bottom:3px solid var(--brand);text-decoration:none">Laser Technology</a>
            <a href="#energy" style="padding:16px 24px;white-space:nowrap;font-weight:500;color:var(--ink-light);text-decoration:none">Energy-Based Devices</a>
            <a href="#slimming" style="padding:16px 24px;white-space:nowrap;font-weight:500;color:var(--ink-light);text-decoration:none">Slimming Devices</a>
            <a href="#cert" style="padding:16px 24px;white-space:nowrap;font-weight:500;color:var(--ink-light);text-decoration:none">Sertifikasi</a>
        </div>
    </div>
</div>

<!-- LASER SECTION -->
<section class="alya-section" id="laser">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px">
            <div>
                <span class="eyebrow">01 — Laser Technology</span>
                <h2>Sistem Laser Medis Canggih</h2>
            </div>
            <span class="badge">FDA &amp; BPOM Approved</span>
        </div>
        <div class="cards-grid cards-grid--2">
            <div class="card">
                <div class="card__image"><img src="' . $img_laser . '" alt="Nd:YAG Laser" width="600" height="400" loading="lazy"></div>
                <div class="card__body">
                    <p style="font-size:.85rem;color:var(--brand);margin:0 0 8px">Cutera · USA</p>
                    <h3 class="card__title">Nd:YAG 1064nm Laser</h3>
                    <p class="card__desc">Sistem laser Neodymium-doped Yttrium Aluminium Garnet untuk pigmentasi, tato, dan rejuvenasi kulit mendalam.</p>
                    <ul style="list-style:none;padding:0;margin:12px 0">
                        <li style="margin-bottom:4px">✓ Mengatasi melasma &amp; hiperpigmentasi</li>
                        <li style="margin-bottom:4px">✓ Laser toning &amp; brightening</li>
                        <li style="margin-bottom:4px">✓ Penghilangan tato &amp; bintik hitam</li>
                        <li style="margin-bottom:4px">✓ Pengencangan pori-pori</li>
                    </ul>
                    <span class="badge">FDA Cleared · BPOM RI</span>
                </div>
            </div>
            <div class="card">
                <div class="card__image"><img src="' . $img_hair . '" alt="Soprano ICE" width="600" height="400" loading="lazy"></div>
                <div class="card__body">
                    <p style="font-size:.85rem;color:var(--brand);margin:0 0 8px">Alma Laser · Israel</p>
                    <h3 class="card__title">Soprano ICE Platinum</h3>
                    <p class="card__desc">Teknologi diode laser 3-panjang gelombang terpadu untuk laser hair removal yang nyaman dan permanen.</p>
                    <ul style="list-style:none;padding:0;margin:12px 0">
                        <li style="margin-bottom:4px">✓ Triple wavelength: 755nm + 810nm + 1064nm</li>
                        <li style="margin-bottom:4px">✓ ICE cooling — nyaman &amp; bebas rasa sakit</li>
                        <li style="margin-bottom:4px">✓ Cocok untuk semua jenis kulit</li>
                        <li style="margin-bottom:4px">✓ Efektif pada rambut halus sekalipun</li>
                    </ul>
                    <span class="badge">CE Mark · FDA Cleared</span>
                </div>
            </div>
            <div class="card">
                <div class="card__image"><img src="' . $img_co2 . '" alt="CO2 Fractional" width="600" height="400" loading="lazy"></div>
                <div class="card__body">
                    <p style="font-size:.85rem;color:var(--brand);margin:0 0 8px">Lumenis · USA</p>
                    <h3 class="card__title">CO₂ Fractional Laser</h3>
                    <p class="card__desc">Laser karbon dioksida fraksional untuk resurfacing, pengencangan kulit, dan koreksi tekstur wajah menyeluruh.</p>
                    <ul style="list-style:none;padding:0;margin:12px 0">
                        <li style="margin-bottom:4px">✓ Menghilangkan bekas jerawat &amp; scar</li>
                        <li style="margin-bottom:4px">✓ Pengencangan kulit non-bedah</li>
                        <li style="margin-bottom:4px">✓ Resurfacing pori-pori kasar</li>
                        <li style="margin-bottom:4px">✓ Stimulasi kolagen jangka panjang</li>
                    </ul>
                    <span class="badge">FDA Cleared · BPOM RI</span>
                </div>
            </div>
            <div class="card">
                <div class="card__image"><img src="' . $img_pico . '" alt="PicoWay" width="600" height="400" loading="lazy"></div>
                <div class="card__body">
                    <p style="font-size:.85rem;color:var(--brand);margin:0 0 8px">Syneron-Candela · USA</p>
                    <h3 class="card__title">PicoWay Picosecond Laser</h3>
                    <p class="card__desc">Laser pikosecond ultra-cepat untuk mengatasi pigmentasi membandel, melasma, dan peremajaan kulit komprehensif.</p>
                    <ul style="list-style:none;padding:0;margin:12px 0">
                        <li style="margin-bottom:4px">✓ Pulsa 300 pikosecond — ultra-presisi</li>
                        <li style="margin-bottom:4px">✓ Multi-wavelength (532 / 785 / 1064nm)</li>
                        <li style="margin-bottom:4px">✓ Minimal downtime</li>
                        <li style="margin-bottom:4px">✓ Efektif untuk Fitzpatrick IV–VI</li>
                    </ul>
                    <span class="badge">FDA Cleared · CE Mark</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ENERGY-BASED DEVICES -->
<section class="alya-section bg-light" id="energy">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px">
            <div>
                <span class="eyebrow">02 — Energy-Based Devices</span>
                <h2>Perangkat Berbasis Energi</h2>
            </div>
            <span class="badge">Non-invasive · No Downtime</span>
        </div>
        <div class="cards-grid cards-grid--2">
            <div class="card">
                <div class="card__image"><img src="' . $img_hifu . '" alt="HIFU" width="600" height="400" loading="lazy"></div>
                <div class="card__body">
                    <p style="font-size:.85rem;color:var(--brand);margin:0 0 8px">Ulthera · USA</p>
                    <h3 class="card__title">HIFU Ultherapy</h3>
                    <p class="card__desc">High-Intensity Focused Ultrasound satu-satunya yang mendapat FDA clearance untuk face lifting non-bedah.</p>
                    <ul style="list-style:none;padding:0;margin:12px 0">
                        <li style="margin-bottom:4px">✓ Lifting alis, pipi, leher &amp; dagu</li>
                        <li style="margin-bottom:4px">✓ Stimulasi kolagen lapisan SMAS</li>
                        <li style="margin-bottom:4px">✓ Hasil natural, tahan 1–2 tahun</li>
                        <li style="margin-bottom:4px">✓ Tanpa sayatan, tanpa pemulihan</li>
                    </ul>
                    <span class="badge">FDA Approved · BPOM RI</span>
                </div>
            </div>
            <div class="card">
                <div class="card__image"><img src="' . $img_thermage . '" alt="Thermage FLX" width="600" height="400" loading="lazy"></div>
                <div class="card__body">
                    <p style="font-size:.85rem;color:var(--brand);margin:0 0 8px">Thermage · USA</p>
                    <h3 class="card__title">Thermage FLX</h3>
                    <p class="card__desc">Radiofrequency monopolar generasi terbaru untuk pengencangan dan pemodelan kontur wajah dan tubuh.</p>
                    <ul style="list-style:none;padding:0;margin:12px 0">
                        <li style="margin-bottom:4px">✓ Deep RF hingga lapisan dermis</li>
                        <li style="margin-bottom:4px">✓ Total Tip 4.0 — cakupan lebih luas</li>
                        <li style="margin-bottom:4px">✓ AccuREP™ adaptive energy delivery</li>
                        <li style="margin-bottom:4px">✓ 1 sesi, hasil progresif 6 bulan</li>
                    </ul>
                    <span class="badge">FDA Cleared · CE Mark</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SLIMMING DEVICES -->
<section class="alya-section" id="slimming">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:24px">
            <div>
                <span class="eyebrow">03 — Slimming Devices</span>
                <h2>Teknologi Body Sculpting</h2>
            </div>
            <span class="badge">Clinically Proven</span>
        </div>
        <div class="cards-grid cards-grid--2">
            <div class="card">
                <div class="card__image"><img src="' . $img_cool . '" alt="CoolSculpting" width="600" height="400" loading="lazy"></div>
                <div class="card__body">
                    <p style="font-size:.85rem;color:var(--brand);margin:0 0 8px">Allergan · USA</p>
                    <h3 class="card__title">CoolSculpting Elite</h3>
                    <p class="card__desc">Teknologi cryolipolysis untuk membekukan dan menghancurkan sel lemak secara permanen tanpa operasi.</p>
                    <ul style="list-style:none;padding:0;margin:12px 0">
                        <li style="margin-bottom:4px">✓ Mengurangi lemak hingga 25% per sesi</li>
                        <li style="margin-bottom:4px">✓ Dual applicator — 2x lebih cepat</li>
                        <li style="margin-bottom:4px">✓ FDA Cleared untuk 9 area tubuh</li>
                        <li style="margin-bottom:4px">✓ Tanpa anestesi, tanpa downtime</li>
                    </ul>
                    <span class="badge">FDA Cleared · BPOM RI</span>
                </div>
            </div>
            <div class="card">
                <div class="card__image"><img src="' . $img_ems . '" alt="Emsculpt NEO" width="600" height="400" loading="lazy"></div>
                <div class="card__body">
                    <p style="font-size:.85rem;color:var(--brand);margin:0 0 8px">BTL · Czech Republic</p>
                    <h3 class="card__title">Emsculpt NEO</h3>
                    <p class="card__desc">Kombinasi RF + HIFEM (High-Intensity Focused Electromagnetic) untuk bakar lemak dan bangun otot secara bersamaan.</p>
                    <ul style="list-style:none;padding:0;margin:12px 0">
                        <li style="margin-bottom:4px">✓ 30% pengurangan lemak + 25% peningkatan otot</li>
                        <li style="margin-bottom:4px">✓ Teknologi HIFEM 20.000 kontraksi/sesi</li>
                        <li style="margin-bottom:4px">✓ Perut, lengan, bokong, paha</li>
                        <li style="margin-bottom:4px">✓ Sesi 30 menit — setara 20.000 sit-up</li>
                    </ul>
                    <span class="badge">FDA Cleared · CE Mark</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CERTIFICATIONS -->
<section class="alya-section bg-dark" id="cert" style="background:var(--brand-dark,#1a1a2e)">
    <div class="container" style="text-align:center">
        <span class="eyebrow center">Sertifikasi &amp; Standar</span>
        <h2>Perangkat Berstandar &amp; Bersertifikat Internasional</h2>
        <p class="lead center">Setiap alat yang kami gunakan telah melalui proses sertifikasi ketat dari lembaga regulasi kesehatan terkemuka dunia.</p>
        <div class="cards-grid cards-grid--4" style="margin-top:32px">
            <div class="card card--compact" style="text-align:center">
                <div style="font-size:2rem;margin-bottom:8px">🇺🇸</div>
                <h3 style="font-size:1rem">FDA</h3>
                <p class="card__desc">U.S. Food &amp; Drug Administration</p>
            </div>
            <div class="card card--compact" style="text-align:center">
                <div style="font-size:2rem;margin-bottom:8px">🇪🇺</div>
                <h3 style="font-size:1rem">CE Mark</h3>
                <p class="card__desc">European Conformity Standard</p>
            </div>
            <div class="card card--compact" style="text-align:center">
                <div style="font-size:2rem;margin-bottom:8px">🇮🇩</div>
                <h3 style="font-size:1rem">BPOM RI</h3>
                <p class="card__desc">Badan Pengawas Obat &amp; Makanan</p>
            </div>
            <div class="card card--compact" style="text-align:center">
                <div style="font-size:2rem;margin-bottom:8px">🌍</div>
                <h3 style="font-size:1rem">ISO 13485</h3>
                <p class="card__desc">Medical Device Quality Mgmt</p>
            </div>
        </div>
        <div class="card card--compact" style="text-align:center;margin-top:16px;max-width:240px;margin-left:auto;margin-right:auto">
            <div style="font-size:2rem;margin-bottom:8px">🏥</div>
            <h3 style="font-size:1rem">Kemenkes RI</h3>
            <p class="card__desc">Izin Alat Kesehatan Resmi</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-section__overlay"></div>
    <div class="container">
        <div class="cta-section__content">
            <span class="eyebrow center" style="color:rgba(255,255,255,.8)">Mulai Perjalanan Kecantikan Anda</span>
            <h2 class="cta-section__title">Rasakan Teknologi Medis Terbaik</h2>
            <p class="cta-section__desc">Konsultasikan kebutuhan Anda dengan dokter kami dan temukan treatment berbasis teknologi yang paling tepat.</p>
            <div class="cta-section__actions">
                <a href="https://wa.me/6281290000000?text=Halo,%20saya%20ingin%20konsultasi" class="btn btn--wa btn--lg" target="_blank" rel="noopener">Konsultasi Gratis</a>
            </div>
        </div>
    </div>
</section>';
        wp_update_post(['ID' => $teknologi_id, 'post_content' => $content]);
        echo "  [UPDATE] Teknologi #" . $teknologi_id . "\n";
    } else {
        echo "  [SKIP] Teknologi page not found\n";
    }
    echo "\n";

    // ═══════════════════════════════════════════
    // 3. KONTAK
    // ═══════════════════════════════════════════
    echo "3. Updating Kontak page...\n";
    $kontak_id = 0;
    $pages = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => -1]);
    foreach ($pages as $p) {
        if (stripos($p->post_title, 'Kontak') !== false) { $kontak_id = $p->ID; break; }
    }
    if ($kontak_id) {
        $kontak_content = '
<!-- ============ PAGE HERO ============ -->
<section class="page-hero page-hero--bg">
  <div class="page-hero__bg"></div>
  <div class="container">
    <span class="eyebrow">Kontak Kami</span>
    <h1>Kami Siap Membantu Anda</h1>
    <div class="breadcrumb">
      <a href="' . esc_url(home_url('/')) . '">Beranda</a>
      <span>/</span>
      <a href="' . get_permalink($kontak_id) . '" style="color:#fff">Kontak</a>
    </div>
  </div>
</section>

<!-- ============ QUICK INFO ============ -->
<div class="quick">
  <div class="container grid">
    <div class="item">
      <div class="ic"><svg viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.2-9C1.2 8.2 3 5 6.4 5c2 0 3.4 1.1 4 2.3h3.2c.6-1.2 2-2.3 4-2.3 3.4 0 5.2 3.2 3.6 7-2.2 4.4-9.2 9-9.2 9z"/></svg></div>
      <div><b>Lokasi Klinik</b><p>Jakarta Selatan, Indonesia</p></div>
    </div>
    <div class="item">
      <div class="ic"><svg viewBox="0 0 24 24"><path d="M6.6 10.8A14.5 14.5 0 0013.2 17.4l2.6-2.6c.3-.3.7-.4 1-.2 1.1.3 2.3.5 3.5.5.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A16 16 0 014 5c0-.6.4-1 1-1h3.8c.6 0 1 .4 1 1 0 1.2.2 2.4.5 3.5.1.4 0 .7-.2 1L7.5 10.5z"/></svg></div>
      <div><b>WhatsApp</b><a href="https://wa.me/6281290000000" target="_blank" rel="noopener">Chat via WhatsApp</a></div>
    </div>
    <div class="item">
      <div class="ic"><svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg></div>
      <div><b>Jam Operasional</b><p>Setiap Hari, 09.00–20.00 WIB</p></div>
    </div>
  </div>
</div>

<!-- ============ CONTACT ============ -->
<section class="contact" id="form">
  <div class="container grid">
    <div class="contact__info">
      <span class="eyebrow">Contact Us</span>
      <h3>Kunjungi Klinik Kami</h3>
      <p class="lead">Ada pertanyaan seputar treatment atau ingin konsultasi terlebih dahulu? Hubungi kami melalui salah satu kanal di bawah ini, tim kami akan segera merespon.</p>
      <ul>
        <li>
          <div class="ic"><svg viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.2-9C1.2 8.2 3 5 6.4 5c2 0 3.4 1.1 4 2.3h3.2c.6-1.2 2-2.3 4-2.3 3.4 0 5.2 3.2 3.6 7-2.2 4.4-9.2 9-9.2 9z"/></svg></div>
          <div><b>Lokasi</b><p>Jakarta Selatan, Indonesia</p></div>
        </li>
        <li>
          <div class="ic"><svg viewBox="0 0 24 24"><path d="M6.6 10.8A14.5 14.5 0 0013.2 17.4l2.6-2.6c.3-.3.7-.4 1-.2 1.1.3 2.3.5 3.5.5.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A16 16 0 014 5c0-.6.4-1 1-1h3.8c.6 0 1 .4 1 1 0 1.2.2 2.4.5 3.5.1.4 0 .7-.2 1L7.5 10.5z"/></svg></div>
          <div><b>Telepon / WhatsApp</b><a href="https://wa.me/6281290000000" target="_blank" rel="noopener">Chat via WhatsApp</a></div>
        </li>
        <li>
          <div class="ic"><svg viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12c0 1.1.9 2 2 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg></div>
          <div><b>Email</b><a href="mailto:hello@alyaesthetic.id">hello@alyaesthetic.id</a></div>
        </li>
      </ul>
      <div class="hours">
        <table>
          <tr><td>Senin – Jumat</td><td>09.00 – 20.00 WIB</td></tr>
          <tr><td>Sabtu – Minggu</td><td>09.00 – 20.00 WIB</td></tr>
          <tr><td>Hari Libur Nasional</td><td>09.00 – 18.00 WIB</td></tr>
        </table>
      </div>
      <div class="socials">
        <a href="https://www.instagram.com/alyaesthetic/" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.3-2.2-.4a3.8 3.8 0 01-1.4-.9 3.8 3.8 0 01-.9-1.4c-.2-.4-.4-1-.4-2.2-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c.1-1.2.3-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4 1.3-.1 1.7-.1 4.9-.1zm0-2.2C8.7 0 8.3 0 7 .1 5.7.1 4.8.4 4 .7 3.1 1 2.4 1.5 1.7 2.2 1 2.9.5 3.6.2 4.5-.1 5.3-.3 6.2-.3 7.5 0 8.8 0 9.2 0 12s0 3.2.1 4.5c.1 1.3.3 2.2.7 3.1.3.9.8 1.6 1.5 2.3.7.7 1.4 1.2 2.3 1.5.9.3 1.8.5 3.1.5 1.3.1 1.7.1 5 .1s3.7-.1 4.9-.1c1.3-.1 2.2-.3 3.1-.7.9-.3 1.6-.8 2.3-1.5.7-.7 1.2-1.4 1.5-2.3.3-.9.5-1.8.5-3.1.1-1.3.1-1.7.1-5s-.1-3.7-.1-4.9c-.1-1.3-.3-2.2-.7-3.1-.3-.9-.8-1.6-1.5-2.3C20.9 1 20.2.5 19.3.2 18.4-.1 17.5-.3 16.2-.3 14.9 0 14.5 0 12 0zm0 5.8a6.2 6.2 0 100 12.4 6.2 6.2 0 000-12.4zm0 10.2a4 4 0 110-8 4 4 0 010 8zm6.4-11.8a1.4 1.4 0 100 2.9 1.4 1.4 0 000-2.9z"/></svg></a>
        <a href="https://wa.me/6281290000000" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-.9-.3-.1-.5-.1-.7.2-.2.2-.7.9-.9 1.1-.2.2-.3.2-.6.1-1.3-.6-2.2-1.1-3-2.3-.2-.4.2-.4.6-1.1.1-.2 0-.3 0-.4s-.7-1.7-1-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-1.1 1.1-1.3 2.5-.3 4 .1.1 2.3 3.6 5.7 5.1a9 9 0 001.9.7c.8.3 1.5.2 2.1.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.5-.3zM12 21a9 9 0 01-7.7-4.4l-1.8.6 1-1.8A9 9 0 1112 21zm0-19.8C5.9 1.2 1 6 1 12c0 1.9.6 3.8 1.6 5.5L1 21l3.6-1a11 11 0 002.2 1.6A10.9 10.9 0 0012 23c6.1 0 11-4.9 11-11C23 6 18 1.2 12 1.2z"/></svg></a>
        <a href="https://www.tiktok.com/@alyaestheticcenter" target="_blank" rel="noopener" aria-label="TikTok"><svg viewBox="0 0 24 24"><path d="M19.3 8.5a5.3 5.3 0 01-3.1-1 5 5 0 01-2-3.9V3.2h-3.3v11.9a2.5 2.5 0 01-2.5 2.4 2.5 2.5 0 01-2.5-2.4 2.5 2.5 0 012.5-2.5c.3 0 .5 0 .8.1V8.9c-.3 0-.5-.1-.8-.1a5.9 5.9 0 100 11.8c3.2 0 5.8-2.6 5.8-5.8V9.9a8.4 8.4 0 004.7 1.5V8.5z"/></svg></a>
        <a href="https://www.youtube.com/@alya.esthetic/featured" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24"><path d="M21.6 7.2a2.6 2.6 0 00-1.8-1.8A30.6 30.6 0 0012 5a30.6 30.6 0 00-7.8.4A2.6 2.6 0 002.4 7.2 26.5 26.5 0 002 12c0 1.6.1 3.2.4 4.8a2.6 2.6 0 001.8 1.8A30.6 30.6 0 0012 19c2.6 0 5.2-.1 7.8-.4a2.6 2.6 0 001.8-1.8c.3-1.6.4-3.2.4-4.8s-.1-3.2-.4-4.8zM10 15V9l5 3-5 3z"/></svg></a>
      </div>
    </div>

    <form class="form" id="bookingForm">
      <h3>Buat Janji Temu</h3>
      <p>Isi form di bawah, tim kami akan menghubungi Anda untuk konfirmasi.</p>
      <div class="field-row">
        <div class="field">
          <label for="fNama">Nama Lengkap</label>
          <input id="fNama" type="text" required placeholder="Nama Anda">
        </div>
        <div class="field">
          <label for="fWA">No. WhatsApp</label>
          <input id="fWA" type="tel" required placeholder="08xx-xxxx-xxxx">
        </div>
      </div>
      <div class="field-row">
        <div class="field">
          <label for="fEmail">Email (opsional)</label>
          <input id="fEmail" type="email" placeholder="nama@email.com">
        </div>
        <div class="field">
          <label for="fLayanan">Layanan</label>
          <select id="fLayanan">
            <option>Skin Serenity</option>
            <option>Beauty Advance</option>
            <option>Slimming &amp; Wellness</option>
            <option>Alya Beauty Bar</option>
          </select>
        </div>
      </div>
      <div class="field">
        <label for="fTanggal">Tanggal (opsional)</label>
        <input id="fTanggal" type="date">
      </div>
      <div class="field">
        <label for="fPesan">Pesan</label>
        <textarea id="fPesan" placeholder="Ceritakan kebutuhan Anda..."></textarea>
      </div>
      <button class="btn" type="submit">Kirim Permintaan</button>
    </form>
  </div>
</section>

<!-- ============ MAP ============ -->
<section class="map">
  <div class="container">
    <div class="map__head">
      <span class="eyebrow">Lokasi</span>
      <h2>Temukan Kami di Sini</h2>
      <p class="lead" style="margin:0 auto">Kunjungi klinik kami di Jakarta Selatan untuk konsultasi langsung bersama tim dokter.</p>
    </div>
    <div class="map__frame">
      <iframe src="https://www.google.com/maps?q=Jakarta%20Selatan&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Alya Esthetic Center"></iframe>
    </div>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="faq">
  <div class="container">
    <div class="faq__head">
      <span class="eyebrow">FAQ</span>
      <h2>Pertanyaan yang Sering Diajukan</h2>
      <p class="lead">Beberapa hal yang paling sering ditanyakan Sahabat Alya sebelum melakukan reservasi.</p>
    </div>
    <div class="faq-list">
      <details class="faq-item">
        <summary>Apakah saya perlu reservasi terlebih dahulu?</summary>
        <p>Ya, kami sarankan untuk membuat janji temu terlebih dahulu melalui WhatsApp atau form di halaman ini agar jadwal konsultasi dan treatment dapat disesuaikan dengan dokter yang Anda pilih.</p>
      </details>
      <details class="faq-item">
        <summary>Apakah konsultasi awal dikenakan biaya?</summary>
        <p>Kebijakan biaya konsultasi dapat berbeda tergantung jenis layanan. Silakan hubungi tim kami melalui WhatsApp untuk informasi terbaru sebelum kunjungan Anda.</p>
      </details>
      <details class="faq-item">
        <summary>Apakah data dan privasi pasien terjamin?</summary>
        <p>Kerahasiaan Sahabat Alya adalah prioritas kami. Seluruh data dan riwayat perawatan pasien dijaga kerahasiaannya sesuai standar klinik.</p>
      </details>
      <details class="faq-item">
        <summary>Apakah Alya Esthetic ramah untuk keluarga?</summary>
        <p>Tentu. Alya Esthetic Center dirancang untuk menjadi klinik yang nyaman dan ramah bagi seluruh anggota keluarga, dari remaja hingga dewasa.</p>
      </details>
    </div>
  </div>
</section>';
        wp_update_post(['ID' => $kontak_id, 'post_content' => $kontak_content]);
        echo "  [UPDATE] Kontak #" . $kontak_id . "\n";
    } else {
        echo "  [SKIP] Kontak page not found\n";
    }
    echo "\n";

    // ═══════════════════════════════════════════
    // 4. KARIR
    // ═══════════════════════════════════════════
    echo "4. Updating Karir page...\n";
    $karir_id = 0;
    $pages = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => -1]);
    foreach ($pages as $p) {
        if (stripos($p->post_title, 'Karir') !== false) { $karir_id = $p->ID; break; }
    }
    if ($karir_id) {
        $jobs = get_posts(['post_type' => 'jobs', 'posts_per_page' => -1, 'post_status' => 'publish']);
        $karir_job_cards = '';
        foreach ($jobs as $job) {
            $cat = get_post_meta($job->ID, '_job_category', true) ?: 'medis';
            $type = get_post_meta($job->ID, '_job_type', true) ?: 'Full-time';
            $location = get_post_meta($job->ID, '_job_location', true) ?: 'Jakarta Selatan';
            $deadline = get_post_meta($job->ID, '_job_deadline', true) ?: '30 Sep 2026';
            $cat_label = ucfirst(str_replace('-', ' ', $cat));
            $karir_job_cards .= '
        <a class="job-card" data-cat="' . esc_attr($cat) . '" href="' . get_permalink($job->ID) . '">
          <div class="job-card__main">
            <div class="job-card__top">
              <span class="tag">' . esc_html($cat_label) . '</span>
              <span class="job-type">' . esc_html($type) . '</span>
            </div>
            <h3>' . esc_html($job->post_title) . '</h3>
            <div class="job-meta">
              <span><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg> ' . esc_html($location) . '</span>
              <span><svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg> Batas lamaran: ' . esc_html($deadline) . '</span>
            </div>
          </div>
          <span class="job-card__cta">Lihat Detail <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg></span>
        </a>';
        }
        $karir_content = '
<!-- ============ PAGE HEADER ============ -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow">Bergabung Bersama Kami</span>
    <h1>Karir di Alya Esthetic Center</h1>
    <p class="lead">Jadi bagian dari tim yang membantu banyak orang tampil lebih percaya diri. Kami mencari individu yang berdedikasi, ramah, dan ingin terus berkembang di industri kecantikan &amp; kesehatan.</p>
    <div class="crumb">
      <a href="' . esc_url(home_url('/')) . '">Beranda</a><span>/</span><a href="' . get_permalink($karir_id) . '" style="color:#fff">Karir</a>
    </div>
  </div>
</div>

<!-- ============ WHY JOIN US ============ -->
<section class="values">
  <div class="container center" style="max-width:640px">
    <span class="eyebrow">Kenapa Alya Esthetic</span>
    <h2>Lingkungan Kerja yang Suportif</h2>
    <p class="lead">Kami percaya tim yang sejahtera dan terus belajar adalah kunci memberikan pelayanan terbaik untuk pasien.</p>
  </div>
  <div class="container">
    <div class="value-grid">
      <div class="value-card">
        <div class="ic"><svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg></div>
        <h4>Tim yang Kolaboratif</h4>
        <p>Budaya kerja yang saling mendukung antar tim medis dan non-medis.</p>
      </div>
      <div class="value-card">
        <div class="ic"><svg viewBox="0 0 24 24"><path d="M12 6v6l4 2-.8 1.6-5.2-2.6V6h2zm0-4a10 10 0 100 20 10 10 0 000-20z"/></svg></div>
        <h4>Pengembangan Karir</h4>
        <p>Pelatihan berkala dan jenjang karir yang jelas untuk setiap posisi.</p>
      </div>
      <div class="value-card">
        <div class="ic"><svg viewBox="0 0 24 24"><path d="M12 2l3 6 6 .9-4.5 4.3 1 6-5.5-3-5.5 3 1-6L3 8.9 9 8z"/></svg></div>
        <h4>Benefit Kompetitif</h4>
        <p>Gaji, tunjangan, dan fasilitas perawatan yang menarik bagi karyawan.</p>
      </div>
      <div class="value-card">
        <div class="ic"><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 5v5.6l4.5 2.7-.9 1.5-5.6-3.3V7h2z"/></svg></div>
        <h4>Keseimbangan Kerja</h4>
        <p>Jadwal kerja yang teratur dengan perhatian pada kesejahteraan karyawan.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FILTER BAR ============ -->
<div class="filterbar">
  <div class="container">
    <div class="chips">
      <button class="chip active" data-filter="semua">Semua</button>
      <button class="chip" data-filter="medis">Medis</button>
      <button class="chip" data-filter="non-medis">Non-Medis</button>
      <button class="chip" data-filter="marketing">Marketing</button>
    </div>
    <div class="searchbox">
      <svg viewBox="0 0 24 24"><path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 10-.7.7l.3.3v.8l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/></svg>
      <input type="text" id="searchInput" placeholder="Cari posisi...">
    </div>
  </div>
</div>

<!-- ============ JOB LIST ============ -->
<section class="jobs">
  <div class="container jobs__layout">
    <div>
      <div class="jobs-list" id="jobsGrid">
        ' . $karir_job_cards . '
      </div>
      <div class="empty-state" id="emptyState">
        Tidak ada posisi yang cocok dengan pencarian Anda. Coba kata kunci lain atau kirimkan CV Anda untuk kami pertimbangkan di kesempatan berikutnya.
      </div>
    </div>
    <aside class="sidebar">
      <div class="side-box">
        <h4>Proses Rekrutmen</h4>
        <div class="step-item"><span class="num">1</span><div><h5>Kirim Lamaran</h5><p>Kirimkan CV &amp; portofolio melalui email atau WhatsApp.</p></div></div>
        <div class="step-item"><span class="num">2</span><div><h5>Seleksi Administrasi</h5><p>Tim HR akan meninjau kesesuaian kualifikasi Anda.</p></div></div>
        <div class="step-item"><span class="num">3</span><div><h5>Wawancara</h5><p>Wawancara dengan tim HR dan user terkait.</p></div></div>
        <div class="step-item"><span class="num">4</span><div><h5>Penawaran Kerja</h5><p>Kandidat terpilih akan menerima offering letter.</p></div></div>
      </div>
      <div class="side-box">
        <h4>Kategori Posisi</h4>
        <div class="tagcloud">
          <a href="#">Medis</a><a href="#">Non-Medis</a><a href="#">Marketing</a><a href="#">Full-time</a><a href="#">Jakarta Selatan</a>
        </div>
      </div>
      <div class="side-box cta-box">
        <h4>Tidak Menemukan Posisi yang Sesuai?</h4>
        <p>Kirimkan CV Anda untuk kami pertimbangkan di kesempatan berikutnya.</p>
        <a class="btn" href="https://wa.me/6281290000000?text=Halo,%20saya%20ingin%20melamar%20pekerjaan" target="_blank" rel="noopener">Kirim CV via WhatsApp</a>
      </div>
    </aside>
  </div>
</section>';
        wp_update_post(['ID' => $karir_id, 'post_content' => $karir_content, 'page_template' => 'templates/page-karir.php']);
        echo "  [UPDATE] Karir #" . $karir_id . "\n";
    } else {
        echo "  [SKIP] Karir page not found\n";
    }
    echo "\n";

    // ═══════════════════════════════════════════
    // 5. LAYANAN PAGE
    // ═══════════════════════════════════════════
    echo "5. Creating/updating Layanan page...\n";
    $layanan_id = 0;
    foreach ($pages as $p) {
        if (stripos($p->post_title, 'Layanan') !== false) { $layanan_id = $p->ID; break; }
    }
    if (!$layanan_id) {
        $layanan_id = wp_insert_post([
            'post_type'    => 'page',
            'post_title'   => 'Layanan',
            'post_name'    => 'layanan',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        echo "  [CREATE] Layanan #" . $layanan_id . "\n";
    }

    // Build treatment cards from CPT
    $skin_svc = get_posts(['post_type' => 'treatment', 'posts_per_page' => 20, 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC']);
    $layanan_cards = '';
    $fallback_imgs = [
        get_template_directory_uri() . '/assets/images/treatments/glass-skin-facial.png',
        get_template_directory_uri() . '/assets/images/treatments/filler.png',
        get_template_directory_uri() . '/assets/images/treatments/slimming-injection.png',
        get_template_directory_uri() . '/assets/images/treatments/laser-hair-removal.png',
    ];
    foreach ($skin_svc as $i => $svc) {
        $img = get_the_post_thumbnail_url($svc->ID, 'full') ?: $fallback_imgs[$i % count($fallback_imgs)];
        $excerpt = wp_trim_words(strip_tags($svc->post_content), 16);
        $layanan_cards .= '<a class="t-card" href="' . esc_url(get_permalink($svc->ID)) . '">
          <div class="t-card__img"><img src="' . esc_url($img) . '" alt="' . esc_attr($svc->post_title) . '" loading="lazy"></div>
          <div class="t-card__body">
            <h3>' . esc_html($svc->post_title) . '</h3>
            <p>' . esc_html($excerpt) . '</p>
            <span class="link">Lihat Detail <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg></span>
          </div>
        </a>';
    }
    if (!$layanan_cards) {
        $layanan_cards = '<p style="color:var(--ink-light);grid-column:1/-1;text-align:center;padding:40px 0">Belum ada treatment. Silakan tambahkan treatment terlebih dahulu.</p>';
    }

    $layanan_content = '
<!-- ============ LAYANAN PAGEHEAD ============ -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow">Layanan Kami</span>
    <h1>Solusi Kecantikan Terlengkap</h1>
    <p class="lead" style="max-width:600px">Pilih treatment yang sesuai dengan kebutuhan kulit Anda — dari facial wajah, treatment laser, hingga program pelangsingan tubuh.</p>
    <div class="filterbar" style="margin-top:24px">
      <div class="chips">
        <a href="#" class="chip is-active" data-filter="all">Semua Treatment</a>
      </div>
    </div>
    <div class="searchbox" style="margin-top:16px">
      <svg viewBox="0 0 24 24"><path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 10-.7.7l.3.3v.8l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/></svg>
      <input type="text" id="searchInput" placeholder="Cari treatment atau layanan...">
    </div>
  </div>
</div>

<!-- ============ LAYANAN GRID ============ -->
<section class="alya-section">
  <div class="container">
    <div class="t-grid" id="tGrid">
      ' . $layanan_cards . '
    </div>
    <div class="empty-state" id="emptyState" style="display:none;text-align:center;padding:60px 0;color:var(--ink-light)">
      Tidak ada treatment yang cocok dengan pencarian Anda.
    </div>
  </div>
</section>

<!-- ============ CTA BAND ============ -->
<section class="cta-band">
  <div class="container">
    <div class="cta-band__inner">
      <div>
        <h2>Mau Tampil Cantik Alami?</h2>
        <p>Konsultasikan kebutuhan treatment kulit &amp; kecantikan Anda bersama dokter spesialis kami. Konsultasi online gratis — chat sekarang.</p>
      </div>
      <a href="https://api.whatsapp.com/send?phone=6281290000000&text=Halo%20Alya%20Esthetic%2C%20saya%20ingin%20konsultasi" class="btn btn--white">Chat Sekarang</a>
    </div>
  </div>
</section>';
    wp_update_post(['ID' => $layanan_id, 'post_content' => $layanan_content]);
    echo "  [UPDATE] Layanan #" . $layanan_id . "\n";

    // ═══════════════════════════════════════════
    // 6. DOKTER PAGE
    // ═══════════════════════════════════════════
    echo "6. Creating/updating Dokter page...\n";
    $dokter_id = 0;
    foreach ($pages as $p) {
        if (stripos($p->post_title, 'Dokter') !== false) { $dokter_id = $p->ID; break; }
    }
    if (!$dokter_id) {
        $dokter_id = wp_insert_post([
            'post_type'    => 'page',
            'post_title'   => 'Dokter Kami',
            'post_name'    => 'dokter',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        echo "  [CREATE] Dokter Kami #" . $dokter_id . "\n";
    }

    // Build doctor cards from CPT
    $doctors = get_posts(['post_type' => 'doctor', 'posts_per_page' => 20, 'post_status' => 'publish']);
    $doc_cards = '';
    $doc_fallback_imgs = [
        'https://alyaesthetic.id/wp-content/uploads/2024/08/dokter1.jpg',
        'https://alyaesthetic.id/wp-content/uploads/2024/08/dokter2.jpg',
    ];
    foreach ($doctors as $i => $doc) {
        $avatar = get_the_post_thumbnail_url($doc->ID, 'full') ?: $doc_fallback_imgs[$i % count($doc_fallback_imgs)];
        $pos = get_post_meta($doc->ID, 'alya_position', true) ?: 'Dokter Spesialis';
        $doc_cards .= '<a href="' . esc_url(get_permalink($doc->ID)) . '" class="doc-card">
          <div class="doc-card__img">
            <img src="' . esc_url($avatar) . '" alt="' . esc_attr($doc->post_title) . '" loading="lazy">
          </div>
          <div class="doc-card__body">
            <h3>' . esc_html($doc->post_title) . '</h3>
            <span class="tag">' . esc_html($pos) . '</span>
          </div>
        </a>';
    }
    if (!$doc_cards) {
        $doc_cards = '<p style="color:var(--ink-light);grid-column:1/-1;text-align:center;padding:40px 0">Belum ada dokter. Silakan tambahkan profil dokter terlebih dahulu.</p>';
    }

    $dokter_content = '
<!-- ============ DOKTER PAGEHEAD ============ -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow">Tim Dokter Kami</span>
    <h1>Dokter Spesialis Kami</h1>
    <p class="lead" style="max-width:600px">Dokter-dokter profesional kami siap membantu Anda mencapai kulit dan tubuh impian dengan perawatan yang aman dan efektif.</p>
    <div class="filterbar" style="margin-top:24px">
      <div class="chips">
        <a href="#" class="chip is-active" data-filter="all">Semua Dokter</a>
        <a href="#" class="chip" data-filter="dokter-umum">Dokter Umum</a>
        <a href="#" class="chip" data-filter="dokter-spesialis-kulit">Spesialis Kulit</a>
        <a href="#" class="chip" data-filter="dokter-spesialis-bedah">Spesialis Bedah</a>
      </div>
    </div>
  </div>
</div>

<!-- ============ DOKTER GRID ============ -->
<section class="alya-section">
  <div class="container">
    <div class="doc-grid" id="docGrid">
      ' . $doc_cards . '
    </div>
  </div>
</section>

<!-- ============ CTA BAND ============ -->
<section class="cta-band">
  <div class="container">
    <div class="cta-band__inner">
      <div>
        <h2>Mau Konsultasi dengan Dokter Kami?</h2>
        <p>Hubungi kami untuk membuat janji temu atau konsultasi online gratis dengan dokter spesialis kami.</p>
      </div>
      <a href="https://api.whatsapp.com/send?phone=6281290000000&text=Halo%20Alya%20Esthetic%2C%20saya%20ingin%20konsultasi" class="btn btn--white">Chat Sekarang</a>
    </div>
  </div>
</section>';
    wp_update_post(['ID' => $dokter_id, 'post_content' => $dokter_content]);
    echo "  [UPDATE] Dokter Kami #" . $dokter_id . "\n";
    echo "\n";

    // ═══════════════════════════════════════════
    // 7. TEKNOLOGI PAGE
    // ═══════════════════════════════════════════
    echo "7. Creating/updating Teknologi page...\n";
    $teknologi_id = 0;
    foreach ($pages as $p) {
        if (stripos($p->post_title, 'Teknologi') !== false) { $teknologi_id = $p->ID; break; }
    }
    if (!$teknologi_id) {
        $teknologi_id = wp_insert_post([
            'post_type'    => 'page',
            'post_title'   => 'Teknologi',
            'post_name'    => 'teknologi',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        echo "  [CREATE] Teknologi #" . $teknologi_id . "\n";
    }

    $teknologi_content = '
<!-- ============ TEKNOLOGI PAGEHEAD ============ -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow">Teknologi Kami</span>
    <h1>Peralatan Medis Terkini</h1>
    <p class="lead" style="max-width:600px">Kami menggunakan teknologi dan peralatan medis terkini untuk memastikan hasil treatment yang optimal dan aman bagi pasien.</p>
  </div>
</div>

<!-- ============ TECH GRID ============ -->
<section class="alya-section">
  <div class="container">
    <div class="t-grid" style="grid-template-columns:repeat(3,1fr)">
      <div class="t-card">
        <div class="t-card__img"><img src="' . get_template_directory_uri() . '/assets/images/treatments/glass-skin-facial.png" alt="Laser Teknologi Terkini" loading="lazy"></div>
        <div class="t-card__body">
          <span class="t-card__tag">Laser</span>
          <h3>Laser Teknologi Terkini</h3>
          <p>Peralatan laser terkini untuk treatment kulit yang efektif dan minim downtime.</p>
        </div>
      </div>
      <div class="t-card">
        <div class="t-card__img"><img src="' . get_template_directory_uri() . '/assets/images/treatments/filler.png" alt="RF & Ultrasound" loading="lazy"></div>
        <div class="t-card__body">
          <span class="t-card__tag">RF & Ultrasound</span>
          <h3>Radio Frequency & Ultrasound</h3>
          <p>Teknologi non-invasif untuk pengencangan kulit dan pembentukan tubuh.</p>
        </div>
      </div>
      <div class="t-card">
        <div class="t-card__img"><img src="' . get_template_directory_uri() . '/assets/images/treatments/slimming-injection.png" alt="Cryotherapy" loading="lazy"></div>
        <div class="t-card__body">
          <span class="t-card__tag">Cryotherapy</span>
          <h3>Cryotherapy & Slimming</h3>
          <p>Teknologi pendingin untuk perawatan kulit dan pelangsingan tubuh.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ SAFETY SECTION ============ -->
<section class="alya-section bg-light">
  <div class="container center" style="max-width:700px">
    <span class="eyebrow">Keamanan Pasien</span>
    <h2>Standar Keamanan Tertinggi</h2>
    <p class="lead" style="margin:0 auto">Semua peralatan kami telah mendapatkan sertifikasi dari BPOM dan internasional. Tim medis kami terlatih dan bersertifikat untuk mengoperasikan setiap peralatan dengan standar keselamatan yang ketat.</p>
  </div>
</section>';
    wp_update_post(['ID' => $teknologi_id, 'post_content' => $teknologi_content]);
    echo "  [UPDATE] Teknologi #" . $teknologi_id . "\n";
    echo "\n";

    // ═══════════════════════════════════════════
    // 8. GALERI PAGE
    // ═══════════════════════════════════════════
    echo "8. Creating/updating Galeri page...\n";
    $galeri_id = 0;
    foreach ($pages as $p) {
        if (stripos($p->post_title, 'Galeri') !== false || stripos($p->post_title, 'Gallery') !== false) { $galeri_id = $p->ID; break; }
    }
    if (!$galeri_id) {
        $galeri_id = wp_insert_post([
            'post_type'    => 'page',
            'post_title'   => 'Galeri',
            'post_name'    => 'galeri',
            'post_status'  => 'publish',
            'post_content' => '',
            'page_template' => 'templates/page-gallery.php',
        ]);
        echo "  [CREATE] Galeri #" . $galeri_id . "\n";
    } else {
        wp_update_post(['ID' => $galeri_id, 'page_template' => 'templates/page-gallery.php']);
    }

    // Helper to find attachment by filename (with or without 'seed-' prefix)
    function seed_find_attach($filename) {
        // Try with seed- prefix first
        $attach = get_posts([
            'post_type'    => 'attachment',
            'post_status'  => 'inherit',
            'meta_query'   => [[
                'key'     => '_wp_attached_file',
                'value'   => 'seed/' . $filename,
                'compare' => 'LIKE',
            ]],
            'posts_per_page' => 1,
        ]);
        if (!empty($attach)) return $attach[0]->ID;
        // Try without prefix
        $attach = get_posts([
            'post_type'    => 'attachment',
            'post_status'  => 'inherit',
            'meta_query'   => [[
                'key'     => '_wp_attached_file',
                'value'   => $filename,
                'compare' => 'LIKE',
            ]],
            'posts_per_page' => 1,
        ]);
        return !empty($attach) ? $attach[0]->ID : 0;
    }

    // Gallery items data: Before_Image_ID | After_Image_ID | category | Tag | Title | Description | Duration | Patient_Info
    // Using existing seed images as before/after pairs
    $gallery_items_data = [
        [
            'before' => seed_find_attach('treat-hydra.png'),
            'after'  => seed_find_attach('post-facial.png'),
            'cat'    => 'rejuvenation',
            'tag'    => 'Facial Treatment',
            'title'  => 'Hydra Facial Glow Up',
            'desc'   => 'Transformasi kulit wajah dari kusam menjadi cerah bercahaya setelah 1x perawatan Hydra Facial.',
            'duration' => '60 menit',
            'patient'  => 'Wanita, 28 tahun',
        ],
        [
            'before' => seed_find_attach('treat-laser.png'),
            'after'  => seed_find_attach('ig-3.png'),
            'cat'    => 'laser',
            'tag'    => 'Laser Treatment',
            'title'  => 'Laser Pigment Removal',
            'desc'   => 'Penghilangan noda pigmentasi dan flek hitam secara tuntas dengan teknologi laser terkini.',
            'duration' => '45 menit',
            'patient'  => 'Wanita, 35 tahun',
        ],
        [
            'before' => seed_find_attach('treat-botox.png'),
            'after'  => seed_find_attach('ig-4.png'),
            'cat'    => 'filler',
            'tag'    => 'Filler & Botox',
            'title'  => 'Botox Anti-Aging',
            'desc'   => 'Pengurangan garis-garis halus dan kerutan pada wajah dengan injeksi botox yang presisi.',
            'duration' => '30 menit',
            'patient'  => 'Wanita, 42 tahun',
        ],
        [
            'before' => seed_find_attach('treat-rf.jpg'),
            'after'  => seed_find_attach('ig-1.png'),
            'cat'    => 'slimming',
            'tag'    => 'Slimming Treatment',
            'title'  => 'RF Body Slimming',
            'desc'   => 'Pengurangan lemak tubuh dan pengencangan kulit pada area perut dengan radio frequency.',
            'duration' => '90 menit',
            'patient'  => 'Pria, 38 tahun',
        ],
        [
            'before' => seed_find_attach('ig-2.png'),
            'after'  => seed_find_attach('ig-5.png'),
            'cat'    => 'acne',
            'tag'    => 'Acne Treatment',
            'title'  => 'Acne Clear Program',
            'desc'   => 'Program perawatan jerawat intensif yang berhasil membersihkan wajah dari jerawat aktif dan bekasnya.',
            'duration' => '120 menit',
            'patient'  => 'Wanita, 22 tahun',
        ],
        [
            'before' => seed_find_attach('ig-6.png'),
            'after'  => seed_find_attach('post-slimming.png'),
            'cat'    => 'slimming',
            'tag'    => 'Slimming Treatment',
            'title'  => 'Body Contouring Result',
            'desc'   => 'Hasil pembentukan tubuh ideal setelah serangkaian perawatan slimming di Alya Esthetic.',
            'duration' => '90 menit',
            'patient'  => 'Wanita, 30 tahun',
        ],
    ];

    // Build pipe-delimited text for alya_gallery_items field
    $gallery_lines = [];
    foreach ($gallery_items_data as $item) {
        if (!$item['before'] || !$item['after']) continue;
        $gallery_lines[] = implode(' | ', [
            $item['before'],
            $item['after'],
            $item['cat'],
            $item['tag'],
            $item['title'],
            $item['desc'],
            $item['duration'],
            $item['patient'],
        ]);
    }
    $gallery_items_text = implode("\n", $gallery_lines);

    // Set ACF fields if available
    if (function_exists('update_field')) {
        // Hero background
        $hero_bg_id = seed_find_attach('hero-v1');
        if ($hero_bg_id) {
            update_field('alya_hero_bg', $hero_bg_id, $galeri_id);
        }
        update_field('alya_hero_title', 'Before & After Gallery', $galeri_id);
        update_field('alya_hero_subtitle', 'Setiap foto adalah kisah nyata transformasi pasien kami. Geser gambar untuk melihat perbandingan hasil perawatan yang luar biasa.', $galeri_id);
        update_field('alya_gallery_disclaimer', 'Foto-foto di bawah ini ditampilkan dengan persetujuan penuh dari pasien. Hasil perawatan dapat bervariasi tergantung kondisi kulit, jenis perawatan, dan faktor individu masing-masing. Konsultasikan dengan dokter kami untuk estimasi hasil yang lebih akurat.', $galeri_id);
        update_field('alya_gallery_items', $gallery_items_text, $galeri_id);
        echo "  [ACF] Set hero + " . count($gallery_lines) . " gallery items (pipe-delimited)\n";
    } else {
        echo "  [SKIP] ACF not available\n";
    }
    echo "  [UPDATE] Galeri #" . $galeri_id . "\n";
    echo "\n";

    // ═══════════════════════════════════════════
    // 9. FLUSH REWRITE
    // ═══════════════════════════════════════════
    echo "8. Flushing rewrite rules...\n";
    flush_rewrite_rules(true);
    echo "  Done.\n\n";

    // ═══════════════════════════════════════════
    // 6. VERIFY
    // ═══════════════════════════════════════════
    echo "6. Verification...\n";
    global $wpdb;
    $counts = $wpdb->get_results("SELECT post_type, COUNT(*) as cnt FROM {$wpdb->posts} WHERE post_status='publish' AND post_type != 'revision' GROUP BY post_type");
    foreach ($counts as $row) {
        echo "  {$row->post_type}: {$row->cnt}\n";
    }

    echo "\n=== Page Seeder Complete! ===\n";
}

// ═══════════════════════════════════════════
// DIRECT CLI RUN
// ═══════════════════════════════════════════
if (php_sapi_name() === 'cli' && !defined('ALYA_SEEDER_CALLED')) {
    alya_seed_pages();
    echo "\nVisit: http://localhost/alya-test/\n";
}

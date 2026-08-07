<?php
/**
 * Test Data Seeder — V2 Homepage Settings
 *
 * Correctly injects settings into the serialized theme_mods array
 * so that get_theme_mod() can read them.
 *
 * Run via: php seeder-v2.php
 *
 * @package Alya_Esthetic
 */

if (!defined('ABSPATH')) {
    $wp_root = 'D:/laragon/www/alya-test';
    define('ABSPATH', $wp_root . '/');
    define('WPINC', 'wp-includes');
    require_once ABSPATH . 'wp-load.php';
}

echo "=== Alya Esthetic V2 Homepage Seeder ===\n\n";

$theme_slug = 'alya-theme';
$mods_option = 'theme_mods_' . $theme_slug;

// Get current serialized theme mods
$mods = get_option($mods_option, []);
if (!is_array($mods)) {
    $mods = [];
}
echo "Current theme mods count: " . count($mods) . "\n\n";

// ═══════════════════════════════════════════
// 1. HOMEPAGE STYLE
// ═══════════════════════════════════════════
echo "1. Setting Homepage Style to V2...\n";
$mods['alya_homepage_style'] = 'v2';

// ═══════════════════════════════════════════
// 2. V2 SECTION TOGGLES (all enabled)
// ═══════════════════════════════════════════
echo "2. Enabling all V2 section toggles...\n";
$v2_toggles = [
    'alya_v2_show_marquee'       => true,
    'alya_v2_show_about'         => true,
    'alya_v2_show_services_v2'   => true,
    'alya_v2_show_signature'     => true,
    'alya_v2_show_promo'         => true,
    'alya_v2_show_stats_band'    => true,
    'alya_v2_show_doctors_grid'  => true,
    'alya_v2_show_testimonials'  => true,
    'alya_v2_show_instagram'     => true,
    'alya_v2_show_articles'      => true,
    'alya_v2_show_career'        => true,
    'alya_v2_show_faq'           => true,
    'alya_v2_show_contact'       => true,
];
foreach ($v2_toggles as $key => $val) {
    $mods[$key] = $val;
    echo "  [SET] {$key} = true\n";
}

// ═══════════════════════════════════════════
// 3. V2 HERO CONTENT
// ═══════════════════════════════════════════
echo "\n3. Setting V2 Hero Content...\n";
$hero_content = [
    'alya_v2_hero_eyebrow'   => 'Klinik Kecantikan Satu Pintu · Jakarta Selatan',
    'alya_v2_hero_title'     => 'Kulit Sehat Dimulai dari Kebiasaan yang Tepat',
    'alya_v2_hero_subtitle'  => 'Alya Esthetic Center memadukan pendekatan medis, hospitality, dan konsistensi rutinitas untuk membantu Anda tampil lebih percaya diri — dipandu langsung oleh tim dokter berpengalaman.',
    'alya_v2_hero_cta_text'  => 'Buat Janji Sekarang',
    'alya_v2_hero_cta_url'   => 'https://wa.me/6281290000000?text=Halo,%20saya%20ingin%20konsultasi',
    'alya_v2_hero_cta2_text' => 'Jelajahi Layanan',
    'alya_v2_hero_cta2_url'  => '#layanan',
];
foreach ($hero_content as $key => $val) {
    $mods[$key] = $val;
    echo "  [SET] {$key}\n";
}

// ═══════════════════════════════════════════
// 4. V2 HERO STATS (JSON string — stored as array in mods)
// ═══════════════════════════════════════════
echo "\n4. Setting V2 Hero Stats...\n";
$mods['alya_v2_hero_stats'] = [
    ['number' => '10rb+', 'label' => 'Pasien Terlayani'],
    ['number' => '10+', 'label' => 'Tahun Beroperasi'],
    ['number' => '15+', 'label' => 'Dokter & Terapis Ahli'],
    ['number' => '4.9/5', 'label' => 'Rating Kepuasan Pasien'],
];
echo "  [SET] alya_v2_hero_stats\n";

// ═══════════════════════════════════════════
// 5. V2 STATS BAND (JSON string)
// ═══════════════════════════════════════════
echo "\n5. Setting V2 Stats Band...\n";
$mods['alya_v2_stats_band'] = [
    ['number' => '10rb+', 'label' => 'Pasien Terlayani'],
    ['number' => '50+', 'label' => 'Jenis Treatment'],
    ['number' => '15+', 'label' => 'Dokter & Terapis Ahli'],
    ['number' => '4.9/5', 'label' => 'Rating Kepuasan Pasien'],
];
echo "  [SET] alya_v2_stats_band\n";

// ═══════════════════════════════════════════
// 6. V2 ABOUT SECTION
// ═══════════════════════════════════════════
echo "\n6. Setting V2 About Content...\n";
$mods['alya_v2_about_title'] = 'Kecantikan yang Dirawat, Bukan Sekadar Ditutupi';
$mods['alya_v2_about_desc'] = 'Alya Esthetic Center hadir sebagai klinik kecantikan satu pintu di Jakarta Selatan, menggabungkan layanan medis, hospitality, dan edukasi rutinitas harian dalam satu pengalaman perawatan.';
$mods['alya_v2_about_points'] = [
    'Ditangani langsung oleh dokter & terapis bersertifikat',
    'Alat dan produk sesuai standar keamanan klinik',
    'Rencana perawatan personal sesuai kondisi kulit',
];
echo "  [SET] alya_v2_about_title, desc, points\n";

// ═══════════════════════════════════════════
// 7. V2 SERVICES SECTION
// ═══════════════════════════════════════════
echo "\n7. Setting V2 Services Content...\n";
$mods['alya_v2_services_title'] = 'Empat Pilar Perawatan Alya Esthetic';
$mods['alya_v2_services_lead'] = 'Setiap layanan dirancang untuk kebutuhan yang berbeda — dari perawatan wajah harian hingga treatment lanjutan.';
echo "  [SET] alya_v2_services_title, lead\n";

// ═══════════════════════════════════════════
// 8. V2 SIGNATURE BANNER
// ═══════════════════════════════════════════
echo "\n8. Setting V2 Signature Banner...\n";
$mods['alya_v2_signature_title'] = 'Glass Skin Facial: Kulit Bercahaya Ala Korea';
$mods['alya_v2_signature_desc'] = 'Kombinasi pembersihan mendalam, eksfoliasi lembut, dan infus nutrisi untuk kulit yang tampak lebih halus dan bercahaya seketika.';
$mods['alya_v2_signature_cta_text'] = 'Lihat Detail Treatment';
$mods['alya_v2_signature_cta_url'] = '/layanan';
echo "  [SET] alya_v2_signature_*\n";

// ═══════════════════════════════════════════
// 9. V2 FAQ SECTION
// ═══════════════════════════════════════════
echo "\n9. Setting V2 FAQ Content...\n";
$mods['alya_v2_faq_title'] = 'Pertanyaan yang Sering Diajukan';
$mods['alya_v2_faq_lead'] = 'Belum menemukan jawaban yang kamu cari? Hubungi tim kami langsung via WhatsApp.';
echo "  [SET] alya_v2_faq_title, lead\n";

// ═══════════════════════════════════════════
// 10. V2 CAREER SECTION
// ═══════════════════════════════════════════
echo "\n10. Setting V2 Career Content...\n";
$mods['alya_v2_career_title'] = 'Ingin Berkarir Bersama Kami?';
$mods['alya_v2_career_desc'] = 'Lihat lowongan yang tersedia di Alya Esthetic Center.';
echo "  [SET] alya_v2_career_title, desc\n";

// ═══════════════════════════════════════════
// 11. SAVE SERIALIZED THEME MODS
// ═══════════════════════════════════════════
echo "\n11. Saving serialized theme mods...\n";
update_option($mods_option, $mods);
echo "  [SAVED] " . $mods_option . " (" . count($mods) . " keys)\n";

// ═══════════════════════════════════════════
// 12. FRONT PAGE SETTINGS
// ═══════════════════════════════════════════
echo "\n12. Ensuring Front Page is set correctly...\n";
update_option('show_on_front', 'page');
update_option('page_on_front', 15);
update_option('page_for_posts', 86);
echo "  [SET] show_on_front=page, page_on_front=15\n";

// ═══════════════════════════════════════════
// 13. PERMALINKS
// ═══════════════════════════════════════════
echo "\n13. Setting Permalinks...\n";
update_option('permalink_structure', '/%postname%/');
flush_rewrite_rules(true);
echo "  [SET] permalinks + flushed\n";

// ═══════════════════════════════════════════
// 14. CLEANUP: Remove any stale separate options
// ═══════════════════════════════════════════
echo "\n14. Cleaning up stale separate options...\n";
$stale_options = [
    'alya_homepage_style',
    'alya_v2_show_marquee', 'alya_v2_show_about', 'alya_v2_show_services_v2',
    'alya_v2_show_signature', 'alya_v2_show_promo', 'alya_v2_show_stats_band', 'alya_v2_show_doctors_grid',
    'alya_v2_show_testimonials', 'alya_v2_show_instagram', 'alya_v2_show_articles',
    'alya_v2_show_career', 'alya_v2_show_faq', 'alya_v2_show_contact',
    'alya_v2_hero_eyebrow', 'alya_v2_hero_title', 'alya_v2_hero_subtitle',
    'alya_v2_hero_cta_text', 'alya_v2_hero_cta_url', 'alya_v2_hero_cta2_text', 'alya_v2_hero_cta2_url',
    'alya_v2_hero_stats', 'alya_v2_stats_band',
    'alya_v2_about_title', 'alya_v2_about_desc', 'alya_v2_about_points',
    'alya_v2_services_title', 'alya_v2_services_lead',
    'alya_v2_signature_title', 'alya_v2_signature_desc',
    'alya_v2_signature_cta_text', 'alya_v2_signature_cta_url',
    'alya_v2_promo_title', 'alya_v2_promo_lead',
    'alya_v2_faq_title', 'alya_v2_faq_lead',
    'alya_v2_career_title', 'alya_v2_career_desc',
];
foreach ($stale_options as $opt) {
    delete_option($opt);
}
echo "  [CLEANED] " . count($stale_options) . " stale options removed\n";

// ═══════════════════════════════════════════
// 15. VERIFY
// ═══════════════════════════════════════════
echo "\n15. Verification via get_theme_mod()...\n";
echo "  homepage_style: " . var_export(get_theme_mod('alya_homepage_style', 'MISSING'), true) . "\n";
echo "  hero_title: " . var_export(get_theme_mod('alya_v2_hero_title', 'MISSING'), true) . "\n";
echo "  hero_eyebrow: " . var_export(get_theme_mod('alya_v2_hero_eyebrow', 'MISSING'), true) . "\n";
echo "  show_marquee: " . var_export(get_theme_mod('alya_v2_show_marquee', 'MISSING'), true) . "\n";
echo "  about_title: " . var_export(get_theme_mod('alya_v2_about_title', 'MISSING'), true) . "\n";
echo "  services_title: " . var_export(get_theme_mod('alya_v2_services_title', 'MISSING'), true) . "\n";
echo "  faq_title: " . var_export(get_theme_mod('alya_v2_faq_title', 'MISSING'), true) . "\n";
echo "  hero_stats type: " . gettype(get_theme_mod('alya_v2_hero_stats', null)) . "\n";
echo "  show_on_front: " . get_option('show_on_front') . "\n";
echo "  page_on_front: " . get_option('page_on_front') . "\n";

// Count published posts
global $wpdb;
$counts = $wpdb->get_results("SELECT post_type, COUNT(*) as cnt FROM {$wpdb->posts} WHERE post_status='publish' AND post_type != 'revision' GROUP BY post_type");
echo "\n  Published Content:\n";
foreach ($counts as $row) {
    echo "    {$row->post_type}: {$row->cnt}\n";
}

echo "\n=== Seeder Complete! ===\n";
echo "Visit: http://localhost/alya-test/\n";

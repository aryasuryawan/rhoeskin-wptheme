<?php
/**
 * Career Page Seeder
 *
 * Seeds: career_category terms, Customizer settings, and sample job posts.
 *
 * Run via: php seed-career.php
 *
 * @package Alya_Esthetic
 */

if (!defined('ABSPATH')) {
    $wp_root = 'D:/laragon/www/alya-test';
    define('ABSPATH', $wp_root . '/');
    define('WPINC', 'wp-includes');
    require_once ABSPATH . 'wp-load.php';
}

echo "=== Alya Esthetic Career Seeder ===\n\n";

$theme_slug = 'alya-theme';
$mods_option = 'theme_mods_' . $theme_slug;
$mods = get_option($mods_option, []);
if (!is_array($mods)) $mods = [];

// ═══════════════════════════════════════════
// 1. CAREER CATEGORY TAXONOMY TERMS
// ═══════════════════════════════════════════
echo "1. Creating career_category terms...\n";

$categories = [
    'medis'     => 'Medis',
    'non-medis' => 'Non-Medis',
    'marketing' => 'Marketing',
];

foreach ($categories as $slug => $name) {
    $term = get_term_by('slug', $slug, 'career_category');
    if (!$term) {
        $result = wp_insert_term($name, 'career_category', ['slug' => $slug]);
        if (!is_wp_error($result)) {
            echo "  [CREATE] $name (slug: $slug)\n";
        } else {
            echo "  [ERROR] " . $result->get_error_message() . "\n";
        }
    } else {
        echo "  [EXISTS] $name (slug: $slug, ID: {$term->term_id})\n";
    }
}

// ═══════════════════════════════════════════
// 2. JOB TYPE TAXONOMY TERMS
// ═══════════════════════════════════════════
echo "\n2. Creating job_type terms...\n";

$job_types = [
    'full-time'  => 'Full-time',
    'part-time'  => 'Part-time',
    'contract'   => 'Contract',
    'internship' => 'Internship',
];

foreach ($job_types as $slug => $name) {
    $term = get_term_by('slug', $slug, 'job_type');
    if (!$term) {
        $result = wp_insert_term($name, 'job_type', ['slug' => $slug]);
        if (!is_wp_error($result)) {
            echo "  [CREATE] $name (slug: $slug)\n";
        } else {
            echo "  [ERROR] " . $result->get_error_message() . "\n";
        }
    } else {
        echo "  [EXISTS] $name (slug: $slug, ID: {$term->term_id})\n";
    }
}

// ═══════════════════════════════════════════
// 3. CUSTOMIZER SETTINGS
// ═══════════════════════════════════════════
echo "\n3. Setting career page customizer...\n";

$career_settings = [
    // Hero
    'alya_career_hero_eyebrow'  => 'Bergabung Bersama Kami',
    'alya_career_hero_subtitle' => 'Jadi bagian dari tim yang membantu banyak orang tampil lebih percaya diri. Kami mencari individu yang berdedikasi, ramah, dan ingin terus berkembang di industri kecantikan & kesehatan.',
    'alya_career_hero_bg'       => get_template_directory_uri() . '/assets/images/career/hero-bg.jpg',
    // Values
    'alya_career_values_eyebrow' => 'Kenapa Alya Esthetic',
    'alya_career_values_title'   => 'Lingkungan Kerja yang Suportif',
    'alya_career_values_subtitle' => 'Kami percaya tim yang sejahtera dan terus belajar adalah kunci memberikan pelayanan terbaik untuk pasien.',
    'alya_career_values' => "user | Tim yang Kolaboratif | Budaya kerja yang saling mendukung antar tim medis dan non-medis.\nclock | Pengembangan Karir | Pelatihan berkala dan jenjang karir yang jelas untuk setiap posisi.\nstar | Benefit Kompetitif | Gaji, tunjangan, dan fasilitas perawatan yang menarik bagi karyawan.\ncalendar | Keseimbangan Kerja | Jadwal kerja yang teratur dengan perhatian pada kesejahteraan karyawan.",
    // Sidebar
    'alya_career_steps' => "1 | Kirim Lamaran | Kirimkan CV & portofolio melalui email atau WhatsApp.\n2 | Seleksi Administrasi | Tim HR akan meninjau kesesuaian kualifikasi Anda.\n3 | Wawancara | Wawancara dengan tim HR dan user terkait.\n4 | Penawaran Kerja | Kandidat terpilih akan menerima offering letter.",
    'alya_career_cta_title' => 'Tidak Menemukan Posisi yang Sesuai?',
    'alya_career_cta_desc'  => 'Kirimkan CV Anda untuk kami pertimbangkan di kesempatan berikutnya.',
];

foreach ($career_settings as $key => $val) {
    $mods[$key] = $val;
    echo "  [SET] $key\n";
}

// ═══════════════════════════════════════════
// 4. SAVE THEME MODS
// ═══════════════════════════════════════════
echo "\n4. Saving theme mods...\n";
update_option($mods_option, $mods);
echo "  [SAVED] $mods_option (" . count($mods) . " keys)\n";

// ═══════════════════════════════════════════
// 5. SAMPLE JOB POSTS
// ═══════════════════════════════════════════
echo "\n5. Creating sample job posts...\n";

$jobs = [
    [
        'title'       => 'Beauty Therapist',
        'category'    => 'medis',
        'job_type'    => 'full-time',
        'location'    => 'Jakarta Selatan',
        'experience'  => '1-3 Tahun',
        'deadline'    => '30 Sep 2026',
        'excerpt'     => 'Menangani perawatan facial dan body treatment sesuai standar operasional klinik.',
        'content'     => '<h4>Tentang Posisi</h4><p>Beauty Therapist bertanggung jawab untuk melakukan perawatan facial dan body treatment kepada pasien sesuai dengan prosedur dan standar operasional yang berlaku di klinik.</p><h4>Tanggung Jawab</h4><ul><li>Melakukan konsultasi awal dengan pasien</li><li>Menjalankan treatment sesuai protokol</li><li>Merawat dan menjaga kebersihan alat kerja</li><li>Mendokumentasikan hasil treatment</li></ul><h4>Kualifikasi</h4><ul><li>Pendidikan minimal D3 Kecantikan atau setara</li><li>Pengalaman minimal 1 tahun di klinik kecantikan</li><li>Sertifikat kecantikan masih berlaku</li><li>Terampil dan teliti dalam bekerja</li></ul>',
    ],
    [
        'title'       => 'Dokter Estetika (Aesthetic Doctor)',
        'category'    => 'medis',
        'job_type'    => 'full-time',
        'location'    => 'Jakarta Selatan',
        'experience'  => '2-5 Tahun',
        'deadline'    => '15 Sep 2026',
        'excerpt'     => 'Menangani prosedur medis estetik dan konsultasi pasien.',
        'content'     => '<h4>Tentang Posisi</h4><p>Aesthetic Doctor bertanggung jawab untuk menangani prosedur medis estetik, melakukan konsultasi, dan merencanakan treatment yang sesuai dengan kondisi kulit pasien.</p><h4>Tanggung Jawab</h4><ul><li>Melakukan konsultasi dan diagnosis kulit</li><li>Menjalankan prosedur medis estetik (laser, injectable, dll)</li><li>Membuat rencana perawatan personal</li><li>Mendampingi pasien selama dan setelah prosedur</li></ul><h4>Kualifikasi</h4><ul><li>Struktur Dokter (S.Ked) atau Sp.KK</li><li>Pengalaman minimal 2 tahun di bidang estetika</li><li>Memiliki STR aktif</li><li>Terdaftar di IDI</li></ul>',
    ],
    [
        'title'       => 'Perawat Klinik (Clinic Nurse)',
        'category'    => 'medis',
        'job_type'    => 'full-time',
        'location'    => 'Jakarta Selatan',
        'experience'  => '1-2 Tahun',
        'deadline'    => '20 Sep 2026',
        'excerpt'     => 'Membantu prosedur medis dan merawat pasien di klinik.',
        'content'     => '<h4>Tentang Posisi</h4><p>Clinic Nurse bertanggung jawab untuk membantu prosedur medis, merawat pasien, dan memastikan kebersihan serta keamanan klinik.</p><h4>Tanggung Jawab</h4><ul><li>Membantu dokter dalam prosedur medis</li><li>Merawat dan mempersiapkan pasien</li><li>Menjaga kebersihan dan sterilisasi alat</li><li>Mengelola stok obat dan alat medis</li></ul><h4>Kualifikasi</h4><ul><li>Pendidikan minimal D3 Keperawatan</li><li>Pengalaman minimal 1 tahun di klinik</li><li>Memiliki STR aktif</li><li>Teliti dan bertanggung jawab</li></ul>',
    ],
    [
        'title'       => 'Beauty Consultant / Customer Service',
        'category'    => 'non-medis',
        'job_type'    => 'full-time',
        'location'    => 'Jakarta Selatan',
        'experience'  => '1-3 Tahun',
        'deadline'    => '25 Sep 2026',
        'excerpt'     => 'Melayani konsultasi dan memberikan rekomendasi perawatan kepada pasien.',
        'content'     => '<h4>Tentang Posisi</h4><p>Beauty Consultant bertanggung jawab untuk melayani konsultasi pasien, memberikan rekomendasi perawatan, dan memastikan kepuasan pelanggan.</p><h4>Tanggung Jawab</h4><ul><li>Melayani konsultasi via telepon dan langsung</li><li>Memberikan rekomendasi treatment yang sesuai</li><li>Menjalin hubungan baik dengan pasien</li><li>Mengelola jadwal appointment</li></ul><h4>Kualifikasi</h4><ul><li>Pendidikan minimal SMA/Sederajat</li><li>Pengalaman 1 tahun di bidang customer service</li><li>Komunikatif dan ramah</li><li>Tertarik di bidang kecantikan</li></ul>',
    ],
    [
        'title'       => 'Social Media & Content Specialist',
        'category'    => 'marketing',
        'job_type'    => 'full-time',
        'location'    => 'Jakarta Selatan',
        'experience'  => '1-3 Tahun',
        'deadline'    => '10 Sep 2026',
        'excerpt'     => 'Mengelola media sosial dan membuat konten kreatif untuk klinik.',
        'content'     => '<h4>Tentang Posisi</h4><p>Social Media & Content Specialist bertanggung jawab untuk mengelola semua platform media sosial klinik, membuat konten kreatif, dan meningkatkan engagement audiens.</p><h4>Tanggung Jawab</h4><ul><li>Mengelola konten Instagram, TikTok, dan platform lainnya</li><li>Membuat desain grafis dan video pendek</li><li>Menyusun strategi konten bulanan</li><li>Menganalisis performa konten</li></ul><h4>Kualifikasi</h4><ul><li>Pendidikan minimal D3/S1 Komunikasi atau Marketing</li><li>Menguasai Canva, CapCut, atau tools desain lainnya</li><li>Pengalaman mengelola media sosial bisnis</li><li>Kreatif dan up-to-date dengan tren digital</li></ul>',
    ],
    [
        'title'       => 'Staff Admin & Finance',
        'category'    => 'non-medis',
        'job_type'    => 'full-time',
        'location'    => 'Jakarta Selatan',
        'experience'  => '2-4 Tahun',
        'deadline'    => '5 Sep 2026',
        'excerpt'     => 'Mengelola administrasi keuangan dan operasional klinik.',
        'content'     => '<h4>Tentang Posisi</h4><p>Staff Admin & Finance bertanggung jawab untuk mengelola administrasi keuangan, pembukuan, dan operasional harian klinik.</p><h4>Tanggung Jawab</h4><ul><li>Mengelola pembukuan harian dan bulanan</li><li>Memproses pembayaran dan tagihan</li><li>Membuat laporan keuangan</li><li>Mengelola dokumen administrasi klinik</li></ul><h4>Kualifikasi</h4><ul><li>Pendidikan minimal D3/S1 Akuntansi atau Keuangan</li><li>Pengalaman 2 tahun di bidang administrasi/finance</li><li>Menguasai software akuntansi (Jurnal, Zahir, dll)</li><li>Detail dan terorganisir</li></ul>',
    ],
];

foreach ($jobs as $job) {
    // Check if post already exists
    $existing = get_posts([
        'post_type'   => 'jobs',
        'title'       => $job['title'],
        'post_status' => 'publish',
        'numberposts' => 1,
    ]);

    if ($existing) {
        echo "  [EXISTS] {$job['title']} (ID: {$existing[0]->ID})\n";
        $post_id = $existing[0]->ID;
    } else {
        $post_id = wp_insert_post([
            'post_type'   => 'jobs',
            'post_title'  => $job['title'],
            'post_content' => $job['content'],
            'post_excerpt' => $job['excerpt'],
            'post_status' => 'publish',
        ]);

        if (is_wp_error($post_id)) {
            echo "  [ERROR] {$job['title']}: " . $post_id->get_error_message() . "\n";
            continue;
        }
        echo "  [CREATE] {$job['title']} (ID: $post_id)\n";
    }

    // Set career_category taxonomy
    $cat_term = get_term_by('slug', $job['category'], 'career_category');
    if ($cat_term) {
        wp_set_object_terms($post_id, [$cat_term->term_id], 'career_category');
    }

    // Set job_type taxonomy
    $type_term = get_term_by('slug', $job['job_type'], 'job_type');
    if ($type_term) {
        wp_set_object_terms($post_id, [$type_term->term_id], 'job_type');
    }

    // Set ACF fields
    update_field('alya_location', $job['location'], $post_id);
    update_field('alya_experience', $job['experience'], $post_id);
    update_field('alya_deadline', $job['deadline'], $post_id);
}

// ═══════════════════════════════════════════
// 6. FLUSH REWRITE RULES
// ═══════════════════════════════════════════
echo "\n6. Flushing rewrite rules...\n";
flush_rewrite_rules(true);
echo "  [DONE]\n";

// ═══════════════════════════════════════════
// 7. VERIFICATION
// ═══════════════════════════════════════════
echo "\n7. Verification...\n";

$cat_terms = get_terms(['taxonomy' => 'career_category', 'hide_empty' => false]);
echo "  career_category terms: " . count($cat_terms) . "\n";
foreach ($cat_terms as $t) {
    echo "    - {$t->name} (slug: {$t->slug}, count: {$t->count})\n";
}

$type_terms = get_terms(['taxonomy' => 'job_type', 'hide_empty' => false]);
echo "  job_type terms: " . count($type_terms) . "\n";
foreach ($type_terms as $t) {
    echo "    - {$t->name} (slug: {$t->slug}, count: {$t->count})\n";
}

$jobs_count = wp_count_posts('jobs');
echo "  jobs posts: {$jobs_count->publish} published\n";

echo "\n  Customizer settings:\n";
echo "    hero_eyebrow: " . var_export(get_theme_mod('alya_career_hero_eyebrow', 'MISSING'), true) . "\n";
echo "    values_title: " . var_export(get_theme_mod('alya_career_values_title', 'MISSING'), true) . "\n";
echo "    steps: " . (get_theme_mod('alya_career_steps', '') ? 'SET' : 'MISSING') . "\n";

echo "\n=== Seeder Complete! ===\n";
echo "Visit: http://localhost/alya-test/karir/\n";

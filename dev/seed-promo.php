<?php
/**
 * Promo Seeder
 *
 * Seeds: promo_category terms and sample promo posts (3 items matching
 * promo/index.html: Skin Booster, Slimming Injection, Filler).
 *
 * Run via: php seed-promo.php
 *
 * @package Alya_Esthetic
 */

if (!defined('ABSPATH')) {
    $wp_root = 'D:/laragon/www/alya-test';
    define('ABSPATH', $wp_root . '/');
    define('WPINC', 'wp-includes');
    require_once ABSPATH . 'wp-load.php';
}

echo "=== Alya Esthetic Promo Seeder ===\n\n";

// ═══════════════════════════════════════════
// 1. PROMO CATEGORY TAXONOMY TERMS
// ═══════════════════════════════════════════
echo "1. Creating promo_category terms...\n";

$categories = [
    'skin-serenity'      => 'Skin Serenity',
    'beauty-advance'     => 'Beauty Advance',
    'slimming-wellness'  => 'Slimming & Wellness',
    'alya-beauty-bar'    => 'Alya Beauty Bar',
];

foreach ($categories as $slug => $name) {
    $term = get_term_by('slug', $slug, 'promo_category');
    if (!$term) {
        $result = wp_insert_term($name, 'promo_category', ['slug' => $slug]);
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
// 2. SAMPLE PROMO POSTS
// ═══════════════════════════════════════════
echo "\n2. Creating sample promo posts...\n";

$treat_uri = get_template_directory_uri() . '/assets/images/treatments';
$wa_link   = 'https://wa.me/6281290000000';

$promos = [
    [
        'title'        => 'Skin Booster Glowing — Diskon 20% Spesial Agustus',
        'category'     => 'skin-serenity',
        'ribbon'       => 'Diskon 20%',
        'price_old'    => 'Rp1.500.000',
        'price_new'    => 'Rp1.200.000',
        'save_text'    => 'Hemat Rp300.000',
        'deadline'     => '2026-08-31',
        'code'         => 'SKINBOOST20',
        'slots'        => 'Sisa 12 slot',
        'quota'        => 60,
        'wa_link'      => $wa_link,
        'image'        => $treat_uri . '/skin-booster.png',
        'excerpt'      => 'Treatment hyaluronic acid untuk hidrasi dari dalam, kulit tampak lebih halus dan bercahaya.',
        'quickfacts'   => [
            ['title' => '1x Sesi', 'description' => 'Durasi ± 45 menit'],
            ['title' => 'Semua Jenis Kulit', 'description' => 'Konsultasi dulu dengan dokter'],
            ['title' => 'Hasil Bertahap', 'description' => 'Terlihat sejak sesi pertama'],
        ],
        'tnc'          => [
            ['text' => 'Berlaku hingga 31 Agustus 2026 atau selama kuota tersedia'],
            ['text' => 'Harga promo berlaku untuk 1x sesi treatment, tidak berlaku kelipatan'],
            ['text' => 'Tidak dapat digabung dengan promo atau diskon lainnya'],
            ['text' => 'Treatment dilakukan setelah konsultasi dan persetujuan dokter'],
        ],
        'faqs'         => [
            ['question' => 'Apakah promo ini berlaku untuk semua jenis kulit?', 'answer' => 'Skin booster pada dasarnya aman untuk berbagai jenis kulit, namun tetap disesuaikan lewat konsultasi dokter terlebih dahulu.'],
            ['question' => 'Berapa lama hasil treatment terlihat?', 'answer' => 'Sebagian pasien sudah merasakan kulit lebih lembap sejak sesi pertama, namun hasil optimal umumnya terlihat setelah beberapa minggu.'],
        ],
        'content'      => '<p>Rayakan bulan Agustus dengan kulit yang lebih glowing! Selama periode promo, treatment <b>Skin Booster</b> di Alya Esthetic Center hadir dengan diskon 20% dari harga normal. Skin booster bekerja dengan menginjeksikan hyaluronic acid ke lapisan kulit untuk memberikan hidrasi dari dalam, membuat kulit tampak lebih kenyal, halus, dan bercahaya secara bertahap.</p><p>Promo ini terbuka untuk pasien baru maupun pasien lama, dan sudah termasuk konsultasi awal dengan dokter estetik untuk memastikan treatment sesuai dengan kondisi kulit Anda.</p><h2>Apa yang Anda Dapatkan</h2><ul><li>Konsultasi dan pemeriksaan kulit oleh dokter estetik</li><li>1x sesi treatment Skin Booster (± 45 menit)</li><li>Produk hyaluronic acid grade medis</li><li>Sesi kontrol/follow-up pasca treatment</li></ul><h2>Cara Klaim Promo</h2><ol><li>Klik tombol <b>"Klaim via WhatsApp"</b> di halaman ini</li><li>Sebutkan kode promo <b>SKINBOOST20</b> ke admin</li><li>Admin akan bantu jadwalkan konsultasi &amp; sesi treatment</li><li>Tunjukkan chat konfirmasi saat kedatangan di klinik</li></ol>',
    ],
    [
        'title'        => 'Paket Slimming Injection 3x — Hemat 15%',
        'category'     => 'slimming-wellness',
        'ribbon'       => 'Diskon 15%',
        'price_old'    => 'Rp3.600.000',
        'price_new'    => 'Rp3.060.000',
        'save_text'    => 'Hemat Rp540.000',
        'deadline'     => '2026-08-20',
        'code'         => 'SLIMMING15',
        'slots'        => 'Sisa 8 slot',
        'quota'        => 35,
        'wa_link'      => $wa_link,
        'image'        => $treat_uri . '/slimming-injection.png',
        'excerpt'      => 'Paket 3x sesi dengan konsultasi dokter, cocok untuk membentuk tubuh lebih ideal.',
        'quickfacts'   => [
            ['title' => '3x Sesi', 'description' => 'Berlaku untuk 1 orang pasien'],
            ['title' => 'Termasuk Konsultasi', 'description' => 'Konsultasi dokter di awal'],
            ['title' => 'Hasil Bertahap', 'description' => 'Terlihat seiring program berjalan'],
        ],
        'tnc'          => [
            ['text' => 'Berlaku hingga 20 Agustus 2026 atau selama kuota tersedia'],
            ['text' => 'Paket berlaku untuk 1 orang pasien, tidak dapat dipindahtangankan'],
            ['text' => 'Tidak dapat digabung dengan promo atau diskon lainnya'],
            ['text' => 'Treatment dilakukan setelah konsultasi dan persetujuan dokter'],
        ],
        'faqs'         => [
            ['question' => 'Berapa kali harus datang untuk paket ini?', 'answer' => 'Paket ini mencakup 3x sesi yang dapat dijadwalkan sesuai anjuran dokter.'],
            ['question' => 'Apakah ada efek samping?', 'answer' => 'Umumnya aman dengan pengawasan dokter, efek samping minimal dan sementara.'],
        ],
        'content'      => '<p>Wujudkan tubuh lebih ideal dengan paket <b>Slimming Injection 3x</b> hemat 15% di Alya Esthetic Center. Paket ini mencakup 3x sesi treatment dengan konsultasi dokter di setiap kunjungan, membantu membakar lemak dan membentuk kontur tubuh secara bertahap.</p><h2>Yang Termasuk dalam Paket</h2><ul><li>3x sesi slimming injection</li><li>Konsultasi dan evaluasi dokter di setiap sesi</li><li>Program personal sesuai kondisi tubuh</li><li>Follow-up pasca program</li></ul>',
    ],
    [
        'title'        => 'Filler Wajah — Gratis Konsultasi Dokter + Cicilan 0%',
        'category'     => 'beauty-advance',
        'ribbon'       => 'Gratis Konsultasi',
        'price_old'    => '',
        'price_new'    => 'Mulai Rp2.100.000',
        'save_text'    => '',
        'deadline'     => '2026-08-25',
        'code'         => '',
        'slots'        => 'Kuota terbatas',
        'quota'        => 80,
        'wa_link'      => $wa_link,
        'image'        => $treat_uri . '/filler.png',
        'excerpt'      => 'Konsultasikan area wajah yang ingin ditreatment secara gratis bersama dokter estetik.',
        'quickfacts'   => [
            ['title' => 'Gratis Konsultasi', 'description' => 'Dengan dokter estetik'],
            ['title' => 'Cicilan 0%', 'description' => 'Berlaku untuk periode promo'],
            ['title' => 'Personalized', 'description' => 'Area perawatan disesuaikan kebutuhan'],
        ],
        'tnc'          => [
            ['text' => 'Berlaku hingga 25 Agustus 2026 atau selama kuota tersedia'],
            ['text' => 'Harga mulai tergantung area dan produk filler yang digunakan'],
            ['text' => 'Cicilan 0% berlaku untuk kartu kredit tertentu'],
            ['text' => 'Treatment dilakukan setelah konsultasi dan persetujuan dokter'],
        ],
        'faqs'         => [
            ['question' => 'Apakah filler aman?', 'answer' => 'Ya, menggunakan produk berlisensi dengan teknik injeksi oleh dokter berpengalaman.'],
            ['question' => 'Berapa lama hasil filler bertahan?', 'answer' => 'Umumnya 6-12 bulan tergantung jenis produk dan area treatment.'],
        ],
        'content'      => '<p>Konsultasikan area wajah yang ingin ditreatment secara gratis bersama dokter estetik kami di Alya Esthetic Center. Promo ini juga hadir dengan opsi cicilan 0% untuk memudahkan perawatan kecantikan Anda.</p><h2>Benefit Promo Ini</h2><ul><li>Konsultasi gratis dengan dokter estetik</li><li>Cicilan 0% untuk metode pembayaran tertentu</li><li>Rencana perawatan personal</li></ul>',
    ],
];

foreach ($promos as $promo) {
    $existing = get_posts([
        'post_type'   => 'promo',
        'title'       => $promo['title'],
        'post_status' => 'publish',
        'numberposts' => 1,
    ]);

    if ($existing) {
        echo "  [EXISTS] {$promo['title']} (ID: {$existing[0]->ID})\n";
        $post_id = $existing[0]->ID;
    } else {
        $post_id = wp_insert_post([
            'post_type'    => 'promo',
            'post_title'   => $promo['title'],
            'post_content' => $promo['content'],
            'post_excerpt' => $promo['excerpt'],
            'post_status'  => 'publish',
        ]);

        if (is_wp_error($post_id)) {
            echo "  [ERROR] {$promo['title']}: " . $post_id->get_error_message() . "\n";
            continue;
        }
        echo "  [CREATE] {$promo['title']} (ID: $post_id)\n";
    }

    // Set promo_category taxonomy
    $cat_term = get_term_by('slug', $promo['category'], 'promo_category');
    if ($cat_term) {
        wp_set_object_terms($post_id, [$cat_term->term_id], 'promo_category');
    }

    // Set ACF fields
    update_field('alya_promo_ribbon', $promo['ribbon'], $post_id);
    update_field('alya_promo_price_old', $promo['price_old'], $post_id);
    update_field('alya_promo_price_new', $promo['price_new'], $post_id);
    update_field('alya_promo_save_text', $promo['save_text'], $post_id);
    update_field('alya_promo_deadline', $promo['deadline'], $post_id);
    update_field('alya_promo_code', $promo['code'], $post_id);
    update_field('alya_promo_slots', $promo['slots'], $post_id);
    update_field('alya_promo_quota', $promo['quota'], $post_id);
    update_field('alya_promo_wa_link', $promo['wa_link'], $post_id);

    // Set repeater meta (JSON, same format as alya_save_doctor_repeater)
    update_post_meta($post_id, 'alya_promo_quickfacts', wp_json_encode($promo['quickfacts']));
    update_post_meta($post_id, 'alya_promo_tnc', wp_json_encode($promo['tnc']));
    update_post_meta($post_id, 'alya_promo_faqs', wp_json_encode($promo['faqs']));

    // Set featured image (local fallback asset)
    $img_url = $promo['image'];
    $filename = basename(parse_url($img_url, PHP_URL_PATH));
    $src_path = get_template_directory() . '/assets/images/treatments/' . $filename;

    $upload_dir = wp_upload_dir();
    $promo_dir  = $upload_dir['basedir'] . '/promo';
    if (!file_exists($promo_dir)) {
        wp_mkdir_p($promo_dir);
    }
    $dest = $promo_dir . '/' . $filename;

    if (file_exists($src_path) && !file_exists($dest)) {
        copy($src_path, $dest);
    }

    if (file_exists($dest)) {
        $existing_attach = get_posts([
            'post_type'   => 'attachment',
            'posts_per_page' => 1,
            'meta_key'    => '_wp_attached_file',
            'meta_value'  => 'promo/' . $filename,
        ]);
        if (!empty($existing_attach)) {
            $attach_id = $existing_attach[0]->ID;
        } else {
            $filetype = wp_check_filetype($filename);
            $attachment = [
                'post_title'     => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
                'post_mime_type' => $filetype['type'],
                'post_status'    => 'inherit',
                'guid'           => $upload_dir['baseurl'] . '/promo/' . $filename,
            ];
            $attach_id = wp_insert_attachment($attachment, $dest);
            if (!is_wp_error($attach_id)) {
                require_once ABSPATH . 'wp-admin/includes/image.php';
                wp_generate_attachment_metadata($attach_id, $dest);
                wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $dest));
            }
        }
        if (!is_wp_error($attach_id) && $attach_id) {
            set_post_thumbnail($post_id, $attach_id);
        }
    }
}

// ═══════════════════════════════════════════
// 3. FLUSH REWRITE RULES
// ═══════════════════════════════════════════
echo "\n3. Flushing rewrite rules...\n";
flush_rewrite_rules(true);
echo "  [DONE]\n";

// ═══════════════════════════════════════════
// 4. VERIFICATION
// ═══════════════════════════════════════════
echo "\n4. Verification...\n";

$terms = get_terms(['taxonomy' => 'promo_category', 'hide_empty' => false]);
echo "  promo_category terms: " . count($terms) . "\n";
foreach ($terms as $t) {
    echo "    - {$t->name} (slug: {$t->slug}, count: {$t->count})\n";
}

$count = wp_count_posts('promo');
echo "  promo posts: {$count->publish} published\n";

echo "\n=== Seeder Complete! ===\n";
echo "Visit: http://localhost/alya-test/promo/\n";

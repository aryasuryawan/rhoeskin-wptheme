<?php
/**
 * Image Seeder — Downloads images from original HTML and assigns to WP content
 *
 * Run via: php seeder-images.php
 *
 * @package Alya_Esthetic
 */

if (!defined('ABSPATH')) {
    $wp_root = 'D:/laragon/www/alya-test';
    define('ABSPATH', $wp_root . '/');
    define('WPINC', 'wp-includes');
    require_once ABSPATH . 'wp-load.php';
}

echo "=== Alya Esthetic Image Seeder ===\n\n";

/**
 * Helper: Download image from URL and create WP attachment
 */
function seed_download_image($url, $filename, $post_parent = 0) {
    $upload_dir = wp_upload_dir();
    $dir = $upload_dir['path'] . '/seed/';
    if (!file_exists($dir)) wp_mkdir_p($dir);

    $filepath = $dir . $filename;
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $mime = 'image/' . ($ext === 'jpg' ? 'jpeg' : $ext);

    // Check if already downloaded
    if (file_exists($filepath)) {
        echo "  [EXISTS] {$filename}\n";
    } else {
        echo "  [DOWNLOAD] {$filename} ... ";
        $response = wp_remote_get($url, ['timeout' => 30]);
        if (is_wp_error($response)) {
            echo "FAILED: " . $response->get_error_message() . "\n";
            return false;
        }
        file_put_contents($filepath, wp_remote_retrieve_body($response));
        echo "OK (" . filesize($filepath) . " bytes)\n";
    }

    // Check if attachment already exists by guid
    global $wpdb;
    $existing_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid=%s LIMIT 1",
        $upload_dir['baseurl'] . '/seed/' . $filename
    ));
    if ($existing_id) {
        echo "  [ATTACH EXISTS] ID={$existing_id}\n";
        return $existing_id;
    }

    // Insert as attachment
    $attach_data = [
        'post_type'      => 'attachment',
        'post_title'     => str_replace(['-', '_'], ' ', pathinfo($filename, PATHINFO_FILENAME)),
        'post_mime_type' => $mime,
        'post_status'    => 'inherit',
        'post_parent'    => $post_parent,
        'guid'           => $upload_dir['baseurl'] . '/seed/' . $filename,
    ];
    $attach_id = wp_insert_post($attach_data);
    if ($attach_id && !is_wp_error($attach_id)) {
        // Update _wp_attachment_metadata
        $img_info = @getimagesize($filepath);
        $meta = [
            'width'  => $img_info[0] ?? 800,
            'height' => $img_info[1] ?? 600,
            'file'   => $upload_dir['subdir'] . '/seed/' . $filename,
            'sizes'  => [],
        ];
        update_post_meta($attach_id, '_wp_attachment_metadata', $meta);
        update_post_meta($attach_id, '_wp_attached_file', $upload_dir['subdir'] . '/seed/' . $filename);
        echo "  [ATTACH] ID={$attach_id}\n";
        return $attach_id;
    }
    echo "  [ERROR] Failed to create attachment\n";
    return false;
}

// ═══════════════════════════════════════════
// 1. IMAGE DEFINITIONS
// ═══════════════════════════════════════════
$images = [
    // Hero backgrounds
    'hero-v1'       => 'https://alyaesthetic.id/wp-content/uploads/2025/01/DSCF5732-scaled-e1737607374147-1536x1233.jpg',
    'hero-v2'       => 'https://alyaesthetic.id/wp-content/uploads/2025/11/DSCF5148-scaled-e1762063528772.jpg',

    // About
    'about-v1'      => 'https://alyaesthetic.id/wp-content/uploads/2024/09/interior-alya-esthetic-1-768x512.jpg',
    'about-v2'      => 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png',

    // Services
    'svc-skin'      => 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png',
    'svc-beauty'    => 'https://alyaesthetic.id/wp-content/uploads/2024/08/13.-filler-1024x819.png',
    'svc-slimming'  => 'https://alyaesthetic.id/wp-content/uploads/2024/09/34.-slimming-injection-1024x819.png',
    'svc-bar'       => 'https://alyaesthetic.id/wp-content/uploads/2024/08/30.-laser-hair-removal-1024x819.png',

    // Signature
    'signature'     => 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png',

    // Doctors
    'doc-fadhilah'  => 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png',
    'doc-vidyani'   => 'https://alyaesthetic.id/wp-content/uploads/2024/08/ALYA_5070_Edit-scaled-e1749967350811.png',
    'doc-renata'    => 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5285-scaled-e1749961075511.jpg',
    'doc-bela'      => 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5381-scaled-e1749961387297.jpg',
    'doc-intan'     => 'https://alyaesthetic.id/wp-content/uploads/2025/06/IMG_7279_edit-copy-scaled-e1751174958482.jpg',
    'doc-vini'      => 'https://alyaesthetic.id/wp-content/uploads/2024/08/ALYA_4567_Edit-scaled-e1749966815138.png',

    // Testimonials (v2 featured)
    'testi-cindy'   => 'https://www.surfaceskinhabit.com/img/CINDY-PRICILLA.jpg',
    'testi-anggie'  => 'https://www.surfaceskinhabit.com/img/ANGGIE-ANG.jpg',
    'testi-sarah'   => 'https://www.surfaceskinhabit.com/img/sarah-andreas.jpg',
    'testi-sandra'  => 'https://www.surfaceskinhabit.com/img/SANDRA-LUBIS.jpg',
    'testi-nina'    => 'https://www.surfaceskinhabit.com/img/NINA-PRATIWI.jpg',
    'testi-maizura' => 'https://www.surfaceskinhabit.com/img/MAIZURA.jpg',

    // Testimonials (v1)
    'testi-elisabeth' => 'https://alyaesthetic.id/wp-content/uploads/2025/01/elisabeth-jovinka.png',
    'testi-disya'     => 'https://alyaesthetic.id/wp-content/uploads/2025/01/disya.png',
    'testi-ghina'     => 'https://alyaesthetic.id/wp-content/uploads/2025/01/Ghina.png',

    // Blog / Articles
    'post-facial'   => 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png',
    'post-slimming' => 'https://alyaesthetic.id/wp-content/uploads/2024/09/34.-slimming-injection-1024x819.png',
    'post-filler'   => 'https://alyaesthetic.id/wp-content/uploads/2024/08/13.-filler-1024x819.png',

    // Instagram feed
    'ig-1'          => 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png',
    'ig-2'          => 'https://alyaesthetic.id/wp-content/uploads/2024/09/34.-slimming-injection-1024x819.png',
    'ig-3'          => 'https://alyaesthetic.id/wp-content/uploads/2024/08/13.-filler-1024x819.png',
    'ig-4'          => 'https://alyaesthetic.id/wp-content/uploads/2024/08/19.-skin-booster-1024x819.png',
    'ig-5'          => 'https://alyaesthetic.id/wp-content/uploads/2024/08/30.-laser-hair-removal-1024x819.png',
    'ig-6'          => 'https://alyaesthetic.id/wp-content/uploads/2025/01/37.-Hair-Coloring-1024x819.png',

    // Logo
    'logo'          => 'https://alyaesthetic.id/wp-content/uploads/2024/06/logo-and-text.352ad43b.svg',
];

// ═══════════════════════════════════════════
// 2. DOWNLOAD ALL IMAGES
// ═══════════════════════════════════════════
echo "1. Downloading images...\n";
$attach_ids = [];
foreach ($images as $key => $url) {
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
    $filename = 'seed-' . $key . '.' . $ext;
    $attach_ids[$key] = seed_download_image($url, $filename);
}
echo "\n";

// ═══════════════════════════════════════════
// 3. SET FEATURED IMAGES ON DOCTORS
// ═══════════════════════════════════════════
echo "2. Setting featured images on doctors...\n";
$doctors = get_posts(['post_type' => 'doctor', 'posts_per_page' => -1, 'post_status' => 'publish']);
$doc_images = ['doc-fadhilah', 'doc-vidyani', 'doc-renata', 'doc-bela', 'doc-intan', 'doc-vini'];
foreach ($doctors as $i => $doc) {
    $img_key = $doc_images[$i % count($doc_images)];
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($doc->ID, $attach_ids[$img_key]);
        // Also set ACF avatar field
        update_field('alya_avatar', $attach_ids[$img_key], $doc->ID);
        echo "  [SET] Doctor #{$doc->ID} ({$doc->post_title}) -> {$img_key}\n";
    }
}
echo "\n";

// ═══════════════════════════════════════════
// 4. SET FEATURED IMAGES ON SERVICES
// ═══════════════════════════════════════════
echo "3. Setting featured images on services...\n";
$services = get_posts(['post_type' => 'service', 'posts_per_page' => -1, 'post_status' => 'publish']);
$svc_images = ['svc-skin', 'svc-beauty', 'svc-slimming', 'svc-bar', 'svc-skin', 'svc-beauty'];
foreach ($services as $i => $svc) {
    $img_key = $svc_images[$i % count($svc_images)];
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($svc->ID, $attach_ids[$img_key]);
        echo "  [SET] Service #{$svc->ID} ({$svc->post_title}) -> {$img_key}\n";
    }
}
echo "\n";

// ═══════════════════════════════════════════
// 5. SET FEATURED IMAGES ON TESTIMONIALS
// ═══════════════════════════════════════════
echo "4. Setting featured images on testimonials...\n";
$testimonials = get_posts(['post_type' => 'testimonial', 'posts_per_page' => -1, 'post_status' => 'publish']);
$testi_images = ['testi-cindy', 'testi-anggie', 'testi-sarah', 'testi-sandra', 'testi-nina', 'testi-maizura'];
foreach ($testimonials as $i => $testi) {
    $img_key = $testi_images[$i % count($testi_images)];
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($testi->ID, $attach_ids[$img_key]);
        echo "  [SET] Testimonial #{$testi->ID} ({$testi->post_title}) -> {$img_key}\n";
    }
}
echo "\n";

// ═══════════════════════════════════════════
// 6. SET FEATURED IMAGES ON POSTS
// ═══════════════════════════════════════════
echo "5. Setting featured images on blog posts...\n";
$posts = get_posts(['post_type' => 'post', 'posts_per_page' => -1, 'post_status' => 'publish']);
$post_images = ['post-facial', 'post-slimming', 'post-filler', 'post-facial', 'post-slimming', 'post-filler'];
foreach ($posts as $i => $p) {
    $img_key = $post_images[$i % count($post_images)];
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($p->ID, $attach_ids[$img_key]);
        echo "  [SET] Post #{$p->ID} ({$p->post_title}) -> {$img_key}\n";
    }
}
echo "\n";

// ═══════════════════════════════════════════
// 7. SET THEME MOD IMAGES
// ═══════════════════════════════════════════
echo "6. Setting theme mod images...\n";
$theme_mods_option = 'theme_mods_alya-theme';
$mods = get_option($theme_mods_option, []);

// Hero background (used by both v1 and v2)
$mods['alya_hero_bg'] = ['url' => $images['hero-v2'], 'id' => $attach_ids['hero-v2']];
echo "  [SET] alya_hero_bg\n";

// About image (v1)
$mods['alya_about_image'] = ['url' => $images['about-v1'], 'id' => $attach_ids['about-v1']];
echo "  [SET] alya_about_image\n";

// About image (v2)
$mods['alya_v2_about_image'] = $images['about-v2'];
echo "  [SET] alya_v2_about_image\n";

// Signature background
$mods['alya_v2_signature_bg'] = $images['signature'];
echo "  [SET] alya_v2_signature_bg\n";

update_option($theme_mods_option, $mods);
echo "  [SAVED] theme_mods\n\n";

// ═══════════════════════════════════════════
// 8. VERIFY
// ═══════════════════════════════════════════
echo "7. Verification...\n";
$verify = [
    'hero_bg'      => get_theme_mod('alya_hero_bg', 'MISSING'),
    'about_image'  => get_theme_mod('alya_about_image', 'MISSING'),
    'v2_about_img' => get_theme_mod('alya_v2_about_image', 'MISSING'),
    'v2_sig_bg'    => get_theme_mod('alya_v2_signature_bg', 'MISSING'),
];
foreach ($verify as $key => $val) {
    if (is_array($val)) {
        echo "  {$key}: URL={$val['url']}\n";
    } else {
        echo "  {$key}: {$val}\n";
    }
}

// Count attachments
global $wpdb;
$attach_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_title LIKE 'seed-%'");
echo "  Total seed attachments: {$attach_count}\n";

echo "\n=== Image Seeder Complete! ===\n";
echo "Visit: http://localhost/alya-test/\n";

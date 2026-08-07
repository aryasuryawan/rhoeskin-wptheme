<?php
/**
 * Image Seeder — Downloads images from external URLs and assigns to WP content
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

// Create directories for images
$seeder_dir = ABSPATH . 'wp-content/themes/alya-theme/assets/images';
if (!file_exists($seeder_dir)) {
    mkdir($seeder_dir, 0755, true);
}

$seeder_images_dir = ABSPATH . 'wp-content/uploads/seed';
if (!file_exists($seeder_images_dir)) {
    mkdir($seeder_images_dir, 0755, true);
}

function seed_download_image($url, $filename, $post_parent = 0) {
    $upload_dir = wp_upload_dir();
    $seeder_path = $upload_dir['path'] . '/seed/';
    $filepath = $seeder_path . $filename;
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $mime = 'image/' . ($ext === 'jpg' ? 'jpeg' : $ext);

    if (file_exists($filepath)) {
        echo "  [EXISTS] {$filename}\n";
        return $upload_dir['baseurl'] . '/seed/' . $filename;
    }

    echo "  [DOWNLOAD] {$filename} ... ";

    // Try to download with curl
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_ACCEPT_ENCODING, 'gzip, deflate');
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($http_code == 200 && $response !== false && $error === '') {
        // Handle gzip compression
        $content = $response;
        if (strpos($http_code, 'gzip') !== false) {
            $content = gzuncompress($content);
        }
        
        file_put_contents($filepath, $content);
        echo "OK (" . filesize($filepath) . " bytes)\n";
    } else {
        echo "FAILED: HTTP {$http_code} - {$error}\n";
        return false;
    }

    // Check if attachment already exists by guid
    $existing_id = seed_get_existing_attachment_id($upload_dir['baseurl'] . '/seed/' . $filename);
    if ($existing_id) {
        echo "  [ATTACH EXISTS] ID={$existing_id}\n";
        return $upload_dir['baseurl'] . '/seed/' . $filename;
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
        return $upload_dir['baseurl'] . '/seed/' . $filename;
    }
    echo "  [ERROR] Failed to create attachment\n";
    return false;
}

function seed_get_existing_attachment_id($guid) {
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND guid=%s LIMIT 1",
        $guid
    ));
}

function seed_get_attachment_id_from_url($url) {
    $parts = parse_url($url);
    $host = $parts['host'] ?? '';
    $path = $parts['path'] ?? '';
    $guid = ($host ? 'https://' . $host : '') . $path;
    return seed_get_existing_attachment_id($guid);
}

echo "=== Alya Esthetic Image Seeder ===\n\n";

/**
 * List of all external images used in the theme
 * Organized by category for easier management
 */
$img_uri = get_template_directory_uri();
$images = [
    // Hero backgrounds
    'hero-v1'       => $img_uri . '/assets/images/fallback/hero-v1.jpg',
    'hero-v2'       => $img_uri . '/assets/images/fallback/hero-v2.jpg',
    
    // About images
    'about-v1'      => $img_uri . '/assets/images/fallback/interior.jpg',
    'about-v2'      => $img_uri . '/assets/images/fallback/doctor-fadhilah.png',
    
    // Service thumbnails
    'svc-skin'      => $img_uri . '/assets/images/services/skin-serenity.png',
    'svc-beauty'    => $img_uri . '/assets/images/services/beauty-advance.png',
    'svc-slimming'  => $img_uri . '/assets/images/services/slimming.png',
    'svc-bar'       => $img_uri . '/assets/images/services/beauty-bar.png',
    
    // Treatment fallback images
    'treat-hydra'   => $img_uri . '/assets/images/services/skin-serenity.png',
    'treat-botox'   => $img_uri . '/assets/images/services/skin-booster.png',
    'treat-laser'   => $img_uri . '/assets/images/services/laser.png',
    'treat-rf'      => $img_uri . '/assets/images/fallback/hero-v1.jpg',
    
    // Signature elements
    'signature'     => $img_uri . '/assets/images/services/skin-serenity.png',
    
    // Doctor profile images
    'doc-fadhilah'  => $img_uri . '/assets/images/doctors/doctor-fadhilah.png',
    'doc-vidyani'   => $img_uri . '/assets/images/doctors/vidyani.png',
    'doc-renata'    => $img_uri . '/assets/images/doctors/renata.jpg',
    'doc-bela'      => $img_uri . '/assets/images/doctors/bela.jpg',
    'doc-intan'     => $img_uri . '/assets/images/doctors/intan.jpg',
    'doc-vini'      => $img_uri . '/assets/images/doctors/vini.png',
    
    // Testimonial images
    'testi-elisabeth' => $img_uri . '/assets/images/testimonials/elisabeth.png',
    'testi-disya'     => $img_uri . '/assets/images/testimonials/disya.png',
    'testi-ghina'     => $img_uri . '/assets/images/testimonials/ghina.png',
    
    // Article/Blog thumbnail images
    'post-facial'   => $img_uri . '/assets/images/services/skin-serenity.png',
    'post-slimming' => $img_uri . '/assets/images/services/slimming.png',
    'post-filler'   => $img_uri . '/assets/images/services/beauty-advance.png',
    
    // Instagram feed images
    'ig-1'          => $img_uri . '/assets/images/services/skin-serenity.png',
    'ig-2'          => $img_uri . '/assets/images/services/slimming.png',
    'ig-3'          => $img_uri . '/assets/images/services/beauty-advance.png',
    'ig-4'          => $img_uri . '/assets/images/services/skin-booster.png',
    'ig-5'          => $img_uri . '/assets/images/services/beauty-bar.png',
    'ig-6'          => $img_uri . '/assets/images/ig/hair-coloring.png',
    
    // Logo
    'logo'          => $img_uri . '/assets/images/logo/logo-and-text.svg',
    
    // Additional images
    'dokter1'       => $img_uri . '/assets/images/fallback/doctor-fadhilah.png',
    'dokter2'       => $img_uri . '/assets/images/fallback/doctor-fadhilah.png',
    
    // 404 page images
    '404-skin'      => $img_uri . '/assets/images/services/skin-serenity.png',
    '404-filler'    => $img_uri . '/assets/images/services/beauty-advance.png',
    '404-slimming'  => $img_uri . '/assets/images/services/slimming.png',
    '404-laser'     => $img_uri . '/assets/images/services/beauty-bar.png',
    
    // Single treatment
    'single-treat'  => $img_uri . '/assets/images/services/skin-serenity.png',
];

echo "=== Downloading Images ===\n";
$attach_ids = [];
foreach ($images as $key => $url) {
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
    $filename = 'seed-' . $key . '.' . $ext;
    $attach_ids[$key] = seed_download_image($url, $filename);
}

echo "\n=== Setting Featured Images ===\n";

/**
 * Attach images to doctors (for doctor avatars in page-dokter.php)
 */
$doctors = get_posts(['post_type' => 'doctor', 'posts_per_page' => -1, 'post_status' => 'publish']);
$doc_images = ['doc-fadhilah', 'doc-vidyani', 'doc-renata', 'doc-bela', 'doc-intan', 'doc-vini'];
foreach ($doctors as $i => $doc) {
    $img_key = $doc_images[$i % count($doc_images)];
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($doc->ID, seed_get_attachment_id_from_url($attach_ids[$img_key]));
        update_field('alya_avatar', seed_get_attachment_id_from_url($attach_ids[$img_key]), $doc->ID);
        echo "  [SET] Doctor #{$doc->ID} ({$doc->post_title}) -> {$img_key}\n";
    }
}

/**
 * Attach images to treatments
 */
$treatments = get_posts(['post_type' => 'treatment', 'posts_per_page' => -1, 'post_status' => 'publish']);
$svc_images = ['svc-skin', 'svc-beauty', 'svc-slimming', 'svc-bar', 'svc-skin', 'svc-beauty'];
foreach ($treatments as $i => $svc) {
    $img_key = $svc_images[$i % count($svc_images)];
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($svc->ID, seed_get_attachment_id_from_url($attach_ids[$img_key]));
        echo "  [SET] Treatment #{$svc->ID} ({$svc->post_title}) -> {$img_key}\n";
    }
}

/**
 * Attach images to treatments
 */
$treatments = get_posts(['post_type' => 'treatment', 'posts_per_page' => -1, 'post_status' => 'any']);
$treat_img_map = [
    'Hydra Facial'       => 'treat-hydra',
    'Botox Anti-Aging'   => 'treat-botox',
    'Laser Carbon Peel'  => 'treat-laser',
    'RF Skin Tightening' => 'treat-rf',
];
foreach ($treatments as $treat) {
    $img_key = $treat_img_map[$treat->post_title] ?? 'treat-hydra';
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($treat->ID, seed_get_attachment_id_from_url($attach_ids[$img_key]));
        echo "  [SET] Treatment #{$treat->ID} ({$treat->post_title}) -> {$img_key}\n";
    }
}

/**
 * Attach images to testimonials
 */
$testimonials = get_posts(['post_type' => 'testimonial', 'posts_per_page' => -1, 'post_status' => 'publish']);
$testi_images = ['testi-elisabeth', 'testi-disya', 'testi-ghina', 'testi-elisabeth', 'testi-disya', 'testi-ghina'];
foreach ($testimonials as $i => $testi) {
    $img_key = $testi_images[$i % count($testi_images)];
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($testi->ID, seed_get_attachment_id_from_url($attach_ids[$img_key]));
        echo "  [SET] Testimonial #{$testi->ID} ({$testi->post_title}) -> {$img_key}\n";
    }
}

/**
 * Attach images to blog posts
 */
$posts = get_posts(['post_type' => 'post', 'posts_per_page' => -1, 'post_status' => 'publish']);
$post_images = ['post-facial', 'post-slimming', 'post-filler', 'post-facial', 'post-slimming', 'post-filler'];
foreach ($posts as $i => $p) {
    $img_key = $post_images[$i % count($post_images)];
    if (!empty($attach_ids[$img_key])) {
        set_post_thumbnail($p->ID, seed_get_attachment_id_from_url($attach_ids[$img_key]));
        echo "  [SET] Post #{$p->ID} ({$p->post_title}) -> {$img_key}\n";
    }
}

/**
 * Set theme mod images
 */
$theme_mods_option = 'theme_mods_alya-theme';
$mods = get_option($theme_mods_option, []);

$mods['alya_hero_bg'] = $images['hero-v2'];
echo "  [SET] alya_hero_bg\n";

$mods['alya_about_image'] = $images['about-v1'];
echo "  [SET] alya_about_image\n";

$mods['alya_v2_about_image'] = $images['about-v2'];
echo "  [SET] alya_v2_about_image\n";

$mods['alya_v2_signature_bg'] = $images['signature'];
echo "  [SET] alya_v2_signature_bg\n";

update_option($theme_mods_option, $mods);
echo "  [SAVED] theme_mods\n\n";

/**
 * Verification
 */
echo "=== Verification ===\n";
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

/**
 * Count and report total seed attachments
 */
global $wpdb;
$attach_count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type='attachment' AND post_title LIKE 'seed-%'");
echo "  Total seed attachments: {$attach_count}\n";

echo "\n=== Image Seeder Complete! ===\n";
echo "Images are now available locally for the theme.\n";

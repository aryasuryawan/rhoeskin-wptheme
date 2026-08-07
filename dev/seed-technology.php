<?php
/**
 * Technology Page Seeder
 * 
 * Creates ACF field group and populates all fields for the Technology page.
 * Run: php seed-technology.php
 */

require_once dirname(__DIR__, 4) . '/wp-load.php';

echo "=== Technology Page Seeder ===" . PHP_EOL . PHP_EOL;

// ═══════════════════════════════════════════
// 1. FIND TECHNOLOGY PAGE
// ═══════════════════════════════════════════
$page_id = 0;
$pages = get_posts([
    'post_type'      => 'page',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
]);

foreach ($pages as $p) {
    if (stripos($p->post_title, 'Teknologi') !== false) {
        $page_id = $p->ID;
        break;
    }
}

if (!$page_id) {
    die("ERROR: Technology page not found!" . PHP_EOL);
}

echo "1. Found page: " . get_the_title($page_id) . " (ID: {$page_id})" . PHP_EOL;

// Set template
update_post_meta($page_id, '_wp_page_template', 'templates/page-technology.php');
echo "   Template set to: templates/page-technology.php" . PHP_EOL . PHP_EOL;

// ═══════════════════════════════════════════
// 2. DOWNLOAD IMAGES
// ═══════════════════════════════════════════
echo "2. Downloading images..." . PHP_EOL;

$upload_dir = wp_upload_dir();
$tech_dir = $upload_dir['basedir'] . '/technology';
if (!file_exists($tech_dir)) {
    wp_mkdir_p($tech_dir);
}

$treat_uri = get_template_directory_uri() . '/assets/images/treatments';
$images = [
    'hero-bg'          => $treat_uri . '/hero-bg.jpg',
    'laser-1'          => $treat_uri . '/laser.png',
    'laser-2'          => $treat_uri . '/laser-hair-removal.png',
    'laser-3'          => $treat_uri . '/glass-skin-facial.png',
    'laser-4'          => $treat_uri . '/skin-booster.png',
    'energy-1'         => $treat_uri . '/glass-skin-facial.png',
    'energy-2'         => $treat_uri . '/skin-booster.png',
    'slimming-1'       => $treat_uri . '/laser.png',
    'slimming-2'       => $treat_uri . '/laser-hair-removal.png',
];

$image_ids = [];
foreach ($images as $key => $url) {
    $filename = basename(parse_url($url, PHP_URL_PATH));
    $filepath = $tech_dir . '/' . $filename;
    
    if (!file_exists($filepath)) {
        $response = wp_remote_get($url, ['timeout' => 30]);
        if (is_wp_error($response)) {
            echo "   FAILED: {$key} - " . $response->get_error_message() . PHP_EOL;
            continue;
        }
        file_put_contents($filepath, wp_remote_retrieve_body($response));
        echo "   Downloaded: {$filename}" . PHP_EOL;
    } else {
        echo "   Exists: {$filename}" . PHP_EOL;
    }
    
    // Create attachment
    $filetype = wp_check_filetype($filename);
    $attachment = [
        'post_title'     => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
        'post_mime_type' => $filetype['type'],
        'post_status'    => 'inherit',
        'guid'           => $upload_dir['baseurl'] . '/technology/' . $filename,
    ];
    
    $attach_id = wp_insert_attachment($attachment, $filepath);
    if (!is_wp_error($attach_id)) {
        $image_ids[$key] = $attach_id;
    }
}

echo PHP_EOL;

// ═══════════════════════════════════════════
// 3. CREATE ACF FIELD GROUP
// ═══════════════════════════════════════════
echo "3. Creating ACF field group..." . PHP_EOL;

// Check if field group already exists
$existing_group = get_posts([
    'post_type'      => 'acf-field-group',
    'posts_per_page' => 1,
    'meta_query'     => [
        [
            'key'   => 'key',
            'value' => 'group_technology',
        ],
    ],
]);

if (empty($existing_group)) {
    // Create field group
    $group_id = acf_add_local_field_group([
        'key'      => 'group_technology',
        'title'    => 'Technology Page Fields',
        'fields'   => [
            // Hero Section
            [
                'key'          => 'field_tech_hero',
                'label'        => 'Hero Section',
                'type'         => 'tab',
            ],
            [
                'key'          => 'field_tech_hero_bg',
                'label'        => 'Hero Background Image',
                'name'         => 'alya_hero_bg',
                'type'         => 'image',
                'return_format' => 'array',
            ],
            [
                'key'          => 'field_tech_hero_eyebrow',
                'label'        => 'Hero Eyebrow',
                'name'         => 'alya_hero_eyebrow',
                'type'         => 'text',
                'default_value' => 'Medical Innovation',
            ],
            [
                'key'          => 'field_tech_hero_title',
                'label'        => 'Hero Title',
                'name'         => 'alya_hero_title',
                'type'         => 'text',
            ],
            [
                'key'          => 'field_tech_hero_subtitle',
                'label'        => 'Hero Subtitle',
                'name'         => 'alya_hero_subtitle',
                'type'         => 'textarea',
                'rows'         => 3,
            ],
            [
                'key'          => 'field_tech_hero_stats',
                'label'        => 'Hero Stats',
                'name'         => 'alya_hero_stats',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Stat',
                'sub_fields'   => [
                    [
                        'key'      => 'field_tech_stat_value',
                        'label'    => 'Value',
                        'name'     => 'value',
                        'type'     => 'text',
                    ],
                    [
                        'key'      => 'field_tech_stat_label',
                        'label'    => 'Label',
                        'name'     => 'label',
                        'type'     => 'text',
                    ],
                ],
            ],

            // Categories
            [
                'key'          => 'field_tech_categories_tab',
                'label'        => 'Technology Categories',
                'type'         => 'tab',
            ],
            [
                'key'          => 'field_tech_categories',
                'label'        => 'Categories',
                'name'         => 'alya_tech_categories',
                'type'         => 'repeater',
                'layout'       => 'block',
                'button_label' => 'Add Category',
                'sub_fields'   => [
                    [
                        'key'      => 'field_tech_cat_id',
                        'label'    => 'Category ID (slug)',
                        'name'     => 'category_id',
                        'type'     => 'text',
                        'instructions' => 'Used for anchor link, e.g. "laser"',
                    ],
                    [
                        'key'      => 'field_tech_cat_label',
                        'label'    => 'Category Label (nav)',
                        'name'     => 'category_label',
                        'type'     => 'text',
                        'instructions' => 'Shown in sticky nav, e.g. "Laser Technology"',
                    ],
                    [
                        'key'      => 'field_tech_cat_number',
                        'label'    => 'Category Number',
                        'name'     => 'category_number',
                        'type'     => 'text',
                        'default_value' => '01',
                    ],
                    [
                        'key'      => 'field_tech_cat_eyebrow',
                        'label'    => 'Category Eyebrow',
                        'name'     => 'category_eyebrow',
                        'type'     => 'text',
                    ],
                    [
                        'key'      => 'field_tech_cat_title',
                        'label'    => 'Category Title',
                        'name'     => 'category_title',
                        'type'     => 'text',
                    ],
                    [
                        'key'      => 'field_tech_cat_badge',
                        'label'    => 'Category Badge',
                        'name'     => 'category_badge',
                        'type'     => 'text',
                    ],
                    [
                        'key'      => 'field_tech_cat_bg_alt',
                        'label'    => 'Alternate Background',
                        'name'     => 'category_bg_alt',
                        'type'     => 'true_false',
                        'default_value' => 0,
                        'ui'       => 1,
                    ],
                    [
                        'key'          => 'field_tech_devices',
                        'label'        => 'Devices',
                        'name'         => 'devices',
                        'type'         => 'repeater',
                        'layout'       => 'block',
                        'button_label' => 'Add Device',
                        'sub_fields'   => [
                            [
                                'key'          => 'field_tech_device_image',
                                'label'        => 'Device Image',
                                'name'         => 'image',
                                'type'         => 'image',
                                'return_format' => 'array',
                            ],
                            [
                                'key'      => 'field_tech_device_brand',
                                'label'    => 'Brand Tag',
                                'name'     => 'brand_tag',
                                'type'     => 'text',
                                'instructions' => 'e.g. "Cutera · USA"',
                            ],
                            [
                                'key'      => 'field_tech_device_title',
                                'label'    => 'Device Title',
                                'name'     => 'device_title',
                                'type'     => 'text',
                            ],
                            [
                                'key'      => 'field_tech_device_desc',
                                'label'    => 'Device Description',
                                'name'     => 'device_desc',
                                'type'     => 'textarea',
                                'rows'     => 3,
                            ],
                            [
                                'key'          => 'field_tech_device_features',
                                'label'        => 'Features',
                                'name'         => 'features',
                                'type'         => 'repeater',
                                'layout'       => 'table',
                                'button_label' => 'Add Feature',
                                'sub_fields'   => [
                                    [
                                        'key'  => 'field_tech_feature_text',
                                        'label'=> 'Feature Text',
                                        'name' => 'feature_text',
                                        'type' => 'text',
                                    ],
                                ],
                            ],
                            [
                                'key'      => 'field_tech_device_origin',
                                'label'    => 'Origin Badge',
                                'name'     => 'origin_badge',
                                'type'     => 'text',
                                'instructions' => 'e.g. "FDA Cleared · BPOM RI"',
                            ],
                        ],
                    ],
                ],
            ],

            // Certification
            [
                'key'          => 'field_tech_cert_tab',
                'label'        => 'Certification Section',
                'type'         => 'tab',
            ],
            [
                'key'      => 'field_tech_cert_eyebrow',
                'label'    => 'Cert Eyebrow',
                'name'     => 'alya_cert_eyebrow',
                'type'     => 'text',
            ],
            [
                'key'      => 'field_tech_cert_title',
                'label'    => 'Cert Title',
                'name'     => 'alya_cert_title',
                'type'     => 'text',
            ],
            [
                'key'      => 'field_tech_cert_desc',
                'label'    => 'Cert Description',
                'name'     => 'alya_cert_desc',
                'type'     => 'textarea',
                'rows'     => 2,
            ],
            [
                'key'          => 'field_tech_cert_logos',
                'label'        => 'Certification Logos',
                'name'         => 'alya_cert_logos',
                'type'         => 'repeater',
                'layout'       => 'table',
                'button_label' => 'Add Certification',
                'sub_fields'   => [
                    [
                        'key'      => 'field_tech_cert_icon',
                        'label'    => 'Icon (emoji)',
                        'name'     => 'icon',
                        'type'     => 'text',
                    ],
                    [
                        'key'      => 'field_tech_cert_name',
                        'label'    => 'Certification Name',
                        'name'     => 'cert_name',
                        'type'     => 'text',
                    ],
                    [
                        'key'      => 'field_tech_cert_desc',
                        'label'    => 'Certification Description',
                        'name'     => 'cert_desc',
                        'type'     => 'text',
                    ],
                ],
            ],

            // CTA
            [
                'key'          => 'field_tech_cta_tab',
                'label'        => 'CTA Section',
                'type'         => 'tab',
            ],
            [
                'key'      => 'field_tech_cta_eyebrow',
                'label'    => 'CTA Eyebrow',
                'name'     => 'alya_cta_eyebrow',
                'type'     => 'text',
            ],
            [
                'key'      => 'field_tech_cta_title',
                'label'    => 'CTA Title',
                'name'     => 'alya_cta_title',
                'type'     => 'text',
            ],
            [
                'key'      => 'field_tech_cta_desc',
                'label'    => 'CTA Description',
                'name'     => 'alya_cta_desc',
                'type'     => 'textarea',
                'rows'     => 2,
            ],
            [
                'key'      => 'field_tech_cta_button_label',
                'label'    => 'CTA Button Label',
                'name'     => 'alya_cta_button_label',
                'type'     => 'text',
            ],
            [
                'key'      => 'field_tech_cta_button_url',
                'label'    => 'CTA Button URL',
                'name'     => 'alya_cta_button_url',
                'type'     => 'url',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'templates/page-technology.php',
                ],
            ],
        ],
    ]);
    
    echo "   Field group created!" . PHP_EOL . PHP_EOL;
} else {
    echo "   Field group already exists, skipping creation." . PHP_EOL . PHP_EOL;
}

// ═══════════════════════════════════════════
// 4. POPULATE ACF FIELDS
// ═══════════════════════════════════════════
echo "4. Populating ACF fields..." . PHP_EOL;

// Hero Section
if (!empty($image_ids['hero-bg'])) {
    update_field('alya_hero_bg', $image_ids['hero-bg'], $page_id);
}
update_field('alya_hero_eyebrow', 'Medical Innovation', $page_id);
update_field('alya_hero_title', 'Teknologi & Medical Devices Berstandar Internasional', $page_id);
update_field('alya_hero_subtitle', 'Alya Esthetic berkomitmen menghadirkan perangkat medis terkini yang telah tersertifikasi BPOM, FDA, dan CE Mark demi hasil perawatan yang aman dan optimal.', $page_id);
update_field('alya_hero_stats', [
    ['value' => '20+', 'label' => 'Perangkat Medis'],
    ['value' => '100%', 'label' => 'Bersertifikat Resmi'],
    ['value' => '15+', 'label' => 'Brand Premium'],
], $page_id);
echo "   Hero section populated" . PHP_EOL;

// Categories
$categories = [
    [
        'category_id'     => 'laser',
        'category_label'  => 'Laser Technology',
        'category_number' => '01',
        'category_eyebrow' => 'Laser Technology',
        'category_title'  => 'Sistem Laser Medis Canggih',
        'category_badge'  => 'FDA & BPOM Approved',
        'category_bg_alt' => 0,
        'devices'         => [
            [
                'image'       => $image_ids['laser-1'] ?? 0,
                'brand_tag'   => 'Cutera · USA',
                'device_title' => 'Nd:YAG 1064nm Laser',
                'device_desc' => 'Sistem laser Neodymium-doped Yttrium Aluminium Garnet untuk pigmentasi, tato, dan rejuvenasi kulit mendalam.',
                'features'    => [
                    ['feature_text' => 'Mengatasi melasma & hiperpigmentasi'],
                    ['feature_text' => 'Laser toning & brightening'],
                    ['feature_text' => 'Penghilangan tato & bintik hitam'],
                    ['feature_text' => 'Pengencangan pori-pori'],
                ],
                'origin_badge' => 'FDA Cleared · BPOM RI',
            ],
            [
                'image'       => $image_ids['laser-2'] ?? 0,
                'brand_tag'   => 'Alma Laser · Israel',
                'device_title' => 'Soprano ICE Platinum',
                'device_desc' => 'Teknologi diode laser 3-panjang gelombang terpadu untuk laser hair removal yang nyaman dan permanen.',
                'features'    => [
                    ['feature_text' => 'Triple wavelength: 755nm + 810nm + 1064nm'],
                    ['feature_text' => 'ICE cooling — nyaman & bebas rasa sakit'],
                    ['feature_text' => 'Cocok untuk semua jenis kulit'],
                    ['feature_text' => 'Efektif pada rambut halus sekalipun'],
                ],
                'origin_badge' => 'CE Mark · FDA Cleared',
            ],
            [
                'image'       => $image_ids['laser-3'] ?? 0,
                'brand_tag'   => 'Lumenis · USA',
                'device_title' => 'CO₂ Fractional Laser',
                'device_desc' => 'Laser karbon dioksida fraksional untuk resurfacing, pengencangan kulit, dan koreksi tekstur wajah menyeluruh.',
                'features'    => [
                    ['feature_text' => 'Menghilangkan bekas jerawat & scar'],
                    ['feature_text' => 'Pengencangan kulit non-bedah'],
                    ['feature_text' => 'Resurfacing pori-pori kasar'],
                    ['feature_text' => 'Stimulasi kolagen jangka panjang'],
                ],
                'origin_badge' => 'FDA Cleared · BPOM RI',
            ],
            [
                'image'       => $image_ids['laser-4'] ?? 0,
                'brand_tag'   => 'Syneron-Candela · USA',
                'device_title' => 'PicoWay Picosecond Laser',
                'device_desc' => 'Laser pikosecond ultra-cepat untuk mengatasi pigmentasi membandel, melasma, dan peremajaan kulit komprehensif.',
                'features'    => [
                    ['feature_text' => 'Pulsa 300 pikosecond — ultra-presisi'],
                    ['feature_text' => 'Multi-wavelength (532 / 785 / 1064nm)'],
                    ['feature_text' => 'Minimal downtime'],
                    ['feature_text' => 'Efektif untuk Fitzpatrick IV–VI'],
                ],
                'origin_badge' => 'FDA Cleared · CE Mark',
            ],
        ],
    ],
    [
        'category_id'     => 'energy',
        'category_label'  => 'Energy-Based Devices',
        'category_number' => '02',
        'category_eyebrow' => 'Energy-Based Devices',
        'category_title'  => 'Perangkat Berbasis Energi',
        'category_badge'  => 'Non-invasive · No Downtime',
        'category_bg_alt' => 1,
        'devices'         => [
            [
                'image'       => $image_ids['energy-1'] ?? 0,
                'brand_tag'   => 'Ulthera · USA',
                'device_title' => 'HIFU Ultherapy',
                'device_desc' => 'High-Intensity Focused Ultrasound satu-satunya yang mendapat FDA clearance untuk face lifting non-bedah.',
                'features'    => [
                    ['feature_text' => 'Lifting alis, pipi, leher & dagu'],
                    ['feature_text' => 'Stimulasi kolagen lapisan SMAS'],
                    ['feature_text' => 'Hasil natural, tahan 1–2 tahun'],
                    ['feature_text' => 'Tanpa sayatan, tanpa pemulihan'],
                ],
                'origin_badge' => 'FDA Approved · BPOM RI',
            ],
            [
                'image'       => $image_ids['energy-2'] ?? 0,
                'brand_tag'   => 'Thermage · USA',
                'device_title' => 'Thermage FLX',
                'device_desc' => 'Radiofrequency monopolar generasi terbaru untuk pengencangan dan pemodelan kontur wajah dan tubuh.',
                'features'    => [
                    ['feature_text' => 'Deep RF hingga lapisan dermis'],
                    ['feature_text' => 'Total Tip 4.0 — cakupan lebih luas'],
                    ['feature_text' => 'AccuREP™ adaptive energy delivery'],
                    ['feature_text' => '1 sesi, hasil progresif 6 bulan'],
                ],
                'origin_badge' => 'FDA Cleared · CE Mark',
            ],
        ],
    ],
    [
        'category_id'     => 'slimming',
        'category_label'  => 'Slimming Devices',
        'category_number' => '03',
        'category_eyebrow' => 'Slimming Devices',
        'category_title'  => 'Teknologi Body Sculpting',
        'category_badge'  => 'Clinically Proven',
        'category_bg_alt' => 0,
        'devices'         => [
            [
                'image'       => $image_ids['slimming-1'] ?? 0,
                'brand_tag'   => 'Allergan · USA',
                'device_title' => 'CoolSculpting Elite',
                'device_desc' => 'Teknologi cryolipolysis untuk membekukan dan menghancurkan sel lemak secara permanen tanpa operasi.',
                'features'    => [
                    ['feature_text' => 'Mengurangi lemak hingga 25% per sesi'],
                    ['feature_text' => 'Dual applicator — 2x lebih cepat'],
                    ['feature_text' => 'FDA Cleared untuk 9 area tubuh'],
                    ['feature_text' => 'Tanpa anestesi, tanpa downtime'],
                ],
                'origin_badge' => 'FDA Cleared · BPOM RI',
            ],
            [
                'image'       => $image_ids['slimming-2'] ?? 0,
                'brand_tag'   => 'BTL · Czech Republic',
                'device_title' => 'Emsculpt NEO',
                'device_desc' => 'Kombinasi RF + HIFEM (High-Intensity Focused Electromagnetic) untuk bakar lemak dan bangun otot secara bersamaan.',
                'features'    => [
                    ['feature_text' => '30% pengurangan lemak + 25% peningkatan otot'],
                    ['feature_text' => 'Teknologi HIFEM 20.000 kontraksi/sesi'],
                    ['feature_text' => 'Perut, lengan, bokong, paha'],
                    ['feature_text' => 'Sesi 30 menit — setara 20.000 sit-up'],
                ],
                'origin_badge' => 'FDA Cleared · CE Mark',
            ],
        ],
    ],
];

update_field('alya_tech_categories', $categories, $page_id);
echo "   Categories populated (3 categories, 8 devices)" . PHP_EOL;

// Certification Section
update_field('alya_cert_eyebrow', 'Sertifikasi & Standar', $page_id);
update_field('alya_cert_title', 'Perangkat Berstandar & Bersertifikat Internasional', $page_id);
update_field('alya_cert_desc', 'Setiap alat yang kami gunakan telah melalui proses sertifikasi ketat dari lembaga regulasi kesehatan terkemuka dunia.', $page_id);
update_field('alya_cert_logos', [
    ['icon' => '🇺🇸', 'cert_name' => 'FDA', 'cert_desc' => 'U.S. Food & Drug Administration'],
    ['icon' => '🇪🇺', 'cert_name' => 'CE Mark', 'cert_desc' => 'European Conformity Standard'],
    ['icon' => '🇮🇩', 'cert_name' => 'BPOM RI', 'cert_desc' => 'Badan Pengawas Obat & Makanan'],
    ['icon' => '🌍', 'cert_name' => 'ISO 13485', 'cert_desc' => 'Medical Device Quality Mgmt'],
    ['icon' => '🏥', 'cert_name' => 'Kemenkes RI', 'cert_desc' => 'Izin Alat Kesehatan Resmi'],
], $page_id);
echo "   Certification section populated" . PHP_EOL;

// CTA Section
update_field('alya_cta_eyebrow', 'Mulai Perjalanan Kecantikan Anda', $page_id);
update_field('alya_cta_title', 'Rasakan Teknologi Medis Terbaik', $page_id);
update_field('alya_cta_desc', 'Konsultasikan kebutuhan Anda dengan dokter kami dan temukan treatment berbasis teknologi yang paling tepat.', $page_id);
update_field('alya_cta_button_label', 'Konsultasi Gratis', $page_id);
update_field('alya_cta_button_url', 'https://wa.me/6281290000000?text=Halo%20Alya%20Esthetic%2C%20saya%20ingin%20konsultasi%20teknologi', $page_id);
echo "   CTA section populated" . PHP_EOL;

echo PHP_EOL . "=== SEEDER COMPLETE ===" . PHP_EOL;
echo "URL: " . get_permalink($page_id) . PHP_EOL;

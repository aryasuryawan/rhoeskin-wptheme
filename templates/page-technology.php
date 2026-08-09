<?php
/**
 * Template Name: Technology Page
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<?php
// Hero Section
$hero_bg       = get_field('alya_hero_bg');
$hero_eyebrow  = get_field('alya_hero_eyebrow') ?: 'Medical Innovation';
$hero_title    = get_field('alya_hero_title') ?: 'Teknologi & Medical Devices Berstandar Internasional';
$hero_subtitle = get_field('alya_hero_subtitle') ?: 'Rhoé Skin berkomitmen menghadirkan perangkat medis terkini yang telah tersertifikasi BPOM, FDA, dan CE Mark demi hasil perawatan yang aman dan optimal.';

// Hero stats - load from JSON (new format) with fallback to text (old format)
$hero_stats = [];

// Try JSON format first
$hero_stats_json = get_post_meta(get_the_ID(), 'alya_hero_stats_json', true);
if (!empty($hero_stats_json)) {
    $decoded = json_decode($hero_stats_json, true);
    if (is_array($decoded)) {
        $hero_stats = $decoded;
    }
}

// Fallback to old text format
if (empty($hero_stats)) {
    $hero_stats_raw = get_post_meta(get_the_ID(), 'alya_hero_stats', true);
    if (is_string($hero_stats_raw) && !empty(trim($hero_stats_raw))) {
        $lines = array_filter(array_map('trim', explode("\n", $hero_stats_raw)));
        foreach ($lines as $line) {
            $parts = array_map('trim', explode('|', $line));
            if (count($parts) >= 2) {
                $hero_stats[] = [
                    'value' => $parts[0],
                    'label' => $parts[1],
                ];
            }
        }
    }
}

// Categories - load from JSON (new format) with fallback to text (old format)
$categories = [];

// Try JSON format first
$raw_json = get_post_meta(get_the_ID(), 'alya_tech_categories_json', true);
if (!empty($raw_json)) {
    $decoded = json_decode($raw_json, true);
    if (is_array($decoded)) {
        // Convert JSON format to template format
        foreach ($decoded as $cat) {
            $devices = [];
            foreach ($cat['devices'] ?? [] as $dev) {
                $features = [];
                if (!empty($dev['features']) && is_array($dev['features'])) {
                    foreach ($dev['features'] as $feat) {
                        $features[] = ['feature_text' => $feat];
                    }
                }
                
                $devices[] = [
                    'device_title'   => $dev['device_title'] ?? '',
                    'device_desc'    => $dev['device_desc'] ?? '',
                    'image'          => !empty($dev['image_id']) ? [
                        'url' => wp_get_attachment_image_url(intval($dev['image_id']), 'medium'),
                        'alt' => get_post_meta(intval($dev['image_id']), '_wp_attachment_image_alt', true),
                    ] : null,
                    'features'       => $features,
                    'brand_tag'      => $dev['brand_tag'] ?? '',
                    'origin_badge'   => $dev['origin_badge'] ?? '',
                    'certifications' => $dev['certifications'] ?? [],
                ];
            }
            
            $categories[] = [
                'category_id'      => $cat['cat_id'] ?? '',
                'category_label'   => $cat['cat_label'] ?? '',
                'category_title'   => $cat['cat_title'] ?? '',
                'category_number'  => $cat['cat_number'] ?? '',
                'category_eyebrow' => $cat['cat_eyebrow'] ?? '',
                'category_badge'   => $cat['cat_badge'] ?? '',
                'category_bg_alt'  => $cat['bg_alt'] ?? false,
                'devices'          => $devices,
            ];
        }
    }
}

// Fallback to old text format
if (empty($categories)) {
    $raw = get_post_meta(get_the_ID(), 'alya_tech_categories', true);
    if (is_string($raw) && !empty(trim($raw))) {
        $lines = array_filter(array_map('trim', explode("\n", $raw)));
        $current_cat = null;
        
        foreach ($lines as $line) {
            if (strpos($line, 'CAT::') === 0) {
                $delimiter = (strpos($line, ' | ') !== false) ? ' | ' : '|';
                $parts = array_map('trim', explode($delimiter, substr($line, 5)));
                $current_cat = [
                    'category_id'      => $parts[0] ?? '',
                    'category_label'   => $parts[1] ?? '',
                    'category_title'   => $parts[2] ?? '',
                    'category_number'  => $parts[3] ?? '',
                    'category_eyebrow' => $parts[4] ?? '',
                    'category_badge'   => $parts[5] ?? '',
                    'category_bg_alt'  => ($parts[6] ?? '0') === '1',
                    'devices'          => [],
                ];
                $categories[] = $current_cat;
                $current_cat = &$categories[count($categories) - 1];
            } elseif (strpos($line, 'DEV::') === 0 && $current_cat !== null) {
                $delimiter = (strpos($line, ' | ') !== false) ? ' | ' : '|';
                $parts = array_map('trim', explode($delimiter, substr($line, 5)));
                
                // Parse features
                $features = [];
                if (!empty($parts[3])) {
                    if (strpos($parts[3], 'FEATURES>>') === 0) {
                        foreach (array_filter(explode('>>', substr($parts[3], 10))) as $feat) {
                            $features[] = ['feature_text' => $feat];
                        }
                    } else {
                        foreach (explode(',', $parts[3]) as $feat) {
                            $features[] = ['feature_text' => trim($feat)];
                        }
                    }
                }
                
                // Parse certifications
                $certifications = [];
                if (!empty($parts[6]) && strpos($parts[6], 'CERTS>>') === 0) {
                    $certifications = array_filter(explode('>>', substr($parts[6], 7)));
                }
                
                $current_cat['devices'][] = [
                    'device_title'   => $parts[0] ?? '',
                    'device_desc'    => $parts[1] ?? '',
                    'image'          => intval($parts[2] ?? 0) ? [
                        'url' => wp_get_attachment_image_url(intval($parts[2]), 'medium'),
                        'alt' => get_post_meta(intval($parts[2]), '_wp_attachment_image_alt', true),
                    ] : null,
                    'features'       => $features,
                    'brand_tag'      => $parts[4] ?? '',
                    'origin_badge'   => $parts[5] ?? '',
                    'certifications' => $certifications,
                ];
            }
        }
    }
}

// Certification
$cert_eyebrow = get_field('alya_cert_eyebrow') ?: 'Sertifikasi & Standar';
$cert_title   = get_field('alya_cert_title') ?: 'Perangkat Berstandar & Bersertifikat Internasional';
$cert_desc    = get_field('alya_cert_desc') ?: 'Setiap alat yang kami gunakan telah melalui proses sertifikasi ketat dari lembaga regulasi kesehatan terkemuka dunia.';

// Cert logos - load from JSON (new format) with fallback to text (old format)
$cert_logos = [];

// Try JSON format first
$cert_logos_json = get_post_meta(get_the_ID(), 'alya_cert_logos_json', true);
if (!empty($cert_logos_json)) {
    $decoded = json_decode($cert_logos_json, true);
    if (is_array($decoded)) {
        foreach ($decoded as $logo) {
            $image_id = intval($logo['image_id'] ?? 0);
            $cert_logos[] = [
                'logo' => $image_id ? [
                    'url' => wp_get_attachment_image_url($image_id, 'medium'),
                    'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
                ] : null,
                'cert_name' => $logo['cert_name'] ?? '',
                'cert_desc' => $logo['cert_desc'] ?? '',
            ];
        }
    }
}

// Fallback to old text format
if (empty($cert_logos)) {
    $cert_logos_raw = get_post_meta(get_the_ID(), 'alya_cert_logos', true);
    if (is_string($cert_logos_raw) && !empty(trim($cert_logos_raw))) {
        $lines = array_filter(array_map('trim', explode("\n", $cert_logos_raw)));
        foreach ($lines as $line) {
            $delimiter = (strpos($line, ' | ') !== false) ? ' | ' : '|';
            $parts = array_map('trim', explode($delimiter, $line));
            if (count($parts) >= 2) {
                $image_id = intval($parts[0] ?? 0);
                $cert_logos[] = [
                    'logo' => $image_id ? [
                        'url' => wp_get_attachment_image_url($image_id, 'medium'),
                        'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true),
                    ] : null,
                    'cert_name' => $parts[1] ?? '',
                    'cert_desc' => $parts[2] ?? '',
                ];
            }
        }
    }
}

// CTA
$cta_eyebrow      = get_field('alya_cta_eyebrow') ?: 'Mulai Perjalanan Kecantikan Anda';
$cta_title        = get_field('alya_cta_title') ?: 'Rasakan Teknologi Medis Terbaik';
$cta_desc         = get_field('alya_cta_desc') ?: 'Konsultasikan kebutuhan Anda dengan dokter kami dan temukan treatment berbasis teknologi yang paling tepat.';
$cta_button_label = get_field('alya_cta_button_label') ?: 'Konsultasi Gratis';
$cta_button_url   = get_field('alya_cta_button_url') ?: alya_wa_link();
?>

<!-- PAGE HERO -->
<section class="page-hero page-hero--tech" <?php if ($hero_bg && is_array($hero_bg)) echo 'style="background-image:url(' . esc_url($hero_bg['url']) . ')"'; ?>>
    <div class="page-hero__overlay"></div>
    <div class="container">
        <div class="page-hero__inner">
            <span class="eyebrow eyebrow--light"><?php echo esc_html($hero_eyebrow); ?></span>
            <h1><?php echo esc_html($hero_title); ?></h1>
            <p><?php echo esc_html($hero_subtitle); ?></p>
            <?php if ($hero_stats && is_array($hero_stats) && count($hero_stats) > 0) : ?>
                <div class="hero-stats">
                    <?php foreach ($hero_stats as $stat) : ?>
                        <div>
                            <b><?php echo esc_html($stat['value'] ?? ''); ?></b>
                            <span><?php echo esc_html($stat['label'] ?? ''); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CATEGORY NAV -->
<?php if ($categories && is_array($categories)) : ?>
<div class="cat-nav" id="catNav">
    <div class="container">
        <div class="cat-nav-inner">
            <?php foreach ($categories as $index => $cat) : ?>
                <a class="cat-link<?php echo $index === 0 ? ' active' : ''; ?>" href="#<?php echo esc_attr($cat['category_id'] ?? ''); ?>">
                    <?php echo esc_html($cat['category_label'] ?? ''); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- TECH SECTIONS -->
<?php foreach ($categories as $index => $cat) : ?>
    <?php
    $devices     = $cat['devices'] ?? [];
    $bg_alt      = !empty($cat['category_bg_alt']) || ($index % 2 === 1);
    ?>
    <section class="tech-section<?php echo $bg_alt ? ' bg-light' : ''; ?>" id="<?php echo esc_attr($cat['category_id'] ?? ''); ?>">
        <div class="container">
            <div class="tech-head">
                <div>
                    <span class="eyebrow"><?php echo esc_html(($cat['category_number'] ?? '') . ' — ' . ($cat['category_eyebrow'] ?? '')); ?></span>
                    <h2><?php echo esc_html($cat['category_title'] ?? ''); ?></h2>
                </div>
                <?php if (!empty($cat['category_badge'])) : ?>
                    <span class="tech-cat-badge"><?php echo esc_html($cat['category_badge']); ?></span>
                <?php endif; ?>
            </div>
            <?php if ($devices && is_array($devices)) : ?>
                <div class="device-grid">
                    <?php foreach ($devices as $device) : ?>
                        <?php
                        $image    = $device['image'] ?? null;
                        $features = $device['features'] ?? [];
                        ?>
                        <div class="device-card">
                            <div class="device-card__img">
                                <?php if ($image && is_array($image)) : ?>
                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($device['device_title'] ?? ''); ?>" loading="lazy" width="280" height="210">
                                <?php else : ?>
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/services/laser.png'); ?>" alt="Medical Device" loading="lazy" width="280" height="210">
                                <?php endif; ?>
                            </div>
                            <div class="device-card__body">
                                <?php if (!empty($device['brand_tag'])) : ?>
                                    <p class="brand-tag"><?php echo esc_html($device['brand_tag']); ?></p>
                                <?php endif; ?>
                                <h3><?php echo esc_html($device['device_title'] ?? ''); ?></h3>
                                <?php if (!empty($device['device_desc'])) : ?>
                                    <p><?php echo esc_html($device['device_desc']); ?></p>
                                <?php endif; ?>
                                <?php if ($features && is_array($features)) : ?>
                                    <ul class="device-card__features">
                                        <?php foreach ($features as $feature) : ?>
                                            <li><?php echo esc_html($feature['feature_text'] ?? ''); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if (!empty($device['certifications']) && is_array($device['certifications'])) : ?>
                                    <div class="device-certs">
                                        <?php foreach ($device['certifications'] as $cert) : ?>
                                            <span class="cert-badge"><?php echo esc_html($cert); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($device['origin_badge'])) : ?>
                                    <span class="origin-badge">
                                        <?php echo alya_icon('certificate'); ?>
                                        <?php echo esc_html($device['origin_badge']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endforeach; ?>
<?php endif; ?>

<!-- CERTIFICATIONS -->
<section class="cert-section">
    <div class="container center">
        <span class="eyebrow eyebrow--light"><?php echo esc_html($cert_eyebrow); ?></span>
        <h2><?php echo esc_html($cert_title); ?></h2>
        <p class="lead lead--light"><?php echo esc_html($cert_desc); ?></p>
        <?php if ($cert_logos && is_array($cert_logos)) : ?>
            <div class="cert-logos">
                <?php foreach ($cert_logos as $logo) : ?>
                    <div class="cert-logo">
                        <?php if (!empty($logo['logo']) && is_array($logo['logo'])) : ?>
                            <img src="<?php echo esc_url($logo['logo']['url']); ?>" alt="<?php echo esc_attr($logo['cert_name'] ?? ''); ?>" class="cert-logo-img" loading="lazy">
                        <?php elseif (!empty($logo['icon'])) : ?>
                            <span class="icon"><?php echo esc_html($logo['icon']); ?></span>
                        <?php endif; ?>
                        <div class="name"><?php echo esc_html($logo['cert_name'] ?? ''); ?></div>
                        <div class="desc"><?php echo esc_html($logo['cert_desc'] ?? ''); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<div class="cta-band">
    <div class="container center">
        <span class="eyebrow"><?php echo esc_html($cta_eyebrow); ?></span>
        <h2><?php echo esc_html($cta_title); ?></h2>
        <p><?php echo esc_html($cta_desc); ?></p>
        <a href="<?php echo esc_url($cta_button_url); ?>" class="btn"><?php echo esc_html($cta_button_label); ?></a>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>

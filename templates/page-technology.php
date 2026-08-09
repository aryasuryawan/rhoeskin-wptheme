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
$hero_stats    = get_field('alya_hero_stats');

// Categories - parse from nested format
$raw = get_post_meta(get_the_ID(), 'alya_tech_categories', true);
$categories = [];

if (is_string($raw) && !empty(trim($raw))) {
    $lines = array_filter(array_map('trim', explode("\n", $raw)));
    $current_cat = null;
    
    foreach ($lines as $line) {
        if (strpos($line, 'CAT::') === 0) {
            // New category
            $parts = array_map('trim', explode('|', substr($line, 5)));
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
            $categories[] = &$current_cat;
        } elseif (strpos($line, 'DEV::') === 0 && $current_cat !== null) {
            // Device under current category
            $parts = array_map('trim', explode('|', substr($line, 5)));
            $features = [];
            if (!empty($parts[3])) {
                foreach (explode(',', $parts[3]) as $feat) {
                    $features[] = ['feature_text' => trim($feat)];
                }
            }
            
            $current_cat['devices'][] = [
                'device_title' => $parts[0] ?? '',
                'device_desc'  => $parts[1] ?? '',
                'image'        => intval($parts[2] ?? 0) ? wp_get_attachment_image_array(intval($parts[2]), 'medium') : null,
                'features'     => $features,
                'brand_tag'    => $parts[4] ?? '',
                'origin_badge' => $parts[5] ?? '',
            ];
        }
    }
}

// Certification
$cert_eyebrow = get_field('alya_cert_eyebrow') ?: 'Sertifikasi & Standar';
$cert_title   = get_field('alya_cert_title') ?: 'Perangkat Berstandar & Bersertifikat Internasional';
$cert_desc    = get_field('alya_cert_desc') ?: 'Setiap alat yang kami gunakan telah melalui proses sertifikasi ketat dari lembaga regulasi kesehatan terkemuka dunia.';
$cert_logos   = get_field('alya_cert_logos');

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
            <?php if ($hero_stats && is_array($hero_stats)) : ?>
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
                        <?php if (!empty($logo['icon'])) : ?>
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

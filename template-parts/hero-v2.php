<?php
/**
 * Hero V2 — Editorial oversized type + full-bleed image
 *
 * @package Alya_Esthetic
 */

$eyebrow   = get_theme_mod('alya_v2_hero_eyebrow', 'Klinik Kecantikan Satu Pintu · Jakarta Selatan');
$title     = get_theme_mod('alya_v2_hero_title', 'Kulit Sehat Dimulai dari Kebiasaan yang Tepat');
$subtitle  = get_theme_mod('alya_v2_hero_subtitle', 'Alya Esthetic Center memadukan pendekatan medis, hospitality, dan konsistensi rutinitas untuk membantu Anda tampil lebih percaya diri — dipandu langsung oleh tim dokter berpengalaman.');
$cta_text  = get_theme_mod('alya_v2_hero_cta_text', 'Buat Janji Sekarang');
$cta_url   = get_theme_mod('alya_v2_hero_cta_url', alya_wa_link());
$cta2_text = get_theme_mod('alya_v2_hero_cta2_text', 'Jelajahi Layanan');
$cta2_url  = get_theme_mod('alya_v2_hero_cta2_url', '#layanan');
$bg_image  = get_theme_mod('alya_hero_bg', '');
if (is_array($bg_image)) $bg_image = $bg_image['url'] ?? '';
$stats     = get_theme_mod('alya_v2_hero_stats', [
    ['number' => '10rb+', 'label' => 'Pasien Terlayani'],
    ['number' => '10+', 'label' => 'Tahun Beroperasi'],
    ['number' => '15+', 'label' => 'Dokter & Terapis Ahli'],
    ['number' => '4.9/5', 'label' => 'Rating Kepuasan Pasien'],
]);

if (empty($cta_url)) $cta_url = alya_wa_link();
?>

<div class="hero" id="beranda">
    <div class="hero__bg"<?php if ($bg_image) : ?> style="background-image:url('<?php echo esc_url($bg_image); ?>')"<?php endif; ?>></div>
    <div class="hero__bg-overlay"></div>
    <div class="container hero__inner">
        <?php if ($eyebrow) : ?>
            <span class="eyebrow eyebrow--light"><?php echo esc_html($eyebrow); ?></span>
        <?php endif; ?>
        <?php if ($title) : ?>
            <h1 class="hero__title hero__title--xl"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>
        <?php if ($subtitle) : ?>
            <p class="lead lead--light"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>
        <div class="hero__actions">
            <?php if ($cta_text) : ?>
                <a class="btn" href="<?php echo esc_url($cta_url); ?>" target="_blank" rel="noopener"><?php echo esc_html($cta_text); ?></a>
            <?php endif; ?>
            <?php if ($cta2_text) : ?>
                <a class="btn btn--ghostlight" href="<?php echo esc_url($cta2_url); ?>"><?php echo esc_html($cta2_text); ?></a>
            <?php endif; ?>
        </div>
        <?php if (!empty($stats) && is_array($stats)) : ?>
            <div class="hero__stats">
                <?php foreach ($stats as $stat) : ?>
                    <div class="stat">
                        <b><?php echo esc_html($stat['number'] ?? ''); ?></b>
                        <span><?php echo esc_html($stat['label'] ?? ''); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

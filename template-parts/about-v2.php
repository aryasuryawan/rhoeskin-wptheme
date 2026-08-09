<?php
/**
 * About V2 — 2-col grid + badge card
 *
 * @package Alya_Esthetic
 */

$title    = get_theme_mod('alya_v2_about_title', 'Kecantikan yang Dirawat, Bukan Sekadar Ditutupi');
$desc     = get_theme_mod('alya_v2_about_desc', 'Rhoé Skin Center hadir sebagai klinik kecantikan satu pintu di Jakarta Selatan, menggabungkan layanan medis, hospitality, dan edukasi rutinitas harian dalam satu pengalaman perawatan.');
$image    = get_theme_mod('alya_v2_about_image', '');
$points   = get_theme_mod('alya_v2_about_points', [
    'Ditangani langsung oleh dokter & terapis bersertifikat',
    'Alat dan produk sesuai standar keamanan klinik',
    'Rencana perawatan personal sesuai kondisi kulit',
]);
?>

<section class="about" id="tentang">
    <div class="container about__grid">
        <div class="about__media">
            <img src="<?php echo esc_url($image ?: 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png'); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" width="600" height="750">
            <div class="about__badge">
                <div class="ic">
                    <svg viewBox="0 0 24 24"><path d="M12 2l3 6 6 .9-4.5 4.3 1 6-5.5-3-5.5 3 1-6L3 8.9 9 8z"/></svg>
                </div>
                <div>
                    <b>4.9/5</b>
                    <span>dari 2.400+ ulasan pasien</span>
                </div>
            </div>
        </div>
        <div class="about__text">
            <span class="eyebrow">Tentang Kami</span>
            <h2><?php echo esc_html($title); ?></h2>
            <p><?php echo esc_html($desc); ?></p>
            <?php if (!empty($points) && is_array($points)) : ?>
                <div class="about__points">
                    <?php foreach ($points as $point) : ?>
                        <div class="pt">
                            <svg viewBox="0 0 24 24"><path d="M9 16.2l-3.5-3.5L4 14.2l5 5 11-11-1.5-1.5z"/></svg>
                            <span><?php echo esc_html($point); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

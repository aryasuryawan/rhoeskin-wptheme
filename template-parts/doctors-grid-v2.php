<?php
/**
 * Doctors Grid V2 — static grid ≤5, Swiper slider >5
 *
 * @package Alya_Esthetic
 */

$doc_placeholder = get_template_directory_uri() . '/assets/images/placeholder-doctor-rhoeskin.webp';
$max_doctors     = max(1, intval(get_theme_mod('alya_featured_doctors_count', 4)));

// Cek total dokter yang tersedia di DB
$total_doctors = (int) wp_count_posts('doctor')->publish;
$use_slider    = $total_doctors > 5;

// Slider: ambil semua dokter yang ada (dibatasi max); static: maks 5
$fetch_count = $use_slider ? max($max_doctors, $total_doctors) : min($max_doctors, 5);
$doctors     = alya_get_posts('doctor', ['posts_per_page' => $fetch_count]);

if (!$doctors->have_posts()) return;

// Build items array
$doc_items = [];
while ($doctors->have_posts()) {
    $doctors->the_post();
    $avatar     = get_field('alya_avatar');
    $specialist = get_field('alya_specialist') ?: get_field('alya_position') ?: 'Aesthetic Doctor';
    $img_url    = '';
    if ($avatar && is_array($avatar)) {
        $img_url = $avatar['url'];
    } elseif (has_post_thumbnail()) {
        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
    }
    if (!$img_url) $img_url = $doc_placeholder;

    $doc_items[] = [
        'title'      => get_the_title(),
        'permalink'  => get_permalink(),
        'img'        => $img_url,
        'specialist' => $specialist,
    ];
}
wp_reset_postdata();
?>

<section class="doctors" id="dokter" data-doc-count="<?php echo esc_attr(count($doc_items)); ?>" data-use-slider="<?php echo $use_slider ? '1' : '0'; ?>">
    <div class="container sec-head">
        <div>
            <span class="eyebrow">Tim Medis Kami</span>
            <h2>Dokter &amp; Tenaga Ahli Berpengalaman</h2>
        </div>
        <p class="lead">Setiap treatment ditangani oleh dokter dan terapis yang berdedikasi pada pendekatan personal.</p>
    </div>

    <div class="container">
        <?php if ($use_slider) : ?>
        <!-- Swiper slider — aktif saat dokter > 5 -->
        <div class="swiper doc-swiper" id="docSwiper">
            <div class="swiper-wrapper">
                <?php foreach ($doc_items as $doc) : ?>
                <div class="swiper-slide">
                    <a href="<?php echo esc_url($doc['permalink']); ?>" class="doc-card" style="text-decoration:none;color:inherit;">
                        <div class="doc-avatar">
                            <img src="<?php echo esc_url($doc['img']); ?>" alt="<?php echo esc_attr($doc['title']); ?>" width="300" height="300" loading="lazy">
                        </div>
                        <h4><?php echo esc_html($doc['title']); ?></h4>
                        <span><?php echo esc_html($doc['specialist']); ?></span>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination doc-swiper__pagination"></div>
            <button class="swiper-button-prev doc-swiper__prev" aria-label="Sebelumnya"></button>
            <button class="swiper-button-next doc-swiper__next" aria-label="Selanjutnya"></button>
        </div>
        <?php else : ?>
        <!-- Static grid — ≤5 dokter -->
        <div class="doc-grid">
            <?php foreach ($doc_items as $doc) : ?>
            <a href="<?php echo esc_url($doc['permalink']); ?>" class="doc-card" style="text-decoration:none;color:inherit;">
                <div class="doc-avatar">
                    <img src="<?php echo esc_url($doc['img']); ?>" alt="<?php echo esc_attr($doc['title']); ?>" width="300" height="300" loading="lazy">
                </div>
                <h4><?php echo esc_html($doc['title']); ?></h4>
                <span><?php echo esc_html($doc['specialist']); ?></span>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

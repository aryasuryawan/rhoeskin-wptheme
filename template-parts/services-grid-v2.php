<?php
/**
 * Services Grid V2 — Photo hotspot cards
 *
 * @package Alya_Esthetic
 */

$title  = get_theme_mod('alya_v2_services_title', 'Empat Pilar Perawatan Alya Esthetic');
$lead   = get_theme_mod('alya_v2_services_lead', 'Setiap layanan dirancang untuk kebutuhan yang berbeda — dari perawatan wajah harian hingga treatment lanjutan.');
$services = alya_get_posts('service', ['posts_per_page' => 4]);

if (!$services->have_posts()) return;
?>

<section class="services services--v2" id="layanan">
    <div class="container">
        <div class="sec-head">
            <div>
                <span class="eyebrow">Layanan Kami</span>
                <h2><?php echo esc_html($title); ?></h2>
            </div>
            <p class="lead"><?php echo esc_html($lead); ?></p>
        </div>
    </div>
    <div class="container">
        <div class="svc-grid">
            <?php while ($services->have_posts()) : $services->the_post();
                $icon = get_field('alya_icon');
                $short_desc = get_field('alya_short_desc');
                $link_page = get_field('alya_link_page');
                $image_url = '';
                if (has_post_thumbnail()) {
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                }
            ?>
                <a class="svc-card" href="<?php echo esc_url($link_page ?: get_the_permalink()); ?>">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" width="400" height="533">
                    <?php endif; ?>
                    <div class="svc-card__body">
                        <span class="svc-card__category">Layanan</span>
                        <h3><?php the_title(); ?></h3>
                        <?php if ($short_desc) : ?>
                            <p><?php echo esc_html($short_desc); ?></p>
                        <?php endif; ?>
                        <span class="svc-card__arrow">
                            <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg>
                        </span>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

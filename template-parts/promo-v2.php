<?php
/**
 * Promo Section V2 — Penawaran spesial bulan ini
 *
 * Matches promo section in index_v2.html, driven by the `promo` CPT.
 *
 * @package Alya_Esthetic
 */

$title = get_theme_mod('alya_v2_promo_title', 'Penawaran Spesial Bulan Ini');
$lead  = get_theme_mod('alya_v2_promo_lead', 'Diskon treatment favorit dengan kuota dan periode terbatas — klaim sebelum kehabisan.');

$promo_query = new WP_Query([
    'post_type'      => 'promo',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
]);

if (!$promo_query->have_posts()) {
    return;
}
?>

<section class="promo-sec" id="promo">
    <div class="container sec-head">
        <div>
            <span class="eyebrow">&#128293; Promo Terbatas</span>
            <h2><?php echo esc_html($title); ?></h2>
        </div>
        <p class="lead"><?php echo esc_html($lead); ?></p>
    </div>
    <div class="container">
        <div class="promo-grid">
            <?php while ($promo_query->have_posts()) : $promo_query->the_post();
                $post_id = get_the_ID();
                $data    = alya_promo_data($post_id);

                $terms    = get_the_terms($post_id, 'promo_category');
                $cat_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Promo';

                $img = get_the_post_thumbnail_url($post_id, 'medium_large');
                if (!$img) {
                    $img = get_template_directory_uri() . '/assets/images/treatments/glass-skin-facial.png';
                }

                $ribbon = $data['ribbon'] ?: 'Promo Spesial';
            ?>
                <div class="promo-card">
                    <a class="promo-card__link" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr(get_the_title()); ?>"></a>
                    <div class="thumb">
                        <span class="ribbon"><?php echo esc_html($ribbon); ?></span>
                        <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" width="400" height="300">
                    </div>
                    <div class="promo-card__body">
                        <span class="tag"><?php echo esc_html($cat_name); ?></span>
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
                        <?php if ($data['price_old'] || $data['price_new']) : ?>
                        <div class="price-row">
                            <?php if ($data['price_old']) : ?><span class="price-old"><?php echo esc_html($data['price_old']); ?></span><?php endif; ?>
                            <?php if ($data['price_new']) : ?><span class="price-new"><?php echo esc_html($data['price_new']); ?></span><?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($data['deadline']) : ?>
                        <div class="expiry">
                            <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 10.4l4 2.4-.8 1.3-4.7-2.8V6h1.5v6.4z"/></svg>
                            Berlaku hingga <?php echo esc_html($data['deadline']); ?>
                        </div>
                        <?php endif; ?>
                        <div class="promo-actions">
                            <a class="btn btn--claim" href="<?php echo esc_url(alya_promo_wa_link($post_id, 'Halo, saya ingin klaim promo ' . get_the_title() . '.')); ?>" target="_blank" rel="noopener">Klaim via WhatsApp</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <div class="promo-sec__foot">
            <a class="btn btn--ghostdark" href="<?php echo esc_url(get_post_type_archive_link('promo')); ?>">Lihat Semua Promo</a>
        </div>
    </div>
</section>

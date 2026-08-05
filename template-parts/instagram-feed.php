<?php
/**
 * Instagram Feed — 6-grid IG feed
 *
 * @package Alya_Esthetic
 */

$ig_url = get_theme_mod('alya_social_instagram', 'https://www.instagram.com/alyaesthetic/');
$images = alya_field_raw('alya_instagram_images');

// Fallback: use service images if no custom field
if (empty($images) || !is_array($images)) {
    $fallback_services = alya_get_posts('service', ['posts_per_page' => 6]);
    $images = [];
    if ($fallback_services->have_posts()) {
        while ($fallback_services->have_posts()) : $fallback_services->the_post();
            if (has_post_thumbnail()) {
                $images[] = [
                    'url'   => get_the_post_thumbnail_url(get_the_ID(), 'medium_large'),
                    'title' => get_the_title(),
                ];
            }
        endwhile;
        wp_reset_postdata();
    }
}

if (empty($images)) return;
?>

<section class="ig" id="instagram">
    <div class="container center" style="max-width:560px">
        <span class="eyebrow">Ikuti Kami</span>
        <h2>@alyaesthetic di Instagram</h2>
    </div>
    <div class="container" style="margin-top:44px">
        <div class="ig-grid">
            <?php foreach (array_slice($images, 0, 6) as $item) : ?>
                <a class="ig-item" href="<?php echo esc_url($ig_url); ?>" target="_blank" rel="noopener">
                    <?php if (is_array($item) && !empty($item['url'])) : ?>
                        <img src="<?php echo esc_url($item['url']); ?>" alt="<?php echo esc_attr($item['title'] ?? 'Instagram'); ?>" width="300" height="300" loading="lazy">
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

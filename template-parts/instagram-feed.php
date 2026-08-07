<?php
/**
 * Instagram Feed — 6-grid IG feed
 *
 * @package Alya_Esthetic
 */

$ig_url = get_theme_mod('alya_social_instagram', 'https://www.instagram.com/alyaesthetic/');
$images = alya_field_raw('alya_instagram_images');

// Fallback: use treatment images if no custom field
if (empty($images) || !is_array($images)) {
    $fallback_treatments = alya_get_posts('treatment', ['posts_per_page' => 6]);
    $images = [];
    if ($fallback_treatments->have_posts()) {
        while ($fallback_treatments->have_posts()) : $fallback_treatments->the_post();
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

if (empty($images)) {
    $images = [
        ['url' => 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png', 'title' => 'Glass Skin Facial'],
        ['url' => 'https://alyaesthetic.id/wp-content/uploads/2024/09/34.-slimming-injection-1024x819.png', 'title' => 'Slimming Injection'],
        ['url' => 'https://alyaesthetic.id/wp-content/uploads/2024/08/13.-filler-1024x819.png', 'title' => 'Filler Wajah'],
        ['url' => 'https://alyaesthetic.id/wp-content/uploads/2024/08/19.-skin-booster-1024x819.png', 'title' => 'Skin Booster'],
        ['url' => 'https://alyaesthetic.id/wp-content/uploads/2024/08/30.-laser-hair-removal-1024x819.png', 'title' => 'Laser Hair Removal'],
        ['url' => 'https://alyaesthetic.id/wp-content/uploads/2025/01/37.-Hair-Coloring-1024x819.png', 'title' => 'Hair Coloring'],
    ];
}
?>

<section class="ig" id="instagram">
    <div class="container center">
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

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
        <a class="btn btn--outline" href="<?php echo esc_url($ig_url); ?>" target="_blank" rel="noopener" style="margin-top:20px">
            <?php echo esc_html('Follow @alyaesthetic'); ?>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.3-2.2-.4a3.8 3.8 0 01-1.4-.9 3.8 3.8 0 01-.9-1.4c-.2-.4-.4-1-.4-2.2-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c.1-1.2.3-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4 1.3-.1 1.7-.1 4.9-.1zm0-2.2C8.7 0 8.3 0 7 .1 5.7.1 4.8.4 4 .7 3.1 1 2.4 1.5 1.7 2.2 1 2.9.5 3.6.2 4.5-.1 5.3-.3 6.2-.3 7.5 0 8.8 0 9.2 0 12s0 3.2.1 4.5c.1 1.3.3 2.2.7 3.1.3.9.8 1.6 1.5 2.3.7.7 1.4 1.2 2.3 1.5.9.3 1.8.5 3.1.5 1.3.1 1.7.1 5 .1s3.7-.1 4.9-.1c1.3-.1 2.2-.3 3.1-.7.9-.3 1.6-.8 2.3-1.5.7-.7 1.2-1.4 1.5-2.3.3-.9.5-1.8.5-3.1.1-1.3.1-1.7.1-5s-.1-3.7-.1-4.9c-.1-1.3-.3-2.2-.7-3.1-.3-.9-.8-1.6-1.5-2.3C20.9 1 20.2.5 19.3.2 18.4-.1 17.5-.3 16.2-.3 14.9 0 14.5 0 12 0zm0 5.8a6.2 6.2 0 100 12.4 6.2 6.2 0 000-12.4zm0 10.2a4 4 0 110-8 4 4 0 010 8zm6.4-11.8a1.4 1.4 0 100 2.9 1.4 1.4 0 000-2.9z"/></svg>
        </a>
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

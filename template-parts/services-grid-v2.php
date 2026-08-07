<?php
/**
 * Services Grid V2 — Photo hotspot cards
 *
 * @package Alya_Esthetic
 */

$title = get_theme_mod('alya_v2_services_title', 'Empat Pilar Perawatan Alya Esthetic');
$lead  = get_theme_mod('alya_v2_services_lead', 'Setiap layanan dirancang untuk kebutuhan yang berbeda — dari perawatan wajah harian hingga treatment lanjutan.');

// Get treatment service categories (taxonomies: treatment_category or service)
$terms = get_terms([
    'taxonomy'   => ['treatment_category', 'service'],
    'hide_empty' => false,
    'orderby'    => 'term_id',
    'order'      => 'ASC',
]);

$tag_map = [
    'skin-serenity'     => 'Perawatan Wajah',
    'beauty-advance'    => 'Treatment Lanjutan',
    'slimming-wellness' => 'Bentuk Tubuh',
    'alya-beauty-bar'   => 'Perawatan Harian',
];

$treat_img_uri = get_template_directory_uri() . '/assets/images/treatments';

$fallback_imgs = [
    'skin-serenity'     => $treat_img_uri . '/glass-skin-facial.png',
    'beauty-advance'    => $treat_img_uri . '/filler.png',
    'slimming-wellness' => $treat_img_uri . '/slimming-injection.png',
    'alya-beauty-bar'   => $treat_img_uri . '/laser-hair-removal.png',
];

$cards_data = [];

if (!empty($terms) && !is_wp_error($terms)) {
    foreach ($terms as $term) {
        $slug = $term->slug;
        
        // Thumbnail
        $cat_thumb = get_term_meta($term->term_id, 'thumbnail_id', true);
        $image_url = '';
        if ($cat_thumb) {
            $image_url = wp_get_attachment_image_url($cat_thumb, 'large');
        }
        if (empty($image_url)) {
            $acf_term_img = get_field('alya_category_image', $term) ?: get_field('image', $term);
            if (is_array($acf_term_img)) {
                $image_url = $acf_term_img['url'] ?? '';
            } elseif (is_numeric($acf_term_img)) {
                $image_url = wp_get_attachment_image_url($acf_term_img, 'large');
            } elseif (is_string($acf_term_img)) {
                $image_url = $acf_term_img;
            }
        }
        if (empty($image_url)) {
            $image_url = $fallback_imgs[$slug] ?? $treat_img_uri . '/glass-skin-facial.png';
        }

        // Link to /layanan/?service=slug
        $treatment_archive = get_post_type_archive_link('treatment') ?: home_url('/layanan/');
        $term_link = add_query_arg('service', $slug, $treatment_archive);

        // Tag
        $tag = $tag_map[$slug] ?? 'Perawatan Treatment';

        $cards_data[] = [
            'tag'   => $tag,
            'title' => $term->name,
            'desc'  => $term->description ?: 'Solusi terbaik untuk perawatan estetik Anda.',
            'url'   => $term_link,
            'img'   => $image_url,
        ];
    }
}

if (empty($cards_data)) {
    $treatment_archive = get_post_type_archive_link('treatment') ?: home_url('/layanan/');
    $cards_data = [
        [
            'tag'   => 'Perawatan Wajah',
            'title' => 'Skin Serenity',
            'desc'  => 'Facial & perawatan kulit untuk wajah bercahaya alami.',
            'url'   => add_query_arg('service', 'skin-serenity', $treatment_archive),
            'img'   => $treat_img_uri . '/glass-skin-facial.png',
        ],
        [
            'tag'   => 'Treatment Lanjutan',
            'title' => 'Beauty Advance',
            'desc'  => 'Filler, skin booster, hingga perawatan pasca hair coloring.',
            'url'   => add_query_arg('service', 'beauty-advance', $treatment_archive),
            'img'   => $treat_img_uri . '/filler.png',
        ],
        [
            'tag'   => 'Bentuk Tubuh',
            'title' => 'Slimming & Wellness',
            'desc'  => 'Solusi tubuh ideal dan program wellness terarah.',
            'url'   => add_query_arg('service', 'slimming-wellness', $treatment_archive),
            'img'   => $treat_img_uri . '/slimming-injection.png',
        ],
        [
            'tag'   => 'Perawatan Harian',
            'title' => 'Alya Beauty Bar',
            'desc'  => 'Laser hair removal & layanan kecantikan harian lainnya.',
            'url'   => add_query_arg('service', 'alya-beauty-bar', $treatment_archive),
            'img'   => $treat_img_uri . '/laser-hair-removal.png',
        ],
    ];
}
?>

<section class="services" id="layanan">
    <div class="container sec-head">
        <div>
            <span class="eyebrow">Layanan Kami</span>
            <h2><?php echo esc_html($title); ?></h2>
        </div>
        <p class="lead"><?php echo esc_html($lead); ?></p>
    </div>
    <div class="container">
        <div class="svc-grid">
            <?php foreach ($cards_data as $card) : ?>
                <a class="svc-card" href="<?php echo esc_url($card['url']); ?>">
                    <img src="<?php echo esc_url($card['img']); ?>" alt="<?php echo esc_attr($card['title']); ?>" loading="lazy" width="400" height="533">
                    <div class="svc-card__body">
                        <span><?php echo esc_html($card['tag']); ?></span>
                        <h3><?php echo esc_html($card['title']); ?></h3>
                        <p><?php echo esc_html($card['desc']); ?></p>
                        <span class="svc-card__arrow">
                            <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
/**
 * Services Archive Template
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<section class="page-hero page-hero--small">
    <div class="container">
        <div class="page-hero__content">
            <span class="eyebrow">Layanan</span>
            <h1 class="page-hero__title"><?php post_type_archive_title(); ?></h1>
            <p class="page-hero__subtitle">Solusi kecantikan terlengkap untuk kebutuhan Anda</p>
        </div>
    </div>
</section>

<?php alya_section('services-archive'); ?>
    <div class="container">
        <!-- Filters -->
        <?php
        $categories = get_terms(['taxonomy' => 'service_category', 'hide_empty' => true]);
        if ($categories && !is_wp_error($categories)) :
        ?>
            <div class="filter-bar">
                <button class="filter-btn filter-btn--active" data-filter="all">Semua</button>
                <?php foreach ($categories as $cat) : ?>
                    <button class="filter-btn" data-filter="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Grid -->
        <?php
        $per_page = get_theme_mod('alya_services_per_page', 9);
        $args = [
            'post_type'      => 'service',
            'posts_per_page' => $per_page,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        ];

        // Category filter
        if (isset($_GET['category']) && !empty($_GET['category'])) {
            $args['tax_query'] = [[
                'taxonomy' => 'service_category',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['category']),
            ]];
        }

        $services = new WP_Query($args);
        ?>

        <?php if ($services->have_posts()) : ?>
            <div class="cards-grid cards-grid--<?php echo esc_attr(get_theme_mod('alya_services_columns', 3)); ?>">
                <?php while ($services->have_posts()) : $services->the_post(); ?>
                    <?php alya_card([
                        'title' => get_the_title(),
                        'desc'  => wp_trim_words(get_the_excerpt(), 15),
                        'image' => get_the_post_thumbnail(get_the_ID(), 'alya-card'),
                        'link'  => get_the_permalink(),
                        'icon'  => alya_icon('check'),
                        'class' => 'card--service',
                    ]); ?>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>

            <?php alya_pagination($services); ?>
        <?php else : ?>
            <div class="no-results">
                <h2>Belum ada layanan tersedia.</h2>
                <p>Silakan hubungi kami untuk informasi lebih lanjut.</p>
            </div>
        <?php endif; ?>
    </div>
<?php alya_section_close(); ?>

<?php get_footer();

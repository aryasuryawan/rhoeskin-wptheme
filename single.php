<?php
/**
 * Single Post Template — Blog
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<?php alya_breadcrumbs(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('blog-single'); ?>>
    <div class="container container--narrow">
        <!-- Header -->
        <header class="blog-single__header">
            <span class="eyebrow"><?php echo get_the_date(); ?></span>
            <h1 class="blog-single__title"><?php the_title(); ?></h1>
            <div class="blog-single__meta">
                <span class="blog-single__author">
                    <?php echo get_the_post_thumbnail(get_the_ID(), 'thumbnail'); ?>
                    <?php the_author(); ?>
                </span>
                <span class="blog-single__reading">
                    <?php echo alya_icon('clock'); ?>
                    <?php echo ceil(str_word_count(strip_tags(get_the_content())) / 200); ?> menit baca
                </span>
            </div>
        </header>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <div class="blog-single__featured">
                <?php the_post_thumbnail('alya-hero', ['loading' => 'eager']); ?>
            </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="blog-single__content entry-content">
            <?php the_content(); ?>
        </div>

        <!-- Tags -->
        <?php
        $tags = get_the_tags();
        if ($tags) :
        ?>
            <div class="blog-single__tags">
                <?php foreach ($tags as $tag) : ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag"><?php echo esc_html($tag->name); ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Share -->
        <?php alya_social_share(); ?>

        <!-- Post Navigation -->
        <nav class="blog-single__nav">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            ?>
            <?php if ($prev) : ?>
                <a href="<?php echo esc_url(get_permalink($prev->ID)); ?>" class="blog-single__nav-link blog-single__nav-link--prev">
                    <span class="blog-single__nav-label"><?php echo alya_icon('arrow'); ?> Sebelumnya</span>
                    <span class="blog-single__nav-title"><?php echo esc_html($prev->post_title); ?></span>
                </a>
            <?php endif; ?>
            <?php if ($next) : ?>
                <a href="<?php echo esc_url(get_permalink($next->ID)); ?>" class="blog-single__nav-link blog-single__nav-link--next">
                    <span class="blog-single__nav-label">Selanjutnya <?php echo alya_icon('arrow'); ?></span>
                    <span class="blog-single__nav-title"><?php echo esc_html($next->post_title); ?></span>
                </a>
            <?php endif; ?>
        </nav>

        <!-- Related Posts -->
        <?php
        $related = alya_get_posts('post', [
            'posts_per_page' => 3,
            'post__not_in'   => [get_the_ID()],
            'category__in'   => wp_get_post_categories(get_the_ID()),
        ]);
        if ($related->have_posts()) :
        ?>
            <div class="blog-single__related">
                <h3>Artikel Terkait</h3>
                <div class="cards-grid cards-grid--3">
                    <?php while ($related->have_posts()) : $related->the_post(); ?>
                        <?php get_template_part('template-parts/content', 'post'); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</article>

<?php endwhile; ?>

<?php get_footer();

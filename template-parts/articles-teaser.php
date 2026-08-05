<?php
/**
 * Articles Teaser — Blog cards
 *
 * @package Alya_Esthetic
 */

$posts = alya_get_posts('post', ['posts_per_page' => 3]);

if (!$posts->have_posts()) return;
?>

<section class="articles articles--v2" id="artikel">
    <div class="container">
        <div class="sec-head">
            <div>
                <span class="eyebrow">Blog Alya Esthetic</span>
                <h2>Artikel & Tips Terbaru</h2>
            </div>
            <a class="btn btn--outline" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                Lihat Semua Artikel
            </a>
        </div>
    </div>
    <div class="container">
        <div class="articles-grid">
            <?php while ($posts->have_posts()) : $posts->the_post();
                $categories = get_the_category();
                $cat_name = !empty($categories) ? $categories[0]->name : '';
            ?>
                <a class="post-card" href="<?php the_permalink(); ?>">
                    <div class="thumb">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php echo get_the_post_thumbnail(get_the_ID(), 'alya-card', ['loading' => 'lazy']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="p-body">
                        <?php if ($cat_name) : ?>
                            <span class="tag"><?php echo esc_html($cat_name); ?></span>
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

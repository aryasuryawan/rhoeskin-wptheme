<?php
/**
 * Blog Archive Template — Artikel & Tips Kecantikan
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<!-- ============ PAGE HEADER ============ -->
<div class="pagehead">
    <div class="container">
        <span class="eyebrow eyebrow--light">Blog Alya Esthetic</span>
        <h1 style="color:#fff"><?php
            echo wp_kses_post(get_the_archive_title() ?: 'Artikel & Tips Kecantikan');
        ?></h1>
        <div class="crumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
            <span>/</span>
            <span style="color:#fff">Artikel</span>
        </div>
    </div>
</div>

<!-- ============ FILTER BAR ============ -->
<div class="filterbar">
    <div class="container">
        <div class="chips">
            <?php
            $categories = get_categories(['orderby' => 'name', 'order' => 'ASC']);
            $active_cat = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : 'semua';
            ?>
            <button class="chip <?php echo $active_cat === 'semua' ? 'active' : ''; ?>" data-filter="semua">Semua</button>
            <?php foreach ($categories as $cat) : ?>
                <button class="chip <?php echo $active_cat === $cat->slug ? 'active' : ''; ?>" data-filter="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
            <?php endforeach; ?>
        </div>
        <div class="searchbox">
            <svg viewBox="0 0 24 24"><path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 10-.7.7l.3.3v.8l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/></svg>
            <input type="text" id="searchInput" placeholder="Cari artikel...">
        </div>
    </div>
</div>

<!-- ============ BLOG LIST ============ -->
<section class="blog">
    <div class="container blog__layout">
        <div>
            <div class="blog__grid" id="blogGrid">
                <?php if (have_posts()) : ?>
                    <?php
                    $post_count = 0;
                    while (have_posts()) : the_post();
                        $post_count++;
                        $is_featured = ($post_count === 1);
                        $categories = get_the_category();
                        $cat_name = !empty($categories) ? $categories[0]->name : '';
                        $cat_slug = !empty($categories) ? $categories[0]->slug : '';
                        $cats_slugs = '';
                        foreach ($categories as $cat) {
                            $cats_slugs .= $cat->slug . ' ';
                        }
                        $cats_slugs = trim($cats_slugs);
                    ?>
                        <a class="post-card <?php echo $is_featured ? 'featured' : ''; ?>" data-cat="<?php echo esc_attr($cats_slugs); ?>" href="<?php the_permalink(); ?>">
                            <div class="thumb">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url(ALYA_URI . '/assets/img/placeholder.jpg'); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="p-body">
                                <?php if ($cat_name) : ?>
                                    <span class="tag"><?php echo esc_html($cat_name); ?></span>
                                <?php endif; ?>
                                <h3><?php the_title(); ?></h3>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <div class="p-meta">
                                    <span>
                                        <svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg>
                                        <?php echo esc_html(get_the_author()); ?>
                                    </span>
                                    <span>
                                        <svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg>
                                        <?php echo esc_html(get_the_date('j M Y')); ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="no-results">
                        <h2>Tidak ada artikel ditemukan.</h2>
                        <p>Silakan coba pencarian atau kategori lain.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (have_posts()) : ?>
                <div class="pagination">
                    <?php
                    echo paginate_links([
                        'prev_text' => '&laquo; Sebelumnya',
                        'next_text' => 'Selanjutnya &raquo;',
                        'type'      => 'list',
                        'mid_size'  => 1,
                    ]);
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ============ SIDEBAR ============ -->
        <aside class="sidebar">
            <div class="side-box">
                <h4>Artikel Populer</h4>
                <?php
                $popular = new WP_Query([
                    'post_type'      => 'post',
                    'posts_per_page' => 3,
                    'meta_key'       => 'post_views_count',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
                    'ignore_sticky_posts' => true,
                ]);

                if (!$popular->have_posts()) {
                    $popular = new WP_Query([
                        'post_type'      => 'post',
                        'posts_per_page' => 3,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ]);
                }

                if ($popular->have_posts()) :
                    while ($popular->have_posts()) : $popular->the_post();
                ?>
                    <div class="popular-item">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail'); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url(ALYA_URI . '/assets/img/placeholder.jpg'); ?>" alt="">
                            <?php endif; ?>
                        </a>
                        <div>
                            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            <span class="date"><?php echo esc_html(get_the_date('j M Y')); ?></span>
                        </div>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>

            <div class="side-box">
                <h4>Kategori</h4>
                <div class="tagcloud">
                    <?php
                    $all_cats = get_categories(['orderby' => 'count', 'order' => 'DESC']);
                    foreach ($all_cats as $cat) :
                    ?>
                        <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="side-box cta-box">
                <h4>Konsultasi Gratis</h4>
                <p>Punya pertanyaan seputar perawatan kulit? Chat langsung dengan tim kami di WhatsApp.</p>
                <a class="btn" href="<?php echo esc_url(alya_wa_link()); ?>" target="_blank" rel="noopener">Hubungi Kami</a>
            </div>
        </aside>
    </div>
</section>

<?php get_footer();

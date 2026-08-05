<?php
/**
 * Search Results Template
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<section class="page-hero page-hero--small">
    <div class="container">
        <div class="page-hero__content">
            <h1 class="page-hero__title">Hasil Pencarian</h1>
            <p class="page-hero__subtitle">Hasil untuk: "<?php echo esc_html(get_search_query()); ?>"</p>
        </div>
    </div>
</section>

<?php alya_section('search-main'); ?>
    <div class="container">
        <?php if (have_posts()) : ?>
            <p class="search-count"><?php printf('Ditemukan %d hasil pencarian.', $wp_query->found_posts); ?></p>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', 'search'); ?>
                <?php endwhile; ?>
            </div>
            <?php alya_pagination(); ?>
        <?php else : ?>
            <div class="no-results">
                <h2>Tidak ada hasil ditemukan.</h2>
                <p>Silakan coba kata kunci lain atau kembali ke beranda.</p>
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-form__row">
                        <input type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="Cari..." class="search-form__input">
                        <button type="submit" class="btn btn--primary">Cari</button>
                    </div>
                </form>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--outline" style="margin-top:1rem;">Kembali ke Beranda</a>
            </div>
        <?php endif; ?>
    </div>
<?php alya_section_close(); ?>

<?php get_footer();

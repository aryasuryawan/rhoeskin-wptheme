<?php
/**
 * Default Archive Template
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<section class="page-hero page-hero--small">
    <div class="container">
        <div class="page-hero__content">
            <h1 class="page-hero__title"><?php the_archive_title(); ?></h1>
            <?php if (get_the_archive_description()) : ?>
                <p class="page-hero__subtitle"><?php echo wp_kses_post(get_the_archive_description()); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php alya_section('archive-main'); ?>
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', get_post_type()); ?>
                <?php endwhile; ?>
            </div>
            <?php alya_pagination(); ?>
        <?php else : ?>
            <div class="no-results">
                <h2>Tidak ada konten ditemukan.</h2>
                <p>Silakan coba pencarian lain atau kembali ke beranda.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">Kembali ke Beranda</a>
            </div>
        <?php endif; ?>
    </div>
<?php alya_section_close(); ?>

<?php get_footer();

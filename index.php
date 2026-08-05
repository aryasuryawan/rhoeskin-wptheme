<?php
/**
 * Index Template (Fallback)
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<section class="page-default">
    <div class="container">
        <?php if (is_home() && !is_front_page()) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>
        <?php endif; ?>

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
                <p>Sepertinya tidak ada konten yang cocok dengan pencarian Anda.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer();

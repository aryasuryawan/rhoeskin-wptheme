<?php
/**
 * Default Page Template
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<?php alya_breadcrumbs(); ?>

<section class="page-default">
    <div class="container container--narrow">
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer();

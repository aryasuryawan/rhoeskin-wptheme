<?php
/**
 * Template Name: Technology Page
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<!-- Hero -->
<?php
$hero_bg        = get_field('alya_hero_bg');
$hero_title     = get_field('alya_hero_title') ?: get_the_title();
$hero_subtitle  = get_field('alya_hero_subtitle');
?>
<section class="page-hero <?php echo $hero_bg ? 'page-hero--bg' : ''; ?>" <?php if ($hero_bg && is_array($hero_bg)) echo 'style="background-image:url(' . esc_url($hero_bg['url']) . ')"'; ?>>
    <div class="page-hero__overlay"></div>
    <div class="container">
        <div class="page-hero__content">
            <h1 class="page-hero__title"><?php echo esc_html($hero_title); ?></h1>
            <?php if ($hero_subtitle) : ?>
                <p class="page-hero__subtitle"><?php echo esc_html($hero_subtitle); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Technology Items -->
<?php
$tech_items = get_field('alya_tech_items');
if ($tech_items) :
?>
<section class="tech-page">
    <div class="container">
        <div class="tech-list">
            <?php foreach ($tech_items as $item) : ?>
                <div class="tech-item">
                    <?php if ($item['image']) : ?>
                        <div class="tech-item__image">
                            <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" width="600" height="400">
                        </div>
                    <?php endif; ?>
                    <div class="tech-item__content">
                        <?php if ($item['icon']) : ?>
                            <div class="tech-item__icon"><?php echo esc_html($item['icon']); ?></div>
                        <?php endif; ?>
                        <h2 class="tech-item__title"><?php echo esc_html($item['title']); ?></h2>
                        <p class="tech-item__desc"><?php echo esc_html($item['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Content -->
<?php if (get_the_content()) : ?>
<section class="page-default">
    <div class="container container--narrow">
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer();

<?php
/**
 * Template Name: About Page
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

<!-- About Content -->
<section class="about-page">
    <div class="container">
        <div class="about-page__content">
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>

<!-- Doctors Preview -->
<?php
$doctors = alya_get_posts('doctor', ['posts_per_page' => 4]);
if ($doctors->have_posts()) :
?>
<?php alya_section('dokter-preview'); ?>
    <?php alya_section_header('Tim Kami', 'Dokter Spesialis', 'Kenali dokter-dokter berpengalaman kami.', 'center'); ?>
    <div class="cards-grid cards-grid--4">
        <?php while ($doctors->have_posts()) : $doctors->the_post(); ?>
            <?php
            $avatar   = get_field('alya_avatar');
            $position = get_field('alya_position');
            ?>
            <article class="card card--doctor">
                <div class="card__image">
                    <?php if ($avatar && is_array($avatar)) : ?>
                        <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" width="300" height="300">
                    <?php else : ?>
                        <?php echo get_the_post_thumbnail(get_the_ID(), 'alya-card'); ?>
                    <?php endif; ?>
                </div>
                <div class="card__body">
                    <h3 class="card__title"><?php the_title(); ?></h3>
                    <?php if ($position) : ?>
                        <p class="card__meta"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="link">
                        Lihat Profil <?php echo alya_icon('arrow-right'); ?>
                    </a>
                </div>
            </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
<?php alya_section_close(); ?>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer();

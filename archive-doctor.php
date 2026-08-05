<?php
/**
 * Doctor Archive Template
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<section class="page-hero page-hero--small">
    <div class="container">
        <div class="page-hero__content">
            <span class="eyebrow">Tim Dokter</span>
            <h1 class="page-hero__title"><?php post_type_archive_title(); ?></h1>
            <p class="page-hero__subtitle">Dokter spesialis berpengalaman yang siap membantu Anda</p>
        </div>
    </div>
</section>

<?php alya_section('doctors-archive'); ?>
    <div class="container">
        <?php
        $doctors = alya_get_posts('doctor', ['posts_per_page' => -1]);
        if ($doctors->have_posts()) :
        ?>
            <div class="cards-grid cards-grid--4">
                <?php while ($doctors->have_posts()) : $doctors->the_post(); ?>
                    <?php
                    $avatar   = get_field('alya_avatar');
                    $position = get_field('alya_position');
                    $featured = get_field('alya_featured');
                    ?>
                    <article class="card card--doctor <?php echo $featured ? 'card--featured' : ''; ?>">
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
                            <?php if (get_field('alya_credentials')) : ?>
                                <p class="card__desc"><?php echo esc_html(get_field('alya_credentials')); ?></p>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" class="link">
                                Lihat Profil <?php echo alya_icon('arrow-right'); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="no-results">
                <h2>Belum ada dokter tersedia.</h2>
            </div>
        <?php endif; ?>
    </div>
<?php alya_section_close(); ?>

<?php get_footer();

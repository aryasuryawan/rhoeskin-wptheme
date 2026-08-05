<?php
/**
 * Template Part: Doctor Card
 *
 * @package Alya_Esthetic
 */
?>
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

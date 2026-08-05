<?php
/**
 * Template Part: Testimonial Card
 *
 * @package Alya_Esthetic
 */
?>
<?php
$rating       = get_field('alya_rating') ?: 5;
$service_used = get_field('alya_service_used');
?>
<article class="card card--testimonial">
    <div class="card__quote">
        <?php echo alya_icon('quote'); ?>
    </div>
    <div class="card__stars">
        <?php echo alya_stars(5, $rating); ?>
    </div>
    <blockquote class="card__text">
        <?php echo wp_kses_post(get_the_content()); ?>
    </blockquote>
    <div class="card__author">
        <?php echo get_the_post_thumbnail(get_the_ID(), 'alya-thumb'); ?>
        <div>
            <h4 class="card__name"><?php the_title(); ?></h4>
            <?php if ($service_used) : ?>
                <span class="card__service"><?php echo esc_html($service_used); ?></span>
            <?php endif; ?>
        </div>
    </div>
</article>

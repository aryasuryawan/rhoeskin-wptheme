<?php
/**
 * Template Part: Job Card
 *
 * @package Alya_Esthetic
 */
?>
<?php
$terms = get_the_terms(get_the_ID(), 'job_type');
$location = get_field('alya_location');
$deadline = get_field('alya_deadline');
?>
<article class="card card--job">
    <div class="card__body">
        <?php if ($terms && !is_wp_error($terms)) : ?>
            <span class="card__badge"><?php echo esc_html($terms[0]->name); ?></span>
        <?php endif; ?>
        <h3 class="card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="card__meta">
            <?php if ($location) : ?>
                <span><?php echo alya_icon('pin'); ?> <?php echo esc_html($location); ?></span>
            <?php endif; ?>
            <?php if ($deadline) : ?>
                <span><?php echo alya_icon('clock'); ?> Deadline: <?php echo esc_html(date('d M Y', strtotime($deadline))); ?></span>
            <?php endif; ?>
        </div>
        <p class="card__desc"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
        <a href="<?php the_permalink(); ?>" class="link">
            Lihat Detail <?php echo alya_icon('arrow-right'); ?>
        </a>
    </div>
</article>

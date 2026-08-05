<?php
/**
 * Template Part: Search Result
 *
 * @package Alya_Esthetic
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('card card--search'); ?>>
    <div class="card__body">
        <span class="card__type"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></span>
        <h3 class="card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="card__desc"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
        <div class="card__meta">
            <span><?php echo esc_html(get_the_date()); ?></span>
        </div>
    </div>
</article>

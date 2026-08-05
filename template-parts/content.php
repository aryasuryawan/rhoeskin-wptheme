<?php
/**
 * Template Part: Default Content
 *
 * @package Alya_Esthetic
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="card__image">
            <a href="<?php the_permalink(); ?>">
                <?php echo get_the_post_thumbnail(get_the_ID(), 'alya-card'); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="card__body">
        <h3 class="card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="card__meta">
            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
        </div>
        <p class="card__text"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
        <a href="<?php the_permalink(); ?>" class="link">
            Baca Selengkapnya
            <svg viewBox="0 0 24 24" width="16" height="16"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg>
        </a>
    </div>
</article>
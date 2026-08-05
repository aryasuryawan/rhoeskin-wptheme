<?php
/**
 * Template Part: Post Card
 *
 * @package Alya_Esthetic
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('card card--post'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="card__image">
            <?php the_post_thumbnail('alya-card', ['loading' => 'lazy']); ?>
        </a>
    <?php endif; ?>
    <div class="card__body">
        <div class="card__meta">
            <span class="card__date"><?php echo alya_icon('calendar'); ?> <?php echo esc_html(get_the_date()); ?></span>
            <span class="card__category">
                <?php
                $cats = get_the_category();
                if ($cats) echo esc_html($cats[0]->name);
                ?>
            </span>
        </div>
        <h3 class="card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="card__desc"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
        <a href="<?php the_permalink(); ?>" class="link">
            Baca Selengkapnya <?php echo alya_icon('arrow-right'); ?>
        </a>
    </div>
</article>

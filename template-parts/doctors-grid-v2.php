<?php
/**
 * Doctors Grid V2 — Static 5-col grid
 *
 * @package Alya_Esthetic
 */

$doctors = alya_get_posts('doctor', ['posts_per_page' => 5]);

if (!$doctors->have_posts()) return;
?>

<section class="doctors" id="dokter">
    <div class="container sec-head">
        <div>
            <span class="eyebrow">Tim Medis Kami</span>
            <h2>Dokter &amp; Tenaga Ahli Berpengalaman</h2>
        </div>
        <p class="lead">Setiap treatment ditangani oleh dokter dan terapis yang berdedikasi pada pendekatan personal.</p>
    </div>
    <div class="container">
        <div class="doc-grid">
            <?php while ($doctors->have_posts()) : $doctors->the_post();
                $avatar = get_field('alya_avatar');
                $specialist = get_field('alya_specialist') ?: get_field('alya_position') ?: 'Aesthetic Doctor';
            ?>
                <a href="<?php the_permalink(); ?>" class="doc-card" style="text-decoration:none;color:inherit;">
                    <div class="doc-avatar">
                        <?php if ($avatar && is_array($avatar)) : ?>
                            <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="300" height="300" loading="lazy">
                        <?php elseif (has_post_thumbnail()) : ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="300" height="300" loading="lazy">
                        <?php else : ?>
                            <div class="doc-avatar initial"><?php echo esc_html(mb_substr(get_the_title(), 0, 1)); ?></div>
                        <?php endif; ?>
                    </div>
                    <h4><?php the_title(); ?></h4>
                    <span><?php echo esc_html($specialist); ?></span>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

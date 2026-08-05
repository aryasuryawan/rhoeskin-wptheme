<?php
/**
 * Testimonials V2 — Featured card + avatar strip
 *
 * @package Alya_Esthetic
 */

$testimonials = alya_get_posts('testimonial', ['posts_per_page' => 6]);

if (!$testimonials->have_posts()) return;

$first = true;
?>

<section class="testi testi--v2" id="testimoni">
    <div class="container">
        <div class="testi__head">
            <div>
                <span class="eyebrow">Testimoni</span>
                <h2>Apa Kata Pasien Kami</h2>
            </div>
            <p class="lead">Sudah banyak pasien Alya Esthetic Center yang merasakan sendiri hasilnya. Lihat cerita mereka di sini!</p>
        </div>

        <div class="testi-feat" id="testiFeat">
            <?php
            $testimonials->rewind_post();
            $t = $testimonials->the_post();
            $avatar = get_field('alya_avatar');
            $stars = intval(get_field('alya_stars') ?: get_field('alya_rating') ?: 5);
            $name = get_field('alya_author_name') ?: get_the_title();
            $role = get_field('alya_author_role') ?: get_field('alya_service_used') ?: '';
            $img_url = '';
            if ($avatar && is_array($avatar)) {
                $img_url = $avatar['url'];
            } elseif (has_post_thumbnail()) {
                $img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
            }
            ?>
            <div class="testi-feat__media" id="testiFeatMedia">
                <?php if ($img_url) : ?>
                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($name); ?>" width="600" height="450" loading="lazy">
                <?php else : ?>
                    <div class="testi-feat__initial"><?php echo esc_html(mb_substr($name, 0, 1)); ?></div>
                <?php endif; ?>
            </div>
            <div class="testi-feat__body">
                <b id="testiFeatName"><?php echo esc_html($name); ?></b>
                <span class="role" id="testiFeatRole"><?php echo esc_html($role); ?></span>
                <div class="stars">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3 6 6 .9-4.5 4.3 1 6-5.5-3-5.5 3 1-6L3 8.9 9 8z"/></svg>
                    <?php endfor; ?>
                </div>
                <p id="testiFeatQuote"><?php echo wp_kses_post(get_the_content()); ?></p>
            </div>
        </div>

        <div class="testi-strip">
            <div class="testi-strip__track" id="testiStrip">
                <?php
                $testimonials->rewind_post();
                while ($testimonials->have_posts()) : $testimonials->the_post();
                    $avatar = get_field('alya_avatar');
                    $stars = intval(get_field('alya_stars') ?: get_field('alya_rating') ?: 5);
                    $name = get_field('alya_author_name') ?: get_the_title();
                    $role = get_field('alya_author_role') ?: get_field('alya_service_used') ?: '';
                    $img_url = '';
                    if ($avatar && is_array($avatar)) {
                        $img_url = $avatar['url'];
                    } elseif (has_post_thumbnail()) {
                        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                    }
                ?>
                    <button class="testi-avatar<?php echo $first ? ' active' : ''; ?>"
                            data-name="<?php echo esc_attr($name); ?>"
                            data-role="<?php echo esc_attr($role); ?>"
                            data-img="<?php echo esc_url($img_url); ?>"
                            data-quote="<?php echo esc_attr(wp_strip_all_tags(get_the_content())); ?>">
                        <span class="thumb">
                            <?php if ($img_url) : ?>
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($name); ?>" width="150" height="142" loading="lazy">
                            <?php else : ?>
                                <span class="thumb__initial"><?php echo esc_html(mb_substr($name, 0, 1)); ?></span>
                            <?php endif; ?>
                        </span>
                        <span><?php echo esc_html($name); ?></span>
                    </button>
                <?php
                    $first = false;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</section>

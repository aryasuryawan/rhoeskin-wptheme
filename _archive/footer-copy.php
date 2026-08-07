<?php
/**
 * Footer Template — matches static HTML template
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;
?>
</main><!-- #main -->

<footer>
    <div class="container grid">
            <div class="brand">
                <?php if (get_theme_mod('alya_logo_white')): ?>
                    <img src="<?php echo esc_url(get_theme_mod('alya_logo_white')); ?>" alt="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>" style="height:34px">
                <?php elseif (get_theme_mod('alya_logo')): ?>
                    <img src="<?php echo esc_url(get_theme_mod('alya_logo')); ?>" alt="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>" style="height:34px;filter:brightness(0) invert(1)">
                <?php else: ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo/logo-and-text.svg'); ?>" alt="Alya Esthetic" style="height:34px;filter:brightness(0) invert(1)">
                <?php endif; ?>
                <p><?php echo esc_html(get_theme_mod('alya_clinic_tagline', 'Klinik kecantikan satu pintu di Jakarta Selatan — hospitality, kesehatan, dan solusi terbaik untuk kecantikan Anda.')); ?></p>
                <?php if (get_theme_mod('alya_description')): ?>
                    <p class="footer-description"><?php echo esc_html(get_theme_mod('alya_description')); ?></p>
                <?php endif; ?>
                <?php if (get_theme_mod('alya_address')): ?>
                    <p class="footer-contact" style="margin-top:12px;font-size:.85rem;color:var(--footer-text);">
                        <span><?php echo esc_html(get_theme_mod('alya_address')); ?></span>
                    </p>
                <?php endif; ?>
                <?php if (get_theme_mod('alya_phone')): ?>
                    <p class="footer-contact" style="margin-top:6px;font-size:.85rem;color:var(--footer-text);">
                        <a href="tel:<?php echo esc_attr(get_theme_mod('alya_phone_link', '6281290000000')); ?>" style="color:inherit;text-decoration:none;"><?php echo esc_html(get_theme_mod('alya_phone')); ?></a>
                    </p>
                <?php endif; ?>
                <?php if (get_theme_mod('alya_email')): ?>
                    <p class="footer-contact" style="margin-top:6px;font-size:.85rem;color:var(--footer-text);">
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('alya_email')); ?>" style="color:inherit;text-decoration:none;"><?php echo esc_html(get_theme_mod('alya_email')); ?></a>
                    </p>
                <?php endif; ?>
            </div>
        <div>
            <h5>Layanan</h5>
            <ul>
                <?php if (get_term_by('slug', 'skin-serenity', 'treatment_category')): ?>
                    <li><a href="<?php echo esc_url(get_term_link(get_term_by('slug', 'skin-serenity', 'treatment_category'))); ?>">Skin Serenity</a></li>
                <?php else: ?>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('treatment')); ?>?service=skin-serenity">Skin Serenity</a></li>
                <?php endif; ?>
                <?php if (get_term_by('slug', 'beauty-advance', 'treatment_category')): ?>
                    <li><a href="<?php echo esc_url(get_term_link(get_term_by('slug', 'beauty-advance', 'treatment_category'))); ?>">Beauty Advance</a></li>
                <?php else: ?>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('treatment')); ?>?service=beauty-advance">Beauty Advance</a></li>
                <?php endif; ?>
                <?php if (get_term_by('slug', 'slimming-wellness', 'treatment_category')): ?>
                    <li><a href="<?php echo esc_url(get_term_link(get_term_by('slug', 'slimming-wellness', 'treatment_category'))); ?>">Slimming &amp; Wellness</a></li>
                <?php else: ?>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('treatment')); ?>?service=slimming-wellness">Slimming &amp; Wellness</a></li>
                <?php endif; ?>
                <?php if (get_term_by('slug', 'alya-beauty-bar', 'treatment_category')): ?>
                    <li><a href="<?php echo esc_url(get_term_link(get_term_by('slug', 'alya-beauty-bar', 'treatment_category'))); ?>">Alya Beauty Bar</a></li>
                <?php else: ?>
                    <li><a href="<?php echo esc_url(get_post_type_archive_link('treatment')); ?>?service=alya-beauty-bar">Alya Beauty Bar</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div>
            <h5>Menu</h5>
            <ul>
                <?php
                $menu_pages = [
                    'Tentang'     => get_page_by_path('tentang'),
                    'Dokter'      => get_post_type_archive_link('doctor'),
                    'Testimoni'   => get_post_type_archive_link('testimonial'),
                    'Artikel'     => get_permalink(get_option('page_for_posts')),
                    'Kontak'      => get_page_by_path('kontak'),
                ];
                foreach ($menu_pages as $label => $link):
                    $url = is_object($link) ? get_permalink($link) : $link;
                    if (!$url) continue;
                ?>
                    <li><a href="<?php echo esc_url($url); ?>">
                        <?php echo esc_html($label); ?>
                    </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h5>Ikuti Kami</h5>
            <div class="socials">
                <?php
                $socials = [
                    'instagram' => get_theme_mod('alya_social_instagram', ''),
                    'whatsapp'  => get_theme_mod('alya_social_whatsapp', ''),
                    'facebook'  => get_theme_mod('alya_social_facebook', ''),
                    'tiktok'    => get_theme_mod('alya_social_tiktok', ''),
                    'youtube'   => get_theme_mod('alya_social_youtube', ''),
                ];
                foreach ($socials as $platform => $url):
                    if (empty($url)) continue;
                    $aria = ['instagram' => 'Instagram', 'whatsapp' => 'WhatsApp', 'facebook' => 'Facebook', 'tiktok' => 'TikTok', 'youtube' => 'YouTube'];
                ?>
                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($aria[$platform]); ?>">
                        <?php echo alya_icon($platform); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container copyright">
        &copy; <span id="currentYear"></span> <?php echo esc_html(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>. All rights reserved.
    </div>
</footer>

<?php if (get_theme_mod('alya_wa_enable', true)) : ?>
<div class="fab-wa fab-wa--bottom-right fab-wa--bounce" id="fab-wa" style="--wa-color: #25D366; --wa-delay: 2s;">
    <a href="<?php echo esc_url(alya_wa_link()); ?>" class="fab-wa__btn" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp">
        <?php echo alya_icon('whatsapp'); ?>
    </a>
</div>
<?php endif; ?>

<script>
document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>

<?php wp_footer(); ?>
</body>
</html>
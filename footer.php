<?php
/**
 * Footer Template
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;
?>
</main><!-- #main -->

<footer id="site-footer" class="site-footer">
    <div class="container">
        <div class="site-footer__grid">
            <!-- Brand Column -->
            <div class="site-footer__col site-footer__col--brand">
                <?php if (get_theme_mod('alya_logo_white')) : ?>
                    <img src="<?php echo esc_url(get_theme_mod('alya_logo_white')); ?>" alt="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>" class="site-footer__logo" width="180" height="50" loading="lazy">
                <?php elseif (get_theme_mod('alya_logo')) : ?>
                    <img src="<?php echo esc_url(get_theme_mod('alya_logo')); ?>" alt="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>" class="site-footer__logo" width="180" height="50" loading="lazy">
                <?php endif; ?>
                <p class="site-footer__desc"><?php echo esc_html(get_theme_mod('alya_clinic_tagline', 'Your Beauty, Our Priority')); ?></p>
                <div class="site-footer__social">
                    <?php
                    $socials = [
                        'facebook'  => get_theme_mod('alya_social_facebook', ''),
                        'instagram' => get_theme_mod('alya_social_instagram', ''),
                        'tiktok'    => get_theme_mod('alya_social_tiktok', ''),
                        'youtube'   => get_theme_mod('alya_social_youtube', ''),
                        'linkedin'  => get_theme_mod('alya_social_linkedin', ''),
                        'twitter'   => get_theme_mod('alya_social_twitter', ''),
                    ];
                    foreach ($socials as $platform => $url) :
                        if (empty($url)) continue;
                    ?>
                        <a href="<?php echo esc_url($url); ?>" class="site-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>">
                            <?php echo alya_icon($platform); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Navigation Column -->
            <div class="site-footer__col">
                <h4 class="site-footer__title">Navigasi</h4>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer',
                    'container'      => false,
                    'menu_class'     => 'site-footer__menu',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ]);
                ?>
            </div>

            <!-- Contact Column -->
            <div class="site-footer__col">
                <h4 class="site-footer__title">Kontak</h4>
                <ul class="site-footer__contact">
                    <?php if (get_theme_mod('alya_address')) : ?>
                        <li>
                            <?php echo alya_icon('pin'); ?>
                            <span><?php echo esc_html(get_theme_mod('alya_address')); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if (get_theme_mod('alya_phone')) : ?>
                        <li>
                            <?php echo alya_icon('phone'); ?>
                            <a href="tel:<?php echo esc_attr(get_theme_mod('alya_phone_link', '6281290000000')); ?>"><?php echo esc_html(get_theme_mod('alya_phone')); ?></a>
                        </li>
                    <?php endif; ?>
                    <?php if (get_theme_mod('alya_email')) : ?>
                        <li>
                            <?php echo alya_icon('email'); ?>
                            <a href="mailto:<?php echo esc_attr(get_theme_mod('alya_email')); ?>"><?php echo esc_html(get_theme_mod('alya_email')); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Google Maps Column -->
            <div class="site-footer__col">
                <h4 class="site-footer__title">Lokasi</h4>
                <?php if (get_theme_mod('alya_google_maps_embed')) : ?>
                    <div class="site-footer__map">
                        <iframe
                            src="<?php echo esc_url(get_theme_mod('alya_google_maps_embed')); ?>"
                            width="100%"
                            height="200"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Alya Esthetic Center">
                        </iframe>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Copyright -->
        <div class="site-footer__bottom">
            <p class="site-footer__copyright">
                <?php
                $copyright = get_theme_mod('alya_footer_copyright', '');
                if ($copyright) {
                    echo esc_html($copyright);
                } else {
                    printf(
                        '&copy; %1$s %2$s. All rights reserved.',
                        date('Y'),
                        esc_html(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center'))
                    );
                }
                ?>
            </p>
        </div>
    </div>
</footer>

<!-- WhatsApp Floating Button -->
<?php if (get_theme_mod('alya_wa_enable', true)) : ?>
<?php
$wa_position   = get_theme_mod('alya_wa_position', 'bottom-right');
$wa_color      = get_theme_mod('alya_wa_color', '#25D366');
$wa_tooltip    = get_theme_mod('alya_wa_tooltip', 'Chat WhatsApp');
$wa_delay      = get_theme_mod('alya_wa_delay', 2);
$wa_animation  = get_theme_mod('alya_wa_animation', 'bounce');
?>
<div class="wa-float wa-float--<?php echo esc_attr($wa_position); ?> <?php echo $wa_animation ? 'wa-float--' . esc_attr($wa_animation) : ''; ?>"
     style="--wa-color: <?php echo esc_attr($wa_color); ?>; --wa-delay: <?php echo esc_attr($wa_delay); ?>s;"
     id="wa-float">
    <div class="wa-float__tooltip"><?php echo esc_html($wa_tooltip); ?></div>
    <a href="<?php echo esc_url(alya_wa_link()); ?>" class="wa-float__btn" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp">
        <?php echo alya_icon('whatsapp'); ?>
    </a>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>

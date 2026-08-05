<?php
/**
 * Header Template
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'alya-esthetic'); ?></a>

<header id="site-header" class="site-header <?php echo get_theme_mod('alya_header_sticky', true) ? 'site-header--sticky' : ''; ?>">
    <div class="container">
        <div class="site-header__inner">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-header__logo" aria-label="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>">
                <?php if (get_theme_mod('alya_logo')) : ?>
                    <img src="<?php echo esc_url(get_theme_mod('alya_logo')); ?>" alt="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>" width="200" height="60" loading="eager">
                <?php else : ?>
                    <span class="site-header__text-logo"><?php echo esc_html(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?></span>
                <?php endif; ?>
            </a>

            <!-- Navigation -->
            <nav class="site-header__nav" aria-label="Main Navigation">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav-list',
                    'fallback_cb'    => false,
                    'depth'          => 2,
                ]);
                ?>
            </nav>

            <!-- CTA + WhatsApp -->
            <div class="site-header__actions">
                <?php
                $cta_text  = get_theme_mod('alya_header_cta_text', 'Konsultasi Gratis');
                $cta_url   = get_theme_mod('alya_header_cta_url', '#konsultasi');
                ?>
                <a href="<?php echo esc_url($cta_url); ?>" class="btn btn--primary btn--sm"><?php echo esc_html($cta_text); ?></a>

                <?php if (get_theme_mod('alya_wa_enable', true)) : ?>
                    <a href="<?php echo esc_url(alya_wa_link()); ?>" class="btn btn--whatsapp btn--sm" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp">
                        <?php echo alya_icon('whatsapp'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Toggle -->
            <button class="site-header__toggle" aria-label="Toggle Menu" aria-expanded="false">
                <span class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
        </div>
    </div>
</header>

<main id="main" class="site-main">

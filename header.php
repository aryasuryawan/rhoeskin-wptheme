<?php
/**
 * Header Template — matches static HTML template
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

<header id="siteHeader">
    <div class="container nav">
        <a class="logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>">
            <?php if (get_theme_mod('alya_logo')) : ?>
                <img src="<?php echo esc_url(get_theme_mod('alya_logo')); ?>" alt="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center')); ?>">
            <?php else : ?>
                <img src="https://alyaesthetic.id/wp-content/uploads/2024/06/logo-and-text.352ad43b.svg" alt="Alya Esthetic Center">
            <?php endif; ?>
        </a>
        <nav class="nav__elms">
            <?php if (is_front_page() && get_theme_mod('alya_homepage_style', 'default') === 'v2') : ?>
                <?php
                wp_nav_menu([
                    'theme_location' => 'home',
                    'container'      => false,
                    'menu_id'        => 'navLinks',
                    'menu_class'     => 'nav__links',
                    'fallback_cb'    => 'alya_home_nav_fallback',
                    'depth'          => 1,
                    'walker'         => new Alya_Dropdown_Walker(),
                ]);
                ?>
            <?php else : ?>
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_id'        => 'navLinks',
                    'menu_class'     => 'nav__links',
                    'fallback_cb'    => false,
                    'depth'          => 3,
                    'walker'         => new Alya_Dropdown_Walker(),
                ]);
                ?>
            <?php endif; ?>
            <a class="btn btn--ghostdark" href="<?php echo (is_front_page() && get_theme_mod('alya_homepage_style', 'default') === 'v2') ? '#kontak' : esc_url(get_permalink(get_page_by_path('kontak')) ?: home_url('/kontak/')); ?>">Buat Janji</a>
            <button class="burger" id="burger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </nav>
    </div>
</header>

<main id="main" class="site-main">
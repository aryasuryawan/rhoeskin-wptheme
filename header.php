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
            <?php
            $logo_light = get_theme_mod('alya_logo')       ?: get_template_directory_uri() . '/assets/images/logo/Rhoe_Skin_transparent.png';
            $logo_dark  = get_theme_mod('alya_logo_white') ?: get_template_directory_uri() . '/assets/images/logo/rhoe_skin_logo_white_transparent.png';
            $alt        = esc_attr(get_theme_mod('alya_clinic_name', 'Alya Esthetic Center'));
            ?>
            <img class="logo__light" src="<?php echo esc_url($logo_light); ?>" alt="<?php echo $alt; ?>">
            <img class="logo__dark"  src="<?php echo esc_url($logo_dark); ?>"  alt="<?php echo $alt; ?>">
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
            <?php if (function_exists('pll_the_languages')) : ?>
                <div class="lang-switcher-custom">
                    <?php
                    $languages = pll_the_languages([
                        'raw' => 1,
                        'hide_if_no_translation' => 0,
                    ]);
                    
                    if (!empty($languages)) {
                        $current = null;
                        $others = [];
                        
                        foreach ($languages as $lang) {
                            if ($lang['current_lang']) {
                                $current = $lang;
                            } else {
                                $others[] = $lang;
                            }
                        }
                        
                        if ($current) :
                    ?>
                        <div class="lang-switcher-btn">
                            <img src="<?php echo esc_url($current['flag']); ?>" alt="<?php echo esc_attr($current['name']); ?>" title="<?php echo esc_attr($current['name']); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="currentColor">
                                <path d="M6 9L1 4h10z"/>
                            </svg>
                        </div>
                        <div class="lang-switcher-dropdown">
                            <?php foreach ($others as $lang) : ?>
                                <a href="<?php echo esc_url($lang['url']); ?>" class="lang-option">
                                    <img src="<?php echo esc_url($lang['flag']); ?>" alt="<?php echo esc_attr($lang['name']); ?>" title="<?php echo esc_attr($lang['name']); ?>">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php
                        endif;
                    }
                    ?>
                </div>
            <?php endif; ?>
            <a class="btn btn--ghostdark" href="<?php echo (is_front_page() && get_theme_mod('alya_homepage_style', 'default') === 'v2') ? '#kontak' : esc_url(get_permalink(get_page_by_path('kontak')) ?: home_url('/kontak/')); ?>">Buat Janji</a>
            <button class="burger" id="burger" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </nav>
    </div>
</header>

<main id="main" class="site-main">
<?php
/**
 * Front Page Template
 * Router untuk Home V1 atau Home V2 based on customizer setting
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

get_header();

// Check homepage style from customizer
$homepage_style = get_theme_mod('alya_homepage_style', 'default');

if ($homepage_style === 'v2') {
    // Load Home V2 sections
    get_template_part('template-parts/hero-v2');
    get_template_part('template-parts/about-v2');
    get_template_part('template-parts/services-grid-v2');
    get_template_part('template-parts/doctors-grid-v2');
    get_template_part('template-parts/testimonials-v2');
    get_template_part('template-parts/promo-v2');
    get_template_part('template-parts/articles-teaser');
    get_template_part('template-parts/faq');
    get_template_part('template-parts/contact-v2');
} else {
    // Load Home V1 sections (default)
    get_template_part('template-parts/home/hero');
    get_template_part('template-parts/home/strip');
    get_template_part('template-parts/home/about');
    get_template_part('template-parts/home/services');
    get_template_part('template-parts/home/treatments');
    get_template_part('template-parts/home/blog');
    get_template_part('template-parts/doctors-grid-v2'); // Using V2 doctors slider
    get_template_part('template-parts/home/testimonials');
    get_template_part('template-parts/home/cta');
    get_template_part('template-parts/home/contact');
}

get_footer();

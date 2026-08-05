/**
 * Customizer Live Preview
 *
 * @package Alya_Esthetic
 */
(function($) {
    'use strict';

    // Brand colors
    ['alya_color_primary', 'alya_color_secondary', 'alya_color_accent', 'alya_color_text',
     'alya_color_text_light', 'alya_color_bg', 'alya_color_bg_alt', 'alya_color_line'].forEach(function(id) {
        wp.customize(id, function(value) {
            value.bind(function(to) {
                document.documentElement.style.setProperty('--' + id.replace('alya_color_', ''), to);
            });
        });
    });

    // Typography
    wp.customize('alya_font_heading', function(value) {
        value.bind(function(to) {
            document.documentElement.style.setProperty('--font-heading', "'" + to + "', Georgia, serif");
        });
    });

    wp.customize('alya_font_body', function(value) {
        value.bind(function(to) {
            document.documentElement.style.setProperty('--font-body', "'" + to + "', -apple-system, sans-serif");
        });
    });

    // Clinic name
    wp.customize('alya_clinic_name', function(value) {
        value.bind(function(to) {
            $('.site-header__text-logo').text(to);
            $('.site-footer__copyright').html('&copy; ' + new Date().getFullYear() + ' ' + to + '. All rights reserved.');
        });
    });

    // Hero
    wp.customize('alya_hero_title', function(value) {
        value.bind(function(to) {
            $('.hero__title').text(to);
        });
    });

    wp.customize('alya_hero_subtitle', function(value) {
        value.bind(function(to) {
            $('.hero__subtitle').text(to);
        });
    });

    // Header CTA
    wp.customize('alya_header_cta_text', function(value) {
        value.bind(function(to) {
            $('.site-header__actions .btn--primary').first().text(to);
        });
    });

    // WhatsApp
    wp.customize('alya_wa_enable', function(value) {
        value.bind(function(to) {
            $('#wa-float').toggle(to);
        });
    });

    wp.customize('alya_wa_color', function(value) {
        value.bind(function(to) {
            document.documentElement.style.setProperty('--wa-color', to);
        });
    });

})(jQuery);

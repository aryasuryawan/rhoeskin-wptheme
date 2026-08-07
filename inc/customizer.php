<?php
/**
 * Customizer Settings — 120+ settings organized in 12 panels
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

function alya_customize_register($wp_customize) {

    // ─── 1. IDENTITAS & KONTAK ───
    $wp_customize->add_panel('alya_identity', [
        'title'    => 'Identitas & Kontak',
        'priority' => 10,
    ]);

    // 1a. Brand
    $wp_customize->add_section('alya_brand', [
        'title' => 'Brand',
        'panel' => 'alya_identity',
    ]);

    $wp_customize->add_setting('alya_logo', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alya_logo', ['label' => 'Logo Utama', 'section' => 'alya_brand']));

    $wp_customize->add_setting('alya_logo_white', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alya_logo_white', ['label' => 'Logo Putih (untuk footer/dark bg)', 'section' => 'alya_brand']));

    $wp_customize->add_setting('alya_favicon', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alya_favicon', ['label' => 'Favicon', 'section' => 'alya_brand']));

    $wp_customize->add_setting('alya_clinic_name', ['default' => 'Alya Esthetic Center', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_clinic_name', ['label' => 'Nama Klinik', 'section' => 'alya_brand']);

    $wp_customize->add_setting('alya_clinic_tagline', ['default' => 'Your Beauty, Our Priority', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_clinic_tagline', ['label' => 'Tagline', 'section' => 'alya_brand']);

    // 1b. Kontak
    $wp_customize->add_section('alya_contact', [
        'title' => 'Kontak',
        'panel' => 'alya_identity',
    ]);

    $wp_customize->add_setting('alya_phone', ['default' => '+62 812-9000-0000', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_phone', ['label' => 'Nomor Telepon', 'section' => 'alya_contact']);

    $wp_customize->add_setting('alya_phone_link', ['default' => '6281290000000', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_phone_link', ['label' => 'Nomor Telepon (format internasional)', 'section' => 'alya_contact', 'description' => 'Format: 62812xxxxxxx']);

    $wp_customize->add_setting('alya_email', ['default' => 'info@alyaesthetic.co.id', 'sanitize_callback' => 'sanitize_email']);
    $wp_customize->add_control('alya_email', ['label' => 'Email', 'section' => 'alya_contact']);

    $wp_customize->add_setting('alya_address', ['default' => '', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_address', ['label' => 'Alamat', 'section' => 'alya_contact', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_google_maps_embed', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('alya_google_maps_embed', ['label' => 'Google Maps Embed URL', 'section' => 'alya_contact']);

    // 1c. Social Media
    $wp_customize->add_section('alya_social', [
        'title' => 'Social Media',
        'panel' => 'alya_identity',
    ]);

    $socials = ['facebook', 'instagram', 'tiktok', 'youtube', 'linkedin', 'twitter'];
    foreach ($socials as $s) {
        $wp_customize->add_setting("alya_social_{$s}", ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
        $wp_customize->add_control("alya_social_{$s}", ['label' => ucfirst($s) . ' URL', 'section' => 'alya_social']);
    }

    // ─── 2. WARNA & TIPOGRAFI ───
    $wp_customize->add_panel('alya_colors', [
        'title'    => 'Warna & Tipografi',
        'priority' => 20,
    ]);

    // 2a. Warna
    $wp_customize->add_section('alya_colors_main', [
        'title' => 'Warna',
        'panel' => 'alya_colors',
    ]);

    $colors = [
        'alya_color_primary'   => ['label' => 'Warna Primer (Brand)', 'default' => '#b0836a'],
        'alya_color_secondary' => ['label' => 'Warna Sekunder', 'default' => '#8a5c44'],
        'alya_color_accent'    => ['label' => 'Warna Aksen', 'default' => '#f6ece6'],
        'alya_color_text'      => ['label' => 'Warna Teks', 'default' => '#2b2623'],
        'alya_color_text_light' => ['label' => 'Warna Teks Ringan', 'default' => '#6f6a66'],
        'alya_color_bg'        => ['label' => 'Warna Background', 'default' => '#ffffff'],
        'alya_color_bg_alt'    => ['label' => 'Warna Background Alternatif', 'default' => '#faf7f4'],
        'alya_color_white'     => ['label' => 'Warna Putih', 'default' => '#FFFFFF'],
        'alya_color_line'      => ['label' => 'Warna Garis/Border', 'default' => '#e9e2dc'],
        'alya_color_success'   => ['label' => 'Warna Success', 'default' => '#28A745'],
        'alya_color_error'     => ['label' => 'Warna Error', 'default' => '#DC3545'],
    ];

    foreach ($colors as $id => $args) {
        $wp_customize->add_setting($id, ['default' => $args['default'], 'sanitize_callback' => 'sanitize_hex_color']);
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $id, ['label' => $args['label'], 'section' => 'alya_colors_main']));
    }

    // 2b. Typography
    $wp_customize->add_section('alya_typography', [
        'title' => 'Tipografi',
        'panel' => 'alya_colors',
    ]);

    $typo = [
        'alya_font_heading'   => ['label' => 'Font Heading', 'default' => 'Poppins'],
        'alya_font_body'      => ['label' => 'Font Body', 'default' => 'Poppins'],
        'alya_font_size_base' => ['label' => 'Base Font Size (px)', 'default' => '16'],
        'alya_font_size_h1'   => ['label' => 'H1 Size (px)', 'default' => '48'],
        'alya_font_size_h2'   => ['label' => 'H2 Size (px)', 'default' => '36'],
        'alya_font_size_h3'   => ['label' => 'H3 Size (px)', 'default' => '28'],
    ];

    foreach ($typo as $id => $args) {
        $wp_customize->add_setting($id, ['default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($id, ['label' => $args['label'], 'section' => 'alya_typography']);
    }

    // ─── 4. HEADER & NAVIGASI ───
    $wp_customize->add_panel('alya_header', [
        'title'    => 'Header & Navigasi',
        'priority' => 40,
    ]);

    $wp_customize->add_section('alya_header_main', [
        'title' => 'Header',
        'panel' => 'alya_header',
    ]);

    $wp_customize->add_setting('alya_header_sticky', ['default' => true, 'sanitize_callback' => 'wp_validate_boolean']);
    $wp_customize->add_control('alya_header_sticky', ['label' => 'Header Sticky', 'section' => 'alya_header_main', 'type' => 'checkbox']);

    $wp_customize->add_setting('alya_header_bg', ['default' => '#FFFFFF', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'alya_header_bg', ['label' => 'Header Background', 'section' => 'alya_header_main']));

    $wp_customize->add_setting('alya_header_text', ['default' => '#1A1A2E', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'alya_header_text', ['label' => 'Header Text Color', 'section' => 'alya_header_main']));

    // CTA Button
    $wp_customize->add_section('alya_header_cta', [
        'title' => 'CTA Button',
        'panel' => 'alya_header',
    ]);

    $wp_customize->add_setting('alya_header_cta_text', ['default' => 'Konsultasi Gratis', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_header_cta_text', ['label' => 'CTA Text', 'section' => 'alya_header_cta']);

    $wp_customize->add_setting('alya_header_cta_url', ['default' => '#konsultasi', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('alya_header_cta_url', ['label' => 'CTA URL', 'section' => 'alya_header_cta']);

    // ─── 5. HERO SECTION ───
    $wp_customize->add_panel('alya_hero', [
        'title'    => 'Hero Section',
        'priority' => 50,
    ]);

    $wp_customize->add_section('alya_hero_main', [
        'title' => 'Hero',
        'panel' => 'alya_hero',
    ]);

    $wp_customize->add_setting('alya_hero_bg', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alya_hero_bg', ['label' => 'Hero Background', 'section' => 'alya_hero_main']));

    $wp_customize->add_setting('alya_hero_title', ['default' => 'Kecantikan Dimulai dari Sini', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_hero_title', ['label' => 'Hero Title', 'section' => 'alya_hero_main']);

    $wp_customize->add_setting('alya_hero_subtitle', ['default' => 'Treatment kecantikan modern dengan teknologi terkini dan dokter berpengalaman.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_hero_subtitle', ['label' => 'Hero Subtitle', 'section' => 'alya_hero_main', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_hero_cta_text', ['default' => 'Konsultasi Sekarang', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_hero_cta_text', ['label' => 'CTA Button Text', 'section' => 'alya_hero_main']);

    $wp_customize->add_setting('alya_hero_cta_url', ['default' => '#konsultasi', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('alya_hero_cta_url', ['label' => 'CTA Button URL', 'section' => 'alya_hero_main']);

    $wp_customize->add_setting('alya_hero_cta2_text', ['default' => 'Lihat Layanan', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_hero_cta2_text', ['label' => 'Secondary CTA Text', 'section' => 'alya_hero_main']);

    $wp_customize->add_setting('alya_hero_cta2_url', ['default' => '/layanan', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('alya_hero_cta2_url', ['label' => 'Secondary CTA URL', 'section' => 'alya_hero_main']);

    // ─── 8. FOOTER ───
    $wp_customize->add_panel('alya_footer', [
        'title'    => 'Footer',
        'priority' => 80,
    ]);

    $wp_customize->add_section('alya_footer_main', [
        'title' => 'Footer',
        'panel' => 'alya_footer',
    ]);

    $wp_customize->add_setting('alya_footer_bg', ['default' => '#1A1A2E', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'alya_footer_bg', ['label' => 'Footer Background', 'section' => 'alya_footer_main']));

    $wp_customize->add_setting('alya_footer_text', ['default' => '#CCCCCC', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'alya_footer_text', ['label' => 'Footer Text Color', 'section' => 'alya_footer_main']));

    $wp_customize->add_setting('alya_description', ['default' => '', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_description', ['label' => 'Deskripsi Singkat/Info', 'section' => 'alya_footer_main', 'type' => 'textarea', 'description' => 'Singkat deskripsi klinik yang muncul di bawah logo (max 200 karakter)']);

    // ─── 9. WHATSAPP FLOATING ───
    $wp_customize->add_panel('alya_whatsapp', [
        'title'    => 'WhatsApp Floating',
        'priority' => 90,
    ]);

    $wp_customize->add_section('alya_wa_main', [
        'title' => 'WhatsApp Button',
        'panel' => 'alya_whatsapp',
    ]);

    $wp_customize->add_setting('alya_wa_enable', ['default' => true, 'sanitize_callback' => 'wp_validate_boolean']);
    $wp_customize->add_control('alya_wa_enable', ['label' => 'Enable WhatsApp Float', 'section' => 'alya_wa_main', 'type' => 'checkbox']);

    $wp_customize->add_setting('alya_wa_number', ['default' => '6281290000000', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_wa_number', ['label' => 'Nomor WhatsApp', 'section' => 'alya_wa_main', 'description' => 'Format internasional tanpa spasi: 62812xxxxxxx']);

    $wp_customize->add_setting('alya_wa_message', ['default' => 'Halo Alya Esthetic, saya ingin bertanya.', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_wa_message', ['label' => 'Pesan Default', 'section' => 'alya_wa_main']);

    $wp_customize->add_setting('alya_wa_position', ['default' => 'bottom-right', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_wa_position', ['label' => 'Posisi', 'section' => 'alya_wa_main', 'type' => 'select', 'choices' => [
        'bottom-right' => 'Bottom Right',
        'bottom-left'  => 'Bottom Left',
    ]]);

    $wp_customize->add_setting('alya_wa_color', ['default' => '#25D366', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'alya_wa_color', ['label' => 'Warna Button', 'section' => 'alya_wa_main']));

    $wp_customize->add_setting('alya_wa_tooltip', ['default' => 'Chat WhatsApp', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_wa_tooltip', ['label' => 'Tooltip Text', 'section' => 'alya_wa_main']);

    $wp_customize->add_setting('alya_wa_delay', ['default' => 2, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_wa_delay', ['label' => 'Delay Show (detik)', 'section' => 'alya_wa_main']);

    $wp_customize->add_setting('alya_wa_animation', ['default' => 'bounce', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_wa_animation', ['label' => 'Animation', 'section' => 'alya_wa_main', 'type' => 'select', 'choices' => [
        'none'   => 'None',
        'bounce' => 'Bounce',
        'pulse'  => 'Pulse',
    ]]);

    // ─── 6. SERVICES PAGE ───
    $wp_customize->add_panel('alya_services', [
        'title'    => 'Layanan',
        'priority' => 60,
    ]);

    $wp_customize->add_section('alya_services_main', [
        'title' => 'Layanan',
        'panel' => 'alya_services',
    ]);

    $wp_customize->add_setting('alya_services_per_page', ['default' => 9, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_services_per_page', ['label' => 'Treatment Per Page', 'section' => 'alya_services_main']);

    $wp_customize->add_setting('alya_services_columns', ['default' => 3, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_services_columns', ['label' => 'Grid Columns', 'section' => 'alya_services_main', 'type' => 'select', 'choices' => [
        '2' => '2 Columns',
        '3' => '3 Columns',
        '4' => '4 Columns',
    ]]);

    // 7b. Slider Settings
    $wp_customize->add_section('alya_slider', [
        'title' => 'Homepage Slider',
        'panel' => 'alya_services',
    ]);

    $wp_customize->add_setting('alya_slider_enable', ['default' => false, 'sanitize_callback' => 'wp_validate_boolean']);
    $wp_customize->add_control('alya_slider_enable', ['label' => 'Enable Slider', 'section' => 'alya_slider', 'type' => 'checkbox']);

    $wp_customize->add_setting('alya_slider_autoplay', ['default' => true, 'sanitize_callback' => 'wp_validate_boolean']);
    $wp_customize->add_control('alya_slider_autoplay', ['label' => 'Autoplay', 'section' => 'alya_slider', 'type' => 'checkbox']);

    $wp_customize->add_setting('alya_slider_speed', ['default' => 5000, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_slider_speed', ['label' => 'Speed (ms)', 'section' => 'alya_slider']);

    // ─── 7. BLOG PAGE ───
    $wp_customize->add_panel('alya_blog', [
        'title'    => 'Blog',
        'priority' => 70,
    ]);

    $wp_customize->add_section('alya_blog_main', [
        'title' => 'Blog',
        'panel' => 'alya_blog',
    ]);

    $wp_customize->add_setting('alya_blog_per_page', ['default' => 9, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_blog_per_page', ['label' => 'Posts Per Page', 'section' => 'alya_blog_main']);

    $wp_customize->add_setting('alya_blog_columns', ['default' => 3, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_blog_columns', ['label' => 'Grid Columns', 'section' => 'alya_blog_main', 'type' => 'select', 'choices' => [
        '2' => '2 Columns',
        '3' => '3 Columns',
    ]]);

    $wp_customize->add_setting('alya_blog_excerpt_length', ['default' => 20, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_blog_excerpt_length', ['label' => 'Excerpt Length (words)', 'section' => 'alya_blog_main']);

    // ─── 10. ANALYTICS & SEO ───
    $wp_customize->add_panel('alya_analytics', [
        'title'    => 'Analytics & SEO',
        'priority' => 100,
    ]);

    $wp_customize->add_section('alya_analytics_main', [
        'title' => 'Analytics',
        'panel' => 'alya_analytics',
    ]);

    $wp_customize->add_setting('alya_ga4_id', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_ga4_id', ['label' => 'Google Analytics 4 ID', 'section' => 'alya_analytics_main', 'description' => 'Format: G-XXXXXXXXXX']);

    $wp_customize->add_setting('alya_fb_pixel_id', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_fb_pixel_id', ['label' => 'Facebook Pixel ID', 'section' => 'alya_analytics_main']);

    $wp_customize->add_setting('alya_tiktok_pixel_id', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_tiktok_pixel_id', ['label' => 'TikTok Pixel ID', 'section' => 'alya_analytics_main']);

    // SEO
    $wp_customize->add_section('alya_seo_main', [
        'title' => 'SEO',
        'panel' => 'alya_analytics',
    ]);

    $wp_customize->add_setting('alya_og_image', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alya_og_image', ['label' => 'Default OG Image', 'section' => 'alya_seo_main']));

    $wp_customize->add_setting('alya_schema_type', ['default' => 'MedicalClinic', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_schema_type', ['label' => 'Schema Type', 'section' => 'alya_seo_main', 'type' => 'select', 'choices' => [
        'MedicalClinic' => 'MedicalClinic',
        'BeautySalon'   => 'BeautySalon',
        'LocalBusiness' => 'LocalBusiness',
    ]]);

    // ─── 3. HOMEPAGE STYLE ───
    $wp_customize->add_panel('alya_homepage', [
        'title'    => 'Homepage',
        'priority' => 30,
    ]);

    $wp_customize->add_section('alya_homepage_style', [
        'title' => 'Gaya Homepage',
        'panel' => 'alya_homepage',
    ]);

    $wp_customize->add_setting('alya_homepage_style', ['default' => 'default', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_homepage_style', [
        'label'       => 'Pilih Gaya Homepage',
        'description' => '"Default" = gaya asli (hero overlay + icon cards + carousel). "V2" = gaya editorial (oversized type + photo cards + FAQ).',
        'section'     => 'alya_homepage_style',
        'type'        => 'select',
        'choices'     => [
            'default' => 'Default (Original)',
            'v2'      => 'V2 (Editorial)',
        ],
    ]);

    // V2 Section Toggles
    $wp_customize->add_section('alya_homepage_v2_sections', [
        'title' => 'V2 — Tampilkan Section',
        'panel' => 'alya_homepage',
    ]);

    $v2_sections = [
        'alya_v2_show_marquee'       => 'Marquee Strip',
        'alya_v2_show_about'         => 'Tentang Kami',
        'alya_v2_show_services_v2'   => 'Layanan (Photo Cards)',
        'alya_v2_show_signature'     => 'Signature Banner',
        'alya_v2_show_stats_band'    => 'Stats Band',
        'alya_v2_show_doctors_grid'  => 'Dokter (Grid)',
        'alya_v2_show_testimonials'  => 'Testimoni (Featured)',
        'alya_v2_show_instagram'     => 'Instagram Feed',
        'alya_v2_show_articles'      => 'Artikel Teaser',
        'alya_v2_show_career'        => 'Career Strip',
        'alya_v2_show_faq'           => 'FAQ',
        'alya_v2_show_contact'       => 'Kontak',
    ];

    foreach ($v2_sections as $id => $label) {
        $wp_customize->add_setting($id, ['default' => true, 'sanitize_callback' => 'wp_validate_boolean']);
        $wp_customize->add_control($id, ['label' => $label, 'section' => 'alya_homepage_v2_sections', 'type' => 'checkbox']);
    }

    // V2 Hero Content
    $wp_customize->add_section('alya_homepage_v2_hero', [
        'title' => 'V2 — Hero Content',
        'panel' => 'alya_homepage',
    ]);

    $v2_hero = [
        'alya_v2_hero_eyebrow'   => ['label' => 'Eyebrow Text', 'default' => 'Klinik Kecantikan Satu Pintu · Jakarta Selatan'],
        'alya_v2_hero_title'     => ['label' => 'Hero Title', 'default' => 'Kulit Sehat Dimulai dari Kebiasaan yang Tepat'],
        'alya_v2_hero_subtitle'  => ['label' => 'Hero Subtitle', 'default' => 'Alya Esthetic Center memadukan pendekatan medis, hospitality, dan konsistensi rutinitas untuk membantu Anda tampil lebih percaya diri.'],
        'alya_v2_hero_cta_text'  => ['label' => 'CTA Text', 'default' => 'Buat Janji Sekarang'],
        'alya_v2_hero_cta_url'   => ['label' => 'CTA URL', 'default' => ''],
        'alya_v2_hero_cta2_text' => ['label' => 'Secondary CTA Text', 'default' => 'Jelajahi Layanan'],
        'alya_v2_hero_cta2_url'  => ['label' => 'Secondary CTA URL', 'default' => '#layanan'],
    ];

    foreach ($v2_hero as $id => $cfg) {
        $wp_customize->add_setting($id, ['default' => $cfg['default'], 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($id, ['label' => $cfg['label'], 'section' => 'alya_homepage_v2_hero']);
    }

    // V2 Hero Stats
    $wp_customize->add_section('alya_homepage_v2_stats', [
        'title' => 'V2 — Hero Stats',
        'panel' => 'alya_homepage',
    ]);

    $wp_customize->add_setting('alya_v2_hero_stats', [
        'default'           => [
            ['number' => '10rb+', 'label' => 'Pasien Terlayani'],
            ['number' => '10+', 'label' => 'Tahun Beroperasi'],
            ['number' => '15+', 'label' => 'Dokter & Terapis Ahli'],
            ['number' => '4.9/5', 'label' => 'Rating Kepuasan Pasien'],
        ],
        'sanitize_callback' => 'alya_sanitize_json',
    ]);

    // V2 Stats Band (separate from hero stats)
    $wp_customize->add_section('alya_homepage_v2_statsband', [
        'title' => 'V2 — Stats Band',
        'panel' => 'alya_homepage',
    ]);

    $wp_customize->add_setting('alya_v2_stats_band', [
        'default'           => [
            ['number' => '10rb+', 'label' => 'Pasien Terlayani'],
            ['number' => '50+', 'label' => 'Jenis Treatment'],
            ['number' => '15+', 'label' => 'Dokter & Terapis Ahli'],
            ['number' => '4.9/5', 'label' => 'Rating Kepuasan Pasien'],
        ],
        'sanitize_callback' => 'alya_sanitize_json',
    ]);

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'alya_v2_stats_band_control', [
        'label'       => 'Stats Band Data (JSON)',
        'description' => 'Format: [{"number":"10rb+","label":"Pasien Terlayani"},...]',
        'section'     => 'alya_homepage_v2_statsband',
        'type'        => 'textarea',
    ]));

    // V2 Sections Content
    $wp_customize->add_section('alya_homepage_v2_content', [
        'title' => 'V2 — Section Content',
        'panel' => 'alya_homepage',
    ]);

    $wp_customize->add_setting('alya_v2_about_title', ['default' => 'Kecantikan yang Dirawat, Bukan Sekadar Ditutupi', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_v2_about_title', ['label' => 'Tentang Title', 'section' => 'alya_homepage_v2_content']);

    $wp_customize->add_setting('alya_v2_about_desc', ['default' => 'Alya Esthetic Center hadir sebagai klinik kecantikan satu pintu di Jakarta Selatan, menggabungkan layanan medis, hospitality, dan edukasi rutinitas harian dalam satu pengalaman perawatan.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_v2_about_desc', ['label' => 'Tentang Description', 'section' => 'alya_homepage_v2_content', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_v2_about_image', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alya_v2_about_image', ['label' => 'Tentang Image', 'section' => 'alya_homepage_v2_content']));

    $wp_customize->add_setting('alya_v2_about_points', [
        'default'           => [
            'Ditangani langsung oleh dokter & terapis bersertifikat',
            'Alat dan produk sesuai standar keamanan klinik',
            'Rencana perawatan personal sesuai kondisi kulit',
        ],
        'sanitize_callback' => 'alya_sanitize_json',
    ]);

    $wp_customize->add_setting('alya_v2_services_title', ['default' => 'Empat Pilar Perawatan Alya Esthetic', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_v2_services_title', ['label' => 'Layanan Title', 'section' => 'alya_homepage_v2_content']);

    $wp_customize->add_setting('alya_v2_services_lead', ['default' => 'Setiap layanan dirancang untuk kebutuhan yang berbeda — dari perawatan wajah harian hingga treatment lanjutan.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_v2_services_lead', ['label' => 'Layanan Lead', 'section' => 'alya_homepage_v2_content', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_v2_signature_title', ['default' => 'Glass Skin Facial: Kulit Bercahaya Ala Korea', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_v2_signature_title', ['label' => 'Signature Title', 'section' => 'alya_homepage_v2_content']);

    $wp_customize->add_setting('alya_v2_signature_desc', ['default' => 'Kombinasi pembersihan mendalam, eksfoliasi lembut, dan infus nutrisi untuk kulit yang tampak lebih halus dan bercahaya seketika.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_v2_signature_desc', ['label' => 'Signature Description', 'section' => 'alya_homepage_v2_content', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_v2_signature_cta_text', ['default' => 'Lihat Detail Treatment', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_v2_signature_cta_text', ['label' => 'Signature CTA Text', 'section' => 'alya_homepage_v2_content']);

    $wp_customize->add_setting('alya_v2_signature_cta_url', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('alya_v2_signature_cta_url', ['label' => 'Signature CTA URL', 'section' => 'alya_homepage_v2_content']);

    $wp_customize->add_setting('alya_v2_signature_bg', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alya_v2_signature_bg', ['label' => 'Signature Background', 'section' => 'alya_homepage_v2_content']));

    $wp_customize->add_setting('alya_v2_faq_title', ['default' => 'Pertanyaan yang Sering Diajukan', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_v2_faq_title', ['label' => 'FAQ Title', 'section' => 'alya_homepage_v2_content']);

    $wp_customize->add_setting('alya_v2_faq_lead', ['default' => 'Belum menemukan jawaban yang kamu cari? Hubungi tim kami langsung via WhatsApp.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_v2_faq_lead', ['label' => 'FAQ Lead', 'section' => 'alya_homepage_v2_content', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_v2_career_title', ['default' => 'Ingin Berkarir Bersama Kami?', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_v2_career_title', ['label' => 'Career Title', 'section' => 'alya_homepage_v2_content']);

    $wp_customize->add_setting('alya_v2_career_desc', ['default' => 'Lihat lowongan yang tersedia di Alya Esthetic Center.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_v2_career_desc', ['label' => 'Career Description', 'section' => 'alya_homepage_v2_content', 'type' => 'textarea']);

    // ─── 11. CAREER PAGE ───
    $wp_customize->add_panel('alya_career', [
        'title'    => 'Halaman Karir',
        'priority' => 110,
    ]);

    $wp_customize->add_section('alya_career_hero', [
        'title' => 'Hero',
        'panel' => 'alya_career',
    ]);

    $wp_customize->add_setting('alya_career_hero_eyebrow', ['default' => 'Bergabung Bersama Kami', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_career_hero_eyebrow', ['label' => 'Hero Eyebrow', 'section' => 'alya_career_hero']);

    $wp_customize->add_setting('alya_career_hero_subtitle', ['default' => 'Jadi bagian dari tim yang membantu banyak orang tampil lebih percaya diri. Kami mencari individu yang berdedikasi, ramah, dan ingin terus berkembang di industri kecantikan & kesehatan.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_career_hero_subtitle', ['label' => 'Hero Subtitle', 'section' => 'alya_career_hero', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_career_hero_bg', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'alya_career_hero_bg', ['label' => 'Hero Background Image', 'section' => 'alya_career_hero']));

    $wp_customize->add_section('alya_career_values', [
        'title' => 'Kenapa Bergabung',
        'panel' => 'alya_career',
    ]);

    $wp_customize->add_setting('alya_career_values_eyebrow', ['default' => 'Kenapa Alya Esthetic', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_career_values_eyebrow', ['label' => 'Values Eyebrow', 'section' => 'alya_career_values']);

    $wp_customize->add_setting('alya_career_values_title', ['default' => 'Lingkungan Kerja yang Suportif', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_career_values_title', ['label' => 'Values Title', 'section' => 'alya_career_values']);

    $wp_customize->add_setting('alya_career_values_subtitle', ['default' => 'Kami percaya tim yang sejahtera dan terus belajar adalah kunci memberikan pelayanan terbaik untuk pasien.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_career_values_subtitle', ['label' => 'Values Subtitle', 'section' => 'alya_career_values', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_career_values', [
        'default'           => "user | Tim yang Kolaboratif | Budaya kerja yang saling mendukung antar tim medis dan non-medis.\nclock | Pengembangan Karir | Pelatihan berkala dan jenjang karir yang jelas untuk setiap posisi.\nstar | Benefit Kompetitif | Gaji, tunjangan, dan fasilitas perawatan yang menarik bagi karyawan.\ncalendar | Keseimbangan Kerja | Jadwal kerja yang teratur dengan perhatian pada kesejahteraan karyawan.",
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('alya_career_values', ['label' => 'Values (one per line: icon | Title | Description)', 'section' => 'alya_career_values', 'type' => 'textarea', 'description' => 'Icons: user, clock, star, calendar, check, phone, email, pin, certificate']);

    $wp_customize->add_section('alya_career_sidebar', [
        'title' => 'Sidebar',
        'panel' => 'alya_career',
    ]);

    $wp_customize->add_setting('alya_career_steps', [
        'default'           => "1 | Kirim Lamaran | Kirimkan CV & portofolio melalui email atau WhatsApp.\n2 | Seleksi Administrasi | Tim HR akan meninjau kesesuaian kualifikasi Anda.\n3 | Wawancara | Wawancara dengan tim HR dan user terkait.\n4 | Penawaran Kerja | Kandidat terpilih akan menerima offering letter.",
        'sanitize_callback' => 'sanitize_textarea_field',
    ]);
    $wp_customize->add_control('alya_career_steps', ['label' => 'Proses Rekrutmen (one per line: Number | Title | Description)', 'section' => 'alya_career_sidebar', 'type' => 'textarea']);

    $wp_customize->add_setting('alya_career_cta_title', ['default' => 'Tidak Menemukan Posisi yang Sesuai?', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('alya_career_cta_title', ['label' => 'CTA Title', 'section' => 'alya_career_sidebar']);

    $wp_customize->add_setting('alya_career_cta_desc', ['default' => 'Kirimkan CV Anda untuk kami pertimbangkan di kesempatan berikutnya.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('alya_career_cta_desc', ['label' => 'CTA Description', 'section' => 'alya_career_sidebar', 'type' => 'textarea']);

    // ─── 12. FEATURED FILTERS ───
    $wp_customize->add_panel('alya_featured', [
        'title'    => 'Featured Filters',
        'priority' => 120,
    ]);

    $wp_customize->add_section('alya_featured_doctors', [
        'title' => 'Featured Doctors',
        'panel' => 'alya_featured',
    ]);

    $wp_customize->add_setting('alya_featured_doctors_count', ['default' => 4, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_featured_doctors_count', ['label' => 'Max Featured Doctors', 'section' => 'alya_featured_doctors']);

    $wp_customize->add_section('alya_featured_testimonials', [
        'title' => 'Featured Testimonials',
        'panel' => 'alya_featured',
    ]);

    $wp_customize->add_setting('alya_featured_testimonials_count', ['default' => 6, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('alya_featured_testimonials_count', ['label' => 'Max Featured Testimonials', 'section' => 'alya_featured_testimonials']);
}
add_action('customize_register', 'alya_customize_register');

/**
 * Output Customizer CSS
 */
function alya_customizer_css() {
    $primary    = get_theme_mod('alya_color_primary', '#b0836a');
    $secondary  = get_theme_mod('alya_color_secondary', '#8a5c44');
    $accent     = get_theme_mod('alya_color_accent', '#f6ece6');
    $text       = get_theme_mod('alya_color_text', '#2b2623');
    $text_light = get_theme_mod('alya_color_text_light', '#6f6a66');
    $bg         = get_theme_mod('alya_color_bg', '#ffffff');
    $bg_alt     = get_theme_mod('alya_color_bg_alt', '#faf7f4');
    $white      = get_theme_mod('alya_color_white', '#FFFFFF');
    $line       = get_theme_mod('alya_color_line', '#e9e2dc');
    $success    = get_theme_mod('alya_color_success', '#28A745');
    $error      = get_theme_mod('alya_color_error', '#DC3545');

    $font_heading = get_theme_mod('alya_font_heading', 'Poppins');
    $font_body    = get_theme_mod('alya_font_body', 'Poppins');
    $font_base    = get_theme_mod('alya_font_size_base', '16');
    $font_h1      = get_theme_mod('alya_font_size_h1', '48');
    $font_h2      = get_theme_mod('alya_font_size_h2', '36');
    $font_h3      = get_theme_mod('alya_font_size_h3', '28');

    $header_bg   = get_theme_mod('alya_header_bg', '#FFFFFF');
    $header_text = get_theme_mod('alya_header_text', '#1A1A2E');

    $footer_bg   = get_theme_mod('alya_footer_bg', '#1A1A2E');
    $footer_text = get_theme_mod('alya_footer_text', '#CCCCCC');

    $css = ":root {
  --brand: {$primary};
  --brand-light: {$secondary};
  --brand-soft: {$accent};
  --ink: {$text};
  --ink-light: {$text_light};
  --bg: {$bg};
  --bg-alt: {$bg_alt};
  --white: {$white};
  --line: {$line};
  --success: {$success};
  --error: {$error};
  --shadow: 0 18px 40px -22px rgba(43,38,35,.35);
  --shadow-lg: 0 18px 40px -22px rgba(43,38,35,.35);
  --font-heading: '{$font_heading}', Georgia, serif;
  --font-body: '{$font_body}', -apple-system, sans-serif;
  --font-size: {$font_base}px;
  --h1: {$font_h1}px;
  --h2: {$font_h2}px;
  --h3: {$font_h3}px;
  --header-bg: {$header_bg};
  --header-text: {$header_text};
  --footer-bg: {$footer_bg};
  --footer-text: {$footer_text};
}";

    return $css;
}

/**
 * Enqueue Customizer CSS in <head>
 */
function alya_customizer_inline_css() {
    $css = alya_customizer_css();
    echo '<style id="alya-customizer">' . $css . '</style>' . "\n";
}
add_action('wp_head', 'alya_customizer_inline_css', 1);

/**
 * Customizer preview JS
 */
function alya_customize_preview_js() {
    wp_enqueue_script('alya-customizer', ALYA_URI . '/assets/js/customizer.js', ['customize-preview'], ALYA_VERSION, true);
}
add_action('customize_preview_init', 'alya_customize_preview_js');

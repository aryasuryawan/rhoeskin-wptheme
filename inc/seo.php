<?php
/**
 * SEO — Open Graph, Twitter Cards, JSON-LD Schema
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

/**
 * Open Graph Meta Tags
 */
function alya_og_tags() {
    if (is_front_page()) {
        $title = get_theme_mod('alya_clinic_name', 'Rhoé Skin Center');
        $desc  = get_theme_mod('alya_clinic_tagline', 'Your Beauty, Our Priority');
    } elseif (is_singular()) {
        $title = get_the_title();
        $desc  = wp_trim_words(get_the_excerpt(), 25);
    } elseif (is_archive()) {
        $title = get_the_archive_title();
        $desc  = get_the_archive_description() ?: get_bloginfo('description');
    } else {
        $title = get_bloginfo('name');
        $desc  = get_bloginfo('description');
    }

    $og_image = get_theme_mod('alya_og_image', '');
    if (is_singular() && has_post_thumbnail()) {
        $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    }
    ?>
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($desc); ?>">
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta property="og:type" content="<?php echo is_singular('post') ? 'article' : 'website'; ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_theme_mod('alya_clinic_name', 'Rhoé Skin Center')); ?>">
    <?php if ($og_image) : ?>
    <meta property="og:image" content="<?php echo esc_url($og_image); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <?php endif; ?>
    <?php if ($locale = get_locale()) : ?>
    <meta property="og:locale" content="<?php echo esc_attr(str_replace('-', '_', $locale)); ?>">
    <?php endif; ?>
    <?php
}
add_action('wp_head', 'alya_og_tags', 5);

/**
 * Twitter Card Meta Tags
 */
function alya_twitter_cards() {
    if (is_singular()) {
        $title = get_the_title();
        $desc  = wp_trim_words(get_the_excerpt(), 25);
    } else {
        $title = get_bloginfo('name');
        $desc  = get_bloginfo('description');
    }

    $image = get_theme_mod('alya_og_image', '');
    if (is_singular() && has_post_thumbnail()) {
        $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    }
    ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($desc); ?>">
    <?php if ($image) : ?>
    <meta name="twitter:image" content="<?php echo esc_url($image); ?>">
    <?php endif; ?>
    <?php
}
add_action('wp_head', 'alya_twitter_cards', 5);

/**
 * JSON-LD Schema — MedicalClinic (default), Physician, Article, JobPosting
 */
function alya_schema_markup() {
    $schema_type = get_theme_mod('alya_schema_type', 'MedicalClinic');
    $clinic_name = get_theme_mod('alya_clinic_name', 'Rhoé Skin Center');
    $phone       = get_theme_mod('alya_phone_link', '6281290000000');
    $email       = get_theme_mod('alya_email', 'info@alyaesthetic.co.id');
    $address     = get_theme_mod('alya_address', '');
    $site_url    = home_url('/');

    $schema = [];

    // Site-level schema
    if (is_front_page()) {
        $schema['@context'] = 'https://schema.org';
        $schema['@type']    = $schema_type;
        $schema['name']     = $clinic_name;
        $schema['url']      = $site_url;
        if ($phone) $schema['telephone'] = $phone;
        if ($email) $schema['email'] = $email;
        if ($address) {
            $schema['address'] = [
                '@type'           => 'PostalAddress',
                'streetAddress'   => $address,
                'addressCountry'  => 'ID',
            ];
        }
        $schema['sameAs'] = array_filter([
            get_theme_mod('alya_social_facebook', ''),
            get_theme_mod('alya_social_instagram', ''),
            get_theme_mod('alya_social_tiktok', ''),
            get_theme_mod('alya_social_youtube', ''),
            get_theme_mod('alya_social_linkedin', ''),
        ]);
    }

    // Doctor single — Physician schema
    if (is_singular('doctor')) {
        $schema['@context']    = 'https://schema.org';
        $schema['@type']       = 'Physician';
        $schema['name']        = get_the_title();
        $schema['url']         = get_permalink();
        $schema['description'] = wp_trim_words(get_the_excerpt(), 25);
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }
        $position = alya_field('alya_position');
        if ($position) $schema['jobTitle'] = $position;
        $credentials = alya_field('alya_credentials');
        if ($credentials) $schema['description'] = $credentials;
        $schema['medicalSpecialty'] = 'Dermatology';
        $schema['hospital'] = [
            '@type' => 'MedicalClinic',
            'name'  => $clinic_name,
            'url'   => $site_url,
        ];
    }

    // Blog post — Article schema
    if (is_singular('post')) {
        $schema['@context']      = 'https://schema.org';
        $schema['@type']         = 'Article';
        $schema['headline']      = get_the_title();
        $schema['url']           = get_permalink();
        $schema['datePublished'] = get_the_date('c');
        $schema['dateModified']  = get_the_modified_date('c');
        $schema['author'] = [
            '@type' => 'Person',
            'name'  => get_the_author(),
        ];
        $schema['publisher'] = [
            '@type' => 'Organization',
            'name'  => $clinic_name,
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => get_theme_mod('alya_logo', ''),
            ],
        ];
        if (has_post_thumbnail()) {
            $schema['image'] = get_the_post_thumbnail_url(get_the_ID(), 'large');
        }
        $schema['description'] = wp_trim_words(get_the_excerpt(), 25);
    }

    // Job single — JobPosting schema
    if (is_singular('jobs')) {
        $schema['@context']    = 'https://schema.org';
        $schema['@type']       = 'JobPosting';
        $schema['title']       = get_the_title();
        $schema['url']         = get_permalink();
        $schema['description'] = wp_strip_all_tags(get_the_content());
        $schema['datePosted']  = get_the_date('c');

        $deadline = alya_field('alya_deadline');
        if ($deadline) {
            $schema['validThrough'] = $deadline . 'T23:59:59';
        }

        $location = alya_field('alya_location');
        if ($location) {
            $schema['jobLocation'] = [
                '@type' => 'Place',
                'address' => [
                    '@type'           => 'PostalAddress',
                    'addressLocality' => $location,
                    'addressCountry'  => 'ID',
                ],
            ];
        }

        $salary = alya_field('alya_salary');
        if ($salary) {
            $schema['baseSalary'] = [
                '@type'         => 'MonetaryAmount',
                'currency'      => 'IDR',
                'value'         => $salary,
            ];
        }

        $schema['hiringOrganization'] = [
            '@type' => 'Organization',
            'name'  => $clinic_name,
            'url'   => $site_url,
        ];
    }

    if (!empty($schema)) {
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'alya_schema_markup', 10);

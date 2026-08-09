<?php
/**
 * Helper Functions — Reusable across all templates
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

// ─── Post Query ───

function alya_home_nav_fallback() {
    $items = [
        ['#beranda', 'Beranda', true],
        ['#tentang', 'Tentang', false],
        ['#layanan', 'Layanan', false],
        ['#dokter', 'Dokter', false],
        ['#testimoni', 'Testimoni', false],
        ['#faq', 'FAQ', false],
        [get_permalink(get_option('page_for_posts')) ?: home_url('/artikel/'), 'Artikel', false],
        [get_post_type_archive_link('promo') ?: home_url('/promo/'), 'Promo', false],
        [get_post_type_archive_link('jobs') ?: home_url('/karir/'), 'Karir', false],
        ['#kontak', 'Kontak', false],
    ];
    echo '<ul class="nav__links" id="navLinks">';
    foreach ($items as $item) {
        $promo_url = get_post_type_archive_link('promo');
        $is_promo  = $promo_url && trailingslashit($item[0]) === trailingslashit($promo_url);
        printf(
            '<li%s><a href="%s"%s>%s%s</a></li>',
            $is_promo ? ' class="promo-nav-item"' : '',
            esc_url($item[0]),
            $item[2] ? ' class="active"' : '',
            esc_html($item[1]),
            $is_promo ? '<span class="promo-nav-badge">HOT</span>' : ''
        );
    }
    echo '</ul>';
}

function alya_get_posts($type, $args = []) {
    $defaults = [
        'post_type'      => $type,
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ];
    return new WP_Query(array_merge($defaults, $args));
}

// ─── ACF Fields ───

function alya_field($field, $fallback = '') {
    if (!function_exists('get_field')) return $fallback;
    $value = get_field($field);
    return $value ? $value : $fallback;
}

function alya_field_raw($field, $post_id = 0, $format = true) {
    if (!function_exists('get_field')) return '';
    return get_field($field, $post_id, $format);
}

// ─── Image Output ───

function alya_image($field, $size = 'medium_large', $fallback = '', $attr = []) {
    if (!function_exists('get_field')) return $fallback;
    $img = get_field($field);
    if (!$img || !is_array($img)) return $fallback;

    $defaults = [
        'loading' => 'lazy',
        'class'   => 'alya-img',
    ];
    $attr = array_merge($defaults, $attr);

    return wp_get_attachment_image($img['ID'], $size, false, $attr);
}

function alya_image_url($field, $fallback = '') {
    if (!function_exists('get_field')) return $fallback;
    $img = get_field($field);
    if (!$img || !is_array($img)) return $fallback;
    return $img['url'] ?? $fallback;
}

function alya_image_attr($field, $size = 'medium_large') {
    if (!function_exists('get_field')) return false;
    $img = get_field($field);
    if (!$img || !is_array($img)) return false;
    return wp_get_attachment_image_src($img['ID'], $size);
}

// ─── Section Wrappers ───

function alya_section($id, $class = '', $bg = '') {
    $style = $bg ? "background:{$bg};" : '';
    echo '<section id="' . esc_attr($id) . '" class="alya-section ' . esc_attr($class) . '" style="' . esc_attr($style) . '">';
    echo '<div class="container">';
}

function alya_section_close() {
    echo '</div></section>';
}

function alya_section_header($eyebrow, $heading, $lead = '', $align = '') {
    $align_class = $align ? " section__head--{$align}" : '';
    ?>
    <div class="section__head<?php echo esc_attr($align_class); ?>">
        <div>
            <?php if ($eyebrow) : ?>
                <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
            <?php endif; ?>
            <?php if ($heading) : ?>
                <h2 class="section__title"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if ($lead) : ?>
                <p class="lead"><?php echo esc_html($lead); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

// ─── Card Component ───

function alya_card($args) {
    $defaults = [
        'title'   => '',
        'desc'    => '',
        'image'   => '',
        'link'    => '',
        'icon'    => '',
        'class'   => '',
        'badge'   => '',
        'meta'    => '',
    ];
    $a = array_merge($defaults, $args);
    ?>
    <article class="card <?php echo esc_attr($a['class']); ?>">
        <?php if ($a['badge']) : ?>
            <span class="card__badge"><?php echo esc_html($a['badge']); ?></span>
        <?php endif; ?>
        <?php if ($a['icon']) : ?>
            <div class="card__icon"><?php echo $a['icon']; ?></div>
        <?php endif; ?>
        <?php if ($a['image']) : ?>
            <div class="card__image"><?php echo $a['image']; ?></div>
        <?php endif; ?>
        <?php if ($a['meta']) : ?>
            <div class="card__meta"><?php echo esc_html($a['meta']); ?></div>
        <?php endif; ?>
        <?php if ($a['title']) : ?>
            <h3 class="card__title"><?php echo esc_html($a['title']); ?></h3>
        <?php endif; ?>
        <?php if ($a['desc']) : ?>
            <p class="card__desc"><?php echo esc_html($a['desc']); ?></p>
        <?php endif; ?>
        <?php if ($a['link']) : ?>
            <a class="link" href="<?php echo esc_url($a['link']); ?>">
                Lihat Detail
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M8.6 4.6L14 10H3v4h11l-5.4 5.4L11 22l9-9-9-9z"/></svg>
            </a>
        <?php endif; ?>
    </article>
    <?php
}

// ─── Icon Library ───

function alya_icon($name) {
    $icons = [
        'check'     => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M9 16.2l-3.2-3.2L4.5 14.3 9 18.8 18.5 9.3l-1.3-1.3z"/></svg>',
        'arrow'     => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M8.6 4.6L14 10H3v4h11l-5.4 5.4L11 22l9-9-9-9z"/></svg>',
        'arrow-right' => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 4l-1.4 1.4L16.2 11H4v2h12.2l-5.6 5.6L12 20l8-8z"/></svg>',
        'star'      => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 2l2.4 7.2H22l-6 4.7 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.7h7.6z"/></svg>',
        'phone'     => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M6.6 10.8A14.5 14.5 0 0013.2 17.4l2.6-2.6c.3-.3.7-.4 1-.2 1.1.3 2.3.5 3.5.5.6 0 1 .4 1 1V20c0 .6-.4 1-1 1A16 16 0 014 5c0-.6.4-1 1-1h3.8c.6 0 1 .4 1 1 0 1.2.2 2.4.5 3.5.1.4 0 .7-.2 1L7.5 10.5z"/></svg>',
        'email'     => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 00-2 2v12c0 1.1.9 2 2 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
        'pin'       => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.2-9C1.2 8.2 3 5 6.4 5c2 0 3.4 1.1 4 2.3h3.2c.6-1.2 2-2.3 4-2.3 3.4 0 5.2 3.2 3.6 7-2.2 4.4-9.2 9-9.2 9z"/></svg>',
        'calendar'  => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg>',
        'user'      => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg>',
        'clock'     => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-2a7 7 0 110-14 7 7 0 010 14zm.5-10.5v5l4.3 2.5-.7 1.2-5-3V10z"/></svg>',
        'quote'     => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>',
        'facebook'  => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>',
        'twitter'   => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53A4.48 4.48 0 0012 7.5v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>',
        'whatsapp'  => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
        'linkedin'  => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 2a2 2 0 110 4 2 2 0 010-4z"/></svg>',
        'instagram' => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.3-2.2-.4a3.8 3.8 0 01-1.4-.9 3.8 3.8 0 01-.9-1.4c-.2-.4-.4-1-.4-2.2-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c.1-1.2.3-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4 1.3-.1 1.7-.1 4.9-.1zm0-2.2C8.7 0 8.3 0 7 .1 5.7.1 4.8.4 4 .7 3.1 1 2.4 1.5 1.7 2.2 1 2.9.5 3.6.2 4.5-.1 5.3-.3 6.2-.3 7.5 0 8.8 0 9.2 0 12s0 3.2.1 4.5c.1 1.3.3 2.2.7 3.1.3.9.8 1.6 1.5 2.3.7.7 1.4 1.2 2.3 1.5.9.3 1.8.5 3.1.5 1.3.1 1.7.1 5 .1s3.7-.1 4.9-.1c1.3-.1 2.2-.3 3.1-.7.9-.3 1.6-.8 2.3-1.5.7-.7 1.2-1.4 1.5-2.3.3-.9.5-1.8.5-3.1.1-1.3.1-1.7.1-5s-.1-3.7-.1-4.9c-.1-1.3-.3-2.2-.7-3.1-.3-.9-.8-1.6-1.5-2.3C20.9 1 20.2.5 19.3.2 18.4-.1 17.5-.3 16.2-.3 14.9 0 14.5 0 12 0zm0 5.8a6.2 6.2 0 100 12.4 6.2 6.2 0 000-12.4zm0 10.2a4 4 0 110-8 4 4 0 010 8zm6.4-11.8a1.4 1.4 0 100 2.9 1.4 1.4 0 000-2.9z"/></svg>',
        'tiktok'    => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M19.3 8.5a5.3 5.3 0 01-3.1-1 5 5 0 01-2-3.9V3.2h-3.3v11.9a2.5 2.5 0 01-2.5 2.4 2.5 2.5 0 01-2.5-2.4 2.5 2.5 0 012.5-2.5c.3 0 .5 0 .8.1V8.9c-.3 0-.5-.1-.8-.1a5.9 5.9 0 100 11.8c3.2 0 5.8-2.6 5.8-5.8V9.9a8.4 8.4 0 004.7 1.5V8.5z"/></svg>',
        'youtube'   => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M21.6 7.2a2.6 2.6 0 00-1.8-1.8A30.6 30.6 0 0012 5a30.6 30.6 0 00-7.8.4A2.6 2.6 0 002.4 7.2 26.5 26.5 0 002 12c0 1.6.1 3.2.4 4.8a2.6 2.6 0 001.8 1.8A30.6 30.6 0 0012 19c2.6 0 5.2-.1 7.8-.4a2.6 2.6 0 001.8-1.8c.3-1.6.4-3.2.4-4.8s-.1-3.2-.4-4.8zM10 15V9l5 3-5 3z"/></svg>',
        'telegram'  => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M21.2 4.4L2.9 11.1c-1.2.5-1.2 1.2-.2 1.5l4.7 1.5 1.8 5.7c.2.6.1.8.7.8.5 0 .7-.2 1-.4l2.3-2.1 4.8 3.5c.9.5 1.5.2 1.7-.9l3-14c.3-1.2-.5-1.7-1.5-1.2z"/></svg>',
        'line'      => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 2C6.5 2 2 5.8 2 10.5c0 3.7 3.1 6.8 7.3 7.8-.1.8-.4 2.5-.5 2.9-.1.5.2.5.4.4.2-.1 2.7-1.8 3.8-2.6.8.2 1.7.3 2.6.3 5.5 0 10-3.8 10-8.5S17.5 2 12 2z"/></svg>',
        'pinterest' => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 0C5.4 0 0 5.4 0 12c0 5 3.1 9.3 7.6 11-.1-.9-.2-2.4 0-3.4.2-.9 1.4-5.7 1.4-5.7s-.4-.7-.4-1.8c0-1.7 1-2.9 2.2-2.9 1 0 1.5.8 1.5 1.7 0 1-.7 2.6-1 4-.3 1.2.6 2.2 1.8 2.2 2.1 0 3.7-2.2 3.7-5.5 0-2.9-2.1-4.9-5-4.9-3.4 0-5.4 2.5-5.4 5.2 0 1 .4 2.1.9 2.7.1.1.1.2.1.3-.1.4-.3 1.2-.3 1.4-.1.2-.2.3-.4.2-1.5-.7-2.4-2.9-2.4-4.7 0-3.8 2.8-7.3 8-7.3 4.2 0 7.5 3 7.5 7 0 4.2-2.6 7.5-6.3 7.5-1.2 0-2.4-.6-2.8-1.4l-.8 3c-.3 1.1-.1 2.5-.5 3.5.4.1.8.2 1.2.2 5.5 0 10-4.5 10-10S17.5 2 12 2z"/></svg>',
        'heart'     => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.2-9C1.2 8.2 3 5 6.4 5c2 0 3.4 1.1 4 2.3h3.2c.6-1.2 2-2.3 4-2.3 3.4 0 5.2 3.2 3.6 7-2.2 4.4-9.2 9-9.2 9z"/></svg>',
        'lock'      => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg>',
        'certificate' => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V5l-9-4zm-2 16l-4-4 1.4-1.4L10 14.2l6.6-6.6L18 9l-8 8z"/></svg>',
        'close'     => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        'menu'      => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M3 12h18M3 6h18M3 18h18" stroke="currentColor" stroke-width="2" fill="none"/></svg>',
        'link'      => '<svg width="20" height="20" viewBox="0 0 24 24"><path d="M3.9 12a4.1 4.1 0 014.1-4.1h4V6H8a6 6 0 000 12h4v-1.9H8A4.1 4.1 0 013.9 12zM12 13h5a4.1 4.1 0 000-8.2h-4V6.9h4a2.1 2.1 0 010 4.2h-5V13z"/></svg>',
    ];
    return $icons[$name] ?? '';
}

// ─── Rating Stars ───

function alya_stars($count = 5, $filled = 5) {
    $output = '';
    for ($i = 1; $i <= $count; $i++) {
        $output .= ($i <= $filled) ? '<span class="star star--filled">&#9733;</span>' : '<span class="star">&#9734;</span>';
    }
    return $output;
}

// ─── WhatsApp ───

function alya_wa_link($text = '') {
    $number  = get_theme_mod('alya_wa_number', '6281290000000');
    $message = $text ?: get_theme_mod('alya_wa_message', 'Halo Rhoe Skin Esthetic Center, saya ingin bertanya.');
    return 'https://wa.me/' . $number . '?text=' . urlencode($message);
}

// ─── Social Share ───

function alya_share_links($post = null) {
    if (!$post) $post = get_post();
    if (!$post) return [];

    $url   = get_permalink($post->ID);
    $title = rawurlencode(get_the_title($post->ID));
    $text  = rawurlencode(wp_trim_words(get_the_excerpt($post), 20));

    return [
        'facebook'  => "https://www.facebook.com/sharer/sharer.php?u={$url}",
        'twitter'   => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
        'whatsapp'  => "https://wa.me/?text={$title}%20{$url}",
        'linkedin'  => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
        'telegram'  => "https://t.me/share/url?url={$url}&text={$title}",
        'line'      => "https://social-plugins.line.me/lineit/share?url={$url}",
        'email'     => "mailto:?subject={$title}&body=Silakan%20lihat%20artikel%20ini:%20{$url}",
        'pinterest' => "https://pinterest.com/pin/create/button/?url={$url}&description={$title}",
    ];
}

// ─── Relative Time ───

function alya_time_ago($post = null) {
    if (!$post) $post = get_post();
    if (!$post) return '';

    $diff = time() - strtotime($post->post_date);
    if ($diff < 60)     return 'Baru saja';
    if ($diff < 3600)   return floor($diff / 60) . ' menit lalu';
    if ($diff < 86400)  return floor($diff / 3600) . ' jam lalu';
    if ($diff < 604800) return floor($diff / 86400) . ' hari lalu';
    return date('d M Y', strtotime($post->post_date));
}

// ─── Breadcrumbs ───

function alya_breadcrumbs() {
    if (is_front_page()) return;

    echo '<nav class="breadcrumb" aria-label="Breadcrumb"><div class="container">';
    echo '<a href="' . esc_url(home_url('/')) . '">Beranda</a>';

    if (is_singular('doctor')) {
        echo ' <span>/</span> <a href="' . esc_url(get_post_type_archive_link('doctor')) . '">Dokter</a>';
        echo ' <span>/</span> <span class="current">' . get_the_title() . '</span>';
    } elseif (is_singular('jobs')) {
        echo ' <span>/</span> <a href="' . esc_url(get_post_type_archive_link('jobs')) . '">Karir</a>';
        echo ' <span>/</span> <span class="current">' . get_the_title() . '</span>';
    } elseif (is_singular('treatment')) {
        echo ' <span>/</span> <a href="' . esc_url(get_post_type_archive_link('treatment')) . '">Layanan</a>';
        echo ' <span>/</span> <span class="current">' . get_the_title() . '</span>';
    } elseif (is_singular('post')) {
        echo ' <span>/</span> <a href="' . esc_url(get_permalink(get_option('page_for_posts'))) . '">Artikel</a>';
        echo ' <span>/</span> <span class="current">' . get_the_title() . '</span>';
    } elseif (is_page()) {
        echo ' <span>/</span> <span class="current">' . get_the_title() . '</span>';
    }

    echo '</div></nav>';
}

// ─── Pagination ───

function alya_pagination($query = null) {
    if (!$query) global $wp_query;
    else $wp_query = $query;

    if ($wp_query->max_num_pages <= 1) return;

    echo '<nav class="pagination">';

    echo paginate_links([
        'prev_text' => '&laquo; Sebelumnya',
        'next_text' => 'Selanjutnya &raquo;',
        'type'      => 'list',
    ]);

    echo '</nav>';
}

// ─── Sanitize JSON (for Customizer arrays) ───

function alya_sanitize_json($input) {
    if (is_string($input)) {
        $decoded = json_decode($input, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
        return [];
    }
    return is_array($input) ? $input : [];
}

// ─── Pipe-Delimited Parser (for ACF Free repeater replacement) ───

/**
 * Parse a textarea field with pipe-delimited lines into an array of associative arrays.
 *
 * Input format:
 *   Title | Description
 *   Title | Description
 *
 * Returns:
 *   [['title' => 'Title', 'description' => 'Description'], ...]
 *
 * @param string $raw       The raw textarea value.
 * @param array  $keys      Named keys for each column (e.g., ['title', 'description']).
 * @param string $separator Column separator (default: '|').
 * @return array
 */
function alya_parse_lines($raw, $keys = [], $separator = '|') {
    if (!is_string($raw)) return [];
    $raw = trim($raw);
    if (!$raw) return [];

    $lines = array_filter(array_map('trim', explode("\n", $raw)));
    $result = [];

    foreach ($lines as $line) {
        $line = trim($line);
        if (!$line) continue;
        $parts = array_map('trim', explode($separator, $line));
        $item = [];
        foreach ($keys as $i => $key) {
            $item[$key] = $parts[$i] ?? '';
        }
        $result[] = $item;
    }
    return $result;
}

/**
 * Parse pipe-delimited lines for steps/process (3 columns: step, title, description).
 */
function alya_parse_steps($raw) {
    $decoded = alya_maybe_rep($raw);
    if (is_array($decoded)) return $decoded;
    return alya_parse_lines($raw, ['step', 'title', 'description']);
}

/**
 * Parse pipe-delimited lines for benefits (2 columns: title, description).
 */
function alya_parse_benefits($raw) {
    $decoded = alya_maybe_rep($raw);
    if (is_array($decoded)) return $decoded;
    return alya_parse_lines($raw, ['title', 'description']);
}

/**
 * Parse pipe-delimited lines for FAQs (2 columns: question, answer).
 */
function alya_parse_faqs($raw) {
    $decoded = alya_maybe_rep($raw);
    if (is_array($decoded)) return $decoded;
    return alya_parse_lines($raw, ['question', 'answer']);
}

/**
 * Decode a custom-repeater value (JSON string from meta box) or pass through arrays.
 *
 * @param mixed $raw Meta value.
 * @return array|null  Decoded array, or null when it isn't JSON.
 */
function alya_maybe_rep($raw) {
    if (is_array($raw)) return $raw;
    if (!is_string($raw) || !$raw) return null;
    $decoded = json_decode($raw, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        return $decoded;
    }
    return null;
}

/**
 * Parse pipe-delimited lines for education/experience (3 columns: year, title, institution).
 * ACF format: Title | Institution | Year  →  parsed as: year=3rd, title=1st, institution=2nd
 */
function alya_parse_table($raw) {
    $decoded = alya_maybe_rep($raw);
    if (is_array($decoded)) return $decoded;
    if (!is_string($raw)) return [];
    $raw = trim($raw);
    if (!$raw) return [];
    $lines = array_filter(array_map('trim', explode("\n", $raw)));
    $result = [];
    foreach ($lines as $line) {
        $parts = array_map('trim', explode('|', $line));
        $item = [
            'year'          => $parts[2] ?? '',  // Year is 3rd column
            'title'         => $parts[0] ?? '',  // Title is 1st column
            'institution'   => $parts[1] ?? '',  // Institution is 2nd column
            'col1'          => $parts[2] ?? '',  // backward compat
            'col2'          => $parts[1] ?? '',  // backward compat
            'col3'          => $parts[0] ?? '',  // backward compat
        ];
        $result[] = $item;
    }
    return $result;
}

/**
 * Parse pipe-delimited lines for stats (2 columns: number, label).
 */
function alya_parse_stats($raw) {
    $decoded = alya_maybe_rep($raw);
    if (is_array($decoded)) return $decoded;
    return alya_parse_lines($raw, ['number', 'label']);
}

/**
 * Parse pipe-delimited lines for schedule (3 columns: day, hours, location).
 */
function alya_parse_schedule($raw) {
    $decoded = alya_maybe_rep($raw);
    if (is_array($decoded)) return $decoded;
    return alya_parse_lines($raw, ['day', 'hours', 'location']);
}

// ─── Promo Data ───

/**
 * Format a date with Indonesian month/day names.
 */
function alya_date_id($format, $ts) {
    static $months = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
        7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
    ];
    static $months_full = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
    $m = (int) date('n', $ts);
    $format = str_replace('F', "§", $format);
    $format = str_replace('M', "¶", $format);
    $out = date($format, $ts);
    $out = str_replace("¶", $months[$m], $out);
    $out = str_replace("§", $months_full[$m], $out);
    return $out;
}

/**
 * Convert a promo deadline value (various formats) to a timestamp.
 * Supports Ymd, Y-m-d, d/m/Y, d M Y etc.
 */
function alya_promo_deadline_ts($raw) {
    if (!$raw) return 0;
    if (preg_match('/^\d{8}$/', $raw)) {
        $y = (int) substr($raw, 0, 4);
        $m = (int) substr($raw, 4, 2);
        $d = (int) substr($raw, 6, 2);
        $ts = mktime(0, 0, 0, $m, $d, $y);
        return $ts ?: 0;
    }
    $ts = strtotime($raw);
    if (!$ts && preg_match('#^\d{2}/\d{2}/\d{4}$#', $raw)) {
        list($d, $m, $y) = array_map('intval', explode('/', $raw));
        $ts = mktime(0, 0, 0, $m, $d, $y);
    }
    return $ts ?: 0;
}

function alya_promo_data($post_id = 0) {
    if (!$post_id) $post_id = get_the_ID();
    if (!$post_id) return [];

    $deadline_raw = get_post_meta($post_id, 'alya_promo_deadline', true);
    $days_left    = '';
    $deadline     = '';
    if ($deadline_raw) {
        $ts = alya_promo_deadline_ts($deadline_raw);
        if ($ts) {
            $deadline = alya_date_id('j M Y', $ts);
            $days = (int) ceil(($ts - current_time('timestamp')) / DAY_IN_SECONDS);
            if ($days > 0) $days_left = 'Sisa ' . $days . ' hari lagi';
        }
    }

    $quickfacts = alya_maybe_rep(get_post_meta($post_id, 'alya_promo_quickfacts', true));
    $tnc        = alya_maybe_rep(get_post_meta($post_id, 'alya_promo_tnc', true));
    $faqs       = alya_maybe_rep(get_post_meta($post_id, 'alya_promo_faqs', true));

    return [
        'ribbon'       => alya_field('alya_promo_ribbon', ''),
        'price_old'    => alya_field('alya_promo_price_old', ''),
        'price_new'    => alya_field('alya_promo_price_new', ''),
        'save_text'    => alya_field('alya_promo_save_text', ''),
        'deadline'     => $deadline,
        'deadline_raw' => $deadline_raw,
        'days_left'    => $days_left,
        'code'         => alya_field('alya_promo_code', ''),
        'slots'        => alya_field('alya_promo_slots', ''),
        'quota'        => (int) alya_field('alya_promo_quota', 0),
        'wa_link'      => alya_field('alya_promo_wa_link', ''),
        'quickfacts'   => is_array($quickfacts) ? $quickfacts : [],
        'tnc'          => is_array($tnc) ? $tnc : [],
        'faqs'         => is_array($faqs) ? $faqs : [],
    ];
}

function alya_promo_wa_link($post_id = 0, $text = '') {
    $data = alya_promo_data($post_id);
    $link = $data['wa_link'] ?? '';
    if ($link) return $link;
    $msg  = $text ?: 'Halo, saya ingin klaim promo di Alya Esthetic Center.';
    return alya_wa_link($msg);
}

// ─── Form Field Helper ───

function alya_form_field($name, $label = '', $args = []) {
    if (is_array($name)) {
        $args = $name;
        $name = $args['name'] ?? $args['id'] ?? '';
        $label = $args['label'] ?? '';
    }
    $defaults = [
        'type'     => 'text',
        'name'     => $name,
        'label'    => $label,
        'value'    => '',
        'required' => false,
        'placeholder' => '',
        'class'    => '',
        'options'  => [],
    ];
    $a = array_merge($defaults, $args);
    ?>
    <div class="field <?php echo esc_attr($a['class']); ?>">
        <?php if ($a['label']) : ?>
            <label for="<?php echo esc_attr($a['name']); ?>"><?php echo esc_html($a['label']); ?></label>
        <?php endif; ?>
        <?php if ($a['type'] === 'textarea') : ?>
            <textarea
                id="<?php echo esc_attr($a['name']); ?>"
                name="<?php echo esc_attr($a['name']); ?>"
                placeholder="<?php echo esc_attr($a['placeholder']); ?>"
                <?php echo $a['required'] ? 'required' : ''; ?>
                rows="5"
            ><?php echo esc_textarea($a['value']); ?></textarea>
        <?php elseif ($a['type'] === 'select') : ?>
            <select
                id="<?php echo esc_attr($a['name']); ?>"
                name="<?php echo esc_attr($a['name']); ?>"
                <?php echo $a['required'] ? 'required' : ''; ?>
            >
                <option value=""><?php echo esc_html($a['placeholder'] ?: 'Pilih...'); ?></option>
                <?php foreach ($a['options'] as $val => $label) : ?>
                    <option value="<?php echo esc_attr($val); ?>" <?php selected($a['value'], $val); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php elseif ($a['type'] === 'file') : ?>
            <input
                type="file"
                id="<?php echo esc_attr($a['name']); ?>"
                name="<?php echo esc_attr($a['name']); ?>"
                <?php echo $a['required'] ? 'required' : ''; ?>
            />
        <?php else : ?>
            <input
                type="<?php echo esc_attr($a['type']); ?>"
                id="<?php echo esc_attr($a['name']); ?>"
                name="<?php echo esc_attr($a['name']); ?>"
                value="<?php echo esc_attr($a['value']); ?>"
                placeholder="<?php echo esc_attr($a['placeholder']); ?>"
                <?php echo $a['required'] ? 'required' : ''; ?>
            />
        <?php endif; ?>
    </div>
    <?php
}

// ─── Parse Pipe-Delimited Text ───
// Format: JSON array [{"number":"10+","label":"Tahun Pengalaman"}] OR pipe-delimited "Number | Label"
function alya_parse_pipe_text($text) {
    if (empty($text)) return [];
    
    // Try JSON first
    $decoded = json_decode($text, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $items = [];
        foreach ($decoded as $item) {
            if (is_array($item) && isset($item['number'], $item['label'])) {
                $items[] = [
                    'number' => sanitize_text_field($item['number']),
                    'label'  => sanitize_text_field($item['label']),
                ];
            }
        }
        if (!empty($items)) return $items;
    }
    
    // Fallback: pipe-delimited
    $items = [];
    $lines = explode("\n", trim($text));
    
    foreach ($lines as $line) {
        $parts = array_map('trim', explode('|', $line));
        $parts = array_filter($parts, function($v) { return $v !== ''; });
        
        if (count($parts) >= 2) {
            $items[] = [
                'number' => $parts[0],
                'label'  => $parts[1],
            ];
        }
    }
    
    return $items;
}

// ─── Parse Values Items ───
// Format: JSON array [{"icon":"heart","title":"Hospitality","description":"..."}]
function alya_parse_values_text($text) {
    if (empty($text)) return [];
    
    $decoded = json_decode($text, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }
    
    if (!is_array($decoded)) {
        return [];
    }
    
    $items = [];
    foreach ($decoded as $item) {
        if (is_array($item) && isset($item['icon'], $item['title'], $item['description'])) {
            $items[] = [
                'icon'        => sanitize_text_field($item['icon']),
                'title'       => sanitize_text_field($item['title']),
                'description' => sanitize_text_field($item['description']),
            ];
        }
    }
    
    return $items;
}

// ─── Parse Simple List ───
// Returns array of strings from multiline text
function alya_parse_list($text) {
    if (empty($text)) return [];
    
    $items = [];
    $lines = explode("\n", trim($text));
    
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line !== '') {
            $items[] = $line;
        }
    }
    
    return $items;
}

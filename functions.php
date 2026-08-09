<?php
/**
 * Alya Esthetic Center — Functions
 *
 * @package Alya_Esthetic
 * @version 1.0.0
 * @author Muhamad Arya Kurniawan <kakayauya@gmail.com>
 */

defined('ABSPATH') || exit;

define('ALYA_VERSION', '1.0.0');
define('ALYA_DIR', get_template_directory());
define('ALYA_URI', get_template_directory_uri());

/**
 * Register custom page templates located in /templates
 */
add_filter('theme_page_templates', function ($templates) {
    $templates['templates/page-about.php']       = 'Tentang';
    $templates['templates/page-dokter.php']      = 'Halaman Dokter';
    $templates['templates/page-gallery.php']     = 'Before & After Gallery';
    $templates['templates/page-karir.php']       = 'Halaman Karir';
    $templates['templates/page-technology.php']  = 'Technology Page';
    return $templates;
});

/**
 * Theme Setup
 */
function alya_setup() {
    load_theme_textdomain('alya-esthetic', ALYA_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ]);
    add_theme_support('custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('responsive-embeds');
    add_theme_support('wp-block-styles');

    add_image_size('alya-card', 600, 400, true);
    add_image_size('alya-thumb', 400, 300, true);
    add_image_size('alya-hero', 1920, 800, true);

    register_nav_menus([
        'primary'   => __('Menu Utama', 'alya-esthetic'),
        'footer'    => __('Menu Footer', 'alya-esthetic'),
        'home'      => __('Menu Homepage', 'alya-esthetic'),
    ]);
}
add_action('after_setup_theme', 'alya_setup');

/**
 * Enqueue Assets
 */
function alya_scripts() {
    wp_enqueue_style('alya-variables', ALYA_URI . '/assets/css/variables.css', [], ALYA_VERSION);
    wp_enqueue_style('alya-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap', [], null);
    wp_enqueue_style('alya-main', ALYA_URI . '/assets/css/main.css', ['alya-variables'], ALYA_VERSION);

    // Technology page specific styles
    if (is_page_template('templates/page-technology.php')) {
        wp_enqueue_style('alya-page-technology', ALYA_URI . '/assets/css/page-technology.css', ['alya-main'], ALYA_VERSION);
    }

    // Gallery page specific styles
    if (is_page_template('templates/page-gallery.php')) {
        wp_enqueue_style('alya-page-gallery', ALYA_URI . '/assets/css/page-gallery.css', ['alya-main'], ALYA_VERSION);
    }

    // Services archive specific styles
    if (is_post_type_archive('treatment') || is_tax('treatment_category') || is_tax('service') || is_page('layanan') || is_page_template('page-services.php') || is_page_template('page-layanan.php')) {
        wp_enqueue_style('alya-page-services', ALYA_URI . '/assets/css/page-services.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-page-services', ALYA_URI . '/assets/js/page-services.js', ['alya-main'], ALYA_VERSION, true);
    }

    // Single treatment specific assets
    if (is_singular('treatment')) {
        wp_enqueue_style('alya-single-treatment', ALYA_URI . '/assets/css/single-treatment.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-single-treatment', ALYA_URI . '/assets/js/single-treatment.js', [], ALYA_VERSION, true);
    }

    // Doctors archive specific styles
    if (is_post_type_archive('doctor') || is_page('dokter') || is_page_template('templates/page-dokter.php')) {
        wp_enqueue_style('alya-page-doctors', ALYA_URI . '/assets/css/page-doctors.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-page-doctors', ALYA_URI . '/assets/js/page-doctors.js', [], ALYA_VERSION, true);
    }

    // Single doctor specific assets
    if (is_singular('doctor')) {
        wp_enqueue_style('alya-single-doctor', ALYA_URI . '/assets/css/single-doctor.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-single-doctor', ALYA_URI . '/assets/js/single-doctor.js', [], ALYA_VERSION, true);
    }

    // Blog index / archive specific styles
    if (is_home() || is_archive() || is_category() || is_tag() || is_page('blog') || is_page('artikel') || is_page_template('page-blog.php') || is_page_template('page-artikel.php')) {
        wp_enqueue_style('alya-page-blog', ALYA_URI . '/assets/css/page-blog.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-page-blog', ALYA_URI . '/assets/js/page-blog.js', [], ALYA_VERSION, true);
    }

    // Promo archive specific styles
    if (is_post_type_archive('promo') || is_tax('promo_category')) {
        wp_enqueue_style('alya-page-promo', ALYA_URI . '/assets/css/page-promo.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-page-promo', ALYA_URI . '/assets/js/page-promo.js', [], ALYA_VERSION, true);
    }

    // Single promo specific assets
    if (is_singular('promo')) {
        wp_enqueue_style('alya-single-promo', ALYA_URI . '/assets/css/page-promo.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-single-promo', ALYA_URI . '/assets/js/page-promo.js', [], ALYA_VERSION, true);
    }

    // Single blog post specific assets
    if (is_singular('post') || is_singular('testimonial')) {
        wp_enqueue_style('alya-single-blog', ALYA_URI . '/assets/css/single-blog.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-single-blog', ALYA_URI . '/assets/js/single-blog.js', [], ALYA_VERSION, true);
    }

    // Jobs / Karir archive specific styles
    if (is_post_type_archive('jobs') || is_tax('career_category') || is_tax('job_type') || is_page('karir') || is_page('jobs') || is_page_template('templates/page-karir.php')) {
        wp_enqueue_style('alya-page-jobs', ALYA_URI . '/assets/css/page-jobs.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-page-jobs', ALYA_URI . '/assets/js/page-jobs.js', [], ALYA_VERSION, true);
    }

    // Single job post specific assets
    if (is_singular('jobs')) {
        wp_enqueue_style('alya-single-jobs', ALYA_URI . '/assets/css/single-jobs.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-single-jobs', ALYA_URI . '/assets/js/single-jobs.js', [], ALYA_VERSION, true);
    }

    // About page specific assets
    if (is_page_template('templates/page-about.php') || is_page('tentang')) {
        wp_enqueue_style('alya-page-about', ALYA_URI . '/assets/css/page-about.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-page-about', ALYA_URI . '/assets/js/page-about.js', [], ALYA_VERSION, true);
    }

    // Home V2 assets
    if (is_front_page() && get_theme_mod('alya_homepage_style', 'default') === 'v2') {
        wp_enqueue_style('swiper',  'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11.0.0');
        wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], '11.0.0', true);
        wp_enqueue_style('alya-home-v2', ALYA_URI . '/assets/css/home-v2.css', ['alya-main'], ALYA_VERSION);
        wp_enqueue_script('alya-home-v2', ALYA_URI . '/assets/js/home-v2.js', ['swiper'], ALYA_VERSION, true);
    }

    // Kontak page assets
    if (is_page_template('page-kontak.php') || is_page('kontak')) {
        wp_enqueue_style('alya-page-kontak', ALYA_URI . '/assets/css/page-kontak.css', ['alya-main'], ALYA_VERSION);
    }

    wp_enqueue_script('alya-main', ALYA_URI . '/assets/js/main.js', [], ALYA_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_localize_script('alya-main', 'alyaData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('alya_nonce'),
        'siteUrl' => home_url('/'),
    ]);
}
add_action('wp_enqueue_scripts', 'alya_scripts');

add_filter('body_class', 'alya_body_classes');
function alya_body_classes($classes) {
    if (is_front_page()) {
        $homepage_style = get_theme_mod('alya_homepage_style', 'default');
        $classes[] = $homepage_style === 'v2' ? 'home-v2' : 'home-v1';
    }
    if (is_page_template('templates/page-about.php') || is_page('tentang')) {
        $classes[] = 'page-about';
    }
    if (is_post_type_archive('treatment') || is_tax('treatment_category') || is_tax('service') || is_page('layanan') || is_page_template('page-services.php') || is_page_template('page-layanan.php')) {
        $classes[] = 'page-services';
    }
    if (is_singular('treatment')) {
        $classes[] = 'single-treatment';
    }
    if (is_post_type_archive('doctor') || is_page('dokter') || is_page_template('templates/page-dokter.php')) {
        $classes[] = 'page-doctors';
    }
    if (is_singular('doctor')) {
        $classes[] = 'single-doctor';
    }
    if (is_home() || is_archive() || is_category() || is_tag() || is_page('blog') || is_page('artikel') || is_page_template('page-blog.php') || is_page_template('page-artikel.php')) {
        $classes[] = 'page-blog';
    }
    if (is_post_type_archive('promo') || is_tax('promo_category')) {
        $classes[] = 'page-promo';
    }
    if (is_singular('promo')) {
        $classes[] = 'single-promo';
    }
    if (is_singular('post')) {
        $classes[] = 'single-blog';
    }
    if (is_post_type_archive('jobs') || is_tax('career_category') || is_tax('job_type') || is_page('karir') || is_page('jobs') || is_page_template('templates/page-karir.php')) {
        $classes[] = 'page-jobs';
    }
    if (is_singular('jobs')) {
        $classes[] = 'single-jobs';
    }
    return $classes;
}

add_action('wp_head', 'alya_customizer_inline_css', 1);

/**
 * Widgets
 */
function alya_widgets_init() {
    register_sidebar([
        'name'          => __('Sidebar', 'alya-esthetic'),
        'id'            => 'sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer Widget 1', 'alya-esthetic'),
        'id'            => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer Widget 2', 'alya-esthetic'),
        'id'            => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer Widget 3', 'alya-esthetic'),
        'id'            => 'footer-3',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'alya_widgets_init');

/**
 * Includes
 */
require_once ALYA_DIR . '/inc/helpers.php';
require_once ALYA_DIR . '/inc/cpt.php';
require_once ALYA_DIR . '/inc/acf.php';
require_once ALYA_DIR . '/inc/gallery-meta.php';
require_once ALYA_DIR . '/inc/customizer.php';
require_once ALYA_DIR . '/inc/security.php';
require_once ALYA_DIR . '/inc/social.php';
require_once ALYA_DIR . '/inc/analytics.php';
require_once ALYA_DIR . '/inc/seo.php';
require_once ALYA_DIR . '/inc/leads.php';
require_once ALYA_DIR . '/inc/preinstall.php';
require_once ALYA_DIR . '/inc/dropdown-walker.php';

/**
 * AJAX Handlers
 */
function alya_job_apply_handler() {
    check_ajax_referer('alya_nonce', 'nonce');

    if (!isset($_POST['job_id']) || !isset($_POST['applicant_name']) || !isset($_POST['applicant_email'])) {
        wp_send_json_error(['message' => 'Data tidak lengkap.']);
    }

    $job_id          = intval($_POST['job_id']);
    $applicant_name  = sanitize_text_field($_POST['applicant_name']);
    $applicant_email = sanitize_email($_POST['applicant_email']);
    $applicant_phone = sanitize_text_field($_POST['applicant_phone'] ?? '');
    $applicant_msg   = sanitize_textarea_field($_POST['applicant_message'] ?? '');

    if (!current_user_can('edit_posts')) {
        if (empty($applicant_name) || empty($applicant_email)) {
            wp_send_json_error(['message' => 'Nama dan email wajib diisi.']);
        }
        if (!is_email($applicant_email)) {
            wp_send_json_error(['message' => 'Format email tidak valid.']);
        }
    }

    $upload_dir  = wp_upload_dir();
    $upload_path = trailingslashit($upload_dir['basedir']) . 'job-applications/';
    $upload_url  = trailingslashit($upload_dir['baseurl']) . 'job-applications/';

    if (!file_exists($upload_path)) {
        wp_mkdir_p($upload_path);
        file_put_contents($upload_path . '.htaccess', "Deny from all\n");
        file_put_contents($upload_path . 'index.php', '<?php // Silence is golden.');
    }

    $file_url  = '';
    $file_name = '';

    if (!empty($_FILES['applicant_cv']['name'])) {
        $allowed = ['pdf', 'doc', 'docx'];
        $upload  = alya_handle_upload('applicant_cv', $allowed);

        if (is_wp_error($upload)) {
            wp_send_json_error(['message' => $upload->get_error_message()]);
        }

        $file_name = basename($upload['file']);
        $file_url  = $upload['url'];
    }

    $subject = sprintf('[Lamaran Kerja] %s — %s', $applicant_name, get_the_title($job_id));

    $message  = "=== LAMARAN KERJA ===\n\n";
    $message .= "Posisi: " . get_the_title($job_id) . "\n";
    $message .= "Nama: {$applicant_name}\n";
    $message .= "Email: {$applicant_email}\n";
    $message .= "Telepon: {$applicant_phone}\n\n";
    $message .= "Pesan:\n{$applicant_msg}\n\n";
    $message .= "CV: {$file_url}\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$applicant_name} <{$applicant_email}>",
    ];

    $admin_email = get_option('admin_email');
    $sent        = wp_mail($admin_email, $subject, $message, $headers);

    if ($sent) {
        wp_send_json_success(['message' => 'Lamaran berhasil dikirim!']);
    } else {
        wp_send_json_error(['message' => 'Gagal mengirim lamaran. Silakan coba lagi.']);
    }
}
add_action('wp_ajax_alya_job_apply', 'alya_job_apply_handler');
add_action('wp_ajax_nopriv_alya_job_apply', 'alya_job_apply_handler');

/**
 * AJAX Handler — Services Filter
 */
function alya_services_filter_handler() {
    check_ajax_referer('alya_nonce', 'nonce');

    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $search   = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
    $per_page = get_theme_mod('alya_services_per_page', 9);

    $args = [
        'post_type'              => 'service',
        'posts_per_page'         => $per_page,
        'orderby'                => 'menu_order',
        'order'                  => 'ASC',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_term_cache'      => false,
        'suppress_filters'       => true,
    ];

    if (!empty($category)) {
        $args['tax_query'] = [[
            'taxonomy' => 'service_category',
            'field'    => 'slug',
            'terms'    => $category,
        ]];
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    $img_uri = ALYA_URI . '/assets/images/services';

    $all_post_ids = [];
    $all_term_map = [];

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $all_post_ids[] = get_the_ID();
        endwhile;
        wp_reset_postdata();

        $raw_terms = wp_get_object_terms($all_post_ids, 'service_category', ['fields' => 'all']);
        if (!is_wp_error($raw_terms)) {
            foreach ($raw_terms as $t) {
                foreach ($t->object_ids as $pid) {
                    $all_term_map[$pid] = $t->name;
                }
            }
        }

        ob_start();
        foreach ($all_post_ids as $pid) :
            $cat_name = isset($all_term_map[$pid]) ? $all_term_map[$pid] : '';
            $post_obj = get_post($pid);
            setup_postdata($post_obj);
            $title       = get_the_title($pid);
            $excerpt     = wp_trim_words(get_the_excerpt($post_obj), 12);
            $permalink   = get_permalink($pid);
            $has_thumb   = has_post_thumbnail($pid);
        ?>
            <a class="svc-t-card" href="<?php echo esc_url($permalink); ?>">
                <div class="thumb">
                    <?php if ($cat_name) : ?>
                        <span class="badge"><?php echo esc_html($cat_name); ?></span>
                    <?php endif; ?>
                    <?php if ($has_thumb) : ?>
                        <?php echo get_the_post_thumbnail($pid, 'alya-card', ['alt' => esc_attr($title), 'loading' => 'eager']); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(ALYA_URI . '/assets/images/placeholder-image-treatment-rhoeskin.webp'); ?>" alt="<?php echo esc_attr($title); ?>" loading="eager">
                    <?php endif; ?>
                </div>
                <div class="t-body">
                    <h4><?php echo esc_html($title); ?></h4>
                    <p><?php echo esc_html($excerpt); ?></p>
                    <div class="t-foot">
                        <span></span>
                        <span class="link">
                            <?php echo esc_html('Detail'); ?>
                            <svg viewBox="0 0 24 24"><path d="M8.6 4.6L14 10H3v4h11l-5.4 5.4L11 22l9-9-9-9z"/></svg>
                        </span>
                    </div>
                </div>
            </a>
        <?php
        endforeach;
        wp_reset_postdata();
        $html = ob_get_clean();
    else :
        $html = '';
    endif;

    wp_send_json_success([
        'html'      => $html,
        'has_posts' => !empty($all_post_ids),
    ]);
}
add_action('wp_ajax_alya_services_filter', 'alya_services_filter_handler');
add_action('wp_ajax_nopriv_alya_services_filter', 'alya_services_filter_handler');

/**
 * AJAX Handler — Treatments Filter
 */
function alya_treatments_filter_handler() {
    check_ajax_referer('alya_nonce', 'nonce');

    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $service  = isset($_POST['service']) ? sanitize_text_field($_POST['service']) : '';
    $search   = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
    $per_page = get_theme_mod('alya_treatments_per_page', 9);

    $args = [
        'post_type'              => 'treatment',
        'posts_per_page'         => $per_page,
        'orderby'                => 'menu_order',
        'order'                  => 'ASC',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_term_cache'      => false,
        'suppress_filters'       => true,
    ];

    $tax_query = [];

    if (!empty($category)) {
        $tax_query[] = [
            'taxonomy' => 'treatment_category',
            'field'    => 'slug',
            'terms'    => $category,
        ];
    }

    if (!empty($service)) {
        $tax_query[] = [
            'taxonomy' => 'service',
            'field'    => 'slug',
            'terms'    => $service,
        ];
    }

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);
    $img_uri = ALYA_URI . '/assets/images/services';

    $all_post_ids = [];
    $all_term_map = [];

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $all_post_ids[] = get_the_ID();
        endwhile;
        wp_reset_postdata();

        $raw_terms = wp_get_object_terms($all_post_ids, 'treatment_category', ['fields' => 'all']);
        if (!is_wp_error($raw_terms)) {
            foreach ($raw_terms as $t) {
                foreach ($t->object_ids as $pid) {
                    $all_term_map[$pid] = $t->name;
                }
            }
        }

        ob_start();
        foreach ($all_post_ids as $pid) :
            $cat_name = isset($all_term_map[$pid]) ? $all_term_map[$pid] : '';
            $post_obj = get_post($pid);
            setup_postdata($post_obj);
            $title       = get_the_title($pid);
            $excerpt     = wp_trim_words(get_the_excerpt($post_obj), 12);
            $permalink   = get_permalink($pid);
            $has_thumb   = has_post_thumbnail($pid);
        ?>
            <a class="svc-t-card" href="<?php echo esc_url($permalink); ?>">
                <div class="thumb">
                    <?php if ($cat_name) : ?>
                        <span class="badge"><?php echo esc_html($cat_name); ?></span>
                    <?php endif; ?>
                    <?php if ($has_thumb) : ?>
                        <?php echo get_the_post_thumbnail($pid, 'alya-card', ['alt' => esc_attr($title), 'loading' => 'eager']); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url(ALYA_URI . '/assets/images/placeholder-image-treatment-rhoeskin.webp'); ?>" alt="<?php echo esc_attr($title); ?>" loading="eager">
                    <?php endif; ?>
                </div>
                <div class="t-body">
                    <h4><?php echo esc_html($title); ?></h4>
                    <p><?php echo esc_html($excerpt); ?></p>
                    <div class="t-foot">
                        <span></span>
                        <span class="link">
                            <?php echo esc_html('Detail'); ?>
                            <svg viewBox="0 0 24 24"><path d="M8.6 4.6L14 10H3v4h11l-5.4 5.4L11 22l9-9-9-9z"/></svg>
                        </span>
                    </div>
                </div>
            </a>
        <?php
        endforeach;
        wp_reset_postdata();
        $html = ob_get_clean();
    else :
        $html = '';
    endif;

    wp_send_json_success([
        'html'      => $html,
        'has_posts' => !empty($all_post_ids),
    ]);
}
add_action('wp_ajax_alya_treatments_filter', 'alya_treatments_filter_handler');
add_action('wp_ajax_nopriv_alya_treatments_filter', 'alya_treatments_filter_handler');

/**
 * AJAX Handler — Doctors Filter + Pagination
 */
function alya_doctors_filter_handler() {
    check_ajax_referer('alya_nonce', 'nonce');

    $search   = isset($_POST['s'])        ? sanitize_text_field($_POST['s'])   : '';
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'all';
    $paged    = isset($_POST['paged'])    ? max(1, intval($_POST['paged']))     : 1;
    $per_page = 9;

    // Build meta_query for category filter
    $meta_query = [];
    if (!empty($category) && $category !== 'all') {
        $meta_query[] = [
            'key'     => 'alya_specialty',
            'value'   => $category,
            'compare' => 'LIKE',
        ];
    }

    // OPTIMIZATION: Only count featured docs if page 1, reuse from query
    $featured_doctors = [];
    $featured_count = 0;
    
    if ($paged === 1) {
        // Fetch featured doctors untuk page 1
        $featured_meta_query = [
            [
                'key'   => 'alya_is_featured',
                'value' => '1',
            ],
        ];
        
        if (!empty($meta_query)) {
            $featured_meta_query[] = $meta_query[0];
        }

        $featured_args = [
            'post_type'      => 'doctor',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'meta_query'     => $featured_meta_query,
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
            'no_found_rows'  => true, // Skip counting for performance
        ];
        
        if (!empty($search)) {
            $featured_args['s'] = $search;
        }

        $featured_query = new WP_Query($featured_args);
        if ($featured_query->have_posts()) {
            $featured_doctors = $featured_query->posts;
            $featured_count = count($featured_doctors);
        }
        wp_reset_postdata();
    }

    // For page 2+, we need to know how many featured existed on page 1
    // Use transient cache to avoid re-querying
    $cache_key = 'alya_featured_count_' . md5($category . $search);
    $total_featured_count = 0;
    
    if ($paged === 1) {
        // Store count for subsequent pages
        $total_featured_count = $featured_count;
        set_transient($cache_key, $total_featured_count, 300); // 5 minutes cache
    } else {
        // Retrieve from cache
        $total_featured_count = get_transient($cache_key);
        if ($total_featured_count === false) {
            // Fallback: quick count query if cache expired
            $total_featured_count = 0;
        }
    }

    // Query regular doctors
    $regular_per_page = $per_page - $featured_count;
    $regular_offset = ($paged === 1) ? 0 : (($paged - 1) * $per_page - $total_featured_count);

    $regular_meta_query = [
        'relation' => 'OR',
        [
            'key'     => 'alya_is_featured',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key'     => 'alya_is_featured',
            'value'   => '1',
            'compare' => '!=',
        ],
    ];
    
    // Tambahkan category filter jika ada
    if (!empty($meta_query)) {
        $regular_meta_query = [
            'relation' => 'AND',
            $regular_meta_query,
            $meta_query[0],
        ];
    }

    $regular_args = [
        'post_type'      => 'doctor',
        'post_status'    => 'publish',
        'posts_per_page' => $regular_per_page,
        'offset'         => max(0, $regular_offset),
        'meta_query'     => $regular_meta_query,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    ];

    if (!empty($search)) {
        $regular_args['s'] = $search;
    }

    $regular_query = new WP_Query($regular_args);

    // Merge doctors: featured di awal (page 1), regular sisanya
    $all_doctors = array_merge($featured_doctors, $regular_query->posts);

    // Calculate pagination - cache total counts for performance
    $total_cache_key = 'alya_total_docs_' . md5($category . $search);
    
    if ($paged === 1) {
        $total_regular = $regular_query->found_posts;
        $total_all = $total_featured_count + $total_regular;
        set_transient($total_cache_key, $total_all, 300); // 5 min cache
    } else {
        $total_all = get_transient($total_cache_key);
        if ($total_all === false) {
            // Fallback
            $total_all = $regular_query->found_posts + $total_featured_count;
        }
    }
    
    $max_pages = ceil($total_all / $per_page);

    ob_start();
    if (!empty($all_doctors)) :
        foreach ($all_doctors as $post) :
            setup_postdata($post);
            $post_id   = $post->ID;
            $avatar    = get_field('alya_avatar', $post_id);
            $position  = get_field('alya_position', $post_id) ?: get_field('alya_specialist', $post_id) ?: 'Aesthetic Doctor';
            $specialty = get_field('alya_specialty', $post_id) ?: 'skin aesthetic';
            $is_featured = get_field('alya_is_featured', $post_id);
            $featured  = get_field('alya_featured', $post_id) ?: '';
            $exp_years = get_field('alya_experience_years', $post_id) ?: get_field('alya_exp_years', $post_id) ?: '10+ tahun';
            $location  = get_field('alya_location', $post_id) ?: 'Jakarta Selatan';
            $excerpt   = has_excerpt($post_id) ? get_the_excerpt($post_id) : 'Dokter spesialis berpengalaman yang siap membantu kebutuhan perawatan dan kecantikan Anda.';

            $img_url = '';
            if ($avatar && is_array($avatar) && isset($avatar['url'])) {
                $img_url = $avatar['url'];
            } elseif (has_post_thumbnail($post_id)) {
                $img_url = get_the_post_thumbnail_url($post_id, 'medium_large');
            } else {
                $img_url = get_template_directory_uri() . '/assets/images/placeholder-doctor-rhoeskin.webp';
            }
            ?>
            <article class="doc-card<?php echo $is_featured ? ' doc-card--featured' : ''; ?>" data-cat="<?php echo esc_attr($specialty); ?>" onclick="location.href='<?php echo esc_url(get_permalink($post_id)); ?>'">
              <div class="doc-card__img">
                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>" loading="lazy">
                <?php if ($is_featured) : ?>
                  <span class="doc-badge doc-badge--archive" title="Featured Doctor">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                  </span>
                <?php elseif ($featured) : ?>
                  <span class="doc-card__badge"><?php echo esc_html($featured); ?></span>
                <?php endif; ?>
              </div>
              <div class="doc-card__body">
                <h3><?php echo get_the_title($post_id); ?></h3>
                <p class="spec"><?php echo esc_html($position); ?></p>
                <p><?php echo esc_html(wp_trim_words($excerpt, 18)); ?></p>
                <div class="doc-card__meta">
                  <span>
                    <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-5h2v5zm0-7H11V7h2v2z"/></svg>
                    <?php echo esc_html($exp_years); ?>
                  </span>
                  <span>
                    <svg viewBox="0 0 24 24"><path d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
                    <?php echo esc_html($location); ?>
                  </span>
                </div>
                <div class="doc-card__actions">
                  <a href="<?php echo get_permalink($post_id); ?>" class="btn btn--outline">Lihat Profil</a>
                  <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="btn">Buat Janji</a>
                </div>
              </div>
            </article>
            <?php
        endforeach;
        wp_reset_postdata();
    endif;
    $html = ob_get_clean();

    wp_send_json_success([
        'html'       => $html,
        'has_posts'  => !empty($all_doctors),
        'max_pages'  => (int) $max_pages,
        'total'      => (int) $total_all,
        'paged'      => $paged,
    ]);
}
add_action('wp_ajax_alya_doctors_filter', 'alya_doctors_filter_handler');
add_action('wp_ajax_nopriv_alya_doctors_filter', 'alya_doctors_filter_handler');

/**
 * AJAX Handler — Jobs Filter
 */
function alya_jobs_filter_handler() {
    check_ajax_referer('alya_nonce', 'nonce');

    $category = isset($_POST['career_category']) ? sanitize_text_field($_POST['career_category']) : '';
    $search   = isset($_POST['s']) ? sanitize_text_field($_POST['s']) : '';
    $per_page = 12;

    $args = [
        'post_type'              => 'jobs',
        'posts_per_page'         => $per_page,
        'post_status'            => 'publish',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_term_cache'      => false,
        'suppress_filters'       => true,
    ];

    if (!empty($category)) {
        $args['tax_query'] = [[
            'taxonomy' => 'career_category',
            'field'    => 'slug',
            'terms'    => $category,
        ]];
    }

    if (!empty($search)) {
        $args['s'] = $search;
    }

    $query = new WP_Query($args);

    $all_post_ids = [];
    $all_cat_map = [];
    $all_type_map = [];

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $all_post_ids[] = get_the_ID();
        endwhile;
        wp_reset_postdata();

        $raw_cats = wp_get_object_terms($all_post_ids, 'career_category', ['fields' => 'all']);
        if (!is_wp_error($raw_cats)) {
            foreach ($raw_cats as $t) {
                foreach ($t->object_ids as $pid) {
                    $all_cat_map[$pid] = $t->name;
                }
            }
        }

        $raw_types = wp_get_object_terms($all_post_ids, 'job_type', ['fields' => 'all']);
        if (!is_wp_error($raw_types)) {
            foreach ($raw_types as $t) {
                foreach ($t->object_ids as $pid) {
                    $all_type_map[$pid] = $t->name;
                }
            }
        }

        ob_start();
        foreach ($all_post_ids as $pid) :
            $cat_name = isset($all_cat_map[$pid]) ? $all_cat_map[$pid] : '';
            $type_name = isset($all_type_map[$pid]) ? $all_type_map[$pid] : '';
            $title = get_the_title($pid);
            $permalink = get_permalink($pid);
            $location = get_field('alya_location', $pid);
            $deadline = get_field('alya_deadline', $pid);
        ?>
            <a class="job-card" href="<?php echo esc_url($permalink); ?>">
                <div class="job-card__main">
                    <div class="job-card__top">
                        <?php if ($cat_name) : ?>
                        <span class="tag"><?php echo esc_html($cat_name); ?></span>
                        <?php endif; ?>
                        <?php if ($type_name) : ?>
                        <span class="job-type"><?php echo esc_html($type_name); ?></span>
                        <?php endif; ?>
                    </div>
                    <h3><?php echo esc_html($title); ?></h3>
                    <div class="job-meta">
                        <?php if ($location) : ?>
                        <span><?php echo alya_icon('pin'); ?> <?php echo esc_html($location); ?></span>
                        <?php endif; ?>
                        <?php if ($deadline) : ?>
                        <span><?php echo alya_icon('calendar'); ?> Batas lamaran: <?php echo esc_html($deadline); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <span class="job-card__cta">Lihat Detail <?php echo alya_icon('arrow-right'); ?></span>
            </a>
        <?php
        endforeach;
        wp_reset_postdata();
        $html = ob_get_clean();
    else :
        $html = '';
    endif;

    wp_send_json_success([
        'html'      => $html,
        'has_posts' => !empty($all_post_ids),
    ]);
}
add_action('wp_ajax_alya_jobs_filter', 'alya_jobs_filter_handler');
add_action('wp_ajax_nopriv_alya_jobs_filter', 'alya_jobs_filter_handler');

/**
 * Custom Excerpt Length
 */
function alya_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'alya_excerpt_length');

function alya_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'alya_excerpt_more');

/**
 * Post View Counter — for "Artikel Populer" sidebar
 */
function alya_set_post_view() {
    if (!is_single()) return;
    $post_id = get_the_ID();
    $count = get_post_meta($post_id, 'post_views_count', true);
    $count = $count ? intval($count) + 1 : 1;
    update_post_meta($post_id, 'post_views_count', $count);
}
add_action('wp_head', 'alya_set_post_view');

function alya_get_post_views($post_id) {
    $count = get_post_meta($post_id, 'post_views_count', true);
    return $count ? intval($count) : 0;
}

/**
 * Support search & category filter within Jobs archive
 */
add_action('pre_get_posts', function ($query) {
    if (is_admin() || !$query->is_main_query()) return;

    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($uri, '/karir/') !== 0) return;

    $query->set('post_type', 'jobs');

    if (!empty($_GET['s'])) {
        $query->set('s', sanitize_text_field($_GET['s']));
    }

    if (!empty($_GET['career_category'])) {
        $query->set('tax_query', [[
            'taxonomy' => 'career_category',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($_GET['career_category']),
        ]]);
    }
});

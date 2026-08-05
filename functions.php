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
    ]);
}
add_action('after_setup_theme', 'alya_setup');

/**
 * Enqueue Assets
 */
function alya_scripts() {
    wp_enqueue_style('alya-main', ALYA_URI . '/assets/css/main.css', [], ALYA_VERSION);
    wp_enqueue_style('alya-components', ALYA_URI . '/assets/css/components.css', ['alya-main'], ALYA_VERSION);
    wp_enqueue_style('alya-responsive', ALYA_URI . '/assets/css/responsive.css', ['alya-main'], ALYA_VERSION);

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
require_once ALYA_DIR . '/inc/customizer.php';
require_once ALYA_DIR . '/inc/security.php';
require_once ALYA_DIR . '/inc/social.php';
require_once ALYA_DIR . '/inc/analytics.php';
require_once ALYA_DIR . '/inc/seo.php';

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

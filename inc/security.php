<?php
/**
 * Security Hardening
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

/**
 * Disable XML-RPC
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove WP version from <head> and feeds
 */
remove_action('wp_head', 'wp_generator');

/**
 * Disable author archives (if single author)
 */
function alya_disable_author_archives() {
    if (is_author()) {
        wp_redirect(home_url('/'), 301);
        exit;
    }
}
add_action('template_redirect', 'alya_disable_author_archives');

/**
 * Remove query strings from static resources
 */
function alya_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'alya_remove_query_strings', 10, 2);
add_filter('script_loader_src', 'alya_remove_query_strings', 10, 2);

/**
 * Security Headers
 */
function alya_security_headers() {
    if (!is_admin()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'alya_security_headers');

/**
 * Disable file editing in admin
 */
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

/**
 * Limit login attempts (basic)
 */
function alya_check_login_attempts() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient = 'alya_login_' . md5($ip);
    $attempts = get_transient($transient);

    if ($attempts && $attempts >= 5) {
        wp_die(
            'Terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.',
            'Akses Ditolak',
            ['response' => 429]
        );
    }
}
add_action('wp_login_failed', function() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $transient = 'alya_login_' . md5($ip);
    $attempts = get_transient($transient);
    $attempts = $attempts ? $attempts + 1 : 1;
    set_transient($transient, $attempts, 15 * MINUTE_IN_SECONDS);
});

/**
 * Sanitize file uploads — block PHP in uploads
 */
function alya_check_upload_mimes($file) {
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $blocked = ['php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'pht', 'phps', 'cgi', 'pl', 'asp', 'aspx', 'jsp', 'sh', 'cgi'];

    if (in_array($ext, $blocked)) {
        $file['error'] = 'Tipe file tidak diizinkan.';
    }
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'alya_check_upload_mimes');

/**
 * Remove REST API user endpoints for non-logged users
 */
function alya_restrict_user_rest($response, $handler, $request) {
    if (preg_match('#/wp/v2/users#', $request->get_route()) && !current_user_can('list_users')) {
        return new WP_Error('rest_forbidden', 'Akses ditolak.', ['status' => 403]);
    }
    return $response;
}
add_filter('rest_request_before_callbacks', 'alya_restrict_user_rest', 10, 3);

/**
 * Disable pingback
 */
function alya_disable_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'alya_disable_pingback');

/**
 * Hide admin bar for non-admins on frontend
 */
function alya_hide_admin_bar() {
    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'alya_hide_admin_bar');

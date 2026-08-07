<?php
/**
 * Pre-installed Data — Runs seeders on first theme activation
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

/**
 * Hook into theme activation
 */
function alya_preinstall_hook() {
    if (get_option('alya_data_seeded', false)) {
        return;
    }

    // Run seeders
    alya_run_seeders();

    // Mark as seeded
    update_option('alya_data_seeded', true);

    // Show admin notice
    update_option('alya_seed_notice_dismissed', false);
}
add_action('after_switch_theme', 'alya_preinstall_hook');

/**
 * Run all seeders in order
 */
function alya_run_seeders() {
    set_time_limit(0);

    $theme_dir = get_template_directory();
    $log_file  = WP_CONTENT_DIR . '/seed-log.txt';
    $log       = "=== Alya Esthetic Seed Log ===\n";
    $log       .= "Date: " . date('Y-m-d H:i:s') . "\n\n";

    // 1. Customizer settings (dev/seeder-v2.php)
    $log .= "--- Step 1: Customizer Settings (dev/seeder-v2.php) ---\n";
    require_once $theme_dir . '/dev/seeder-v2.php';
    $log .= "Customizer settings applied.\n\n";

    // 2. Images (dev/seeder-images.php)
    $log .= "--- Step 2: Images (dev/seeder-images.php) ---\n";
    require_once $theme_dir . '/dev/seeder-images.php';
    $log .= "Images downloaded and assigned.\n\n";

    // 3. Page content (dev/seeder-pages.php)
    $log .= "--- Step 3: Page Content (dev/seeder-pages.php) ---\n";
    require_once $theme_dir . '/dev/seeder-pages.php';
    if (function_exists('alya_seed_pages')) {
        alya_seed_pages();
    }
    $log .= "Page content seeded.\n\n";

    $log .= "=== Seed Complete ===\n";

    // Write log file
    file_put_contents($log_file, $log);
}

/**
 * Admin notice after seeding
 */
function alya_seed_admin_notice() {
    if (get_option('alya_seed_notice_dismissed', false)) {
        return;
    }

    if (!get_option('alya_data_seeded', false)) {
        return;
    }

    $screen = get_current_screen();
    if ($screen && $screen->id !== 'dashboard') {
        return;
    }
    ?>
    <div class="notice notice-success is-dismissible" data-dismiss-option="alya_seed_notice_dismissed" style="padding:16px 20px">
        <p style="margin:0;font-weight:600">Alya Esthetic demo data has been installed.</p>
        <p style="margin:4px 0 0;color:#555">All pages, images, and settings have been configured. Visit your <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank">site</a> to preview.</p>
    </div>
    <?php
}
add_action('admin_notices', 'alya_seed_admin_notice');

/**
 * Handle AJAX dismiss for the admin notice
 */
function alya_seed_dismiss_notice() {
    check_ajax_referer('alya_nonce', 'nonce');
    update_option('alya_seed_notice_dismissed', true);
    wp_send_json_success();
}
add_action('wp_ajax_alya_seed_dismiss', 'alya_seed_dismiss_notice');

/**
 * Enqueue script for dismissible notice
 */
function alya_seed_admin_scripts($hook) {
    if ($hook !== 'index.php') {
        return;
    }
    if (get_option('alya_seed_notice_dismissed', false)) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var notice = document.querySelector('.notice[data-dismiss-option]');
        if (!notice) return;
        var closeBtn = notice.querySelector('.notice-dismiss');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('action=alya_seed_dismiss&nonce=<?php echo wp_create_nonce('alya_nonce'); ?>');
            });
        }
    });
    </script>
    <?php
}
add_action('admin_enqueue_scripts', 'alya_seed_admin_scripts');

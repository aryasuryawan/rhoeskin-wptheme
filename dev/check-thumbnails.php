<?php
define('ABSPATH', 'D:/laragon/www/alya-test/');
define('WPINC', 'wp-includes');
require_once('D:/laragon/www/alya-test/wp-load.php');

$posts = get_posts(['post_type' => 'treatment', 'posts_per_page' => -1, 'post_status' => 'any']);
foreach ($posts as $p) {
    $thumb_id = get_post_thumbnail_id($p->ID);
    $thumb_url = get_the_post_thumbnail_url($p->ID, 'full');
    echo $p->post_title . " (ID:" . $p->ID . ")\n  featured image ID: " . ($thumb_id ?: "NONE") . "\n  URL: " . ($thumb_url ?: "NONE") . "\n";
}

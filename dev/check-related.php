<?php
define('ABSPATH', 'D:/laragon/www/alya-test/');
define('WPINC', 'wp-includes');
require_once('D:/laragon/www/alya-test/wp-load.php');

echo "=== TREATMENT POSTS ===\n";
$posts = get_posts(['post_type' => 'treatment', 'posts_per_page' => -1, 'post_status' => 'publish']);
foreach ($posts as $p) {
    $terms = wp_get_post_terms($p->ID, 'service', ['fields' => 'names']);
    $svc_names = is_wp_error($terms) ? [] : $terms;
    echo $p->post_title . " (ID:" . $p->ID . ") | service: " . implode(', ', $svc_names) . "\n";
}

echo "\n=== DOCTOR SERVICES (for dr. Nadia, ID 24) ===\n";
$doc_services = get_field('alya_services', 24);
if ($doc_services) {
    foreach ($doc_services as $svc) {
        echo "Service: " . (is_object($svc) ? $svc->post_title : $svc) . "\n";
    }
} else {
    echo "(empty)\n";
}

echo "\n=== DOCTOR SPECIALTY (id 24) ===\n";
echo "alya_specialty: " . get_field('alya_specialty', 24) . "\n";

echo "\n=== SERVICE TAXONOMY TERMS ===\n";
$terms = get_terms(['taxonomy' => 'service', 'hide_empty' => false]);
if (!is_wp_error($terms)) {
    foreach ($terms as $t) {
        echo $t->name . " (slug: " . $t->slug . ", count: " . $t->count . ")\n";
    }
}

<?php
define('ABSPATH', 'D:/laragon/www/alya-test/');
define('WPINC', 'wp-includes');
require_once('D:/laragon/www/alya-test/wp-load.php');

echo "=== Registering service taxonomy terms for treatments ===\n\n";

// Service slug mappings (matching service post slugs)
$service_slugs = [
    'skin-serenity'      => 'Skin Serenity',
    'beauty-advance'     => 'Beauty Advance',
    'slimming-wellness'  => 'Slimming & Wellness',
    'alya-beauty-bar'    => 'Alya Beauty Bar',
];

// Create terms if they don't exist
foreach ($service_slugs as $slug => $name) {
    $term = get_term_by('slug', $slug, 'service');
    if (!$term) {
        $result = wp_insert_term($name, 'service', ['slug' => $slug]);
        if (!is_wp_error($result)) {
            echo "[CREATE] Term: $name (slug: $slug)\n";
        } else {
            echo "[ERROR] " . $result->get_error_message() . "\n";
        }
    } else {
        echo "[EXISTS] Term: $name (slug: $slug, ID: {$term->term_id})\n";
    }
}

echo "\n=== Mapping treatments to service terms ===\n\n";

$treatment_service_map = [
    'Hydra Facial'           => 'skin-serenity',
    'Botox Anti-Aging'       => 'beauty-advance',
    'Laser Carbon Peel'      => 'beauty-advance',
    'RF Skin Tightening'     => 'slimming-wellness',
];

$posts = get_posts(['post_type' => 'treatment', 'posts_per_page' => -1, 'post_status' => 'any']);

foreach ($posts as $p) {
    $title = $p->post_title;
    $service_term = $treatment_service_map[$title] ?? '';

    if ($service_term) {
        $term = get_term_by('slug', $service_term, 'service');
        if ($term) {
            $result = wp_set_object_terms($p->ID, [$term->term_id], 'service', true);
            if (!is_wp_error($result)) {
                echo "[SET] '{$title}' (ID:{$p->ID}) -> service: '{$service_term}'\n";
            } else {
                echo "[ERROR] '{$title}': " . $result->get_error_message() . "\n";
            }
        }
    } else {
        echo "[SKIP] '{$title}' - no mapping defined\n";
    }
}

echo "\n=== Verification ===\n";
foreach ($posts as $p) {
    $terms = wp_get_object_terms($p->ID, 'service', ['fields' => 'names']);
    $term_names = is_wp_error($terms) ? [] : $terms;
    echo $p->post_title . " (ID:{$p->ID}) -> services: " . implode(', ', $term_names) . "\n";
}

echo "\n=== Done! ===\n";

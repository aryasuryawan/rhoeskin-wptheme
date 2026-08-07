<?php
/**
 * Migration Script: Convert repeater fields to textarea format
 *
 * The ACF field type was changed from 'repeater' (requires ACF Pro)
 * to 'textarea' (works with free ACF). This script migrates existing
 * stored data from serialized repeater arrays to pipe-delimited text.
 *
 * Run via: php seeder-migrate-fields.php
 *
 * @package Alya_Esthetic
 */

if (!defined('ABSPATH')) {
    $wp_root = 'D:/laragon/www/alya-test';
    define('ABSPATH', $wp_root . '/');
    define('WPINC', 'wp-includes');
    require_once ABSPATH . 'wp-load.php';
}

echo "=== ACF Field Migration: Repeater -> Textarea ===\n\n";

$doctors = get_posts(['post_type' => 'doctor', 'posts_per_page' => -1, 'post_status' => 'any']);
echo "Found " . count($doctors) . " doctors\n\n";

foreach ($doctors as $doctor) {
    $pid = $doctor->ID;
    $title = get_the_title($pid);
    $changed = false;

    // ── Stats: repeater -> textarea "Number | Label" ──
    $stats_raw = get_field('alya_stats', $pid);
    if (is_array($stats_raw) && !empty($stats_raw)) {
        $lines = [];
        foreach ($stats_raw as $stat) {
            if (is_array($stat)) {
                $number = $stat['number'] ?? '';
                $label  = isset($stat['label']) ? $stat['label'] : ($stat['suffix'] ?? '');
                if ($number && $label) {
                    $lines[] = "$number | $label";
                }
            }
        }
        if (!empty($lines)) {
            $stats_text = implode("\n", $lines);
            update_field('alya_stats', $stats_text, $pid);
            echo "  [STATS] {$title}: migrated " . count($lines) . " stats\n";
            $changed = true;
        }
    }

    // ── Certifications: repeater -> textarea "Title | Institution" ──
    $certs_raw = get_field('alya_certifications', $pid);
    if (is_array($certs_raw) && !empty($certs_raw)) {
        $lines = [];
        foreach ($certs_raw as $cert) {
            if (is_array($cert)) {
                $title_val = $cert['title'] ?? '';
                $inst_val  = $cert['institution'] ?? '';
                if ($title_val) {
                    $lines[] = "$title_val | $inst_val";
                }
            }
        }
        if (!empty($lines)) {
            $certs_text = implode("\n", $lines);
            update_field('alya_certifications', $certs_text, $pid);
            echo "  [CERTS] {$title}: migrated " . count($lines) . " certifications\n";
            $changed = true;
        }
    }

    if (!$changed) {
        echo "  [SKIP] {$title}: no repeater data found\n";
    }
}

echo "\n=== Migration Complete! ===\n";
echo "Now reload the doctor edit page — fields will be editable as textareas.\n";

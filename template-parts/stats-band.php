<?php
/**
 * Stats Band — 4-col stat counters
 *
 * @package Alya_Esthetic
 */

$stats = get_theme_mod('alya_v2_stats_band', [
    ['number' => '10rb+', 'label' => 'Pasien Terlayani'],
    ['number' => '50+', 'label' => 'Jenis Treatment'],
    ['number' => '15+', 'label' => 'Dokter & Terapis Ahli'],
    ['number' => '4.9/5', 'label' => 'Rating Kepuasan Pasien'],
]);

// Handle JSON string from textarea
if (is_string($stats)) {
    $decoded = json_decode($stats, true);
    if (is_array($decoded)) $stats = $decoded;
}
?>

<section class="stats-band">
    <div class="container">
        <?php if (!empty($stats) && is_array($stats)) : ?>
            <?php foreach ($stats as $stat) : ?>
                <div>
                    <b><?php echo esc_html($stat['number'] ?? ''); ?></b>
                    <span><?php echo esc_html($stat['label'] ?? ''); ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

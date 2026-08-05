<?php
/**
 * Marquee — Scrolling text strip
 *
 * @package Alya_Esthetic
 */

$services = [
    'Skin Serenity',
    'Beauty Advance',
    'Slimming & Wellness',
    'Alya Beauty Bar',
];
?>

<div class="marquee">
    <div class="marquee__track">
        <?php for ($i = 0; $i < 2; $i++) : ?>
            <?php foreach ($services as $service) : ?>
                <span><?php echo esc_html($service); ?></span>
            <?php endforeach; ?>
        <?php endfor; ?>
    </div>
</div>

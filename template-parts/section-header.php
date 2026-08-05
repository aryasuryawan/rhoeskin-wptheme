<?php
/**
 * Template Part: Section Header
 *
 * Usage: get_template_part('template-parts/section', 'header');
 * Then pass variables: $eyebrow, $heading, $lead, $align
 */

$eyebrow = $eyebrow ?? '';
$heading = $heading ?? '';
$lead    = $lead ?? '';
$align   = $align ?? '';
?>
<div class="section__head <?php echo $align ? 'section__head--' . esc_attr($align) : ''; ?>">
    <div>
        <?php if ($eyebrow) : ?>
            <span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
        <?php endif; ?>
        <?php if ($heading) : ?>
            <h2 class="section__title"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if ($lead) : ?>
            <p class="lead"><?php echo esc_html($lead); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php if (!defined('ABSPATH')) exit;

$icon   = get_field('alya_service_icon');
$title  = get_the_title();
$excerpt = get_the_excerpt();
$permalink = get_permalink();
?>
<div class="card">
  <?php if ($icon): ?>
    <div class="card__icon">
      <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>" width="34" height="34">
    </div>
  <?php endif; ?>
  <h3><?php echo esc_html($title); ?></h3>
  <p><?php echo esc_html(wp_trim_words($excerpt, 15)); ?></p>
  <a href="<?php echo esc_url($permalink); ?>" class="link">
    Lihat Detail
    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
  </a>
</div>
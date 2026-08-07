<?php if (!defined('ABSPATH')) exit;

$specialist = get_post_meta(get_the_ID(), 'alya_doctor_specialist', true);
$featured   = get_post_meta(get_the_ID(), 'alya_featured', true);
?>
<div class="doc">
  <?php if (has_post_thumbnail()): ?>
    <?php the_post_thumbnail('medium', ['class' => 'doc-avatar', 'loading' => 'lazy']); ?>
  <?php else: ?>
    <div class="doc-avatar" style="background:var(--brand-soft);"></div>
  <?php endif; ?>
  <div class="doc__info">
    <h4><?php the_title(); ?></h4>
    <?php if ($specialist): ?>
      <p><?php echo esc_html($specialist); ?></p>
    <?php endif; ?>
    <?php if ($featured): ?>
      <span style="font-size:.76rem;color:var(--brand);font-weight:600">★ Featured</span>
    <?php endif; ?>
  </div>
</div>
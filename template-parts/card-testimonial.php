<?php if (!defined('ABSPATH')) exit;

$role  = get_post_meta(get_the_ID(), 'alya_testimonial_role', true);
$stars = get_post_meta(get_the_ID(), 'alya_testimonial_stars', 5);
?>
<div class="t-q">
  <p><?php the_content(); ?></p>
  <div class="who">
    <?php if (has_post_thumbnail()): ?>
      <?php the_post_thumbnail('medium', ['loading' => 'lazy']); ?>
    <?php else: ?>
      <div style="width:46px;height:46px;border-radius:50%;background:var(--brand);display:grid;place-items:center;"></div>
    <?php endif; ?>
    <div>
      <b><?php the_title(); ?></b>
      <?php if ($role): ?><span><?php echo esc_html($role); ?></span><?php endif; ?>
    </div>
  </div>
  <div class="stars">
    <?php for ($i = 0; $i < intval($stars); $i++): ?>
      <span>&#starf;</span>
    <?php endfor; ?>
  </div>
</div>
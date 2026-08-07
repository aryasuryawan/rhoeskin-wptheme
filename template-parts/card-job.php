<?php if (!defined('ABSPATH')) exit;

$location = get_field('alya_job_location');
$type     = get_field('alya_job_type');
$featured = get_post_meta(get_the_ID(), 'alya_featured', true);
?>
<div class="card" style="cursor:pointer">
  <div class="p-body">
    <div class="tag">Karir</div>
    <h3><?php the_title(); ?></h3>
    <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 15)); ?></p>
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:12px">
      <?php if ($location): ?><span style="font-size:.8rem;background:var(--brand-soft);padding:4px 12px;border-radius:999px;color:var(--brand)"><?php echo esc_html($location); ?></span><?php endif; ?>
      <?php if ($type): ?><span style="font-size:.8rem;background:var(--brand-soft);padding:4px 12px;border-radius:999px;color:var(--brand)"><?php echo esc_html($type); ?></span><?php endif; ?>
    </div>
    <a href="<?php the_permalink(); ?>" class="link" style="margin-top:16px">
      Lihat Detail
      <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
    </a>
  </div>
</div>
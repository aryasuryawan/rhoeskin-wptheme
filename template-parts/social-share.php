<?php if (!defined('ABSPATH')) exit;

$enable = get_theme_mod('alya_share_enable', true);
if (!$enable) return;

$position = get_theme_mod('alya_share_position', 'top-and-bottom');
$style    = get_theme_mod('alya_share_style', 'icon-with-label');
$permalink = get_permalink();
$title     = get_the_title();
?>
<div class="social-share" style="margin-top:24px">
  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($permalink); ?>" target="_blank" rel="noopener" aria-label="Share on Facebook" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:999px;background:var(--brand-soft);color:var(--brand);font-size:.85rem;font-weight:600;transition:.25s;text-decoration:none">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
    <?php if ($style === 'icon-with-label'): ?>Facebook<?php endif; ?>
  </a>
  <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($permalink); ?>&text=<?php echo urlencode($title); ?>" target="_blank" rel="noopener" aria-label="Share on Twitter" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:999px;background:var(--brand-soft);color:var(--brand);font-size:.85rem;font-weight:600;transition:.25s;text-decoration:none">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
    <?php if ($style === 'icon-with-label'): ?>Twitter<?php endif; ?>
  </a>
  <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($title . ' ' . $permalink); ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:999px;background:var(--brand-soft);color:var(--brand);font-size:.85rem;font-weight:600;transition:.25s;text-decoration:none">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-.9-.3-.1-.5-.1-.7.2-.2.2-.7.9-.9 1.1-.2.2-.3.2-.6.1-1.3-.6-2.2-1.1-3-2.3-.2-.4.2-.4.6-1.1.1-.2 0-.3 0-.4s-.7-1.7-1-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-1.1 1.1-1.3 2.5-.3 4 .1.1 2.3 3.6 5.7 5.1a9 9 0 001.9.7c.8.3 1.5.2 2.1.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.5-.3zM12 21a9 9 0 01-7.7-4.4l-1.8.6 1-1.8A9 9 0 1112 21zm0-19.8C5.9 1.2 1 6 1 12c0 1.9.6 3.8 1.6 5.5L1 21l3.6-1a11 11 0 002.2 1.6A10.9 10.9 0 0012 23c6.1 0 11-4.9 11-11C23 6 18 1.2 12 1.2z"/></svg>
    <?php if ($style === 'icon-with-label'): ?>WhatsApp<?php endif; ?>
  </a>
  <a href="mailto:?subject=<?php echo urlencode($title); ?>&body=<?php echo urlencode($permalink); ?>" aria-label="Share via Email" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:999px;background:var(--brand-soft);color:var(--brand);font-size:.85rem;font-weight:600;transition:.25s;text-decoration:none">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
    <?php if ($style === 'icon-with-label'): ?>Email<?php endif; ?>
  </a>
</div>
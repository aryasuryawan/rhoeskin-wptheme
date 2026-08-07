<?php
/**
 * Single Promo Template — 100% matches promo/skin-booster-agustus.html
 *
 * @package Alya_Esthetic
 */

get_header();

while (have_posts()) : the_post();

$post_id = get_the_ID();
$data    = alya_promo_data($post_id);

$terms = get_the_terms($post_id, 'promo_category');
$cat_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Promo';
$cat_slug = ($terms && !is_wp_error($terms)) ? $terms[0]->slug : 'promo';

$hero_img = get_the_post_thumbnail_url($post_id, 'full');
if (!$hero_img) {
    $hero_img = get_template_directory_uri() . '/assets/images/treatments/glass-skin-facial.png';
}

$reading_time = max(1, ceil(str_word_count(strip_tags(get_the_content())) / 200));

$quickfacts = $data['quickfacts'];
if (empty($quickfacts)) {
    $quickfacts = [
        ['title' => '1x Sesi', 'description' => 'Durasi ± 45 menit'],
        ['title' => 'Semua Jenis Kulit', 'description' => 'Konsultasi dulu dengan dokter'],
        ['title' => 'Hasil Bertahap', 'description' => 'Terlihat sejak sesi pertama'],
    ];
}
$tnc  = $data['tnc'];
$faqs = $data['faqs'];
?>

<!-- ============ ARTICLE HEADER ============ -->
<div class="art-head">
  <div class="container">
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('promo')); ?>">Promo</a><span>/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('promo')); ?>" style="color:var(--brand)"><?php echo esc_html($cat_name); ?></a>
    </div>
    <span class="tag-pill promo"><?php echo esc_html($cat_name); ?></span>
    <h1><?php the_title(); ?></h1>
    <div class="art-meta">
      <?php if ($data['deadline']) : ?>
      <div class="meta-item urgent">
        <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 10.4l4 2.4-.8 1.3-4.7-2.8V6h1.5v6.4z"/></svg>
        Berlaku hingga <?php echo esc_html($data['deadline']); ?>
      </div>
      <?php endif; ?>
      <div class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg>
        Tim Alya Esthetic
      </div>
      <div class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M12 6v6l4 2-.8 1.6-5.2-2.6V6h2z"/></svg>
        <?php echo esc_html($reading_time); ?> menit baca
      </div>
    </div>

    <?php if ($data['price_old'] || $data['price_new']) : ?>
    <div class="promo-offerbar">
      <div class="price-block">
        <?php if ($data['price_old']) : ?>
          <span class="price-old"><?php echo esc_html($data['price_old']); ?></span>
        <?php endif; ?>
        <span class="price-new"><?php echo esc_html($data['price_new'] ?: $data['price_old']); ?></span>
        <?php if ($data['save_text']) : ?>
          <span class="save-tag"><?php echo esc_html($data['save_text']); ?></span>
        <?php endif; ?>
      </div>
      <div class="cta-block">
        <a class="btn btn--claim" href="<?php echo esc_url(alya_promo_wa_link($post_id, 'Halo, saya ingin klaim promo ' . get_the_title() . ' di Alya Esthetic Center.')); ?>" target="_blank" rel="noopener">Klaim via WhatsApp</a>
        <?php if ($data['slots']) : ?>
          <span class="quota">Kuota terbatas — <?php echo esc_html($data['slots']); ?></span>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($quickfacts)) : ?>
    <div class="promo-quickfacts">
      <?php foreach (array_slice($quickfacts, 0, 3) as $fact) : ?>
        <div class="fact"><b><?php echo esc_html($fact['title'] ?? ''); ?></b><span><?php echo esc_html($fact['description'] ?? ''); ?></span></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- ============ COVER ============ -->
<div class="art-cover">
  <div class="container" style="padding:34px 0 0;position:relative">
    <span class="promo-badge" style="position:absolute;top:14px;left:8%;background:#c0392b;color:#fff;font-size:.72rem;font-weight:700;letter-spacing:.05em;text-transform:uppercase;padding:6px 14px;border-radius:999px;z-index:2;box-shadow:0 8px 18px -8px rgba(192,57,43,.6)"><?php echo esc_html($data['ribbon'] ?: 'Promo Spesial'); ?></span>
    <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
  </div>
</div>

<!-- ============ ARTICLE BODY ============ -->
<section>
  <div class="art-layout">

    <!-- Share Rail -->
    <div class="share-rail">
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" aria-label="Bagikan ke Facebook">
        <svg viewBox="0 0 24 24"><path d="M13.5 22v-8h2.7l.4-3.1h-3.1V9c0-.9.2-1.5 1.6-1.5H17V4.7c-.3 0-1.3-.1-2.4-.1-2.4 0-4.1 1.5-4.1 4.2v2.1H8v3.1h2.5V22h3z"/></svg>
      </a>
      <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" rel="noopener" aria-label="Bagikan ke WhatsApp">
        <svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-.9-.3-.1-.5-.1-.7.2-.2.2-.7.9-.9 1.1-.2.2-.3.2-.6.1-1.3-.6-2.2-1.1-3-2.3-.2-.4.2-.4.6-1.1.1-.2 0-.3 0-.4s-.7-1.7-1-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-1.1 1.1-1.3 2.5-.3 4 .1.1 2.3 3.6 5.7 5.1a9 9 0 001.9.7c.8.3 1.5.2 2.1.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.5-.3zM12 21a9 9 0 01-7.7-4.4l-1.8.6 1-1.8A9 9 0 1112 21zm0-19.8C5.9 1.2 1 6 1 12c0 1.9.6 3.8 1.6 5.5L1 21l3.6-1a11 11 0 002.2 1.6A10.9 10.9 0 0012 23c6.1 0 11-4.9 11-11C23 6 18 1.2 12 1.2z"/></svg>
      </a>
      <a href="#" aria-label="Salin Tautan" id="copyLink">
        <svg viewBox="0 0 24 24"><path d="M3.9 12a4.1 4.1 0 014.1-4.1h4V6H8a6 6 0 000 12h4v-1.9H8A4.1 4.1 0 013.9 12zM12 13h5a4.1 4.1 0 000-8.2h-4V6.9h4a2.1 2.1 0 010 4.2h-5V13z"/></svg>
      </a>
    </div>

    <!-- Content -->
    <article class="art-content">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>

      <?php if (!empty($tnc)) : ?>
      <div class="callout tnc">
        <h4>
          <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 2 .8 3.6 1.7 5.1C8 15.9 9 18.4 9 21h6c0-2.6 1-5.1 2.3-6.9C18.2 12.6 19 11 19 9a7 7 0 00-7-7z"/></svg>
          Syarat &amp; Ketentuan
        </h4>
        <ul style="margin:0 0 0 18px;font-size:.92rem;color:var(--ink)">
          <?php foreach ($tnc as $item) : ?>
            <li><?php echo esc_html($item['text'] ?? ''); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <?php if (!empty($faqs)) : ?>
      <h2>Pertanyaan Umum</h2>
      <?php foreach ($faqs as $idx => $faq) : ?>
        <?php if (!empty($faq['question'])) : ?>
          <h3><?php echo esc_html($faq['question']); ?></h3>
          <p><?php echo esc_html($faq['answer'] ?? ''); ?></p>
        <?php endif; ?>
      <?php endforeach; ?>
      <?php endif; ?>

      <div class="tags-row">
        <a href="<?php echo esc_url(get_post_type_archive_link('promo')); ?>">Promo</a>
        <a href="<?php echo esc_url(get_post_type_archive_link('promo')); ?>"><?php echo esc_html($cat_name); ?></a>
      </div>
    </article>

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="side-box promo-summary">
        <h4>Ringkasan Promo</h4>
        <?php if ($data['price_old']) : ?><span class="price-old"><?php echo esc_html($data['price_old']); ?></span><?php endif; ?>
        <span class="price-new"><?php echo esc_html($data['price_new'] ?: $data['price_old']); ?></span>
        <?php if ($data['deadline']) : ?>
        <div class="fact-row"><span>Berlaku hingga</span><span><?php echo esc_html($data['deadline']); ?></span></div>
        <?php endif; ?>
        <?php if ($data['code']) : ?>
        <div class="fact-row"><span>Kode promo</span><span><?php echo esc_html($data['code']); ?></span></div>
        <?php endif; ?>
        <?php if ($data['slots']) : ?>
        <div class="fact-row"><span>Kuota</span><span><?php echo esc_html($data['slots']); ?></span></div>
        <?php endif; ?>
        <a class="btn" href="<?php echo esc_url(alya_promo_wa_link($post_id, 'Halo, saya ingin klaim promo ' . get_the_title() . ' di Alya Esthetic Center.')); ?>" target="_blank" rel="noopener">Klaim Sekarang</a>
      </div>

      <div class="side-box">
        <h4>Promo Lainnya</h4>
        <?php
        $other = new WP_Query([
            'post_type'      => 'promo',
            'posts_per_page' => 3,
            'post__not_in'   => [$post_id],
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
        if ($other->have_posts()) :
            while ($other->have_posts()) : $other->the_post();
                $o_id  = get_the_ID();
                $o_img = get_the_post_thumbnail_url($o_id, 'thumbnail');
                if (!$o_img) {
                    $o_img = get_template_directory_uri() . '/assets/images/treatments/skin-booster.png';
                }
        ?>
            <div class="popular-item">
              <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($o_img); ?>" alt=""></a>
              <div><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5><span class="date"><?php echo esc_html(alya_promo_data($o_id)['days_left']); ?></span></div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
      </div>

      <div class="side-box cta-box">
        <h4>Ada Pertanyaan?</h4>
        <p>Tim kami siap bantu jawab pertanyaan seputar promo ini via WhatsApp.</p>
        <a class="btn" href="<?php echo esc_url(alya_wa_link('Halo, saya ingin bertanya seputar promo di Alya Esthetic Center.')); ?>" target="_blank" rel="noopener">Hubungi Kami</a>
      </div>
    </aside>

  </div>
</section>

<!-- ============ PROMO LAINNYA ============ -->
<?php
$related = new WP_Query([
    'post_type'      => 'promo',
    'posts_per_page' => 3,
    'post__not_in'   => [$post_id],
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

if ($related->have_posts()) :
?>
<section class="related">
  <div class="container">
    <div class="related__head">
      <span class="eyebrow" style="color:#c0392b">Jangan Lewatkan</span>
      <h2>Promo Lainnya Bulan Ini</h2>
    </div>
    <div class="related__grid">
      <?php while ($related->have_posts()) : $related->the_post();
        $rel_id  = get_the_ID();
        $rel_img = get_the_post_thumbnail_url($rel_id, 'medium_large');
        if (!$rel_img) {
            $rel_img = get_template_directory_uri() . '/assets/images/treatments/skin-booster.png';
        }
        $rel_terms = get_the_terms($rel_id, 'promo_category');
        $rel_cat   = ($rel_terms && !is_wp_error($rel_terms)) ? $rel_terms[0]->name : 'Promo';
      ?>
        <a class="post-card" href="<?php the_permalink(); ?>">
          <img src="<?php echo esc_url($rel_img); ?>" alt="<?php the_title_attribute(); ?>">
          <div class="p-body">
            <span class="tag" style="color:#c0392b"><?php echo esc_html($rel_cat); ?></span>
            <h3><?php the_title(); ?></h3>
          </div>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ STICKY CTA (mobile) ============ -->
<?php if ($data['price_old'] || $data['price_new']) : ?>
<div class="promo-sticky-cta">
  <div>
    <?php if ($data['price_old']) : ?><span class="price-old"><?php echo esc_html($data['price_old']); ?></span><?php endif; ?>
    <span class="price-new"><?php echo esc_html($data['price_new'] ?: $data['price_old']); ?></span>
  </div>
  <a class="btn" href="<?php echo esc_url(alya_promo_wa_link($post_id, 'Halo, saya ingin klaim promo ' . get_the_title() . ' di Alya Esthetic Center.')); ?>" target="_blank" rel="noopener">Klaim</a>
</div>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>

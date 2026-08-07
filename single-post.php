<?php
/**
 * Single Post Template — 100% matches artikel-single.html
 *
 * @package Alya_Esthetic
 */

get_header();

while (have_posts()) : the_post();

$post_id       = get_the_ID();
$hero_img      = get_the_post_thumbnail_url($post_id, 'full');
$date          = get_the_date('j F Y');
$author_id     = get_the_author_meta('ID');
$author_name   = get_the_author();
$author_bio    = get_the_author_meta('description');
$author_avatar = get_avatar_url($author_id, ['size' => 96]);
if (!$author_avatar || strpos($author_avatar, 'gravatar') !== false) {
    $author_avatar = 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png';
}
$reading_time = max(1, ceil(str_word_count(strip_tags(get_the_content())) / 200));

$cats     = get_the_category();
$cat_name = !empty($cats) ? $cats[0]->name : 'Skin Serenity';
$cat_link = !empty($cats) ? get_category_link($cats[0]->term_id) : home_url('/blog/');
?>

<!-- ============ ARTICLE HEADER ============ -->
<div class="art-head">
  <div class="container">
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span>
      <a href="<?php echo esc_url(home_url('/blog/')); ?>">Artikel</a><span>/</span>
      <a href="<?php echo esc_url($cat_link); ?>" style="color:var(--brand)"><?php echo esc_html($cat_name); ?></a>
    </div>
    <?php if ($cat_name) : ?>
      <span class="tag-pill"><?php echo esc_html($cat_name); ?></span>
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <div class="art-meta">
      <div class="author">
        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
        <div>
          <b><?php echo esc_html($author_name); ?></b>
          <span>Aesthetic Doctor</span>
        </div>
      </div>
      <div class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg>
        <?php echo esc_html($date); ?>
      </div>
      <div class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-2a7 7 0 110-14 7 7 0 010 14zm.5-10.5v5l4.3 2.5-.7 1.2-5-3V10z"/></svg>
        <?php echo esc_html($reading_time); ?> menit baca
      </div>
    </div>
  </div>
</div>

<!-- ============ COVER ============ -->
<?php if ($hero_img) : ?>
<div class="art-cover">
  <div class="container" style="padding:34px 0 0">
    <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
  </div>
</div>
<?php endif; ?>

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

      <?php
      $tags = get_the_tags();
      if ($tags) :
      ?>
        <div class="tags-row">
          <?php foreach ($tags as $tag) : ?>
            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"><?php echo esc_html($tag->name); ?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="author-box">
        <img src="<?php echo esc_url($author_avatar); ?>" alt="<?php echo esc_attr($author_name); ?>">
        <div>
          <h4><?php echo esc_html($author_name); ?></h4>
          <span>Aesthetic Doctor · Alya Esthetic Center</span>
          <p><?php echo esc_html($author_bio ?: 'Berpengalaman menangani berbagai kasus perawatan kulit dan estetika, dengan fokus pada pendekatan personal dan berbasis kebutuhan tiap pasien.'); ?></p>
        </div>
      </div>
    </article>

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="side-box">
        <h4>Artikel Populer</h4>
        <?php
        $popular = new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => 3,
            'meta_key'            => 'post_views_count',
            'orderby'             => 'meta_value_num',
            'order'               => 'DESC',
            'post__not_in'        => [$post_id],
            'ignore_sticky_posts' => true,
        ]);

        if (!$popular->have_posts()) {
            $popular = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'post__not_in'   => [$post_id],
            ]);
        }

        if ($popular->have_posts()) :
            while ($popular->have_posts()) : $popular->the_post();
                $pop_img = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                if (!$pop_img) {
                    $pop_img = get_template_directory_uri() . '/assets/images/treatments/glass-skin-facial.png';
                }
        ?>
            <div class="popular-item">
              <a href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_url($pop_img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
              </a>
              <div>
                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <span class="date"><?php echo esc_html(get_the_date('j M Y')); ?></span>
              </div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
      </div>

      <div class="side-box cta-box">
        <h4>Konsultasi Gratis</h4>
        <p>Punya pertanyaan seputar perawatan kulit? Chat langsung dengan tim dokter kami di WhatsApp.</p>
        <a class="btn" href="<?php echo esc_url(alya_wa_link('Halo, saya ingin konsultasi gratis seputar artikel kulit.')); ?>" target="_blank" rel="noopener">Hubungi Kami</a>
      </div>
    </aside>

  </div>
</section>

<!-- ============ RELATED POSTS ============ -->
<?php
$related_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [$post_id],
    'orderby'        => 'rand',
]);

if ($related_query->have_posts()) :
?>
<section class="related">
  <div class="container">
    <div class="related__head">
      <span class="eyebrow">Rekomendasi</span>
      <h2>Artikel Terkait</h2>
    </div>
    <div class="related__grid">
      <?php while ($related_query->have_posts()) : $related_query->the_post();
        $rel_img = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
        if (!$rel_img) {
            $rel_img = 'https://alyaesthetic.id/wp-content/uploads/2025/11/DSCF5148-scaled-e1762063528772.jpg';
        }
        $rel_cats = get_the_category();
        $rel_cat  = !empty($rel_cats) ? $rel_cats[0]->name : 'Artikel';
      ?>
        <a href="<?php the_permalink(); ?>" class="post-card">
          <img src="<?php echo esc_url($rel_img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
          <div class="p-body">
            <span class="tag"><?php echo esc_html($rel_cat); ?></span>
            <h3><?php the_title(); ?></h3>
          </div>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>

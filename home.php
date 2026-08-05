<?php
/**
 * Home / Blog List Template — matches artikel.html
 *
 * @package Alya_Esthetic
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$current_cat = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$current_tag = isset($_GET['tag']) ? sanitize_text_field($_GET['tag']) : '';
$current_search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

$args = [
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'post_status'    => 'publish',
];

if ($current_cat) {
    $args['category_name'] = $current_cat;
}
if ($current_tag) {
    $args['tag'] = $current_tag;
}
if ($current_search) {
    $args['s'] = $current_search;
}

$query = new WP_Query($args);

$all_categories = get_categories([
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
]);

$all_tags = get_tags([
    'hide_empty' => true,
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => 20,
]);
?>

<!-- PAGEHEAD -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow">Blog &amp; Edukasi</span>
    <h1>Artikel Kecantikan Terbaru</h1>
    <p style="color:var(--ink-light);max-width:600px;margin-top:8px">Tips perawatan kulit, panduan treatment, dan berita terbaru dari Alya Esthetic Center oleh para dokter spesialis kami.</p>

    <!-- SEARCH -->
    <form class="searchbox" method="get" action="<?php echo esc_url(home_url('/')); ?>" style="margin-top:24px">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" fill="none" stroke="currentColor" stroke-width="2"/><line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="2"/></svg>
      <input type="search" name="s" placeholder="Cari artikel, tips, treatment…" value="<?php echo esc_attr($current_search); ?>">
      <button type="submit" class="btn btn--brand">Cari</button>
    </form>
  </div>
</div>

<!-- FILTER -->
<section style="padding:32px 0 0">
  <div class="container">
    <div class="filterbar">
      <div class="chips">
        <a href="<?php echo esc_url(remove_query_arg('category')); ?>" class="chip <?php echo !$current_cat ? 'is-active' : ''; ?>">Semua</a>
        <?php foreach ($all_categories as $cat) : ?>
        <a href="<?php echo esc_url(add_query_arg('category', $cat->slug)); ?>" class="chip <?php echo $current_cat === $cat->slug ? 'is-active' : ''; ?>">
          <?php echo esc_html($cat->name); ?>
        </a>
        <?php endforeach; ?>
      </div>
    </div>

    <?php if ($current_tag) : ?>
    <div style="margin-top:16px;display:flex;align-items:center;gap:8px">
      <span style="font-size:.86rem;color:var(--ink-light)">Tag: <strong><?php echo esc_html($current_tag); ?></strong></span>
      <a href="<?php echo esc_url(remove_query_arg('tag')); ?>" style="font-size:.8rem;color:var(--brand);text-decoration:none">Hapus ×</a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ARTICLES GRID -->
<section class="section">
  <div class="container">
    <?php if ($query->have_posts()) : ?>
    <div class="art-grid">
      <?php while ($query->have_posts()) : $query->the_post();
        $art_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
        $cats = get_the_category();
        $cat_name = !empty($cats) ? $cats[0]->name : '';
      ?>
      <a href="<?php the_permalink(); ?>" class="post-card">
        <div class="post-card__img">
          <?php if ($art_img) : ?>
            <img src="<?php echo esc_url($art_img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
          <?php endif; ?>
          <?php if ($cat_name) : ?>
            <span class="post-card__cat"><?php echo esc_html($cat_name); ?></span>
          <?php endif; ?>
        </div>
        <div class="post-card__body">
          <span class="post-card__tag"><?php echo esc_html(get_the_date('d M Y')); ?></span>
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 16)); ?></p>
        </div>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>

    <!-- PAGINATION -->
    <?php if ($query->max_num_pages > 1) : ?>
    <nav style="margin-top:48px;display:flex;justify-content:center">
      <ul style="display:flex;gap:8px;list-style:none;padding:0;margin:0">
        <?php
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        for ($i = 1; $i <= $query->max_num_pages; $i++) :
          $is_active = $i === $paged;
        ?>
        <li>
          <a href="<?php echo esc_url(add_query_arg('paged', $i)); ?>"
             style="display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:10px;font-weight:600;font-size:.9rem;text-decoration:none;transition:all .2s;
             <?php echo $is_active ? 'background:var(--brand);color:#fff' : 'background:var(--bg-alt);color:var(--ink);border:1px solid var(--line)'; ?>"
             <?php echo $is_active ? 'aria-current="page"' : ''; ?>>
            <?php echo $i; ?>
          </a>
        </li>
        <?php endfor; ?>
      </ul>
    </nav>
    <?php endif; ?>

    <?php else : ?>
    <div style="text-align:center;padding:80px 0">
      <svg viewBox="0 0 24 24" width="48" height="48" style="fill:var(--line);margin-bottom:16px"><path d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
      <h3 style="margin-bottom:8px;color:var(--ink)">Artikel tidak ditemukan</h3>
      <p style="color:var(--ink-light)">Coba kata kunci lain atau lihat semua artikel kami.</p>
      <a href="<?php echo esc_url(remove_query_arg(['s', 'category', 'tag'])); ?>" class="btn btn--brand" style="margin-top:16px">Lihat Semua Artikel</a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- CTA -->
<section class="cta-band">
  <div class="container">
    <div class="cta-band__inner">
      <div>
        <h2>Mau Tampil Cantik Alami?</h2>
        <p>Konsultasikan kebutuhan treatment kulit &amp; kecantikan Anda bersama dokter spesialis kami. Konsultasi online gratis — chat sekarang.</p>
      </div>
      <a href="https://api.whatsapp.com/send?phone=6281290000000&text=Halo%20Alya%20Esthetic%2C%20saya%20ingin%20konsultasi" class="btn btn--white">Chat Sekarang</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>

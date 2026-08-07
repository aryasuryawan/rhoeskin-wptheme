<?php
/**
 * Archive Promo Template — 100% matches promo/index.html
 *
 * @package Alya_Esthetic
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

$query = new WP_Query([
    'post_type'      => 'promo',
    'posts_per_page' => 10,
    'paged'          => $paged,
    'post_status'    => 'publish',
]);

$promo_terms = get_terms([
    'taxonomy'   => 'promo_category',
    'hide_empty' => false,
]);
if (is_wp_error($promo_terms)) {
    $promo_terms = [];
}
?>

<!-- ============ PAGE HEADER (Promo hero) ============ -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow2">&#128293; Promo Terbatas</span>
    <h1>Promo &amp; Penawaran Spesial Bulan Ini</h1>
    <p>Kumpulan penawaran khusus treatment kecantikan dan wellness dari Alya Esthetic Center. Diskon berlaku untuk waktu dan kuota terbatas — klaim sebelum kehabisan.</p>
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span><a href="<?php echo esc_url(get_post_type_archive_link('promo')); ?>" style="color:#fff">Promo</a>
    </div>
    <div class="pagehead-stats">
      <div class="stat"><b><?php echo esc_html($query->found_posts ?: 3); ?></b><span>Promo Aktif</span></div>
      <div class="stat"><b>s.d. 20%</b><span>Diskon Treatment</span></div>
      <div class="stat"><b><?php echo esc_html(date_i18n('F')); ?></b><span>Periode Berjalan</span></div>
    </div>
  </div>
</div>

<!-- ============ FILTER BAR ============ -->
<div class="filterbar">
  <div class="container">
    <div class="chips">
      <button class="chip active" data-filter="semua">Semua Promo</button>
      <?php foreach ($promo_terms as $term) : ?>
        <button class="chip" data-filter="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></button>
      <?php endforeach; ?>
    </div>
    <div class="searchbox">
      <svg viewBox="0 0 24 24"><path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 10-.7.7l.3.3v.8l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/></svg>
      <input type="text" id="searchInput" placeholder="Cari promo...">
    </div>
  </div>
</div>

<!-- ============ PROMO LIST ============ -->
<section class="promolist">
  <div class="container promolist__layout">
    <div>
      <div class="promo-grid" id="promoGrid">
        <?php if ($query->have_posts()) : ?>
          <?php while ($query->have_posts()) : $query->the_post();
            $post_id = get_the_ID();
            $data    = alya_promo_data($post_id);

            $terms = get_the_terms($post_id, 'promo_category');
            $cat_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Promo';
            $cats_slugs = '';
            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $t) {
                    $cats_slugs .= $t->slug . ' ';
                }
            }
            $cats_slugs = trim($cats_slugs);

            $img = get_the_post_thumbnail_url($post_id, 'medium_large');
            if (!$img) {
                $img = get_template_directory_uri() . '/assets/images/treatments/glass-skin-facial.png';
            }
            $ribbon = $data['ribbon'] ?: 'Promo Spesial';
          ?>
            <div class="promo-item" data-cat="<?php echo esc_attr($cats_slugs); ?>">
              <div class="thumb">
                <span class="ribbon"><?php echo esc_html($ribbon); ?></span>
                <img src="<?php echo esc_url($img); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
              </div>
              <div class="p-body">
                <span class="tag"><?php echo esc_html($cat_name); ?></span>
                <h3><?php the_title(); ?></h3>
                <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                <?php if ($data['price_old'] || $data['price_new']) : ?>
                <div class="price-row">
                  <?php if ($data['price_old']) : ?><span class="price-old"><?php echo esc_html($data['price_old']); ?></span><?php endif; ?>
                  <?php if ($data['price_new']) : ?><span class="price-new"><?php echo esc_html($data['price_new']); ?></span><?php endif; ?>
                </div>
                <?php endif; ?>
                <div class="meta-row">
                  <?php if ($data['deadline']) : ?>
                  <span>
                    <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 10.4l4 2.4-.8 1.3-4.7-2.8V6h1.5v6.4z"/></svg>
                    <?php echo esc_html('Hingga ' . $data['deadline']); ?>
                  </span>
                  <?php endif; ?>
                  <?php if ($data['slots']) : ?>
                  <span>
                    <svg viewBox="0 0 24 24"><path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3zM8 11c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    <?php echo esc_html($data['slots']); ?>
                  </span>
                  <?php endif; ?>
                </div>
                <?php if ($data['quota'] > 0) : ?>
                <div class="quota-bar"><i style="width:<?php echo esc_attr(min(100, $data['quota'])); ?>%"></i></div>
                <?php endif; ?>
                <div class="promo-actions">
                  <a class="btn btn--claim" href="<?php echo esc_url(alya_promo_wa_link($post_id, 'Halo, saya ingin klaim promo ' . get_the_title() . '.')); ?>" target="_blank" rel="noopener">Klaim via WhatsApp</a>
                  <a class="btn btn--detail" href="<?php the_permalink(); ?>">Lihat Detail</a>
                </div>
              </div>
            </div>
          <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
          <p style="color:var(--muted);padding:40px 0;text-align:center">Belum ada promo aktif saat ini. Nantikan penawaran spesial berikutnya!</p>
        <?php endif; ?>
      </div>

      <?php if ($query->max_num_pages > 1) : ?>
        <div class="pagination">
          <?php
          echo paginate_links([
              'prev_text' => '&laquo;',
              'next_text' => '&raquo;',
              'type'      => 'plain',
              'mid_size'  => 1,
              'total'     => $query->max_num_pages,
              'current'   => $paged,
          ]);
          ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- ============ SIDEBAR ============ -->
    <aside class="sidebar">
      <div class="side-box">
        <h4>Segera Berakhir</h4>
        <?php
        $ending = new WP_Query([
            'post_type'      => 'promo',
            'posts_per_page' => 3,
            'meta_key'       => 'alya_promo_deadline',
            'orderby'        => 'meta_value',
            'order'          => 'ASC',
        ]);
        if ($ending->have_posts()) :
            while ($ending->have_posts()) : $ending->the_post();
                $end_id  = get_the_ID();
                $end_img = get_the_post_thumbnail_url($end_id, 'thumbnail');
                if (!$end_img) {
                    $end_img = get_template_directory_uri() . '/assets/images/treatments/slimming-injection.png';
                }
        ?>
            <div class="ending-item">
              <img src="<?php echo esc_url($end_img); ?>" alt="">
              <div><h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5><span class="days-left"><?php echo esc_html(alya_promo_data($end_id)['days_left']); ?></span></div>
            </div>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
      </div>

      <div class="side-box">
        <h4>Kategori Promo</h4>
        <div class="tagcloud">
          <?php if (!empty($promo_terms)) : ?>
            <?php foreach ($promo_terms as $term) : ?>
              <a href="<?php echo esc_url(get_term_link($term)); ?>"><?php echo esc_html($term->name); ?></a>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>

      <div class="side-box cta-box">
        <h4>Tanya Promo</h4>
        <p>Bingung pilih promo yang cocok? Chat tim kami, kami bantu rekomendasikan.</p>
        <a class="btn" href="<?php echo esc_url(alya_wa_link('Halo, saya ingin bertanya seputar promo di Alya Esthetic Center.')); ?>" target="_blank" rel="noopener">Hubungi Kami</a>
      </div>
    </aside>
  </div>
</section>

<?php get_footer(); ?>

<?php
/**
 * Home / Blog List Template — 100% matches artikel.html
 *
 * @package Alya_Esthetic
 */

get_header();

$paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

$args = [
    'post_type'      => 'post',
    'posts_per_page' => 7,
    'paged'          => $paged,
    'post_status'    => 'publish',
];

$query = new WP_Query($args);
?>

<!-- ============ PAGE HEADER ============ -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow" style="color:#efd9c8">Blog Alya Esthetic</span>
    <h1>Artikel &amp; Tips Kecantikan</h1>
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
      <span>/</span>
      <a href="<?php echo esc_url(home_url('/blog/')); ?>" style="color:#fff">Artikel</a>
    </div>
  </div>
</div>

<!-- ============ FILTER BAR ============ -->
<div class="filterbar">
  <div class="container">
    <div class="chips">
      <button class="chip active" data-filter="semua">Semua</button>
      <?php
      $categories = get_categories(['orderby' => 'name', 'order' => 'ASC']);
      if (!empty($categories) && !is_wp_error($categories)) :
          foreach ($categories as $cat) :
      ?>
          <button class="chip" data-filter="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
      <?php
          endforeach;
      endif;
      ?>
    </div>
    <div class="searchbox">
      <svg viewBox="0 0 24 24"><path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 10-.7.7l.3.3v.8l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/></svg>
      <input type="text" id="searchInput" placeholder="Cari artikel...">
    </div>
  </div>
</div>

<!-- ============ BLOG LIST ============ -->
<section class="blog">
  <div class="container blog__layout">
    <div>
      <div class="blog__grid" id="blogGrid">
        <?php if ($query->have_posts()) : ?>
          <?php
          $post_count = 0;
          while ($query->have_posts()) : $query->the_post();
              $post_count++;
              $is_featured = ($post_count === 1 && $paged == 1);
              $post_cats   = get_the_category();
              $cat_name    = !empty($post_cats) ? $post_cats[0]->name : 'Perawatan Kulit';
              $cats_slugs  = '';
              if (!empty($post_cats)) {
                  foreach ($post_cats as $c) {
                      $cats_slugs .= $c->slug . ' ';
                  }
              }
              $cats_slugs = trim($cats_slugs);
              $img_url    = get_the_post_thumbnail_url(get_the_ID(), 'large');
              if (!$img_url) {
                  $img_url = 'https://alyaesthetic.id/wp-content/uploads/2025/11/DSCF5148-scaled-e1762063528772.jpg';
              }
          ?>
            <a class="post-card <?php echo $is_featured ? 'featured' : ''; ?>" data-cat="<?php echo esc_attr($cats_slugs); ?>" href="<?php the_permalink(); ?>">
              <div class="thumb">
                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
              </div>
              <div class="p-body">
                <span class="tag"><?php echo esc_html($cat_name); ?></span>
                <h3><?php the_title(); ?></h3>
                <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), $is_featured ? 26 : 16)); ?></p>
                <div class="p-meta">
                  <span>
                    <svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg>
                    <?php echo esc_html(get_the_author()); ?>
                  </span>
                  <span>
                    <svg viewBox="0 0 24 24"><path d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-2a7 7 0 110-14 7 7 0 010 14zm.5-10.5v5l4.3 2.5-.7 1.2-5-3V10z"/></svg>
                    <?php echo esc_html(get_the_date('j M Y')); ?>
                  </span>
                </div>
              </div>
            </a>
          <?php endwhile; wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>

      <div class="empty-state" id="emptyState" style="display:none;padding:40px 0;text-align:center">
        <p style="color:var(--muted)">Tidak ada artikel yang cocok dengan pencarian Anda.</p>
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
        <h4>Artikel Populer</h4>
        <?php
        $popular = new WP_Query([
            'post_type'           => 'post',
            'posts_per_page'      => 3,
            'meta_key'            => 'post_views_count',
            'orderby'             => 'meta_value_num',
            'order'               => 'DESC',
            'ignore_sticky_posts' => true,
        ]);

        if (!$popular->have_posts()) {
            $popular = new WP_Query([
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
        }

        if ($popular->have_posts()) :
            while ($popular->have_posts()) : $popular->the_post();
                $pop_img = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                if (!$pop_img) {
                    $pop_img = 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png';
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

      <div class="side-box">
        <h4>Kategori</h4>
        <div class="tagcloud">
          <?php
          $all_cats = get_categories(['orderby' => 'count', 'order' => 'DESC']);
          if (!empty($all_cats) && !is_wp_error($all_cats)) :
              foreach ($all_cats as $cat) :
          ?>
              <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
          <?php
              endforeach;
          endif;
          ?>
        </div>
      </div>

      <div class="side-box cta-box">
        <h4>Konsultasi Gratis</h4>
        <p>Punya pertanyaan seputar perawatan kulit? Chat langsung dengan tim dokter kami di WhatsApp.</p>
        <a class="btn" href="<?php echo esc_url(alya_wa_link('Halo, saya ingin konsultasi gratis seputar artikel kulit.')); ?>" target="_blank" rel="noopener">Hubungi Kami</a>
      </div>
    </aside>
  </div>
</section>

<?php get_footer(); ?>

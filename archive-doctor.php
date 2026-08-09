<?php
/**
 * Doctor Archive Template — Rhoé Skin Center
 *
 * @package Alya_Esthetic
 */

get_header();

$per_page = 9;
$paged    = get_query_var('paged', 1) ?: 1;

// Query featured doctors (hanya di page 1)
$featured_doctors = [];
$featured_count = 0;
if ($paged === 1) {
    $featured_query = new WP_Query([
        'post_type'      => 'doctor',
        'posts_per_page' => -1,
        'meta_query'     => [
            [
                'key'   => 'alya_is_featured',
                'value' => '1',
            ],
        ],
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    ]);
    if ($featured_query->have_posts()) {
        $featured_doctors = $featured_query->posts;
        $featured_count = count($featured_doctors);
    }
    wp_reset_postdata();
}

// Query regular doctors
$regular_per_page = $per_page - $featured_count;
$regular_offset = ($paged - 1) * $per_page;

// Di page 1, offset 0 tapi sudah dikurangi featured
// Di page 2+, offset normal
if ($paged === 1) {
    $regular_offset = 0;
} else {
    $regular_offset = ($paged - 1) * $per_page - $featured_count;
}

$regular_query = new WP_Query([
    'post_type'      => 'doctor',
    'posts_per_page' => $regular_per_page,
    'offset'         => max(0, $regular_offset),
    'meta_query'     => [
        'relation' => 'OR',
        [
            'key'     => 'alya_is_featured',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key'     => 'alya_is_featured',
            'value'   => '1',
            'compare' => '!=',
        ],
    ],
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]);

// Merge doctors: featured di awal (page 1), regular sisanya
$all_doctors = array_merge($featured_doctors, $regular_query->posts);

// Hitung total pages (featured + regular)
$total_regular = $regular_query->found_posts;
$total_all = $featured_count + $total_regular;
$max_pages = ceil($total_all / $per_page);

// Create fake WP_Query object untuk compatibility
$doctors = new stdClass();
$doctors->posts = $all_doctors;
$doctors->post_count = count($all_doctors);
$doctors->max_num_pages = $max_pages;
?>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="container">
    <span class="eyebrow"><?php echo esc_html(get_theme_mod('alya_doctors_eyebrow', 'Tim Ahli Kami')); ?></span>
    <h1>Dokter Profesional &amp;<br>Berpengalaman</h1>
    <p><?php echo esc_html(get_theme_mod('alya_doctors_desc', 'Setiap dokter di Rhoé Skin Center berkomitmen memberikan perawatan terbaik yang personal, aman, dan efektif untuk kecantikan Anda.')); ?></p>
  </div>
</div>

<!-- FILTER BAR -->
<div class="filter-bar" id="doctorFilterBar">
  <div class="container">
    <div class="filter-bar__inner">

      <!-- Tab filter -->
      <div class="filter-tabs" id="doctorTabs">
        <button class="tab active" data-filter="all">Semua Dokter</button>
        <button class="tab" data-filter="skin">Skin Care</button>
        <button class="tab" data-filter="aesthetic">Aesthetic</button>
        <button class="tab" data-filter="slimming">Slimming &amp; Wellness</button>
      </div>

      <!-- Search by name -->
      <div class="doctor-search">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 19.6l-4.9-4.9A7.5 7.5 0 103.4 14a7.5 7.5 0 0010.3.7l4.9 4.9 2.4-2zm-13.5-3a5.5 5.5 0 110-11 5.5 5.5 0 010 11z"/></svg>
        <input
          type="search"
          id="doctorSearch"
          placeholder="Cari nama dokter…"
          autocomplete="off"
          aria-label="Cari nama dokter"
        >
      </div>

    </div>
  </div>
</div>

<!-- DOCTORS GRID -->
<section style="padding:0">
  <div class="container">

    <!-- Grid — konten di-replace AJAX -->
    <div class="doctors-grid" id="doctorsGrid">
      <?php
      if (!empty($all_doctors)) :
        foreach ($all_doctors as $post) :
          setup_postdata($post);
          $post_id   = $post->ID;
          $avatar    = get_field('alya_avatar', $post_id);
          $position  = get_field('alya_position', $post_id) ?: get_field('alya_specialist', $post_id) ?: 'Aesthetic Doctor';
          $specialty = get_field('alya_specialty', $post_id) ?: 'skin aesthetic';
          $is_featured = get_field('alya_is_featured', $post_id);
          $featured  = get_field('alya_featured', $post_id) ?: '';
          $exp_years = get_field('alya_experience_years', $post_id) ?: get_field('alya_exp_years', $post_id) ?: '10+ tahun';
          $location  = get_field('alya_location', $post_id) ?: 'Jakarta Selatan';
          $excerpt   = has_excerpt($post_id) ? get_the_excerpt($post_id) : 'Dokter spesialis berpengalaman yang siap membantu kebutuhan perawatan dan kecantikan Anda.';

          $img_url = '';
          if ($avatar && is_array($avatar) && isset($avatar['url'])) {
              $img_url = $avatar['url'];
          } elseif (has_post_thumbnail($post_id)) {
              $img_url = get_the_post_thumbnail_url($post_id, 'medium_large');
          } else {
              $img_url = get_template_directory_uri() . '/assets/images/placeholder-doctor-rhoeskin.webp';
          }
      ?>
        <article class="doc-card<?php echo $is_featured ? ' doc-card--featured' : ''; ?>" data-cat="<?php echo esc_attr($specialty); ?>" onclick="location.href='<?php echo esc_url(get_permalink($post_id)); ?>'">
          <div class="doc-card__img">
            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>" loading="lazy">
            <?php if ($is_featured) : ?>
              <span class="doc-badge doc-badge--archive" title="Featured Doctor">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              </span>
            <?php elseif ($featured) : ?>
              <span class="doc-card__badge"><?php echo esc_html($featured); ?></span>
            <?php endif; ?>
          </div>
          <div class="doc-card__body">
            <h3><?php echo get_the_title($post_id); ?></h3>
            <p class="spec"><?php echo esc_html($position); ?></p>
            <p><?php echo esc_html(wp_trim_words($excerpt, 18)); ?></p>
            <div class="doc-card__meta">
              <span>
                <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-5h2v5zm0-7H11V7h2v2z"/></svg>
                <?php echo esc_html($exp_years); ?>
              </span>
              <span>
                <svg viewBox="0 0 24 24"><path d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/></svg>
                <?php echo esc_html($location); ?>
              </span>
            </div>
            <div class="doc-card__actions">
              <a href="<?php echo get_permalink($post_id); ?>" class="btn btn--outline">Lihat Profil</a>
              <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="btn">Buat Janji</a>
            </div>
          </div>
        </article>
      <?php endforeach; wp_reset_postdata(); ?>
      <?php else : ?>
        <p class="doctors-empty">Belum ada dokter yang ditampilkan.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="doctors-pagination" id="doctorsPagination">
      <?php
      if ($doctors && $doctors->max_num_pages > 1) :
          alya_pagination($doctors);
      endif;
      ?>
    </div>

  </div>
</section>

<!-- CTA BAND -->
<div class="cta-band">
  <div class="container">
    <h2><?php echo esc_html(get_theme_mod('alya_doctors_cta_title', 'Konsultasikan Kebutuhan Kecantikan Anda')); ?></h2>
    <p><?php echo esc_html(get_theme_mod('alya_doctors_cta_desc', 'Tim dokter kami siap membantu Anda menemukan program perawatan yang paling tepat dan personal.')); ?></p>
    <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="btn">Buat Janji Sekarang</a>
  </div>
</div>

<?php get_footer(); ?>

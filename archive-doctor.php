<?php
/**
 * Doctor Archive Template — Rhoé Skin Center
 *
 * @package Alya_Esthetic
 */

get_header();

$per_page = 9;
$paged    = get_query_var('paged', 1) ?: 1;

$doctors = alya_get_posts('doctor', [
    'posts_per_page' => $per_page,
    'paged'          => $paged,
]);
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
      if ($doctors && $doctors->have_posts()) :
        while ($doctors->have_posts()) : $doctors->the_post();
          $post_id   = get_the_ID();
          $avatar    = get_field('alya_avatar');
          $position  = get_field('alya_position') ?: get_field('alya_specialist') ?: 'Aesthetic Doctor';
          $specialty = get_field('alya_specialty') ?: 'skin aesthetic';
          $featured  = get_field('alya_featured') ?: '';
          $exp_years = get_field('alya_experience_years') ?: get_field('alya_exp_years') ?: '10+ tahun';
          $location  = get_field('alya_location') ?: 'Jakarta Selatan';
          $excerpt   = get_the_excerpt() ?: 'Dokter spesialis berpengalaman yang siap membantu kebutuhan perawatan dan kecantikan Anda.';

          $img_url = '';
          if ($avatar && is_array($avatar) && isset($avatar['url'])) {
              $img_url = $avatar['url'];
          } elseif (has_post_thumbnail()) {
              $img_url = get_the_post_thumbnail_url($post_id, 'medium_large');
          } else {
              $img_url = get_template_directory_uri() . '/assets/images/placeholder-doctor-rhoeskin.webp';
          }
      ?>
        <article class="doc-card" data-cat="<?php echo esc_attr($specialty); ?>" onclick="location.href='<?php echo esc_url(get_permalink()); ?>'">
          <div class="doc-card__img">
            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
            <?php if ($featured) : ?>
              <span class="doc-card__badge"><?php echo esc_html($featured); ?></span>
            <?php endif; ?>
          </div>
          <div class="doc-card__body">
            <h3><?php the_title(); ?></h3>
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
              <a href="<?php the_permalink(); ?>" class="btn btn--outline">Lihat Profil</a>
              <a href="<?php echo esc_url(home_url('/kontak')); ?>" class="btn">Buat Janji</a>
            </div>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
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

<?php
/**
 * Doctor Archive Template — 100% matches dokter.html
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<!-- PAGE HERO -->
<div class="page-hero">
  <div class="container">
    <span class="eyebrow"><?php echo esc_html(get_theme_mod('alya_doctors_eyebrow', 'Tim Ahli Kami')); ?></span>
    <h1>Dokter Profesional &amp;<br>Berpengalaman</h1>
    <p><?php echo esc_html(get_theme_mod('alya_doctors_desc', 'Setiap dokter di Alya Esthetic Center berkomitmen memberikan perawatan terbaik yang personal, aman, dan efektif untuk kecantikan Anda.')); ?></p>
  </div>
</div>

<!-- FILTER BAR -->
<div class="filter-bar">
  <div class="container">
    <div class="filter-tabs">
      <button class="tab active" data-filter="all">Semua Dokter</button>
      <button class="tab" data-filter="skin">Skin Care</button>
      <button class="tab" data-filter="aesthetic">Aesthetic</button>
      <button class="tab" data-filter="slimming">Slimming &amp; Wellness</button>
    </div>
  </div>
</div>

<!-- DOCTORS GRID -->
<section style="padding:0">
  <div class="container">
    <div class="doctors-grid">
      <?php
      $doctors = alya_get_posts('doctor', ['posts_per_page' => -1]);
      if ($doctors && $doctors->have_posts()) :
        while ($doctors->have_posts()) : $doctors->the_post();
          $post_id   = get_the_ID();
          $avatar    = get_field('alya_avatar');
          $position  = get_field('alya_position') ?: get_field('alya_specialist') ?: 'Aesthetic Doctor';
          $specialty = get_field('alya_specialty') ?: 'skin aesthetic';
          $featured  = get_field('alya_featured') ?: 'Skin & Aesthetic';
          $exp_years = get_field('alya_experience_years') ?: get_field('alya_exp_years') ?: '10+ tahun';
          $location  = get_field('alya_location') ?: 'Jakarta Selatan';
          $excerpt   = get_the_excerpt() ?: 'Dokter spesialis berpengalaman yang siap membantu kebutuhan perawatan dan kecantikan Anda.';

          $img_url = '';
          if ($avatar && is_array($avatar) && isset($avatar['url'])) {
              $img_url = $avatar['url'];
          } elseif (has_post_thumbnail()) {
              $img_url = get_the_post_thumbnail_url($post_id, 'medium_large');
          } else {
              $img_url = 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png';
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
      <?php endif; ?>
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

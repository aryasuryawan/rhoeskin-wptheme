<?php
/**
 * Single Jobs Template — 100% matches karir-detail.html
 *
 * @package Alya_Esthetic
 */

get_header();

while (have_posts()) : the_post();

$post_id    = get_the_ID();
$cat_terms  = get_the_terms($post_id, 'career_category');
$cat_name   = ($cat_terms && !is_wp_error($cat_terms)) ? $cat_terms[0]->name : 'Medis';
$cat_slug   = ($cat_terms && !is_wp_error($cat_terms)) ? $cat_terms[0]->slug : 'medis';

$type_terms = get_the_terms($post_id, 'job_type');
$type_name  = ($type_terms && !is_wp_error($type_terms)) ? $type_terms[0]->name : 'Full-time';

$location         = get_field('alya_location') ?: 'Jakarta Selatan';
$experience       = get_field('alya_experience') ?: '1-3 Tahun Pengalaman';
$deadline         = get_field('alya_deadline') ?: '30 September 2026';
$salary           = get_field('alya_salary') ?: 'Kompetitif + Tunjangan';
$requirements     = get_field('alya_requirements');
$responsibilities = get_field('alya_responsibilities');
$benefits         = get_field('alya_job_benefits');
$apply_link       = get_field('alya_apply_link');

$wa_msg  = 'Halo HR Alya Esthetic, saya ingin melamar posisi *' . get_the_title() . '*.';
$wa_link = $apply_link ?: alya_wa_link($wa_msg);
$career_archive = get_post_type_archive_link('jobs') ?: home_url('/karir/');
?>

<!-- ============ JOB HEADER ============ -->
<div class="art-head">
  <div class="container">
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span>
      <a href="<?php echo esc_url($career_archive); ?>">Karir</a><span>/</span>
      <a href="<?php echo esc_url($career_archive); ?>" style="color:var(--brand)"><?php echo esc_html($cat_name); ?></a>
    </div>
    <?php if ($cat_name) : ?>
      <span class="tag-pill"><?php echo esc_html($cat_name); ?></span>
    <?php endif; ?>
    <?php if ($type_name) : ?>
      <span class="tag-pill type"><?php echo esc_html($type_name); ?></span>
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <div class="art-meta">
      <div class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
        <?php echo esc_html($location); ?>
      </div>
      <div class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M12 6v6l4 2-.8 1.6-5.2-2.6V6h2z"/></svg>
        <?php echo esc_html($experience); ?>
      </div>
      <div class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg>
        Batas lamaran: <?php echo esc_html($deadline); ?>
      </div>
    </div>
  </div>
</div>

<!-- ============ JOB BODY ============ -->
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

      <?php if ($requirements) : ?>
        <h2>Kualifikasi &amp; Persyaratan</h2>
        <div class="job-section-body">
          <?php echo wp_kses_post($requirements); ?>
        </div>
      <?php endif; ?>

      <?php if ($responsibilities) : ?>
        <h2>Tanggung Jawab Pekerjaan</h2>
        <div class="job-section-body">
          <?php echo wp_kses_post($responsibilities); ?>
        </div>
      <?php endif; ?>

      <?php if ($benefits) : ?>
        <h2>Benefit &amp; Fasilitas</h2>
        <div class="job-section-body">
          <?php echo wp_kses_post($benefits); ?>
        </div>
      <?php endif; ?>

      <div class="apply-box">
        <div>
          <h4>Tertarik dengan posisi ini?</h4>
          <p>Kirimkan CV dan portofolio Anda melalui WhatsApp, tim HR kami akan segera menghubungi Anda.</p>
        </div>
        <a class="btn" href="<?php echo esc_url($wa_link); ?>" target="_blank" rel="noopener">Lamar Sekarang</a>
      </div>

      <div class="tags-row">
        <?php if ($cat_name) : ?>
          <a href="<?php echo esc_url($career_archive); ?>"><?php echo esc_html($cat_name); ?></a>
        <?php endif; ?>
        <?php if ($type_name) : ?>
          <a href="<?php echo esc_url($career_archive); ?>"><?php echo esc_html($type_name); ?></a>
        <?php endif; ?>
        <a href="<?php echo esc_url($career_archive); ?>"><?php echo esc_html($location); ?></a>
      </div>
    </article>

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="side-box">
        <h4>Info Lowongan</h4>
        <div class="info-list">
          <?php if ($cat_name) : ?>
            <div class="row"><span>Departemen</span><span><?php echo esc_html($cat_name); ?></span></div>
          <?php endif; ?>
          <div class="row"><span>Lokasi</span><span><?php echo esc_html($location); ?></span></div>
          <?php if ($type_name) : ?>
            <div class="row"><span>Tipe Kerja</span><span><?php echo esc_html($type_name); ?></span></div>
          <?php endif; ?>
          <div class="row"><span>Pengalaman</span><span><?php echo esc_html($experience); ?></span></div>
          <?php if ($salary) : ?>
            <div class="row"><span>Gaji</span><span><?php echo esc_html($salary); ?></span></div>
          <?php endif; ?>
          <div class="row"><span>Batas Lamaran</span><span><?php echo esc_html($deadline); ?></span></div>
        </div>
      </div>

      <div class="side-box cta-box">
        <h4>Lamar Posisi Ini</h4>
        <p>Kirimkan CV Anda sekarang dan bergabung bersama tim Alya Esthetic Center.</p>
        <a class="btn" href="<?php echo esc_url($wa_link); ?>" target="_blank" rel="noopener">Lamar via WhatsApp</a>
      </div>
    </aside>

  </div>
</section>

<!-- ============ RELATED JOBS ============ -->
<?php
$related_jobs = alya_get_posts('jobs', ['posts_per_page' => 3, 'post__not_in' => [$post_id]]);
if ($related_jobs && $related_jobs->have_posts()) :
?>
<section class="related">
  <div class="container">
    <div class="related__head">
      <span class="eyebrow">Lowongan Lain</span>
      <h2>Posisi yang Mungkin Sesuai</h2>
    </div>
    <div class="related__grid">
      <?php while ($related_jobs->have_posts()) : $related_jobs->the_post();
        $r_id = get_the_ID();
        $r_cat_terms = get_the_terms($r_id, 'career_category');
        $r_cat_name = ($r_cat_terms && !is_wp_error($r_cat_terms)) ? $r_cat_terms[0]->name : 'Medis';
        $r_type_terms = get_the_terms($r_id, 'job_type');
        $r_type_name = ($r_type_terms && !is_wp_error($r_type_terms)) ? $r_type_terms[0]->name : 'Full-time';
        $r_location = get_field('alya_location', $r_id) ?: 'Jakarta Selatan';
      ?>
        <a href="<?php the_permalink(); ?>" class="job-card">
          <div class="job-card__top">
            <span class="tag"><?php echo esc_html($r_cat_name); ?></span>
            <span class="job-type"><?php echo esc_html($r_type_name); ?></span>
          </div>
          <h3><?php the_title(); ?></h3>
          <div class="job-meta">
            <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
            <?php echo esc_html($r_location); ?>
          </div>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
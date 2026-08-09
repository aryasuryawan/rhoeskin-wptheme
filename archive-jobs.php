<?php
/**
 * Jobs Archive Template — 100% matches karir.html
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<!-- ============ PAGE HEADER ============ -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow" style="color:#efd9c8">Bergabung Bersama Kami</span>
    <h1>Karir di Rhoé Skin Center</h1>
    <p class="lead">Jadi bagian dari tim yang membantu banyak orang tampil lebih percaya diri. Kami mencari individu yang berdedikasi, ramah, dan ingin terus berkembang di industri kecantikan &amp; kesehatan.</p>
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('jobs')); ?>" style="color:#fff">Karir</a>
    </div>
  </div>
</div>

<!-- ============ WHY JOIN US ============ -->
<section class="values">
  <div class="container center" style="max-width:640px">
    <span class="eyebrow">Kenapa Rhoé Skin</span>
    <h2>Lingkungan Kerja yang Suportif</h2>
    <p class="lead">Kami percaya tim yang sejahtera dan terus belajar adalah kunci memberikan pelayanan terbaik untuk pasien.</p>
  </div>
  <div class="container">
    <div class="value-grid">
      <div class="value-card">
        <div class="ic">
          <svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg>
        </div>
        <h4>Tim yang Kolaboratif</h4>
        <p>Budaya kerja yang saling mendukung antar tim medis dan non-medis.</p>
      </div>
      <div class="value-card">
        <div class="ic">
          <svg viewBox="0 0 24 24"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"/></svg>
        </div>
        <h4>Pengembangan Karir</h4>
        <p>Pelatihan berkala dan jenjang karir yang jelas untuk setiap posisi.</p>
      </div>
      <div class="value-card">
        <div class="ic">
          <svg viewBox="0 0 24 24"><path d="M12 2l2.4 7.2H22l-6 4.7 2.3 7.1-6.3-4.6-6.3 4.6 2.3-7.1-6-4.7h7.6z"/></svg>
        </div>
        <h4>Benefit Kompetitif</h4>
        <p>Gaji, tunjangan, dan fasilitas perawatan yang menarik bagi karyawan.</p>
      </div>
      <div class="value-card">
        <div class="ic">
          <svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg>
        </div>
        <h4>Keseimbangan Kerja</h4>
        <p>Jadwal kerja yang teratur dengan perhatian pada kesejahteraan karyawan.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ FILTER BAR ============ -->
<div class="filterbar">
  <div class="container">
    <div class="chips">
      <button class="chip active" data-career-category="semua">Semua</button>
      <?php
      $categories = get_terms(['taxonomy' => 'career_category', 'hide_empty' => false]);
      if (!is_wp_error($categories) && !empty($categories)) :
          foreach ($categories as $cat) :
      ?>
          <button class="chip" data-career-category="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
      <?php
          endforeach;
      endif;
      ?>
    </div>
    <div class="searchbox">
      <svg viewBox="0 0 24 24"><path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 10-.7.7l.3.3v.8l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/></svg>
      <input type="text" placeholder="Cari posisi...">
    </div>
  </div>
</div>

<!-- ============ JOB LISTING ============ -->
<section class="jobs">
  <div class="container jobs__layout">
    <div>
      <div class="jobs-list" id="jobsGrid">
        <?php
        $jobs_query = alya_get_posts('jobs', ['posts_per_page' => -1]);
        if ($jobs_query && $jobs_query->have_posts()) :
            while ($jobs_query->have_posts()) : $jobs_query->the_post();
                $post_id    = get_the_ID();
                $cat_terms  = get_the_terms($post_id, 'career_category');
                $cat_name   = ($cat_terms && !is_wp_error($cat_terms)) ? $cat_terms[0]->name : 'Umum';
                $cat_slug   = ($cat_terms && !is_wp_error($cat_terms)) ? $cat_terms[0]->slug : 'semua';
                
                $type_terms = get_the_terms($post_id, 'job_type');
                $type_name  = ($type_terms && !is_wp_error($type_terms)) ? $type_terms[0]->name : 'Full-time';

                $location = get_field('alya_location') ?: 'Jakarta Selatan';
                $deadline = get_field('alya_deadline') ?: '30 September 2026';
        ?>
            <a class="job-card" data-cat="<?php echo esc_attr($cat_slug); ?>" href="<?php the_permalink(); ?>">
              <div class="job-card__main">
                <div class="job-card__top">
                  <span class="tag"><?php echo esc_html($cat_name); ?></span>
                  <span class="job-type"><?php echo esc_html($type_name); ?></span>
                </div>
                <h3><?php the_title(); ?></h3>
                <div class="job-meta">
                  <span>
                    <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
                    <?php echo esc_html($location); ?>
                  </span>
                  <span>
                    <svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg>
                    Batas lamaran: <?php echo esc_html($deadline); ?>
                  </span>
                </div>
              </div>
              <span class="job-card__cta">
                Lihat Detail
                <svg viewBox="0 0 24 24"><path d="M8.6 4.6L14 10H3v4h11l-5.4 5.4L11 22l9-9-9-9z"/></svg>
              </span>
            </a>
        <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
      </div>

      <div class="empty-state" id="emptyJobsState">
        <h4>Tidak ada posisi yang sesuai.</h4>
        <p>Silakan coba pencarian posisi atau kategori departemen lain.</p>
      </div>
    </div>

    <!-- ============ SIDEBAR ============ -->
    <aside class="sidebar">
      <div class="side-box">
        <h4>Proses Rekrutmen</h4>
        <div class="step-item">
          <span class="num">1</span>
          <div>
            <h5>Kirim Lamaran</h5>
            <p>Pilih posisi yang sesuai dan kirimkan CV serta portofolio Anda.</p>
          </div>
        </div>
        <div class="step-item">
          <span class="num">2</span>
          <div>
            <h5>Seleksi Berkas</h5>
            <p>Tim HR kami akan meninjau kualifikasi dan pengalaman Anda.</p>
          </div>
        </div>
        <div class="step-item">
          <span class="num">3</span>
          <div>
            <h5>Wawancara &amp; Tes</h5>
            <p>Sesi wawancara tatap muka atau online bersama tim HR &amp; User.</p>
          </div>
        </div>
        <div class="step-item">
          <span class="num">4</span>
          <div>
            <h5>Onboarding</h5>
            <p>Selamat bergabung! Anda akan mengikuti sesi induksi dan pelatihan.</p>
          </div>
        </div>
      </div>

      <div class="side-box cta-box">
        <h4>Tidak Menemukan Posisi yang Pas?</h4>
        <p>Tetap kirimkan CV Anda. Kami akan menghubungi Anda jika ada posisi yang sesuai di masa depan.</p>
        <a class="btn" href="<?php echo esc_url(alya_wa_link('Halo HR Rhoé Skin, saya ingin mengirimkan Open Application CV.')); ?>" target="_blank" rel="noopener">Kirim Open Application</a>
      </div>
    </aside>
  </div>
</section>

<?php get_footer(); ?>

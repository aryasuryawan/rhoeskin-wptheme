<?php
/**
 * Single Doctor Template — 100% matches dokter-single.html
 *
 * @package Alya_Esthetic
 */

get_header();

while (have_posts()) : the_post();

$post_id   = get_the_ID();
$position  = get_field('alya_position') ?: get_field('alya_specialist') ?: 'Aesthetic Doctor';
$specialty = get_field('alya_specialty') ?: 'Skin Care & Aesthetic';
$featured  = get_field('alya_featured') ?: 'Skin & Aesthetic';
$avatar    = get_field('alya_avatar');

$img_url = '';
if ($avatar && is_array($avatar) && isset($avatar['url'])) {
    $img_url = $avatar['url'];
} elseif (has_post_thumbnail()) {
    $img_url = get_the_post_thumbnail_url($post_id, 'full');
} else {
    $img_url = 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png';
}

$about = get_field('alya_about') ?: get_field('alya_bio') ?: get_the_excerpt();
if (!$about) {
    $about = 'Dokter spesialis berpengalaman di Alya Esthetic Center yang berdedikasi memberikan perawatan kulit dan estetika yang personal, aman, dan berteknologi tinggi.';
}

// Stats
$stats_raw = get_field('alya_stats');
$stats = is_array($stats_raw) ? $stats_raw : alya_parse_stats($stats_raw);
if (empty($stats)) {
    $stats = [
        ['number' => '10+', 'label' => 'Tahun Pengalaman'],
        ['number' => '1000+', 'label' => 'Pasien Puas'],
        ['number' => '15+', 'label' => 'Sertifikasi International'],
    ];
}

// Education & Experience
$education  = alya_parse_table(get_field('alya_education'));
if (empty($education)) {
    $education = [
        ['year' => '2010 - 2016', 'title' => 'Dokter Spesialis Kulit & Kelamin', 'institution' => 'Universitas Indonesia'],
        ['year' => '2004 - 2010', 'title' => 'Sarjana Kedokteran', 'institution' => 'Universitas Indonesia'],
    ];
}

$experience = alya_parse_table(get_field('alya_experience'));
if (empty($experience)) {
    $experience = [
        ['year' => '2018 - Sekarang', 'title' => 'Head Doctor & Aesthetic Specialist', 'institution' => 'Alya Esthetic Center'],
        ['year' => '2016 - 2018', 'title' => 'Spesialis Dermatologi', 'institution' => 'RS Kanker Dharmais'],
    ];
}

$certifications = alya_parse_table(get_field('alya_certifications'));
if (empty($certifications)) {
    $certifications = [
        ['title' => 'Certified Botox & Filler Injector', 'institution' => 'American Academy of Aesthetic Medicine'],
        ['title' => 'Laser & Energy Based Device Certification', 'institution' => 'International Society of Dermatology'],
        ['title' => 'Advanced Thread Lift Technique', 'institution' => 'Korean Aesthetic Surgery Society'],
        ['title' => 'Skin Rejuvenation & Chemical Peeling', 'institution' => 'Asian Dermatological Association'],
    ];
}

// Schedules
$schedules = alya_parse_schedule(get_field('alya_schedule'));
if (empty($schedules)) {
    $schedules = [
        ['day' => 'Senin - Rabu', 'time' => '10.00 - 18.00', 'status' => 'Tersedia'],
        ['day' => 'Kamis', 'time' => '10.00 - 15.00', 'status' => 'Tersedia'],
        ['day' => 'Jumat - Sabtu', 'time' => '10.00 - 18.00', 'status' => 'Tersedia'],
        ['day' => 'Minggu', 'time' => 'Dengan Perjanjian', 'status' => 'Konfirmasi'],
    ];
}
?>

<!-- ============ BREADCRUMB ============ -->
<div class="breadcrumb">
  <div class="container">
    <div class="breadcrumb-inner">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
      <svg viewBox="0 0 24 24"><path d="M8.6 4.6L14 10H3v4h11l-5.4 5.4L11 22l9-9-9-9z"/></svg>
      <a href="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>">Dokter</a>
      <svg viewBox="0 0 24 24"><path d="M8.6 4.6L14 10H3v4h11l-5.4 5.4L11 22l9-9-9-9z"/></svg>
      <span><?php the_title(); ?></span>
    </div>
  </div>
</div>

<!-- ============ DOCTOR PROFILE HERO ============ -->
<section class="doc-hero">
  <div class="container">
    <div class="doc-hero__grid">

      <div class="doc-hero__photo">
        <div class="doc-hero__photo-wrap">
          <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
        </div>
        <div class="doc-hero__badges">
          <?php if ($featured) : ?>
            <span class="badge-pill"><?php echo esc_html($featured); ?></span>
          <?php endif; ?>
          <span class="badge-pill"><?php echo esc_html($position); ?></span>
        </div>
        <div class="doc-hero__actions">
          <a href="#booking" class="btn">Buat Janji Sekarang</a>
          <a href="<?php echo esc_url(alya_wa_link('Halo, saya ingin konsultasi dengan ' . get_the_title() . '.')); ?>"
             class="btn btn--outline" target="_blank" rel="noopener">
            Tanya via WhatsApp
          </a>
        </div>
      </div>

      <div class="doc-hero__info">
        <span class="eyebrow">Profil Dokter</span>
        <h1><?php the_title(); ?></h1>
        <p class="spec"><?php echo esc_html($position); ?></p>

        <p><?php echo esc_html($about); ?></p>
        <?php if (get_the_content()) : ?>
          <div class="doc-bio-full" style="margin-bottom:20px">
            <?php the_content(); ?>
          </div>
        <?php endif; ?>

        <div class="stats-row">
          <?php foreach ($stats as $st) : ?>
            <div class="stat">
              <b><?php echo esc_html($st['number'] ?? ''); ?></b>
              <span><?php echo esc_html($st['label'] ?? ''); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ============ EDUCATION & EXPERIENCE ============ -->
<section class="doc-section">
  <div class="container">
    <div class="doc-section__grid">

      <div class="doc-section__col">
        <h2>Pendidikan</h2>
        <ul class="exp-list">
          <?php foreach ($education as $edu) : ?>
            <li class="exp-item">
              <span class="yr"><?php echo esc_html($edu['year'] ?? ''); ?></span>
              <div class="detail">
                <b><?php echo esc_html($edu['title'] ?? ''); ?></b>
                <span><?php echo esc_html($edu['institution'] ?? ''); ?></span>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="doc-section__col">
        <h2>Pengalaman</h2>
        <ul class="exp-list">
          <?php foreach ($experience as $exp) : ?>
            <li class="exp-item">
              <span class="yr"><?php echo esc_html($exp['year'] ?? ''); ?></span>
              <div class="detail">
                <b><?php echo esc_html($exp['title'] ?? ''); ?></b>
                <span><?php echo esc_html($exp['institution'] ?? ''); ?></span>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

    </div>

    <?php if (!empty($certifications)) : ?>
      <div class="doc-certs" style="margin-top:40px">
        <h2>Sertifikasi &amp; Pelatihan</h2>
        <div class="cert-grid">
          <?php foreach ($certifications as $cert) : ?>
            <div class="cert-item">
              <svg viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
              <div>
                <b><?php echo esc_html($cert['title'] ?? ''); ?></b>
                <span><?php echo esc_html($cert['institution'] ?? ''); ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- ============ RELATED TREATMENTS ============ -->
<?php
$related_treatments = alya_get_posts('treatment', ['posts_per_page' => 3]);
if ($related_treatments && $related_treatments->have_posts()) :
?>
<section class="rel-treatments">
  <div class="container">
    <div class="rel-head">
      <div>
        <span class="eyebrow">Treatment Terkait</span>
        <h2>Layanan yang Ditangani</h2>
      </div>
      <a href="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>">
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;fill:var(--brand);margin-right:4px"><path d="M8.6 4.6L14 10H3v4h11l-5.4 5.4L11 22l9-9-9-9z"/></svg>
        Kembali ke Semua Dokter
      </a>
    </div>
    <div class="treat-cards">
      <?php while ($related_treatments->have_posts()) : $related_treatments->the_post();
        $t_id = get_the_ID();
        $t_img = get_the_post_thumbnail_url($t_id, 'medium_large') ?: get_template_directory_uri() . '/assets/images/treatments/glass-skin-facial.png';
      ?>
        <a href="<?php the_permalink(); ?>" class="t-card">
          <img src="<?php echo esc_url($t_img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
          <div class="t-body">
            <h4><?php the_title(); ?></h4>
            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 12)); ?></p>
            <span>Selengkapnya &rarr;</span>
          </div>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ SCHEDULE & BOOKING SECTION ============ -->
<section class="booking-section" id="booking">
  <div class="container">
    <div class="booking-grid">

      <div>
        <h2>Jadwal Praktik</h2>
        <p style="color:var(--muted);margin-bottom:20px">Jadwal dapat berubah sewaktu-waktu. Disarankan melakukan konfirmasi sebelum kedatangan.</p>
        <table class="schedule-table">
          <thead>
            <tr>
              <th>Hari</th>
              <th>Jam Praktik</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($schedules as $sch) : ?>
              <tr>
                <td class="day"><?php echo esc_html($sch['day'] ?? ''); ?></td>
                <td><?php echo esc_html($sch['time'] ?? ''); ?></td>
                <td><span class="avail"><?php echo esc_html($sch['status'] ?? 'Tersedia'); ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="form">
        <h3>Buat Janji Konsultasi</h3>
        <p class="sub">Isi formulir di bawah ini untuk memesan jadwal konsultasi bersama dokter.</p>
        
        <div class="field">
          <label for="docNama">Nama Lengkap</label>
          <input id="docNama" type="text" placeholder="Nama Anda">
        </div>
        <div class="field">
          <label for="docWA">No. WhatsApp</label>
          <input id="docWA" type="tel" placeholder="08xx-xxxx-xxxx">
        </div>
        <div class="field">
          <label for="docLayanan">Layanan yang Diinginkan</label>
          <select id="docLayanan">
            <option value="Konsultasi umum">Konsultasi Umum</option>
            <option value="Skin Serenity">Skin Serenity</option>
            <option value="Beauty Advance">Beauty Advance</option>
            <option value="Slimming & Wellness">Slimming &amp; Wellness</option>
            <option value="Alya Beauty Bar">Alya Beauty Bar</option>
          </select>
        </div>
        <div class="field">
          <label for="docTanggal">Tanggal Konsultasi</label>
          <input id="docTanggal" type="date">
        </div>
        <div class="field">
          <label for="docPesan">Catatan (Opsional)</label>
          <textarea id="docPesan" placeholder="Keluhan atau pertanyaan Anda..."></textarea>
        </div>
        <button class="btn" id="docBookBtn" type="button">Kirim via WhatsApp</button>
      </div>

    </div>
  </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>

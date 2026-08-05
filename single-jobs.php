<?php
/**
 * Single Job Template — Karir Detail
 *
 * @package Alya_Esthetic
 */

get_header();

while (have_posts()) : the_post();

$cat = get_post_meta(get_the_ID(), '_job_category', true) ?: 'medis';
$type = get_post_meta(get_the_ID(), '_job_type', true) ?: 'Full-time';
$location = get_post_meta(get_the_ID(), '_job_location', true) ?: 'Jakarta Selatan';
$experience = get_post_meta(get_the_ID(), '_job_experience', true) ?: '1-2 tahun';
$deadline = get_post_meta(get_the_ID(), '_job_deadline', true) ?: '30 Sep 2026';
$cat_label = ucfirst(str_replace('-', ' ', $cat));
$karir_url = '';
$pages = get_posts(['post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => -1]);
foreach ($pages as $p) {
    if (stripos($p->post_title, 'Karir') !== false) { $karir_url = get_permalink($p->ID); break; }
}

$share_url = get_permalink();
$share_title = urlencode(get_the_title());
?>

<!-- ============ ARTICLE HEAD ============ -->
<div class="art-head">
  <div class="container">
    <span class="tag-pill"><?php echo esc_html($cat_label); ?></span>
    <span class="tag-pill type"><?php echo esc_html($type); ?></span>
    <h1><?php the_title(); ?></h1>
    <div class="art-meta">
      <span class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
        <?php echo esc_html($location); ?>
      </span>
      <span class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 5v5.6l4.5 2.7-.9 1.5-5.6-3.3V7h2z"/></svg>
        Pengalaman: <?php echo esc_html($experience); ?>
      </span>
      <span class="meta-item">
        <svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg>
        Batas lamaran: <?php echo esc_html($deadline); ?>
      </span>
    </div>
  </div>
</div>

<!-- ============ ARTICLE LAYOUT ============ -->
<div class="art-layout" style="padding:40px 0">

  <!-- Share Rail -->
  <div class="share-rail">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" aria-label="Facebook">
      <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
    </a>
    <a href="https://wa.me/?text=<?php echo $share_title . '%20' . urlencode($share_url); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
      <svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-.9-.3-.1-.5-.1-.7.2-.2.2-.7.9-.9 1.1-.2.2-.3.2-.6.1-1.3-.6-2.2-1.1-3-2.3-.2-.4.2-.4.6-1.1.1-.2 0-.3 0-.4s-.7-1.7-1-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-1.1 1.1-1.3 2.5-.3 4 .1.1 2.3 3.6 5.7 5.1a9 9 0 001.9.7c.8.3 1.5.2 2.1.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.5-.3zM12 21a9 9 0 01-7.7-4.4l-1.8.6 1-1.8A9 9 0 1112 21zm0-19.8C5.9 1.2 1 6 1 12c0 1.9.6 3.8 1.6 5.5L1 21l3.6-1a11 11 0 002.2 1.6A10.9 10.9 0 0012 23c6.1 0 11-4.9 11-11C23 6 18 1.2 12 1.2z"/></svg>
    </a>
    <a href="#" onclick="navigator.clipboard.writeText(window.location.href);return false;" aria-label="Copy link">
      <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
    </a>
  </div>

  <!-- Article Content -->
  <div class="art-content">
    <?php the_content(); ?>

    <!-- Callout -->
    <div class="callout">
      <h4>
        <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm1 5v5.6l4.5 2.7-.9 1.5-5.6-3.3V7h2z"/></svg>
        Tertarik Bergabung?
      </h4>
      <p>Kirimkan CV dan portofolio Anda melalui WhatsApp. Tim HR kami akan segera merespon.</p>
    </div>

    <!-- Apply Box -->
    <div class="apply-box">
      <div>
        <h4>Siap Melamar?</h4>
        <p>Kirim CV Anda langsung via WhatsApp untuk proses lebih cepat.</p>
      </div>
      <a class="btn" href="https://wa.me/6281290000000?text=Halo,%20saya%20tertarik%20melamar%20posisi%20<?php echo urlencode(get_the_title()); ?>" target="_blank" rel="noopener">Lamar via WhatsApp</a>
    </div>

    <!-- Tags Row -->
    <div class="tags-row">
      <a href="<?php echo esc_url($karir_url); ?>">Karir</a>
      <a href="#"><?php echo esc_html($cat_label); ?></a>
      <a href="#"><?php echo esc_html($type); ?></a>
      <a href="#"><?php echo esc_html($location); ?></a>
    </div>
  </div>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="side-box">
      <h4>Info Lowongan</h4>
      <div class="info-list">
        <div class="row"><span>Departemen</span><span><?php echo esc_html($cat_label); ?></span></div>
        <div class="row"><span>Lokasi</span><span><?php echo esc_html($location); ?></span></div>
        <div class="row"><span>Tipe</span><span><?php echo esc_html($type); ?></span></div>
        <div class="row"><span>Pengalaman</span><span><?php echo esc_html($experience); ?></span></div>
        <div class="row"><span>Batas Lamaran</span><span><?php echo esc_html($deadline); ?></span></div>
      </div>
    </div>

    <div class="side-box cta-box">
      <h4>Butuh Bantuan?</h4>
      <p>Hubungi kami jika ada pertanyaan seputar lowongan ini.</p>
      <a class="btn" href="https://wa.me/6281290000000?text=Halo,%20saya%20ingin%20bertanya%20tentang%20lowongan" target="_blank" rel="noopener">Tanya via WhatsApp</a>
    </div>

    <?php
    $other_jobs = get_posts(['post_type' => 'jobs', 'posts_per_page' => 3, 'post_status' => 'publish', 'exclude' => [get_the_ID()]]);
    if ($other_jobs) :
    ?>
    <div class="side-box">
      <h4>Lowongan Lain</h4>
      <?php foreach ($other_jobs as $oj) :
        $oj_cat = get_post_meta($oj->ID, '_job_category', true) ?: 'medis';
        $oj_type = get_post_meta($oj->ID, '_job_type', true) ?: 'Full-time';
      ?>
        <div class="popular-item">
          <div>
            <a href="<?php echo get_permalink($oj->ID); ?>"><h5><?php echo esc_html($oj->post_title); ?></h5></a>
            <span class="date"><?php echo esc_html(ucfirst(str_replace('-', ' ', $oj_cat))) . ' · ' . esc_html($oj_type); ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </aside>
</div>

<!-- ============ RELATED JOBS ============ -->
<?php
$related_jobs = get_posts(['post_type' => 'jobs', 'posts_per_page' => 3, 'post_status' => 'publish', 'exclude' => [get_the_ID()]]);
if ($related_jobs) :
?>
<section class="related">
  <div class="container">
    <div class="related__head">
      <span class="eyebrow">Lowongan Lainnya</span>
      <h2>Posisi Tersedia Lainnya</h2>
    </div>
    <div class="related__grid">
      <?php foreach ($related_jobs as $rj) :
        $rj_cat = get_post_meta($rj->ID, '_job_category', true) ?: 'medis';
        $rj_type = get_post_meta($rj->ID, '_job_type', true) ?: 'Full-time';
        $rj_location = get_post_meta($rj->ID, '_job_location', true) ?: 'Jakarta Selatan';
        $rj_deadline = get_post_meta($rj->ID, '_job_deadline', true) ?: '30 Sep 2026';
        $rj_cat_label = ucfirst(str_replace('-', ' ', $rj_cat));
      ?>
        <a class="job-card" href="<?php echo get_permalink($rj->ID); ?>">
          <div class="job-card__main">
            <div class="job-card__top">
              <span class="tag"><?php echo esc_html($rj_cat_label); ?></span>
              <span class="job-type"><?php echo esc_html($rj_type); ?></span>
            </div>
            <h3><?php echo esc_html($rj->post_title); ?></h3>
            <div class="job-meta">
              <span><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg> <?php echo esc_html($rj_location); ?></span>
              <span><svg viewBox="0 0 24 24"><path d="M7 2h2v2h6V2h2v2h3v18H2V4h3V2zm13 8H4v10h16V10z"/></svg> Batas: <?php echo esc_html($rj_deadline); ?></span>
            </div>
          </div>
          <span class="job-card__cta">Lihat Detail <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>

<?php
/**
 * Single Testimonial Template
 *
 * @package Alya_Esthetic
 */

get_header();

while (have_posts()) : the_post();

$name     = get_the_title();
$content  = get_the_content();
$avatar   = get_the_post_thumbnail(get_the_ID(), 'alya-thumb');
$rating   = get_field('alya_rating') ?: 5;
$role     = get_field('alya_role') ?: '';
$service  = get_field('alya_service_used') ?: '';
$before   = get_field('alya_before');
$after    = get_field('alya_after');
$archive  = get_post_type_archive_link('testimonial');
?>

<!-- HERO -->
<section class="page-hero page-hero--bg">
  <div class="page-hero__bg"></div>
  <div class="container">
    <span class="eyebrow eyebrow--light">Testimoni</span>
    <h1>Cerita dari Sahabat Alya</h1>
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
      <span>/</span>
      <a href="<?php echo esc_url($archive); ?>">Testimoni</a>
      <span>/</span>
      <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html($name); ?></a>
    </div>
  </div>
</section>

<!-- CONTENT -->
<section>
  <div class="art-layout">
    <div class="share-rail">
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink()); ?>" target="_blank" rel="noopener" aria-label="Facebook"><?php echo alya_icon('facebook'); ?></a>
      <a href="https://wa.me/?text=<?php echo esc_url(get_permalink()); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?php echo alya_icon('whatsapp'); ?></a>
      <a href="#" aria-label="Salin tautan" id="copyLink"><?php echo alya_icon('link'); ?></a>
    </div>

    <article class="art-content">
      <!-- Author -->
      <div class="author-box">
        <?php if ($avatar) : ?>
          <?php echo $avatar; ?>
        <?php endif; ?>
        <div>
          <h4><?php echo esc_html($name); ?></h4>
          <?php if ($role) : ?>
            <span><?php echo esc_html($role); ?></span>
          <?php endif; ?>
          <p><?php echo esc_html($service); ?></p>
        </div>
      </div>

      <!-- Rating -->
      <div style="margin:24px 0;display:flex;gap:4px">
        <?php for ($i = 1; $i <= 5; $i++) : ?>
          <svg width="22" height="22" viewBox="0 0 24 24" fill="<?php echo $i <= $rating ? 'var(--brand)' : 'var(--line)'; ?>"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <?php endfor; ?>
        <span style="margin-left:8px;font-size:.88rem;color:var(--muted);font-weight:600"><?php echo esc_html($rating); ?>/5</span>
      </div>

      <!-- Testimonial Content -->
      <div class="entry-content" style="margin-top:24px">
        <?php the_content(); ?>
      </div>

      <!-- Before / After -->
      <?php if ($before || $after) : ?>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:36px">
        <?php if ($before && is_array($before)) : ?>
          <div>
            <span class="eyebrow" style="font-size:.72rem;margin-bottom:8px">Before</span>
            <img src="<?php echo esc_url($before['url']); ?>" alt="Before" style="width:100%;border-radius:16px;object-fit:cover;aspect-ratio:1/1">
          </div>
        <?php endif; ?>
        <?php if ($after && is_array($after)) : ?>
          <div>
            <span class="eyebrow" style="font-size:.72rem;margin-bottom:8px">After</span>
            <img src="<?php echo esc_url($after['url']); ?>" alt="After" style="width:100%;border-radius:16px;object-fit:cover;aspect-ratio:1/1">
          </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <!-- CTA -->
      <div class="apply-box" style="margin-top:40px">
        <div>
          <h4>Mau hasil yang sama?</h4>
          <p>Konsultasikan kebutuhan Anda dengan tim dokter kami.</p>
        </div>
        <a class="btn" href="<?php echo esc_url(alya_wa_link('Halo, saya lihat testimoni di website dan ingin konsultasi.')); ?>" target="_blank" rel="noopener">Konsultasi Sekarang</a>
      </div>
    </article>

    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="side-box cta-box">
        <h4>Butuh Bantuan?</h4>
        <p>Hubungi kami langsung untuk info layanan dan reservasi.</p>
        <a class="btn" href="<?php echo esc_url(alya_wa_link()); ?>" target="_blank" rel="noopener">Chat WhatsApp</a>
      </div>
    </aside>
  </div>
</section>

<script>
(function(){
  var copyBtn = document.getElementById('copyLink');
  if (copyBtn) {
    copyBtn.addEventListener('click', function(e){
      e.preventDefault();
      navigator.clipboard.writeText(window.location.href).then(function(){
        copyBtn.setAttribute('title', 'Tautan disalin!');
      });
    });
  }
})();
</script>

<?php endwhile; ?>

<?php get_footer();

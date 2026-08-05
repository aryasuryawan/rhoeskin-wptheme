<?php
/**
 * Single Treatment Template — matches treatment.html
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post();

$terms = get_the_terms(get_the_ID(), 'treatment_category');
$cat_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : '';
$cat_slug = ($terms && !is_wp_error($terms)) ? $terms[0]->slug : '';
$hero_img = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png';
$duration = get_field('alya_duration') ?: '60 menit';
$price = get_field('alya_price') ?: 'Mulai dari';
$subtitle = get_field('alya_subtitle') ?: '';
$skin_type = get_field('alya_skin_type') ?: 'Semua jenis kulit';
$downtime = get_field('alya_downtime') ?: 'Tanpa downtime';
?>

<!-- HERO -->
<div class="t-hero" style="background-image:url('<?php echo esc_url($hero_img); ?>')">
  <div class="container">
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('treatment')); ?>">Layanan</a><span>/</span>
      <?php if ($cat_name) : ?>
        <a href="<?php echo esc_url(get_term_link($terms[0])); ?>"><?php echo esc_html($cat_name); ?></a><span>/</span>
      <?php endif; ?>
      <span style="color:#fff"><?php the_title(); ?></span>
    </div>
    <?php if ($cat_name) : ?>
      <span class="tag-pill"><?php echo esc_html($cat_name); ?></span>
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <?php if ($subtitle) : ?>
      <p><?php echo esc_html($subtitle); ?></p>
    <?php endif; ?>
    <div class="hero-facts">
      <div>
        <svg viewBox="0 0 24 24"><path d="M12 6v6l4 2-.8 1.6-5.2-2.6V6h2z"/></svg>
        <?php echo esc_html($duration); ?>
      </div>
      <div>
        <svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg>
        <?php echo esc_html($skin_type); ?>
      </div>
      <div>
        <svg viewBox="0 0 24 24"><path d="M9 16.2l-3.2-3.2L4.5 14.3 9 18.8 18.5 9.3l-1.3-1.3z"/></svg>
        <?php echo esc_html($downtime); ?>
      </div>
    </div>
  </div>
</div>

<!-- CONTENT -->
<section style="padding:84px 0">
  <div class="t-layout">

    <div class="t-content">
      <?php if (has_post_thumbnail()) : ?>
      <div class="t-cover">
        <?php the_post_thumbnail('full', ['alt' => get_the_title() . ' di Alya Esthetic Center']); ?>
      </div>
      <?php endif; ?>

      <h2>Deskripsi Treatment</h2>
      <p><?php echo $subtitle ? esc_html($subtitle) : get_the_excerpt(); ?></p>

      <?php
      $benefits = alya_parse_benefits(get_field('alya_benefits'));
      if ($benefits) :
      ?>
      <h2>Manfaat Utama</h2>
      <div class="benefit-grid">
        <?php foreach ($benefits as $b) : ?>
        <div class="benefit-item">
          <svg viewBox="0 0 24 24"><path d="M9 16.2l-3.2-3.2L4.5 14.3 9 18.8 18.5 9.3l-1.3-1.3z"/></svg>
          <span><?php echo esc_html($b['title']); ?></span>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <?php
      $process = alya_parse_steps(get_field('alya_process'));
      if ($process) :
      ?>
      <h2>Prosedur Treatment</h2>
      <ol class="steps">
        <?php foreach ($process as $step) : ?>
        <li>
          <div>
            <h4><?php echo esc_html($step['title']); ?></h4>
            <p><?php echo esc_html($step['description']); ?></p>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
      <?php endif; ?>

      <div class="callout">
        <h4>
          <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 2 .8 3.6 1.7 5.1C8 15.9 9 18.4 9 21h6c0-2.6 1-5.1 2.3-6.9C18.2 12.6 19 11 19 9a7 7 0 00-7-7z"/></svg>
          Perlu Diketahui
        </h4>
        <p>Hasil terbaik didapat dengan treatment rutin setiap 3–4 minggu sekali. Konsultasikan dengan dokter kami untuk paket perawatan yang sesuai dengan kondisi kulit Anda.</p>
      </div>

      <?php
      $faqs = alya_parse_faqs(get_field('alya_faqs'));
      if ($faqs) :
      ?>
      <h2>Pertanyaan Umum</h2>
      <?php foreach ($faqs as $i => $faq) : ?>
      <details class="faq-item" <?php echo $i === 0 ? 'open' : ''; ?>>
        <summary><?php echo esc_html($faq['question']); ?></summary>
        <p><?php echo esc_html($faq['answer']); ?></p>
      </details>
      <?php endforeach; ?>
      <?php endif; ?>

      <?php the_content(); ?>
    </div>

    <!-- SIDEBAR -->
    <aside>
      <div class="book-card">
        <div class="price"><?php echo esc_html($price); ?> <span>/ sesi</span></div>
        <p class="price-note">Harga final tergantung kondisi kulit &amp; rekomendasi dokter. Chat kami untuk info lengkap.</p>

        <div class="field">
          <label for="fNama">Nama Lengkap</label>
          <input id="fNama" type="text" placeholder="Nama Anda">
        </div>
        <div class="field">
          <label for="fWA">No. WhatsApp</label>
          <input id="fWA" type="tel" placeholder="08xx-xxxx-xxxx">
        </div>
        <div class="field">
          <label for="fTanggal">Tanggal Diinginkan</label>
          <input id="fTanggal" type="date">
        </div>
        <button class="btn btn--full" id="bookBtn" type="button" style="width:100%;justify-content:center">Booking via WhatsApp</button>

        <div class="divider" style="border-top:1px solid var(--line);margin:20px 0"></div>
        <div class="drow" style="display:flex;align-items:center;gap:10px;font-size:.86rem;color:var(--ink-light);margin-bottom:12px">
          <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:var(--brand);flex:none"><path d="M12 6v6l4 2-.8 1.6-5.2-2.6V6h2z"/></svg>
          Durasi <?php echo esc_html($duration); ?>
        </div>
        <div class="drow" style="display:flex;align-items:center;gap:10px;font-size:.86rem;color:var(--ink-light);margin-bottom:12px">
          <svg viewBox="0 0 24 24" style="width:18px;height:18px;fill:var(--brand);flex:none"><path d="M12 21s-7-4.6-9.2-9C1.2 8.2 3 5 6.4 5c2 0 3.4 1.1 4 2.3h3.2c.6-1.2 2-2.3 4-2.3 3.4 0 5.2 3.2 3.6 7-2.2 4.4-9.2 9-9.2 9z"/></svg>
          Alya Esthetic Center, Jakarta Selatan
        </div>
      </div>

      <?php
      $doctors = get_field('alya_doctors');
      if ($doctors && !empty($doctors[0])) :
        $doc = $doctors[0];
      ?>
      <div class="doctor-mini">
        <?php
        $avatar = get_field('alya_avatar', $doc->ID);
        if ($avatar && is_array($avatar)) :
        ?>
          <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr($doc->post_title); ?>">
        <?php else : ?>
          <?php echo get_the_post_thumbnail($doc->ID, 'thumbnail', ['style' => 'width:56px;height:56px;border-radius:50%;object-fit:cover']); ?>
        <?php endif; ?>
        <div>
          <h5 style="font-size:.94rem;margin:0"><?php echo esc_html($doc->post_title); ?></h5>
          <span style="font-size:.8rem;color:var(--brand)"><?php echo esc_html(get_field('alya_position', $doc->ID)); ?></span>
        </div>
      </div>
      <?php endif; ?>
    </aside>

  </div>
</section>

<!-- RELATED TREATMENTS -->
<?php
$related = get_field('alya_related');
if ($related) :
?>
<section class="related">
  <div class="container">
    <div class="related__head">
      <span class="eyebrow">Rekomendasi</span>
      <h2>Treatment Terkait</h2>
    </div>
    <div class="related__grid">
      <?php foreach ($related as $rel) :
        $rel_img = get_the_post_thumbnail_url($rel->ID, 'full') ?: 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png';
      ?>
      <a class="t-item" href="<?php echo esc_url(get_permalink($rel->ID)); ?>">
        <img src="<?php echo esc_url($rel_img); ?>" alt="<?php echo esc_attr($rel->post_title); ?>">
        <div class="cap"><?php echo esc_html($rel->post_title); ?></div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<script>
(function(){
  var WA_NUMBER = '6281290000000';
  var bookBtn = document.getElementById('bookBtn');
  if (bookBtn) {
    bookBtn.addEventListener('click', function(){
      var nama = document.getElementById('fNama').value.trim();
      var wa = document.getElementById('fWA').value.trim();
      var tanggal = document.getElementById('fTanggal').value;
      var treatmentName = document.querySelector('.t-hero h1').textContent.trim();
      var text = 'Halo Alya Esthetic Center, saya ingin booking treatment *' + treatmentName + '*.\n'
               + '------------------------------------------\n'
               + 'Nama      : ' + (nama || '-') + '\n'
               + 'No. WA    : ' + (wa || '-') + '\n';
      if (tanggal) text += 'Tanggal   : ' + tanggal + '\n';
      text += '------------------------------------------\nSaya diarahkan dari website. Terima kasih!';
      var url = 'https://web.whatsapp.com/send?phone=' + WA_NUMBER + '&text=' + encodeURIComponent(text);
      if (/iPhone|iPad|Android|Mobile/i.test(navigator.userAgent)) {
        url = 'https://api.whatsapp.com/send?phone=' + WA_NUMBER + '&text=' + encodeURIComponent(text);
      }
      window.open(url, '_blank');
    });
  }
})();
</script>

<?php endwhile; ?>

<?php get_footer(); ?>

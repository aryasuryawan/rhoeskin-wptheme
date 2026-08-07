<?php
/**
 * 404 Page Template — matches 404.html
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<!-- 404 HERO -->
<div class="error-hero">
  <div class="container center">
    <span class="error-code">404</span>
    <h1>Halaman yang Anda Cari Tidak Ditemukan</h1>
    <p class="lead">Tautan mungkin sudah tidak berlaku atau salah ketik. Tapi tenang, sambil di sini Anda bisa langsung menjelajahi layanan perawatan kulit dan kecantikan kami.</p>

    <div class="searchbox-lg">
      <svg viewBox="0 0 24 24"><path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 10-.7.7l.3.3v.8l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/></svg>
      <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="text" name="s" placeholder="Cari layanan atau artikel..." value="<?php echo esc_attr(get_search_query()); ?>">
      </form>
    </div>

    <div class="error-actions">
      <a class="btn" href="<?php echo esc_url(home_url('/')); ?>">Kembali ke Beranda</a>
      <a class="btn btn--ghostdark" href="https://wa.me/message/ZN5DUXKN4BZSC1" target="_blank" rel="noopener">Konsultasi via WhatsApp</a>
    </div>
  </div>
</div>

<!-- SERVICES UPSELL -->
<section class="services">
  <div class="container center" style="max-width:600px">
    <span class="eyebrow">Layanan Unggulan</span>
    <h2>Mungkin Anda Sedang Mencari Ini</h2>
    <p class="lead">Sambil menemukan kembali halaman yang Anda tuju, lihat dulu layanan favorit pasien kami.</p>
  </div>
  <div class="container">
    <div class="service-grid" id="serviceGrid">
      <?php
      $img_uri = get_template_directory_uri() . '/assets/images/services';
      $services = [
        [
          'title'   => 'Skin Serenity',
          'desc'    => 'Rangkaian facial &amp; perawatan kulit untuk wajah bercahaya dan skin barrier yang sehat.',
          'img'     => $img_uri . '/skin-serenity.png',
          'url'     => add_query_arg('service', 'skin-serenity', get_post_type_archive_link('treatment')),
          'keywords' => 'skin serenity glass skin facial perawatan kulit',
        ],
        [
          'title'   => 'Beauty Advance',
          'desc'    => 'Treatment lanjutan seperti filler, skin booster, hingga perawatan pasca hair coloring.',
          'img'     => $img_uri . '/beauty-advance.png',
          'url'     => add_query_arg('service', 'beauty-advance', get_post_type_archive_link('treatment')),
          'keywords' => 'beauty advance filler skin booster hair coloring',
        ],
        [
          'title'   => 'Slimming &amp; Wellness',
          'desc'    => 'Solusi membentuk tubuh ideal, mulai dari slimming injection hingga program wellness.',
          'img'     => $img_uri . '/slimming.png',
          'url'     => add_query_arg('service', 'slimming-wellness', get_post_type_archive_link('treatment')),
          'keywords' => 'slimming wellness slimming injection diet',
        ],
        [
          'title'   => 'Alya Beauty Bar',
          'desc'    => 'Layanan kecantikan harian termasuk laser hair removal untuk kulit halus bebas bulu.',
          'img'     => $img_uri . '/beauty-bar.png',
          'url'     => add_query_arg('service', 'alya-beauty-bar', get_post_type_archive_link('treatment')),
          'keywords' => 'alya beauty bar laser hair removal',
        ],
      ];
      foreach ($services as $svc) :
      ?>
      <a class="service-card" data-name="<?php echo esc_attr($svc['keywords']); ?>" href="<?php echo esc_url($svc['url']); ?>">
        <div class="thumb"><img src="<?php echo esc_url($svc['img']); ?>" alt="<?php echo esc_attr($svc['title']); ?>"></div>
        <div class="s-body">
          <h3><?php echo wp_kses_post($svc['title']); ?></h3>
          <p><?php echo wp_kses_post($svc['desc']); ?></p>
          <span class="s-link">Lihat Layanan <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg></span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PROMO BANNER -->
<section class="promo">
  <div class="container promo__inner">
    <div>
      <h2>Konsultasi Gratis Sebelum Treatment</h2>
      <p>Belum yakin perawatan mana yang cocok untuk Anda? Tim dokter kami siap membantu menentukan rutinitas dan treatment yang paling sesuai dengan kondisi kulit Anda.</p>
    </div>
    <a class="btn" href="https://wa.me/message/ZN5DUXKN4BZSC1" target="_blank" rel="noopener">Chat Tim Kami</a>
  </div>
</section>

<!-- HELPFUL LINKS -->
<section class="helpful">
  <div class="container center" style="max-width:600px">
    <span class="eyebrow">Jelajahi Lainnya</span>
    <h2>Tautan yang Mungkin Membantu</h2>
  </div>
  <div class="container">
    <div class="helpful-grid">
      <a class="helpful-card" href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
        <div class="ic"><svg viewBox="0 0 24 24"><path d="M6 2h9l5 5v15H6V2zm8 1.5V8h4.5L14 3.5zM8 12h8v2H8v-2zm0 4h8v2H8v-2z"/></svg></div>
        <div><h4>Artikel &amp; Tips Kecantikan</h4><p>Baca tips perawatan kulit dari tim dokter kami.</p></div>
      </a>
      <a class="helpful-card" href="<?php echo esc_url(home_url('/karir/')); ?>">
        <div class="ic"><svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg></div>
        <div><h4>Karir</h4><p>Lihat lowongan kerja dan bergabung bersama tim kami.</p></div>
      </a>
      <a class="helpful-card" href="<?php echo esc_url(home_url('/kontak/')); ?>">
        <div class="ic"><svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg></div>
        <div><h4>Lokasi &amp; Kontak</h4><p>Temukan klinik kami dan buat janji temu.</p></div>
      </a>
    </div>
  </div>
</section>

<script>
(function(){
  // Search redirect
  var search = document.querySelector('.searchbox-lg form');
  if (search) {
    search.addEventListener('submit', function(e){
      var input = search.querySelector('input');
      var q = (input.value || '').trim().toLowerCase();
      if (!q) { e.preventDefault(); return; }
      var cards = document.querySelectorAll('#serviceGrid .service-card');
      var match = Array.prototype.find.call(cards, function(card){
        return (card.dataset.name || '').indexOf(q) > -1;
      });
      if (match) {
        e.preventDefault();
        window.location.href = match.getAttribute('href');
      }
    });
  }
})();
</script>

<?php get_footer(); ?>

<?php
/**
 * Template Name: Before & After Gallery
 *
 * @package Alya_Esthetic
 */

get_header();

$img_uri = ALYA_URI . '/assets/images/services';
$hero_bg        = get_field('alya_hero_bg');
$hero_title     = get_field('alya_hero_title') ?: 'Before & After Gallery';
$hero_subtitle  = get_field('alya_hero_subtitle') ?: 'Setiap foto adalah kisah nyata transformasi pasien kami. Geser gambar untuk melihat perbandingan hasil perawatan yang luar biasa.';

$disclaimer_text = get_field('alya_gallery_disclaimer') ?: 'Foto-foto di bawah ini ditampilkan dengan persetujuan penuh dari pasien. Hasil perawatan dapat bervariasi tergantung kondisi kulit, jenis perawatan, dan faktor individu masing-masing. Konsultasikan dengan dokter kami untuk estimasi hasil yang lebih akurat.';

$raw_items = get_field('alya_gallery_items');
$gallery_items = [];
if (is_string($raw_items) && !empty(trim($raw_items))) {
    $lines = array_filter(array_map('trim', explode("\n", $raw_items)));
    foreach ($lines as $line) {
        $parts = array_map('trim', explode('|', $line));
        $gallery_items[] = [
            'before_id' => intval($parts[0] ?? 0),
            'after_id'  => intval($parts[1] ?? 0),
            'category'  => $parts[2] ?? '',
            'tag'       => $parts[3] ?? '',
            'title'     => $parts[4] ?? '',
            'desc'      => $parts[5] ?? '',
            'duration'  => $parts[6] ?? '',
            'patient'   => $parts[7] ?? '',
        ];
    }
}
?>

<!-- PAGE HERO -->
<div class="svc-pagehead" style="background-image:url('<?php echo esc_url($hero_bg && is_array($hero_bg) ? $hero_bg['url'] : $img_uri . '/hero-bg.jpg'); ?>')">
    <div class="container">
        <span class="eyebrow"><?php echo esc_html('Transformasi Nyata'); ?></span>
        <h1><?php echo esc_html($hero_title); ?></h1>
        <div class="crumb">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html('Beranda'); ?></a>
            <span>/</span>
            <a href="<?php echo esc_url(get_permalink()); ?>" style="color:#fff"><?php echo esc_html('Galeri'); ?></a>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<div class="filter-bar">
  <div class="container">
    <div class="filter-inner">
      <div class="filter-tabs">
        <button class="tab active" data-filter="all">Semua</button>
        <button class="tab" data-filter="acne">Acne &amp; Bekas Jerawat</button>
        <button class="tab" data-filter="laser">Laser Treatment</button>
        <button class="tab" data-filter="slimming">Slimming</button>
        <button class="tab" data-filter="rejuvenation">Rejuvenasi</button>
        <button class="tab" data-filter="filler">Filler &amp; Botox</button>
      </div>
    </div>
  </div>
</div>

<!-- DISCLAIMER -->
<section style="padding:40px 0 0">
  <div class="container">
    <div class="disclaimer">
      <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-5h2v5zm0-7H11V7h2v2z"/></svg>
      <p><b>Catatan Penting:</b> <?php echo esc_html($disclaimer_text); ?></p>
    </div>
  </div>
</section>

<!-- GALLERY GRID -->
<section style="padding:0">
  <div class="container">
    <div class="ba-grid" id="baGrid">
      <?php foreach ($gallery_items as $item) :
          if (!$item['before_id'] || !$item['after_id']) continue;
          $before_url = wp_get_attachment_image_url($item['before_id'], 'large') ?: $img_uri . '/fallback.png';
          $after_url  = wp_get_attachment_image_url($item['after_id'], 'large') ?: $img_uri . '/fallback.png';
          $before_alt = get_post_meta($item['before_id'], '_wp_attachment_image_alt', true) ?: 'Before';
          $after_alt  = get_post_meta($item['after_id'], '_wp_attachment_image_alt', true) ?: 'After';
      ?>
      <div class="ba-card" data-cat="<?php echo esc_attr($item['category']); ?>" data-title="<?php echo esc_attr($item['title']); ?>" data-desc="<?php echo esc_attr($item['desc']); ?>" onclick="openLB(this)">
        <div class="ba-slider" data-slider>
          <div class="after"><img src="<?php echo esc_url($after_url); ?>" alt="<?php echo esc_attr($after_alt); ?>"></div>
          <div class="before"><img src="<?php echo esc_url($before_url); ?>" alt="<?php echo esc_attr($before_alt); ?>"></div>
          <div class="divider"></div>
          <div class="handle"></div>
          <div class="ba-labels"><span>Before</span><span>After</span></div>
        </div>
        <div class="ba-body">
          <p class="treat-tag"><?php echo esc_html($item['tag']); ?></p>
          <h3><?php echo esc_html($item['title']); ?></h3>
          <div class="meta">
            <?php if ($item['duration']) : ?>
              <span><svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm1 14H11v-5h2v5zm0-7H11V7h2v2z"/></svg> <?php echo esc_html($item['duration']); ?></span>
            <?php endif; ?>
            <?php if ($item['patient']) : ?>
              <span><svg viewBox="0 0 24 24"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 9a7 7 0 0114 0v1H5v-1z"/></svg> <?php echo esc_html($item['patient']); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<div class="cta-band">
  <div class="container" style="text-align:center">
    <h2>Jadilah Cerita Transformasi Berikutnya</h2>
    <p>Konsultasi gratis dengan dokter kami dan mulailah perjalanan kecantikan Anda hari ini.</p>
    <a href="<?php echo esc_url(alya_wa_link('Halo, saya ingin konsultasi tentang treatment.')); ?>" class="btn" target="_blank" rel="noopener noreferrer">Konsultasi Sekarang</a>
  </div>
</div>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox" onclick="closeLB(event)">
  <div class="lb-box">
    <button class="lb-close" onclick="document.getElementById('lightbox').classList.remove('open')">&times;</button>
    <div class="lb-compare">
      <div><img id="lbBefore" src="" alt="Before"><span class="lb-label">Before</span></div>
      <div><img id="lbAfter" src="" alt="After"><span class="lb-label">After</span></div>
    </div>
    <div class="lb-info">
      <p class="treat" id="lbTreat"></p>
      <h3 id="lbTitle"></h3>
      <p id="lbDesc"></p>
    </div>
  </div>
</div>

<script>
(function(){
  // Slider interaction
  document.querySelectorAll('[data-slider]').forEach(function(slider){
    var before = slider.querySelector('.before');
    var divider = slider.querySelector('.divider');
    var handle = slider.querySelector('.handle');
    var dragging = false;

    function setPos(x){
      var rect = slider.getBoundingClientRect();
      var pct = Math.min(Math.max((x - rect.left) / rect.width * 100, 5), 95);
      before.style.clipPath = 'inset(0 ' + (100 - pct) + '% 0 0)';
      divider.style.left = pct + '%';
      handle.style.left = pct + '%';
    }

    slider.addEventListener('mousedown', function(e){ e.preventDefault(); dragging = true; setPos(e.clientX); });
    window.addEventListener('mousemove', function(e){ if(dragging) setPos(e.clientX); });
    window.addEventListener('mouseup', function(){ dragging = false; });
    slider.addEventListener('touchstart', function(e){ dragging = true; setPos(e.touches[0].clientX); },{passive:true});
    window.addEventListener('touchmove', function(e){ if(dragging) setPos(e.touches[0].clientX); },{passive:true});
    window.addEventListener('touchend', function(){ dragging = false; });
  });

  // Filter tabs
  var tabs = document.querySelectorAll('.tab');
  var cards = document.querySelectorAll('.ba-card');
  tabs.forEach(function(tab){
    tab.addEventListener('click', function(e){
      e.stopPropagation();
      tabs.forEach(function(t){ t.classList.remove('active'); });
      tab.classList.add('active');
      var f = tab.dataset.filter;
      cards.forEach(function(c){
        c.style.display = (f === 'all' || c.dataset.cat.includes(f)) ? '' : 'none';
      });
    });
  });
})();

function openLB(card){
  var after = card.querySelector('.after img').src;
  var before = card.querySelector('.before img').src;
  var title = card.dataset.title;
  var desc = card.dataset.desc;
  var treat = card.querySelector('.treat-tag').textContent;
  document.getElementById('lbBefore').src = before;
  document.getElementById('lbAfter').src = after;
  document.getElementById('lbTitle').textContent = title;
  document.getElementById('lbDesc').textContent = desc;
  document.getElementById('lbTreat').textContent = treat;
  document.getElementById('lightbox').classList.add('open');
}
function closeLB(e){
  if(e.target === document.getElementById('lightbox')) document.getElementById('lightbox').classList.remove('open');
}
</script>

<?php get_footer(); ?>

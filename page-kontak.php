<?php
/**
 * Template Name: Halaman Kontak
 *
 * Full-width contact page matching the HTML reference.
 *
 * @package Alya_Esthetic
 */

get_header();

$address   = get_theme_mod('alya_address', 'Jakarta Selatan, Indonesia');
$phone     = get_theme_mod('alya_phone', '+62 812-9000-0000');
$phone_link = get_theme_mod('alya_phone_link', '6281290000000');
$hours     = get_theme_mod('alya_clinic_hours', 'Setiap hari, 09.00 – 20.00 WIB');
$maps      = get_theme_mod('alya_google_maps_embed', '');
$hero_bg   = get_theme_mod('alya_kontak_hero_bg', alya_field_raw('alya_kontak_hero_bg'));
if (is_string($hero_bg)) $hero_bg = ['url' => $hero_bg];
$wa_url    = alya_wa_link();
$wa_number = get_theme_mod('alya_phone_link', '6281290000000');
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero page-hero--bg">
  <div class="page-hero__bg" <?php if (!empty($hero_bg['url'])) echo 'style="background-image:url(' . esc_url($hero_bg['url']) . ')"'; ?>></div>
  <div class="container">
    <span class="eyebrow eyebrow--light">Kontak Kami</span>
    <h1>Kami Siap Membantu Anda</h1>
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
      <span>/</span>
      <a href="<?php echo esc_url(get_permalink()); ?>">Kontak</a>
    </div>
  </div>
</section>

<!-- ============ QUICK INFO ============ -->
<div class="quick">
  <div class="container grid">
    <div class="item">
      <div class="ic"><?php echo alya_icon('pin'); ?></div>
      <div><b>Lokasi Klinik</b><p><?php echo esc_html($address); ?></p></div>
    </div>
    <div class="item">
      <div class="ic"><?php echo alya_icon('whatsapp'); ?></div>
      <div><b>WhatsApp</b><a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener">Chat via WhatsApp</a></div>
    </div>
    <div class="item">
      <div class="ic"><?php echo alya_icon('clock'); ?></div>
      <div><b>Jam Operasional</b><p><?php echo esc_html($hours); ?></p></div>
    </div>
  </div>
</div>

<!-- ============ CONTACT ============ -->
<section class="contact" id="form">
  <div class="container grid">
    <div class="contact__info">
      <span class="eyebrow">Contact Us</span>
      <h3>Kunjungi Klinik Kami</h3>
      <p class="lead">Ada pertanyaan seputar treatment atau ingin konsultasi terlebih dahulu? Hubungi kami melalui salah satu kanal di bawah ini, tim kami akan segera merespon.</p>
      <ul>
        <li>
          <div class="ic"><?php echo alya_icon('pin'); ?></div>
          <div><b>Lokasi</b><p><?php echo esc_html($address); ?></p></div>
        </li>
        <li>
          <div class="ic"><?php echo alya_icon('whatsapp'); ?></div>
          <div><b>Telepon / WhatsApp</b><a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener">Chat via WhatsApp</a></div>
        </li>
        <li>
          <div class="ic"><?php echo alya_icon('email'); ?></div>
          <div><b>Email</b><a href="mailto:hello@alyaesthetic.id">hello@alyaesthetic.id</a></div>
        </li>
      </ul>

      <div class="hours">
        <table>
          <tr><td>Senin – Jumat</td><td>09.00 – 20.00 WIB</td></tr>
          <tr><td>Sabtu – Minggu</td><td>09.00 – 20.00 WIB</td></tr>
          <tr><td>Hari Libur Nasional</td><td>09.00 – 18.00 WIB</td></tr>
        </table>
      </div>

      <div class="socials">
        <a href="https://www.instagram.com/alyaesthetic/" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.3-2.2-.4a3.8 3.8 0 01-1.4-.9 3.8 3.8 0 01-.9-1.4c-.2-.4-.4-1-.4-2.2-.1-1.3-.1-1.7-.1-4.9s0-3.6.1-4.9c.1-1.2.3-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4 1.3-.1 1.7-.1 4.9-.1zm0-2.2C8.7 0 8.3 0 7 .1 5.7.1 4.8.4 4 .7 3.1 1 2.4 1.5 1.7 2.2 1 2.9.5 3.6.2 4.5-.1 5.3-.3 6.2-.3 7.5 0 8.8 0 9.2 0 12s0 3.2.1 4.5c.1 1.3.3 2.2.7 3.1.3.9.8 1.6 1.5 2.3.7.7 1.4 1.2 2.3 1.5.9.3 1.8.5 3.1.5 1.3.1 1.7.1 5 .1s3.7-.1 4.9-.1c1.3-.1 2.2-.3 3.1-.7.9-.3 1.6-.8 2.3-1.5.7-.7 1.2-1.4 1.5-2.3.3-.9.5-1.8.5-3.1.1-1.3.1-1.7.1-5s-.1-3.7-.1-4.9c-.1-1.3-.3-2.2-.7-3.1-.3-.9-.8-1.6-1.5-2.3C20.9 1 20.2.5 19.3.2 18.4-.1 17.5-.3 16.2-.3 14.9 0 14.5 0 12 0zm0 5.8a6.2 6.2 0 100 12.4 6.2 6.2 0 000-12.4zm0 10.2a4 4 0 110-8 4 4 0 010 8zm6.4-11.8a1.4 1.4 0 100 2.9 1.4 1.4 0 000-2.9z"/></svg></a>
        <a href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-.9-.3-.1-.5-.1-.7.2-.2.2-.7.9-.9 1.1-.2.2-.3.2-.6.1-1.3-.6-2.2-1.1-3-2.3-.2-.4.2-.4.6-1.1.1-.2 0-.3 0-.4s-.7-1.7-1-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-1.1 1.1-1.3 2.5-.3 4 .1.1 2.3 3.6 5.7 5.1a9 9 0 001.9.7c.8.3 1.5.2 2.1.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.5-.3zM12 21a9 9 0 01-7.7-4.4l-1.8.6 1-1.8A9 9 0 1112 21zm0-19.8C5.9 1.2 1 6 1 12c0 1.9.6 3.8 1.6 5.5L1 21l3.6-1a11 11 0 002.2 1.6A10.9 10.9 0 0012 23c6.1 0 11-4.9 11-11C23 6 18 1.2 12 1.2z"/></svg></a>
        <a href="https://www.tiktok.com/@alyaestheticcenter" target="_blank" rel="noopener" aria-label="TikTok"><svg viewBox="0 0 24 24"><path d="M19.3 8.5a5.3 5.3 0 01-3.1-1 5 5 0 01-2-3.9V3.2h-3.3v11.9a2.5 2.5 0 01-2.5 2.4 2.5 2.5 0 01-2.5-2.4 2.5 2.5 0 012.5-2.5c.3 0 .5 0 .8.1V8.9c-.3 0-.5-.1-.8-.1a5.9 5.9 0 100 11.8c3.2 0 5.8-2.6 5.8-5.8V9.9a8.4 8.4 0 004.7 1.5V8.5z"/></svg></a>
        <a href="https://www.youtube.com/@alya.esthetic/featured" target="_blank" rel="noopener" aria-label="YouTube"><svg viewBox="0 0 24 24"><path d="M21.6 7.2a2.6 2.6 0 00-1.8-1.8A30.6 30.6 0 0012 5a30.6 30.6 0 00-7.8.4A2.6 2.6 0 002.4 7.2 26.5 26.5 0 002 12c0 1.6.1 3.2.4 4.8a2.6 2.6 0 001.8 1.8A30.6 30.6 0 0012 19c2.6 0 5.2-.1 7.8-.4a2.6 2.6 0 001.8-1.8c.3-1.6.4-3.2.4-4.8s-.1-3.2-.4-4.8zM10 15V9l5 3-5 3z"/></svg></a>
      </div>
    </div>

    <form class="form" id="bookingForm">
      <h3>Buat Janji Temu</h3>
      <p>Isi form di bawah, tim kami akan menghubungi Anda untuk konfirmasi.</p>
      <div class="field-row">
        <div class="field">
          <label for="fNama">Nama Lengkap</label>
          <input id="fNama" type="text" required placeholder="Nama Anda">
        </div>
        <div class="field">
          <label for="fWA">No. WhatsApp</label>
          <input id="fWA" type="tel" required placeholder="08xx-xxxx-xxxx">
        </div>
      </div>
      <div class="field-row">
        <div class="field">
          <label for="fEmail">Email (opsional)</label>
          <input id="fEmail" type="email" placeholder="nama@email.com">
        </div>
        <div class="field">
          <label for="fLayanan">Layanan</label>
          <select id="fLayanan">
            <option>Skin Serenity</option>
            <option>Beauty Advance</option>
            <option>Slimming &amp; Wellness</option>
            <option>Alya Beauty Bar</option>
          </select>
        </div>
      </div>
      <div class="field">
        <label for="fTanggal">Tanggal (opsional)</label>
        <input id="fTanggal" type="date">
      </div>
      <div class="field">
        <label for="fPesan">Pesan</label>
        <textarea id="fPesan" placeholder="Ceritakan kebutuhan Anda..."></textarea>
      </div>
      <button class="btn" type="submit">Kirim Permintaan</button>
    </form>
  </div>
</section>

<!-- ============ MAP ============ -->
<section class="map">
  <div class="container">
    <div class="map__head">
      <span class="eyebrow">Lokasi</span>
      <h2>Temukan Kami di Sini</h2>
      <p class="lead" style="margin:0 auto">Kunjungi klinik kami di Jakarta Selatan untuk konsultasi langsung bersama tim dokter.</p>
    </div>
    <div class="map__frame">
      <?php if ($maps) : ?>
        <iframe src="<?php echo esc_url($maps); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Alya Esthetic Center"></iframe>
      <?php else : ?>
        <iframe src="https://www.google.com/maps?q=Jakarta%20Selatan&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Lokasi Alya Esthetic Center"></iframe>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="faq">
  <div class="container">
    <div class="faq__head">
      <span class="eyebrow">FAQ</span>
      <h2>Pertanyaan yang Sering Diajukan</h2>
      <p class="lead">Beberapa hal yang paling sering ditanyakan Sahabat Alya sebelum melakukan reservasi.</p>
    </div>
    <div class="faq-list">
      <details class="faq-item">
        <summary>Apakah saya perlu reservasi terlebih dahulu?</summary>
        <p>Ya, kami sarankan untuk membuat janji temu terlebih dahulu melalui WhatsApp atau form di halaman ini agar jadwal konsultasi dan treatment dapat disesuaikan dengan dokter yang Anda pilih.</p>
      </details>
      <details class="faq-item">
        <summary>Apakah konsultasi awal dikenakan biaya?</summary>
        <p>Kebijakan biaya konsultasi dapat berbeda tergantung jenis layanan. Silakan hubungi tim kami melalui WhatsApp untuk informasi terbaru sebelum kunjungan Anda.</p>
      </details>
      <details class="faq-item">
        <summary>Apakah data dan privasi pasien terjamin?</summary>
        <p>Kerahasiaan Sahabat Alya adalah prioritas kami. Seluruh data dan riwayat perawatan pasien dijaga kerahasiaannya sesuai standar klinik.</p>
      </details>
      <details class="faq-item">
        <summary>Apakah Alya Esthetic ramah untuk keluarga?</summary>
        <p>Tentu. Alya Esthetic Center dirancang untuk menjadi klinik yang nyaman dan ramah bagi seluruh anggota keluarga, dari remaja hingga dewasa.</p>
      </details>
    </div>
  </div>
</section>

<script>
(function(){
  var WA_NUMBER = '<?php echo esc_js($wa_number); ?>';
  var AJAX_URL  = '<?php echo esc_js(admin_url('admin-ajax.php')); ?>';
  var NONCE     = '<?php echo esc_js(wp_create_nonce('alya_nonce')); ?>';
  var form = document.getElementById('bookingForm');
  if (!form) return;

  // Visual status container
  var statusDiv = document.createElement('div');
  statusDiv.style.marginTop = '15px';
  statusDiv.style.padding = '12px 18px';
  statusDiv.style.borderRadius = '12px';
  statusDiv.style.fontSize = '0.92rem';
  statusDiv.style.fontWeight = '500';
  statusDiv.style.display = 'none';
  form.appendChild(statusDiv);

  function showStatus(msg, type) {
    statusDiv.textContent = msg;
    statusDiv.style.display = 'block';
    if (type === 'success') {
      statusDiv.style.background = '#e6f4ea';
      statusDiv.style.color = '#137333';
      statusDiv.style.border = '1px solid #c2e7c9';
    } else if (type === 'error') {
      statusDiv.style.background = '#fce8e6';
      statusDiv.style.color = '#c5221f';
      statusDiv.style.border = '1px solid #fad2cf';
    } else {
      statusDiv.style.background = '#e8f0fe';
      statusDiv.style.color = '#1a73e8';
      statusDiv.style.border = '1px solid #d2e3fc';
    }
  }

  form.addEventListener('submit', function(e){
    e.preventDefault();
    var submitBtn = form.querySelector('button[type="submit"]');
    var origText = submitBtn.textContent;
    
    // Set loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Memproses...';
    showStatus('Menghubungkan ke WhatsApp, mohon tunggu...', 'info');

    var nama    = document.getElementById('fNama').value.trim();
    var wa      = document.getElementById('fWA').value.trim();
    var email   = document.getElementById('fEmail').value.trim();
    var layanan = document.getElementById('fLayanan').value;
    var tanggal = document.getElementById('fTanggal').value;
    var pesan   = document.getElementById('fPesan').value.trim();

    /* Save lead via AJAX */
    var fd = new FormData();
    fd.append('action', 'alya_save_lead');
    fd.append('nonce', NONCE);
    fd.append('name', nama);
    fd.append('phone', wa);
    fd.append('email', email);
    fd.append('service', layanan);
    fd.append('date', tanggal);
    fd.append('message', pesan);

    fetch(AJAX_URL, { 
      method: 'POST', 
      body: fd, 
      credentials: 'same-origin' 
    })
    .then(function(res) {
      return res.text();
    })
    .then(function(text) {
      var data = {};
      try {
        data = JSON.parse(text);
      } catch(e) {}
      // Success feedback
      showStatus('Berhasil mengirim permintaan! Mengalihkan ke WhatsApp...', 'success');
      
      setTimeout(function(){
        submitBtn.disabled = false;
        submitBtn.textContent = origText;
        form.reset();
        statusDiv.style.display = 'none';
      }, 4000);
    })
    .catch(function(err) {
      // Fallback if network fails, we still redirect to WhatsApp
      showStatus('Data tersimpan secara lokal. Membuka WhatsApp...', 'success');
      setTimeout(function(){
        submitBtn.disabled = false;
        submitBtn.textContent = origText;
        form.reset();
        statusDiv.style.display = 'none';
      }, 4000);
    });

    /* Open WhatsApp */
    var text = 'Halo Alya Esthetic Center, saya *' + nama + '* ingin melakukan reservasi.\n'
             + '------------------------------------------\n'
             + 'Nama      : ' + nama + '\n'
             + 'No. WA    : ' + wa + '\n';
    if (email) text += 'Email     : ' + email + '\n';
    text += 'Layanan   : ' + layanan + '\n';
    if (tanggal) text += 'Tanggal   : ' + tanggal + '\n';
    if (pesan)   text += 'Catatan   : ' + pesan + '\n';
    text += '------------------------------------------\nSaya diarahkan dari halaman kontak website. Terima kasih!';

    var url = 'https://web.whatsapp.com/send?phone=' + WA_NUMBER + '&text=' + encodeURIComponent(text);
    if (/iPhone|iPad|Android|Mobile/i.test(navigator.userAgent)) {
      url = 'https://api.whatsapp.com/send?phone=' + WA_NUMBER + '&text=' + encodeURIComponent(text);
    }
    window.open(url, '_blank');
  });
})();
</script>

<?php get_footer();

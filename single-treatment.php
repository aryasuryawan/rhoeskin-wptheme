<?php
/**
 * Single Treatment Template — 100% matches treatment.html
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post();

$post_id = get_the_ID();
$terms = get_the_terms($post_id, 'treatment_category');
if (empty($terms) || is_wp_error($terms)) {
    $terms = get_the_terms($post_id, 'service');
}
$cat_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Skin Serenity';
$cat_slug = ($terms && !is_wp_error($terms)) ? $terms[0]->slug : 'skin-serenity';

$hero_img = get_the_post_thumbnail_url($post_id, 'full');
if (!$hero_img) {
    $acf_img = get_field('alya_treatment_image') ?: get_field('alya_image');
    if (is_array($acf_img)) {
        $hero_img = $acf_img['url'] ?? '';
    } elseif (is_numeric($acf_img)) {
        $hero_img = wp_get_attachment_image_url($acf_img, 'full');
    } elseif (is_string($acf_img)) {
        $hero_img = $acf_img;
    }
}
if (!$hero_img) {
    $hero_img = get_template_directory_uri() . '/assets/images/placeholder-image-treatment-rhoeskin.webp';
}

$duration  = get_field('alya_duration') ?: '60 menit';
$price     = get_field('alya_price') ?: 'Mulai dari';
$subtitle  = get_field('alya_subtitle') ?: get_the_excerpt();
$skin_type = get_field('alya_skin_type') ?: 'Semua jenis kulit';
$downtime  = get_field('alya_downtime') ?: 'Tanpa downtime';

if (!$subtitle) {
    $subtitle = 'Perawatan facial menyeluruh yang menggabungkan pembersihan mendalam, eksfoliasi lembut, dan infus nutrisi untuk menghasilkan kulit yang tampak halus, lembap, dan bercahaya alami layaknya kaca.';
}
?>

<!-- ============ HERO ============ -->
<div class="t-hero" style="background-image:url('<?php echo esc_url($hero_img); ?>')">
  <div class="container">
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('treatment')); ?>">Layanan</a><span>/</span>
      <a href="<?php echo esc_url(add_query_arg('service', $cat_slug, get_post_type_archive_link('treatment'))); ?>"><?php echo esc_html($cat_name); ?></a><span>/</span>
      <span style="color:#fff"><?php the_title(); ?></span>
    </div>
    <span class="tag-pill"><?php echo esc_html($cat_name); ?></span>
    <h1><?php the_title(); ?></h1>
    <p><?php echo esc_html($subtitle); ?></p>
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

<!-- ============ CONTENT ============ -->
<section>
  <div class="t-layout">

    <div class="t-content">
      <div class="t-cover">
        <img src="<?php echo esc_url($hero_img); ?>" alt="<?php echo esc_attr(get_the_title() . ' di Alya Esthetic Center'); ?>">
      </div>

      <h2>Deskripsi Treatment</h2>
      <p><?php echo esc_html($subtitle); ?></p>
      <?php if (get_the_content()) : ?>
        <div class="t-description" style="margin-bottom:34px">
          <?php the_content(); ?>
        </div>
      <?php endif; ?>

      <?php
      $benefits = alya_parse_benefits(get_post_meta($post_id, 'alya_benefits', true));
      if (empty($benefits)) :
        $benefits = [
          ['title' => 'Kulit tampak lebih cerah dan halus seketika'],
          ['title' => 'Mengangkat sel kulit mati & kotoran mendalam'],
          ['title' => 'Meningkatkan hidrasi & kekenyalan kulit'],
          ['title' => 'Mengecilkan tampilan pori-pori'],
          ['title' => 'Aman & nyaman, tanpa masa pemulihan'],
          ['title' => 'Cocok untuk semua jenis & kondisi kulit'],
        ];
      endif;
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

      <?php
      $process = alya_parse_steps(get_post_meta($post_id, 'alya_process', true));
      if (empty($process)) :
        $process = [
          ['title' => 'Konsultasi & Analisa Kulit', 'description' => 'Dokter memeriksa kondisi kulit Anda untuk menentukan pendekatan yang paling sesuai.'],
          ['title' => 'Double Cleansing', 'description' => 'Pembersihan dua tahap untuk mengangkat kotoran, sisa makeup, dan sunscreen secara menyeluruh.'],
          ['title' => 'Eksfoliasi Lembut', 'description' => 'Mengangkat sel kulit mati agar produk perawatan selanjutnya lebih optimal terserap.'],
          ['title' => 'Infus Nutrisi & Serum', 'description' => 'Serum kaya nutrisi diaplikasikan untuk menghidrasi dan menutrisi kulit dari lapisan terluar.'],
          ['title' => 'Massage & Masker Penutup', 'description' => 'Pijatan wajah untuk relaksasi, dilanjutkan masker penutup agar hasil lebih maksimal.'],
        ];
      endif;
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

      <div class="callout">
        <h4>
          <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 2 .8 3.6 1.7 5.1C8 15.9 9 18.4 9 21h6c0-2.6 1-5.1 2.3-6.9C18.2 12.6 19 11 19 9a7 7 0 00-7-7z"/></svg>
          Perlu Diketahui
        </h4>
        <p>Hasil terbaik didapat dengan treatment rutin setiap 3–4 minggu sekali. Konsultasikan dengan dokter kami untuk paket perawatan yang sesuai dengan kondisi kulit Anda.</p>
      </div>

      <?php
      $faqs = alya_parse_faqs(get_post_meta($post_id, 'alya_faqs', true));
      if (empty($faqs)) :
        $faqs = [
          ['question' => 'Apakah treatment ini menimbulkan rasa sakit?', 'answer' => 'Tidak. Treatment ini adalah treatment non-invasif yang nyaman dilakukan dan tidak menimbulkan rasa sakit maupun downtime.'],
          ['question' => 'Berapa kali sebaiknya treatment ini dilakukan?', 'answer' => 'Untuk hasil optimal, disarankan dilakukan secara rutin setiap 3–4 minggu sekali, disesuaikan dengan kondisi kulit masing-masing.'],
          ['question' => 'Apakah aman untuk kulit sensitif?', 'answer' => 'Aman. Namun tim dokter akan melakukan analisa kulit terlebih dahulu untuk menyesuaikan produk dan teknik yang digunakan.'],
          ['question' => 'Apa yang harus dilakukan setelah treatment?', 'answer' => 'Gunakan sunscreen secara rutin dan hindari eksfoliasi tambahan selama 2–3 hari setelah treatment untuk hasil yang optimal.'],
        ];
      endif;
      ?>
      <h2>Pertanyaan Umum</h2>
      <?php foreach ($faqs as $i => $faq) : ?>
        <details class="faq-item" <?php echo $i === 0 ? 'open' : ''; ?>>
          <summary><?php echo esc_html($faq['question']); ?></summary>
          <p><?php echo esc_html($faq['answer']); ?></p>
        </details>
      <?php endforeach; ?>
    </div>

    <!-- ============ SIDEBAR / BOOKING CARD ============ -->
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
        <button class="btn btn--block" id="bookBtn" type="button">Booking via WhatsApp</button>

        <div class="divider"></div>
        <div class="drow">
          <svg viewBox="0 0 24 24"><path d="M12 6v6l4 2-.8 1.6-5.2-2.6V6h2z"/></svg>
          Durasi <?php echo esc_html($duration); ?>
        </div>
        <div class="drow">
          <svg viewBox="0 0 24 24"><path d="M12 21s-7-4.6-9.2-9C1.2 8.2 3 5 6.4 5c2 0 3.4 1.1 4 2.3h3.2c.6-1.2 2-2.3 4-2.3 3.4 0 5.2 3.2 3.6 7-2.2 4.4-9.2 9-9.2 9z"/></svg>
          Alya Esthetic Center, Jakarta Selatan
        </div>
      </div>

      <?php
      $doc_name = 'dr. Fadhilah Saptogino';
      $doc_pos  = 'Aesthetic Doctor';
      $doc_img  = 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png';

      $doctors = get_field('alya_doctors');
      if ($doctors && !empty($doctors[0])) {
          $doc_obj = $doctors[0];
          $doc_name = $doc_obj->post_title;
          $doc_pos  = get_field('alya_position', $doc_obj->ID) ?: 'Aesthetic Doctor';
          $avatar   = get_field('alya_avatar', $doc_obj->ID);
          if ($avatar && is_array($avatar)) {
              $doc_img = $avatar['url'];
          } elseif (has_post_thumbnail($doc_obj->ID)) {
              $doc_img = get_the_post_thumbnail_url($doc_obj->ID, 'medium');
          }
      }
      ?>
      <div class="doctor-mini">
        <img src="<?php echo esc_url($doc_img); ?>" alt="<?php echo esc_attr($doc_name); ?>">
        <div>
          <h5><?php echo esc_html($doc_name); ?></h5>
          <span><?php echo esc_html($doc_pos); ?></span>
        </div>
      </div>
    </aside>

  </div>
</section>

<!-- ============ RELATED TREATMENTS ============ -->
<?php
$related_items = [];
$related_field = get_field('alya_related');

if ($related_field && is_array($related_field)) {
    foreach ($related_field as $rel_obj) {
        $rel_id = is_object($rel_obj) ? $rel_obj->ID : $rel_obj;
        $rel_img = get_the_post_thumbnail_url($rel_id, 'medium_large');
        if (!$rel_img) {
            $rel_img = get_template_directory_uri() . '/assets/images/placeholder-image-treatment-rhoeskin.webp';
        }
        $related_items[] = [
            'title' => get_the_title($rel_id),
            'url'   => get_permalink($rel_id),
            'img'   => $rel_img,
        ];
    }
}

if (empty($related_items)) {
    $rel_query = new WP_Query([
        'post_type'      => 'treatment',
        'posts_per_page' => 4,
        'post__not_in'   => [$post_id],
        'orderby'        => 'rand',
    ]);
    if ($rel_query->have_posts()) {
        while ($rel_query->have_posts()) {
            $rel_query->the_post();
            $rel_img = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
            if (!$rel_img) {
                $rel_img = get_template_directory_uri() . '/assets/images/placeholder-image-treatment-rhoeskin.webp';
            }
            $related_items[] = [
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'img'   => $rel_img,
            ];
        }
        wp_reset_postdata();
    }
}
?>

<?php if (!empty($related_items)) : ?>
<section class="related">
  <div class="container">
    <div class="related__head">
      <span class="eyebrow">Rekomendasi</span>
      <h2>Treatment Terkait</h2>
    </div>
    <div class="related__grid">
      <?php foreach ($related_items as $rel) : ?>
        <a class="t-item" href="<?php echo esc_url($rel['url']); ?>">
          <img src="<?php echo esc_url($rel['img']); ?>" alt="<?php echo esc_attr($rel['title']); ?>">
          <div class="cap"><?php echo esc_html($rel['title']); ?></div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>

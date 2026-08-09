<?php
/**
 * Treatment Archive Template — matches services.html
 *
 * @package Alya_Esthetic
 */

get_header();

$current_cat     = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
$current_service = isset($_GET['service']) ? sanitize_text_field($_GET['service']) : '';
$search_query    = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

// 4 Pillar Service Categories
$service_terms = get_terms([
    'taxonomy'   => ['treatment_category', 'service'],
    'hide_empty' => false,
    'orderby'    => 'term_id',
    'order'      => 'ASC',
]);

$treat_img_uri = get_template_directory_uri() . '/assets/images/treatments';
$treatment_placeholder = get_template_directory_uri() . '/assets/images/placeholder-image-treatment-rhoeskin.webp';
$fallback_imgs = [
    'skin-serenity'     => $treatment_placeholder,
    'beauty-advance'    => $treatment_placeholder,
    'slimming-wellness' => $treatment_placeholder,
    'alya-beauty-bar'   => $treatment_placeholder,
];
?>

<!-- ============ PAGE HEADER ============ -->
<div class="pagehead">
  <div class="container">
    <span class="eyebrow" style="color:#efd9c8">One Stop Beauty Solution</span>
    <h1>Layanan &amp; Treatment Kami</h1>
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
      <span>/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('treatment')); ?>" style="color:#fff">Layanan</a>
    </div>
  </div>
</div>

<!-- ============ CATEGORY OVERVIEW ============ -->
<?php if (!empty($service_terms) && !is_wp_error($service_terms)) : ?>
<section class="categories">
  <div class="container">
    <div class="section__head section__head--center" style="margin-bottom:44px">
      <span class="eyebrow">Kategori Layanan</span>
      <h2>4 Pilar Layanan Rhoé Skin</h2>
      <p class="lead" style="margin:0 auto">Rhoé Skin adalah klinik kecantikan yang mengedepankan hospitality, kesehatan, dan solusi satu pintu untuk semua kebutuhan Anda.</p>
    </div>
    <div class="cat-grid">
      <?php foreach ($service_terms as $term) :
        $cat_thumb = get_term_meta($term->term_id, 'thumbnail_id', true);
        $cat_img_url = $cat_thumb ? wp_get_attachment_image_url($cat_thumb, 'large') : '';
        if (!$cat_img_url) {
            $cat_img_url = $fallback_imgs[$term->slug] ?? $treatment_placeholder;
        }
        $cat_link = add_query_arg('service', $term->slug, get_post_type_archive_link('treatment'));
      ?>
        <a class="cat-card" href="<?php echo esc_url($cat_link); ?>">
          <div class="thumb">
            <img src="<?php echo esc_url($cat_img_url); ?>" alt="<?php echo esc_attr($term->name); ?>" loading="lazy">
          </div>
          <div class="c-body">
            <h3><?php echo esc_html($term->name); ?></h3>
            <p><?php echo esc_html($term->description ?: 'Setiap layanan dirancang khusus untuk memenuhi kebutuhan estetika Anda.'); ?></p>
            <span class="link">
              Lihat Semua Treatment
              <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg>
            </span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ FILTER BAR ============ -->
<div class="filterbar">
  <div class="container">
    <div class="chips">
      <a class="chip <?php echo empty($current_service) ? 'active' : ''; ?>"
         href="<?php echo esc_url(get_post_type_archive_link('treatment')); ?>"
         data-filter="semua">
        Semua Layanan
      </a>
      <?php if (!empty($service_terms) && !is_wp_error($service_terms)) : ?>
        <?php foreach ($service_terms as $term) : ?>
          <a class="chip <?php echo ($current_service === $term->slug) ? 'active' : ''; ?>"
             href="<?php echo esc_url(add_query_arg('service', $term->slug, get_post_type_archive_link('treatment'))); ?>"
             data-filter="<?php echo esc_attr($term->slug); ?>">
            <?php echo esc_html($term->name); ?>
          </a>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <div class="searchbox">
      <svg viewBox="0 0 24 24"><path d="M15.5 14h-.8l-.3-.3a6.5 6.5 0 10-.7.7l.3.3v.8l5 5L20.5 19l-5-5zm-6 0a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/></svg>
      <input type="text" id="searchInput" placeholder="Cari treatment..." value="<?php echo esc_attr($search_query); ?>">
    </div>
  </div>
</div>

<!-- ============ ALL TREATMENTS CATALOG ============ -->
<?php
$args = [
    'post_type'      => 'treatment',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
];

$tax_query = [];
if (!empty($current_service)) {
    $tax_query[] = [
        'relation' => 'OR',
        [
            'taxonomy' => 'service',
            'field'    => 'slug',
            'terms'    => $current_service,
        ],
        [
            'taxonomy' => 'treatment_category',
            'field'    => 'slug',
            'terms'    => $current_service,
        ],
    ];
}
if (!empty($tax_query)) {
    $args['tax_query'] = $tax_query;
}
if (!empty($search_query)) {
    $args['s'] = $search_query;
}

$treatments = new WP_Query($args);
?>

<section class="catalog">
  <div class="container">
    <div class="catalog__head">
      <div>
        <span class="eyebrow">Katalog Lengkap</span>
        <h2>Semua Treatment</h2>
      </div>
      <p class="lead">Pilih treatment sesuai kebutuhan kulit, tubuh, dan gaya hidup Anda.</p>
    </div>

    <div class="t-grid" id="treatGrid">
      <?php if ($treatments->have_posts()) : ?>
        <?php while ($treatments->have_posts()) : $treatments->the_post();
          $post_id = get_the_ID();
          $terms = get_the_terms($post_id, 'treatment_category');
          if (empty($terms) || is_wp_error($terms)) {
              $terms = get_the_terms($post_id, 'service');
          }
          $cat_name = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Layanan';
          $cat_slug = ($terms && !is_wp_error($terms)) ? $terms[0]->slug : '';
          $img_url = get_the_post_thumbnail_url($post_id, 'medium_large');
          if (!$img_url) {
              $acf_img = get_field('alya_treatment_image', $post_id) ?: get_field('alya_image', $post_id);
              if (is_array($acf_img)) {
                  $img_url = $acf_img['url'] ?? '';
              } elseif (is_numeric($acf_img)) {
                  $img_url = wp_get_attachment_image_url($acf_img, 'medium_large');
              } elseif (is_string($acf_img)) {
                  $img_url = $acf_img;
              }
          }
          if (!$img_url) {
              $img_url = $treatment_placeholder;
          }
        ?>
          <a class="t-card" href="<?php the_permalink(); ?>" data-cat="<?php echo esc_attr($cat_slug); ?>">
            <div class="thumb">
              <span class="badge"><?php echo esc_html($cat_name); ?></span>
              <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
            </div>
            <div class="t-body">
              <h4><?php the_title(); ?></h4>
              <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 12)); ?></p>
              <div class="t-foot">
                <span></span>
                <span class="link">
                  Detail
                  <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6-1.4-1.4L12.2 12 7.6 7.4z"/></svg>
                </span>
              </div>
            </div>
          </a>
        <?php endwhile; wp_reset_postdata(); ?>
      <?php endif; ?>
    </div>

    <div class="empty-state <?php echo (!$treatments->have_posts()) ? 'show' : ''; ?>" id="emptyState">
      <p>Tidak ada treatment yang cocok dengan pencarian Anda.</p>
    </div>
  </div>
</section>

<!-- ============ CTA ============ -->
<section class="cta" style="background-image:url('https://alyaesthetic.id/wp-content/uploads/2025/11/DSCF5148-scaled-e1762063528772.jpg')">
  <div class="container">
    <h2>Belum Yakin Treatment yang Tepat?</h2>
    <p>Konsultasikan kebutuhan kecantikan Anda bersama tim dokter profesional kami di Jakarta Selatan.</p>
    <a class="btn btn--ghostdark"
       href="<?php echo esc_url(alya_wa_link('Halo, saya ingin konsultasi tentang treatment yang tepat.')); ?>"
       target="_blank"
       rel="noopener noreferrer">
      Konsultasi via WhatsApp
    </a>
  </div>
</section>

<?php get_footer(); ?>
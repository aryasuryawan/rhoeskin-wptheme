<?php
/**
 * Single Doctor Template — matches dokter-single.html
 *
 * @package Alya_Esthetic
 */

get_header();

while (have_posts()) : the_post();

$pos = get_field('alya_position') ?: 'Dokter Umum';
$about = get_field('alya_about') ?: get_the_excerpt();
$avatar_id = get_field('alya_avatar');
$hero_bg = is_array($avatar_id) && isset($avatar_id['url']) ? $avatar_id['url'] : get_the_post_thumbnail_url(get_the_ID(), 'full');
$schedules = alya_parse_schedule(get_field('alya_schedule'));
$treatments = get_field('alya_services') ?: [];
$education = alya_parse_table(get_field('alya_education'));
$experience = alya_parse_table(get_field('alya_experience'));
?>

<!-- HERO -->
<section class="pagehead pagehead--short" style="background: linear-gradient(135deg, #b0836a 0%, #8a5c44 100%)">
  <div class="container">
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span>
      <a href="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>">Dokter Kami</a><span>/</span>
      <span><?php the_title(); ?></span>
    </div>
  </div>
</section>

<!-- MAIN -->
<section class="section">
  <div class="container">

    <!-- TOP ROW -->
    <div style="display:grid;grid-template-columns:360px 1fr;gap:40px;align-items:start;margin-top:-60px;position:relative;z-index:2">

      <div class="t-cover">
        <?php if ($hero_bg) : ?>
          <img src="<?php echo esc_url($hero_bg); ?>" alt="<?php the_title_attribute(); ?>"
               style="width:100%;border-radius:20px;object-fit:cover;aspect-ratio:4/5;box-shadow:var(--shadow)">
        <?php endif; ?>
      </div>

      <div>
        <span class="eyebrow" style="color:#fff"><?php echo esc_html($pos); ?></span>
        <h1 style="margin-top:8px"><?php the_title(); ?></h1>
        <p class="lead" style="margin-top:12px;color:var(--ink-light)"><?php echo wp_kses_post($about); ?></p>

        <?php if ($schedules) : ?>
        <div style="margin-top:24px;display:flex;flex-wrap:wrap;gap:12px">
          <?php foreach ($schedules as $s) :
            $day = is_array($s) ? ($s['day'] ?? '') : '';
            $hours = is_array($s) ? ($s['hours'] ?? '') : '';
            if (!$day) continue;
          ?>
          <div style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:12px;background:var(--bg-alt)">
            <svg viewBox="0 0 24 24" width="18" height="18" style="flex:none;fill:var(--brand)"><path d="M12 6v6l4 2-.8 1.6-5.2-2.6V6h2z"/></svg>
            <div>
              <div style="font-size:.8rem;color:var(--ink-light)"><?php echo esc_html($day); ?></div>
              <div style="font-weight:600;font-size:.9rem"><?php echo esc_html($hours); ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ($treatments) : ?>
        <div style="margin-top:24px">
          <h4 style="margin-bottom:8px">Konsultasi &amp; Treatment</h4>
          <div style="display:flex;flex-wrap:wrap;gap:8px">
            <?php foreach ($treatments as $t) :
              $t_name = is_object($t) ? $t->post_title : $t;
            ?>
              <span class="chip chip--outline"><?php echo esc_html($t_name); ?></span>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($education) : ?>
        <div style="margin-top:24px">
          <h4 style="margin-bottom:8px">Pendidikan</h4>
          <ul style="list-style:none;padding:0;margin:0">
            <?php foreach ($education as $edu) : ?>
            <li style="padding:6px 0;border-bottom:1px solid var(--line);display:flex;align-items:center;gap:8px">
              <svg viewBox="0 0 24 24" width="16" height="16" style="fill:var(--brand);flex:none"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
              <span style="font-weight:600;font-size:.9rem"><?php echo esc_html($edu['col1']); ?></span>
              <?php if (!empty($edu['col2'])) : ?>
                <span style="font-size:.8rem;color:var(--ink-light)">— <?php echo esc_html($edu['col2']); ?></span>
              <?php endif; ?>
              <?php if (!empty($edu['col3'])) : ?>
                <span style="font-size:.8rem;color:var(--ink-light)"><?php echo esc_html($edu['col3']); ?></span>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if ($experience) : ?>
        <div style="margin-top:24px">
          <h4 style="margin-bottom:8px">Pengalaman</h4>
          <ul style="list-style:none;padding:0;margin:0">
            <?php foreach ($experience as $exp) : ?>
            <li style="padding:6px 0;border-bottom:1px solid var(--line);display:flex;align-items:center;gap:8px">
              <svg viewBox="0 0 24 24" width="16" height="16" style="fill:var(--brand);flex:none"><path d="M20 6h-4V4c0-1.1-.9-2-2-2h-4c-1.1 0-2 .9-2 2v2H4c-1.1 0-2 .9-2 2v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6 0h-4V4h4v2z"/></svg>
              <span style="font-weight:600;font-size:.9rem"><?php echo esc_html($exp['col1']); ?></span>
              <?php if (!empty($exp['col2'])) : ?>
                <span style="font-size:.8rem;color:var(--ink-light)">— <?php echo esc_html($exp['col2']); ?></span>
              <?php endif; ?>
              <?php if (!empty($exp['col3'])) : ?>
                <span style="font-size:.8rem;color:var(--ink-light)"><?php echo esc_html($exp['col3']); ?></span>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- ABOUT -->
    <?php
    $full_about = get_field('alya_about');
    if ($full_about) :
    ?>
    <div style="margin-top:60px;padding:40px;background:var(--bg-alt);border-radius:20px">
      <h3 style="margin-bottom:16px">Tentang <?php the_title(); ?></h3>
      <div class="entry-content"><?php echo wp_kses_post($full_about); ?></div>
    </div>
    <?php endif; ?>

    <!-- RELATED DOCTORS -->
    <?php
    $related = alya_get_posts('doctor', ['post__not_in' => [get_the_ID()], 'posts_per_page' => 3]);
    if ($related->have_posts()) :
    ?>
    <div style="margin-top:80px">
      <div class="catalog__head" style="display:flex;align-items:center;justify-content:space-between">
        <div>
          <span class="eyebrow">Dokter Lainnya</span>
          <h2>Temui Dokter Kami</h2>
        </div>
        <a href="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>" class="btn btn--outline">Lihat Semua</a>
      </div>
      <div class="doc-grid" style="margin-top:24px">
        <?php while ($related->have_posts()) : $related->the_post();
          $doc_avatar = get_field('alya_avatar');
          $doc_avatar_url = is_array($doc_avatar) && isset($doc_avatar['url']) ? $doc_avatar['url'] : get_the_post_thumbnail_url(get_the_ID(), 'full');
        ?>
        <a href="<?php the_permalink(); ?>" class="doc-card">
          <div class="doc-card__img">
            <?php if ($doc_avatar_url) : ?>
              <img src="<?php echo esc_url($doc_avatar_url); ?>" alt="<?php the_title_attribute(); ?>">
            <?php endif; ?>
          </div>
          <div class="doc-card__body">
            <h3><?php the_title(); ?></h3>
            <span class="tag"><?php echo esc_html(get_field('alya_position')); ?></span>
          </div>
        </a>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>

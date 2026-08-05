<?php
/**
 * Single Post Template — matches artikel-single.html
 *
 * @package Alya_Esthetic
 */

get_header();

while (have_posts()) : the_post();

$hero_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
$date = get_the_date('d M Y');
$author = get_the_author();
$cat = '';
$cats = get_the_category();
if (!empty($cats)) {
    $cat = $cats[0]->name;
}
?>

<!-- HERO -->
<div class="art-head" <?php if ($hero_img) : ?>style="background-image:url('<?php echo esc_url($hero_img); ?>')"<?php endif; ?>>
  <div class="container">
    <div class="crumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a><span>/</span>
      <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">Artikel</a><span>/</span>
      <span><?php the_title(); ?></span>
    </div>
    <?php if ($cat) : ?>
      <span class="eyebrow"><?php echo esc_html($cat); ?></span>
    <?php endif; ?>
    <h1><?php the_title(); ?></h1>
    <div class="meta">
      <span><?php echo esc_html($date); ?></span> · <span>Oleh <?php echo esc_html($author); ?></span>
    </div>
  </div>
</div>

<!-- SHARE RAIL -->
<aside class="share-rail" id="shareRail">
  <div class="share-rail__inner">
    <button onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),'_blank')" title="Bagikan ke Facebook">
      <svg viewBox="0 0 24 24" width="20" height="20"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3V2z" fill="currentColor"/></svg>
    </button>
    <button onclick="window.open('https://twitter.com/intent/tweet?url='+encodeURIComponent(location.href),'_blank')" title="Bagikan ke X">
      <svg viewBox="0 0 24 24" width="20" height="20"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" fill="currentColor"/></svg>
    </button>
    <button onclick="navigator.share({title:document.title,url:location.href}).catch(()=>{})" title="Bagikan">
      <svg viewBox="0 0 24 24" width="20" height="20"><circle cx="18" cy="5" r="3" fill="currentColor"/><circle cx="6" cy="12" r="3" fill="currentColor"/><circle cx="18" cy="19" r="3" fill="currentColor"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49" stroke="currentColor" stroke-width="1.5"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49" stroke="currentColor" stroke-width="1.5"/></svg>
    </button>
  </div>
</aside>

<!-- CONTENT -->
<div class="art-layout">
  <div class="container">

    <!-- ART CONTENT -->
    <article class="art-content">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>

      <div class="tags-row" id="tagsRow">
        <?php
        $tags = get_the_tags();
        if ($tags) :
          foreach ($tags as $tag) :
        ?>
        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="chip"><?php echo esc_html($tag->name); ?></a>
        <?php
          endforeach;
        endif;
        ?>
      </div>

      <!-- SHARE BOTTOM -->
      <div style="margin-top:40px;padding-top:24px;border-top:1px solid var(--line)">
        <div style="display:flex;align-items:center;gap:12px">
          <span style="font-size:.86rem;font-weight:600;color:var(--ink-light)">Bagikan:</span>
          <div style="display:flex;gap:8px">
            <button onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),'_blank')" style="width:36px;height:36px;border-radius:50%;border:1px solid var(--line);display:flex;align-items:center;justify-content:center;background:var(--bg);cursor:pointer;transition:all .2s" onmouseover="this.style.borderColor='var(--brand)';this.style.color='var(--brand)'" onmouseout="this.style.borderColor='var(--line)';this.style.color=''">
              <svg viewBox="0 0 24 24" width="16" height="16"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3V2z" fill="currentColor"/></svg>
            </button>
            <button onclick="window.open('https://twitter.com/intent/tweet?url='+encodeURIComponent(location.href),'_blank')" style="width:36px;height:36px;border-radius:50%;border:1px solid var(--line);display:flex;align-items:center;justify-content:center;background:var(--bg);cursor:pointer;transition:all .2s" onmouseover="this.style.borderColor='var(--brand)';this.style.color='var(--brand)'" onmouseout="this.style.borderColor='var(--line)';this.style.color=''">
              <svg viewBox="0 0 24 24" width="16" height="16"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" fill="currentColor"/></svg>
            </button>
            <button onclick="navigator.share({title:document.title,url:location.href}).catch(()=>{})" style="width:36px;height:36px;border-radius:50%;border:1px solid var(--line);display:flex;align-items:center;justify-content:center;background:var(--bg);cursor:pointer;transition:all .2s" onmouseover="this.style.borderColor='var(--brand)';this.style.color='var(--brand)'" onmouseout="this.style.borderColor='var(--line)';this.style.color=''">
              <svg viewBox="0 0 24 24" width="16" height="16"><circle cx="18" cy="5" r="3" fill="currentColor"/><circle cx="6" cy="12" r="3" fill="currentColor"/><circle cx="18" cy="19" r="3" fill="currentColor"/></svg>
            </button>
          </div>
        </div>
      </div>

      <!-- POST NAV -->
      <div style="margin-top:40px;padding-top:24px;border-top:1px solid var(--line);display:grid;grid-template-columns:1fr 1fr;gap:24px">
        <?php
        $prev = get_previous_post();
        $next = get_next_post();
        ?>
        <?php if ($prev) : ?>
        <a href="<?php echo esc_url(get_permalink($prev->ID)); ?>" style="text-align:left;text-decoration:none;color:var(--ink);padding:16px;border-radius:12px;border:1px solid var(--line);transition:border-color .2s" onmouseover="this.style.borderColor='var(--brand)'" onmouseout="this.style.borderColor='var(--line)'">
          <span style="font-size:.76rem;text-transform:uppercase;letter-spacing:.06em;color:var(--ink-light);display:block;margin-bottom:6px">← Sebelumnya</span>
          <span style="font-weight:600;font-size:.94rem;line-height:1.4"><?php echo esc_html($prev->post_title); ?></span>
        </a>
        <?php else : ?>
        <div></div>
        <?php endif; ?>

        <?php if ($next) : ?>
        <a href="<?php echo esc_url(get_permalink($next->ID)); ?>" style="text-align:right;text-decoration:none;color:var(--ink);padding:16px;border-radius:12px;border:1px solid var(--line);transition:border-color .2s" onmouseover="this.style.borderColor='var(--brand)'" onmouseout="this.style.borderColor='var(--line)'">
          <span style="font-size:.76rem;text-transform:uppercase;letter-spacing:.06em;color:var(--ink-light);display:block;margin-bottom:6px">Selanjutnya →</span>
          <span style="font-weight:600;font-size:.94rem;line-height:1.4"><?php echo esc_html($next->post_title); ?></span>
        </a>
        <?php endif; ?>
      </div>
    </article>

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="side-box">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
          <div style="width:44px;height:44px;border-radius:50%;background:var(--brand-soft);display:flex;align-items:center;justify-content:center;flex:none">
            <svg viewBox="0 0 24 24" width="22" height="22" style="fill:var(--brand)"><path d="M12 2a7 7 0 00-7 7c0 2 .8 3.6 1.7 5.1C8 15.9 9 18.4 9 21h6c0-2.6 1-5.1 2.3-6.9C18.2 12.6 19 11 19 9a7 7 0 00-7-7z"/></svg>
          </div>
          <div>
            <h4 style="margin:0;font-size:1rem">Gratis Konsultasi Online</h4>
            <span style="font-size:.8rem;color:var(--ink-light)">Chat langsung dengan tim kami</span>
          </div>
        </div>
        <a href="https://api.whatsapp.com/send?phone=6281290000000&text=Halo%20Alya%20Esthetic%2C%20saya%20ingin%20konsultasi" class="btn btn--brand" style="width:100%;justify-content:center">
          Chat Sekarang
        </a>
      </div>

      <div class="side-box">
        <h4>Layanan Kami</h4>
        <div style="display:flex;flex-direction:column;gap:8px;margin-top:8px">
          <?php
          $svc_args = [
            'post_type'      => 'treatment',
            'posts_per_page' => 5,
            'orderby'        => 'rand',
          ];
          $svc_q = new WP_Query($svc_args);
          while ($svc_q->have_posts()) : $svc_q->the_post();
          ?>
          <a href="<?php the_permalink(); ?>" style="display:flex;align-items:center;gap:10px;padding:8px;border-radius:8px;transition:background .2s;text-decoration:none;color:var(--ink)" onmouseover="this.style.background='var(--bg-alt)'" onmouseout="this.style.background='transparent'">
            <span style="font-size:.9rem;font-weight:500"><?php the_title(); ?></span>
          </a>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </aside>

  </div>
</div>

<!-- CTA -->
<section class="cta-band">
  <div class="container">
    <div class="cta-band__inner">
      <div>
        <h2>Mau Tampil Cantik Alami?</h2>
        <p>Konsultasikan kebutuhan treatment kulit &amp; kecantikan Anda bersama dokter spesialis kami. Konsultasi online gratis — chat sekarang.</p>
      </div>
      <a href="https://api.whatsapp.com/send?phone=6281290000000&text=Halo%20Alya%20Esthetic%2C%20saya%20ingin%20konsultasi" class="btn btn--white">Chat Sekarang</a>
    </div>
  </div>
</section>

<!-- RELATED ARTICLES -->
<?php
$related_args = [
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post__not_in'   => [get_the_ID()],
];
$related_q = new WP_Query($related_args);
if ($related_q->have_posts()) :
?>
<section class="section">
  <div class="container">
    <div class="related__head" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
      <div>
        <span class="eyebrow">Baca Juga</span>
        <h2>Artikel Terkait</h2>
      </div>
      <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="btn btn--outline btn--sm">Lihat Semua</a>
    </div>
    <div class="art-grid">
      <?php while ($related_q->have_posts()) : $related_q->the_post();
        $art_img = get_the_post_thumbnail_url(get_the_ID(), 'full');
      ?>
      <a href="<?php the_permalink(); ?>" class="post-card">
        <div class="post-card__img">
          <?php if ($art_img) : ?>
            <img src="<?php echo esc_url($art_img); ?>" alt="<?php the_title_attribute(); ?>">
          <?php endif; ?>
        </div>
        <div class="post-card__body">
          <span class="post-card__tag"><?php echo esc_html(get_the_date('d M Y')); ?></span>
          <h3><?php the_title(); ?></h3>
          <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 12)); ?></p>
        </div>
      </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>

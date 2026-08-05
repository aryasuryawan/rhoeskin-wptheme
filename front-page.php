<?php
/**
 * Front Page Template — Dual Homepage Composer
 *
 * Loads default or V2 editorial sections based on Customizer setting:
 * Appearance → Customize → Homepage → Homepage Style
 *
 * @package Alya_Esthetic
 */

get_header();

$homepage_style = get_theme_mod('alya_homepage_style', 'default');
?>

<?php if ($homepage_style === 'v2') : ?>

<!-- ════════════════════════════════════════════ HERO V2 ════════════════════════════════════════════ -->
<?php get_template_part('template-parts/hero', 'v2'); ?>

<!-- ════════════════════════════════════════════ MARQUEE ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_marquee', true)) : ?>
    <?php get_template_part('template-parts/marquee'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ ABOUT V2 ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_about', true)) : ?>
    <?php get_template_part('template-parts/about', 'v2'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ SERVICES V2 ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_services_v2', true)) : ?>
    <?php get_template_part('template-parts/services-grid', 'v2'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ SIGNATURE BANNER ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_signature', true)) : ?>
    <?php get_template_part('template-parts/signature-banner'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ STATS BAND ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_stats_band', true)) : ?>
    <?php get_template_part('template-parts/stats-band'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ DOCTORS V2 ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_doctors_grid', true)) : ?>
    <?php get_template_part('template-parts/doctors-grid', 'v2'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ TESTIMONIALS V2 ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_testimonials', true)) : ?>
    <?php get_template_part('template-parts/testimonials', 'v2'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ INSTAGRAM FEED ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_instagram', true)) : ?>
    <?php get_template_part('template-parts/instagram-feed'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ ARTICLES TEASER ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_articles', true)) : ?>
    <?php get_template_part('template-parts/articles-teaser'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ FAQ ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_faq', true)) : ?>
    <?php get_template_part('template-parts/faq'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ CAREER STRIP ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_career', true)) : ?>
    <?php get_template_part('template-parts/career-strip'); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ CONTACT V2 ════════════════════════════════════════════ -->
<?php if (get_theme_mod('alya_v2_show_contact', true)) : ?>
    <?php get_template_part('template-parts/contact', 'v2'); ?>
<?php endif; ?>

<?php else : ?>

<!-- ════════════════════════════════════════════ HERO (Default) ════════════════════════════════════════════ -->
<section id="hero" class="hero" <?php $hero_bg = get_theme_mod('alya_hero_bg', alya_field_raw('alya_hero_bg')); if (is_array($hero_bg)) $hero_bg = $hero_bg['url']; if ($hero_bg) echo 'style="background-image:url(' . esc_url($hero_bg) . ')"'; ?>>
    <div class="hero__overlay"></div>
    <div class="container">
        <div class="hero__content">
            <span class="eyebrow"><?php echo esc_html(get_theme_mod('alya_clinic_tagline', 'Your Beauty, Our Priority')); ?></span>
            <h1 class="hero__title"><?php echo esc_html(get_theme_mod('alya_hero_title', alya_field_raw('alya_hero_title') ?: 'Kecantikan Dimulai dari Sini')); ?></h1>
            <p class="hero__subtitle"><?php echo esc_html(get_theme_mod('alya_hero_subtitle', alya_field_raw('alya_hero_subtitle') ?: 'Treatment kecantikan modern dengan teknologi terkini dan dokter berpengalaman.')); ?></p>
            <div class="hero__actions">
                <a href="<?php echo esc_url(get_theme_mod('alya_hero_cta_url', alya_field_raw('alya_hero_cta')['url'] ?? '#konsultasi')); ?>" class="btn btn--primary btn--lg">
                    <?php echo esc_html(get_theme_mod('alya_hero_cta_text', alya_field_raw('alya_hero_cta')['title'] ?? 'Konsultasi Sekarang')); ?>
                    <?php echo alya_icon('arrow-right'); ?>
                </a>
                <a href="<?php echo esc_url(get_theme_mod('alya_hero_cta2_url', '/layanan')); ?>" class="btn btn--outline btn--lg">
                    <?php echo esc_html(get_theme_mod('alya_hero_cta2_text', 'Lihat Layanan')); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ════════════════════════════════════════════ SERVICES (Default) ════════════════════════════════════════════ -->
<?php
$services_title    = get_theme_mod('alya_services_title', alya_field_raw('alya_services_title') ?: 'Layanan Kami');
$services_subtitle = get_theme_mod('alya_services_subtitle', alya_field_raw('alya_services_subtitle') ?: 'Solusi kecantikan terlengkap untuk kebutuhan Anda');
$services          = alya_get_posts('service', ['posts_per_page' => 6]);
if ($services->have_posts()) :
?>
<?php alya_section('layanan', 'bg-light'); ?>
    <?php alya_section_header('Layanan', $services_title, $services_subtitle, 'center'); ?>
    <div class="cards-grid cards-grid--3">
        <?php while ($services->have_posts()) : $services->the_post(); ?>
            <?php alya_card([
                'title' => get_the_title(),
                'desc'  => wp_trim_words(get_the_excerpt(), 15),
                'image' => get_the_post_thumbnail(get_the_ID(), 'alya-card'),
                'link'  => get_the_permalink(),
                'icon'  => alya_icon('check'),
                'class' => 'card--service',
            ]); ?>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <div class="section__cta">
        <a href="<?php echo esc_url(get_post_type_archive_link('service')); ?>" class="btn btn--primary">
            Lihat Semua Layanan
            <?php echo alya_icon('arrow-right'); ?>
        </a>
    </div>
<?php alya_section_close(); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ ABOUT + STATS (Default) ════════════════════════════════════════════ -->
<?php
$about_title = get_theme_mod('alya_about_title', alya_field_raw('alya_about_title') ?: 'Tentang Alya Esthetic');
$about_desc  = get_theme_mod('alya_about_desc', alya_field_raw('alya_about_desc') ?: '<p>Alya Esthetic Center adalah klinik estetik medis terpercaya yang menghadirkan treatment kecantikan modern dengan standar internasional.</p>');
$about_image = get_theme_mod('alya_about_image', alya_field_raw('alya_about_image'));
if (is_string($about_image)) $about_image = ['url' => $about_image];
$stats = alya_field_raw('alya_home_stats') ?: [
    ['number' => '10', 'suffix' => '+', 'label' => 'Tahun Pengalaman'],
    ['number' => '5000', 'suffix' => '+', 'label' => 'Pasien Puas'],
    ['number' => '15', 'suffix' => '+', 'label' => 'Dokter Spesialis'],
    ['number' => '50', 'suffix' => '+', 'label' => 'Treatment Tersedia'],
];
?>
<?php alya_section('tentang'); ?>
    <div class="about-grid">
        <div class="about-grid__image">
            <?php if ($about_image && is_array($about_image)) : ?>
                <img src="<?php echo esc_url($about_image['url']); ?>" alt="<?php echo esc_attr($about_title); ?>" loading="lazy" width="600" height="400">
            <?php endif; ?>
        </div>
        <div class="about-grid__content">
            <span class="eyebrow">Tentang Kami</span>
            <h2 class="section__title"><?php echo esc_html($about_title); ?></h2>
            <div class="about-grid__desc"><?php echo wp_kses_post($about_desc); ?></div>
            <div class="stats-row">
                <?php foreach ($stats as $stat) : ?>
                    <div class="stat">
                        <span class="stat__number"><?php echo esc_html($stat['number']); ?><?php echo esc_html($stat['suffix']); ?></span>
                        <span class="stat__label"><?php echo esc_html($stat['label']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="<?php echo esc_url(home_url('/tentang')); ?>" class="btn btn--primary">
                Selengkapnya
                <?php echo alya_icon('arrow-right'); ?>
            </a>
        </div>
    </div>
<?php alya_section_close(); ?>

<!-- ════════════════════════════════════════════ DOCTORS (Default) ════════════════════════════════════════════ -->
<?php
$doctors_title = get_theme_mod('alya_doctors_title', alya_field_raw('alya_doctors_title') ?: 'Tim Dokter Kami');
$doctors       = alya_get_posts('doctor', ['posts_per_page' => 4, 'meta_key' => 'alya_featured', 'meta_value' => '1', 'meta_compare' => 'NOT EXISTS']);
if ($doctors->have_posts()) :
?>
<?php alya_section('dokter', 'bg-light'); ?>
    <?php alya_section_header('Dokter', $doctors_title, 'Dokter spesialis berpengalaman yang siap membantu Anda.', 'center'); ?>
    <div class="cards-grid cards-grid--4">
        <?php while ($doctors->have_posts()) : $doctors->the_post(); ?>
            <?php
            $avatar = get_field('alya_avatar');
            $position = get_field('alya_position');
            ?>
            <article class="card card--doctor">
                <div class="card__image">
                    <?php if ($avatar && is_array($avatar)) : ?>
                        <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="300" height="300" loading="lazy">
                    <?php else : ?>
                        <?php echo get_the_post_thumbnail(get_the_ID(), 'alya-card'); ?>
                    <?php endif; ?>
                </div>
                <div class="card__body">
                    <h3 class="card__title"><?php the_title(); ?></h3>
                    <?php if ($position) : ?>
                        <p class="card__meta"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>" class="link">
                        Lihat Profil
                        <?php echo alya_icon('arrow-right'); ?>
                    </a>
                </div>
            </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <div class="section__cta">
        <a href="<?php echo esc_url(get_post_type_archive_link('doctor')); ?>" class="btn btn--outline">
            Lihat Semua Dokter
            <?php echo alya_icon('arrow-right'); ?>
        </a>
    </div>
<?php alya_section_close(); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ TESTIMONIALS (Default) ════════════════════════════════════════════ -->
<?php
$testimonials_title = get_theme_mod('alya_testimonials_title', alya_field_raw('alya_testimonials_title') ?: 'Apa Kata Mereka');
$testimonials       = alya_get_posts('testimonial', ['posts_per_page' => 6]);
if ($testimonials->have_posts()) :
?>
<?php alya_section('testimoni'); ?>
    <?php alya_section_header('Testimoni', $testimonials_title, 'Kepuasan pasien adalah prioritas kami.', 'center'); ?>
    <div class="swiper" id="testimonial-swiper">
        <div class="swiper-wrapper">
            <?php while ($testimonials->have_posts()) : $testimonials->the_post(); ?>
                <div class="swiper-slide">
                    <?php
                    $rating = get_field('alya_rating') ?: 5;
                    $service_used = get_field('alya_service_used');
                    ?>
                    <article class="card card--testimonial">
                        <div class="card__quote">
                            <?php echo alya_icon('quote'); ?>
                        </div>
                        <div class="card__stars">
                            <?php echo alya_stars(5, $rating); ?>
                        </div>
                        <blockquote class="card__text">
                            <?php echo wp_kses_post(get_the_content()); ?>
                        </blockquote>
                        <div class="card__author">
                            <?php echo get_the_post_thumbnail(get_the_ID(), 'alya-thumb'); ?>
                            <div>
                                <h4 class="card__name"><?php the_title(); ?></h4>
                                <?php if ($service_used) : ?>
                                    <span class="card__service"><?php echo esc_html($service_used); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
<?php alya_section_close(); ?>
<?php endif; ?>

<!-- ════════════════════════════════════════════ CTA CONSULTATION (Default) ════════════════════════════════════════════ -->
<section id="konsultasi" class="cta-section">
    <div class="cta-section__overlay"></div>
    <div class="container">
        <div class="cta-section__content">
            <h2 class="cta-section__title">Siap untuk Konsultasi?</h2>
            <p class="cta-section__desc">Hubungi kami sekarang untuk konsultasi gratis dan dapatkan treatment terbaik untuk Anda.</p>
            <div class="cta-section__actions">
                <a href="<?php echo esc_url(alya_wa_link('Halo, saya ingin konsultasi.')); ?>" class="btn btn--wa btn--lg" target="_blank" rel="noopener noreferrer">
                    <?php echo alya_icon('whatsapp'); ?>
                    Chat WhatsApp
                </a>
                <a href="tel:<?php echo esc_attr(get_theme_mod('alya_phone_link', '6281290000000')); ?>" class="btn btn--primary btn--lg">
                    <?php echo alya_icon('phone'); ?>
                    <?php echo esc_html(get_theme_mod('alya_phone', '+62 812-9000-0000')); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>

<?php get_footer();
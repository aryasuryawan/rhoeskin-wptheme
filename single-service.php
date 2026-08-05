<?php
/**
 * Single Service Template
 *
 * @package Alya_Esthetic
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<?php alya_breadcrumbs(); ?>

<article id="service-<?php the_ID(); ?>" <?php post_class('service-single'); ?>>

    <!-- Hero -->
    <?php
    $hero_bg = get_field('alya_hero_bg');
    if (!$hero_bg && has_post_thumbnail()) $hero_bg = get_the_post_thumbnail_url(get_the_ID(), 'alya-hero');
    ?>
    <section class="page-hero <?php echo $hero_bg ? 'page-hero--bg' : ''; ?>" <?php if ($hero_bg) echo 'style="background-image:url(' . esc_url($hero_bg) . ')"'; ?>>
        <div class="page-hero__overlay"></div>
        <div class="container">
            <div class="page-hero__content">
                <?php
                $terms = get_the_terms(get_the_ID(), 'service_category');
                if ($terms && !is_wp_error($terms)) :
                ?>
                    <span class="eyebrow"><?php echo esc_html($terms[0]->name); ?></span>
                <?php endif; ?>
                <h1 class="page-hero__title"><?php the_title(); ?></h1>
                <?php if (get_field('alya_subtitle')) : ?>
                    <p class="page-hero__subtitle"><?php echo esc_html(get_field('alya_subtitle')); ?></p>
                <?php endif; ?>
                <div class="page-hero__actions">
                    <a href="<?php echo esc_url(alya_wa_link('Halo, saya ingin tahu tentang ' . get_the_title())); ?>" class="btn btn--wa" target="_blank" rel="noopener noreferrer">
                        <?php echo alya_icon('whatsapp'); ?>
                        Konsultasi
                    </a>
                    <a href="#proses" class="btn btn--outline">
                        Lihat Proses
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Content + Sidebar Layout -->
        <div class="service-single__layout">
            <!-- Main Content -->
            <div class="service-single__main">

                <!-- Benefits -->
                <?php
                $benefits = alya_parse_benefits(get_field('alya_benefits'));
                if ($benefits) :
                ?>
                    <section class="service-section" id="manfaat">
                        <h2>Manfaat Treatment</h2>
                        <div class="benefits-grid">
                            <?php foreach ($benefits as $benefit) : ?>
                                <div class="benefit">
                                    <div class="benefit__icon"><?php echo alya_icon('check'); ?></div>
                                    <h3 class="benefit__title"><?php echo esc_html($benefit['title']); ?></h3>
                                    <p class="benefit__desc"><?php echo esc_html($benefit['description']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Process -->
                <?php
                $process = alya_parse_steps(get_field('alya_process'));
                if ($process) :
                ?>
                    <section class="service-section" id="proses">
                        <h2>Proses Treatment</h2>
                        <div class="process-steps">
                            <?php foreach ($process as $step) : ?>
                                <div class="process-step">
                                    <div class="process-step__number"><?php echo esc_html($step['step']); ?></div>
                                    <div class="process-step__content">
                                        <h3 class="process-step__title"><?php echo esc_html($step['title']); ?></h3>
                                        <p class="process-step__desc"><?php echo esc_html($step['description']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Gallery -->
                <?php
                $gallery = get_field('alya_gallery');
                if ($gallery) :
                ?>
                    <section class="service-section" id="galeri">
                        <h2>Galeri</h2>
                        <div class="gallery-grid">
                            <?php foreach ($gallery as $img_id) :
                                $img_url = wp_get_attachment_url($img_id);
                                if (!$img_url) continue;
                            ?>
                                <a href="<?php echo esc_url($img_url); ?>" class="gallery-item" data-lightbox>
                                    <?php echo wp_get_attachment_image($img_id, 'medium_large', false, ['alt' => esc_attr(get_the_title() . ' galeri'), 'loading' => 'lazy', 'width' => 400, 'height' => 300]); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- FAQs -->
                <?php
                $faqs = alya_parse_faqs(get_field('alya_faqs'));
                if ($faqs) :
                ?>
                    <section class="service-section" id="faq">
                        <h2>Pertanyaan Umum</h2>
                        <div class="accordion">
                            <?php foreach ($faqs as $i => $faq) : ?>
                                <div class="accordion__item <?php echo $i === 0 ? 'accordion__item--active' : ''; ?>">
                                    <button class="accordion__trigger" aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>">
                                        <span><?php echo esc_html($faq['question']); ?></span>
                                        <span class="accordion__icon"></span>
                                    </button>
                                    <div class="accordion__content" <?php echo $i === 0 ? '' : 'aria-hidden="true"'; ?>>
                                        <p><?php echo esc_html($faq['answer']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Content -->
                <section class="service-section">
                    <?php the_content(); ?>
                </section>

                <!-- Share -->
                <?php alya_social_share(); ?>
            </div>

            <!-- Sidebar -->
            <aside class="service-single__sidebar">
                <div class="sidebar-sticky">
                    <div class="sidebar-card">
                        <h3 class="sidebar-card__title">Butuh Konsultasi?</h3>
                        <p class="sidebar-card__desc">Hubungi kami untuk informasi lebih lanjut tentang treatment ini.</p>
                        <a href="<?php echo esc_url(alya_wa_link('Halo, saya ingin tahu tentang ' . get_the_title())); ?>" class="btn btn--wa btn--full" target="_blank" rel="noopener noreferrer">
                            <?php echo alya_icon('whatsapp'); ?>
                            Chat WhatsApp
                        </a>
                    </div>

                    <?php
                    $related = get_field('alya_related');
                    if ($related) :
                    ?>
                        <div class="sidebar-card">
                            <h3 class="sidebar-card__title">Layanan Terkait</h3>
                            <ul class="sidebar-links">
                                <?php foreach ($related as $rel) : ?>
                                    <li>
                                        <a href="<?php echo esc_url(get_permalink($rel->ID)); ?>">
                                            <?php echo esc_html($rel->post_title); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</article>

<?php endwhile; ?>

<?php get_footer();

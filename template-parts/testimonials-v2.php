<?php
/**
 * Testimonials V2 — Featured card + avatar strip
 *
 * @package Alya_Esthetic
 */

$testi_placeholder = get_template_directory_uri() . '/assets/images/placeholder-testimonial.webp';

$max_testi   = max(1, intval(get_theme_mod('alya_featured_testimonials_count', 6)));

// Slider aktif jika total testimonial di DB > 6 (melebihi kapasitas layout avatar-strip)
$total_testi = wp_count_posts('testimonial')->publish ?? 0;
$use_slider  = $total_testi > 6;

// Jika slider aktif ambil sesuai setting; jika tidak batasi 6
$fetch_count = $use_slider ? $max_testi : min($max_testi, 6);
$testi_posts = alya_get_posts('testimonial', ['posts_per_page' => $fetch_count]);
$items = [];

if ($testi_posts && $testi_posts->have_posts()) {
    while ($testi_posts->have_posts()) {
        $testi_posts->the_post();
        $avatar = get_field('alya_avatar');
        $name = get_field('alya_author_name') ?: get_the_title();
        $role = get_field('alya_author_role') ?: get_field('alya_service_used') ?: 'Pasien Rhoé Skin';
        $quote = wp_strip_all_tags(get_the_content());
        $img_url = '';
        if ($avatar && is_array($avatar)) {
            $img_url = $avatar['url'];
        } elseif (has_post_thumbnail()) {
            $img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        }
        if (!$img_url) {
            $img_url = $testi_placeholder;
        }
        $items[] = [
            'name'   => $name,
            'role'   => $role,
            'quote'  => $quote,
            'img'    => $img_url,
            'rating' => intval(get_field('alya_rating') ?: 5),
        ];
    }
    wp_reset_postdata();
}

if (empty($items)) {
    $items = [
        [
            'name'   => 'Cindy Pricilla',
            'role'   => 'Pasien Skin Serenity',
            'quote'  => 'Konsultasinya sangat detail, dokter menjelaskan kondisi kulit saya dengan jelas sebelum treatment. Hasilnya juga terasa setelah beberapa sesi. Tempatnya nyaman banget, jadi makin semangat rutin perawatan!',
            'img'    => $testi_placeholder,
            'rating' => 5,
        ],
        [
            'name'   => 'Anggie Ang',
            'role'   => 'Pasien Beauty Advance',
            'quote'  => 'Stafnya ramah dan klinik selalu bersih. Booking jadwal juga gampang lewat WhatsApp, jadi nggak perlu antre lama. Dokternya juga sabar jawab semua pertanyaan.',
            'img'    => $testi_placeholder,
            'rating' => 5,
        ],
        [
            'name'   => 'Sarah Andreas',
            'role'   => 'Pasien Slimming & Wellness',
            'quote'  => 'Program slimming-nya membantu banget, dan tetap diawasi dokter jadi lebih tenang. Hasilnya bertahap tapi konsisten, dan aku merasa lebih sehat secara keseluruhan.',
            'img'    => $testi_placeholder,
            'rating' => 5,
        ],
        [
            'name'   => 'Sandra Lubis',
            'role'   => 'Pasien Alya Beauty Bar',
            'quote'  => 'Gak nyesel sama sekali treatment di Alya, tempatnya super nyaman! Buat aku yang awalnya gak paham treatment, dijelaskan sama dokternya sampai ngerti. 100% mau balik lagi.',
            'img'    => $testi_placeholder,
            'rating' => 5,
        ],
        [
            'name'   => 'Nina Pratiwi',
            'role'   => 'Pasien Skin Serenity',
            'quote'  => 'Perawatan wajahnya bikin kulit terasa lebih segar dan glowing dari sesi pertama. Terapisnya juga informatif, selalu kasih tau step demi step yang dilakukan.',
            'img'    => $testi_placeholder,
            'rating' => 5,
        ],
        [
            'name'   => 'Maizura',
            'role'   => 'Pasien Beauty Advance',
            'quote'  => 'Suka banget sama pelayanannya, dari resepsionis sampai dokter semua ramah. Hasil fillernya juga natural, sesuai ekspektasi.',
            'img'    => $testi_placeholder,
            'rating' => 5,
        ],
    ];
}

$first = $items[0];
?>

<section class="testi" id="testimoni" data-testi-count="<?php echo esc_attr($max_testi); ?>" data-use-slider="<?php echo $use_slider ? '1' : '0'; ?>">
    <div class="container">
        <div class="testi__head">
            <div>
                <span class="eyebrow">Testimoni</span>
                <h2>Apa Kata Pasien Kami</h2>
            </div>
            <p class="lead">Sudah banyak pasien Rhoé Skin Center yang merasakan sendiri hasilnya. Lihat cerita mereka di sini!</p>
        </div>

        <div class="testi-feat" id="testiFeat">
            <div class="testi-feat__media" id="testiFeatMedia">
                <?php if (!empty($first['img'])) : ?>
                    <img src="<?php echo esc_url($first['img']); ?>" alt="<?php echo esc_attr($first['name']); ?>">
                <?php else : ?>
                    <div class="testi-feat__initial"><?php echo esc_html(mb_substr($first['name'], 0, 1)); ?></div>
                <?php endif; ?>
            </div>
            <div class="testi-feat__body">
                <b id="testiFeatName"><?php echo esc_html($first['name']); ?></b>
                <span class="role" id="testiFeatRole"><?php echo esc_html($first['role']); ?></span>
                <div class="stars" id="testiFeatStars">
                    <?php echo alya_stars(5, $first['rating']); ?>
                </div>
                <p id="testiFeatQuote"><?php echo esc_html($first['quote']); ?></p>
            </div>
        </div>

        <div class="testi-strip">
            <?php if ($use_slider) : ?>
            <!-- Swiper mode — aktif saat testimonial > 6 -->
            <div class="swiper testi-swiper" id="testiAvatarSwiper">
                <div class="swiper-wrapper testi-strip__track" id="testiStrip">
            <?php else : ?>
            <div class="testi-strip__track" id="testiStrip">
            <?php endif; ?>

                <?php foreach ($items as $idx => $item) : ?>
                    <?php $slide_open  = $use_slider ? '<div class="swiper-slide">' : ''; ?>
                    <?php $slide_close = $use_slider ? '</div>' : ''; ?>
                    <?php echo $slide_open; ?>
                    <button class="testi-avatar<?php echo $idx === 0 ? ' active' : ''; ?>"
                            data-name="<?php echo esc_attr($item['name']); ?>"
                            data-role="<?php echo esc_attr($item['role']); ?>"
                            data-img="<?php echo esc_url($item['img']); ?>"
                            data-quote="<?php echo esc_attr($item['quote']); ?>"
                            data-rating="<?php echo esc_attr($item['rating']); ?>">
                        <span class="thumb">
                            <?php if (!empty($item['img'])) : ?>
                                <img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['name']); ?>">
                            <?php else : ?>
                                <span class="initial"><?php echo esc_html(mb_substr($item['name'], 0, 1)); ?></span>
                            <?php endif; ?>
                        </span>
                        <span><?php echo esc_html($item['name']); ?></span>
                    </button>
                    <?php echo $slide_close; ?>
                <?php endforeach; ?>

            <?php if ($use_slider) : ?>
                </div><!-- .swiper-wrapper -->
                <div class="swiper-pagination testi-swiper__pagination"></div>
                <div class="swiper-button-prev testi-swiper__prev"></div>
                <div class="swiper-button-next testi-swiper__next"></div>
            </div><!-- .testi-swiper -->
            <?php else : ?>
            </div><!-- .testi-strip__track -->
            <?php endif; ?>
        </div>
    </div>
</section>

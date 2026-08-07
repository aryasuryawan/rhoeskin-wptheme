<?php
/**
 * Testimonials V2 — Featured card + avatar strip
 *
 * @package Alya_Esthetic
 */

$testi_posts = alya_get_posts('testimonial', ['posts_per_page' => 6]);
$items = [];

if ($testi_posts && $testi_posts->have_posts()) {
    while ($testi_posts->have_posts()) {
        $testi_posts->the_post();
        $avatar = get_field('alya_avatar');
        $name = get_field('alya_author_name') ?: get_the_title();
        $role = get_field('alya_author_role') ?: get_field('alya_service_used') ?: 'Pasien Alya Esthetic';
        $quote = wp_strip_all_tags(get_the_content());
        $img_url = '';
        if ($avatar && is_array($avatar)) {
            $img_url = $avatar['url'];
        } elseif (has_post_thumbnail()) {
            $img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        }
        $items[] = [
            'name'  => $name,
            'role'  => $role,
            'quote' => $quote,
            'img'   => $img_url,
        ];
    }
    wp_reset_postdata();
}

if (empty($items)) {
    $items = [
        [
            'name'  => 'Cindy Pricilla',
            'role'  => 'Pasien Skin Serenity',
            'quote' => 'Konsultasinya sangat detail, dokter menjelaskan kondisi kulit saya dengan jelas sebelum treatment. Hasilnya juga terasa setelah beberapa sesi. Tempatnya nyaman banget, jadi makin semangat rutin perawatan!',
            'img'   => 'https://www.surfaceskinhabit.com/img/CINDY-PRICILLA.jpg',
        ],
        [
            'name'  => 'Anggie Ang',
            'role'  => 'Pasien Beauty Advance',
            'quote' => 'Stafnya ramah dan klinik selalu bersih. Booking jadwal juga gampang lewat WhatsApp, jadi nggak perlu antre lama. Dokternya juga sabar jawab semua pertanyaan.',
            'img'   => 'https://www.surfaceskinhabit.com/img/ANGGIE-ANG.jpg',
        ],
        [
            'name'  => 'Sarah Andreas',
            'role'  => 'Pasien Slimming & Wellness',
            'quote' => 'Program slimming-nya membantu banget, dan tetap diawasi dokter jadi lebih tenang. Hasilnya bertahap tapi konsisten, dan aku merasa lebih sehat secara keseluruhan.',
            'img'   => 'https://www.surfaceskinhabit.com/img/sarah-andreas.jpg',
        ],
        [
            'name'  => 'Sandra Lubis',
            'role'  => 'Pasien Alya Beauty Bar',
            'quote' => 'Gak nyesel sama sekali treatment di Alya, tempatnya super nyaman! Buat aku yang awalnya gak paham treatment, dijelaskan sama dokternya sampai ngerti. 100% mau balik lagi.',
            'img'   => 'https://www.surfaceskinhabit.com/img/SANDRA-LUBIS.jpg',
        ],
        [
            'name'  => 'Nina Pratiwi',
            'role'  => 'Pasien Skin Serenity',
            'quote' => 'Perawatan wajahnya bikin kulit terasa lebih segar dan glowing dari sesi pertama. Terapisnya juga informatif, selalu kasih tau step demi step yang dilakukan.',
            'img'   => 'https://www.surfaceskinhabit.com/img/NINA-PRATIWI.jpg',
        ],
        [
            'name'  => 'Maizura',
            'role'  => 'Pasien Beauty Advance',
            'quote' => 'Suka banget sama pelayanannya, dari resepsionis sampai dokter semua ramah. Hasil fillernya juga natural, sesuai ekspektasi.',
            'img'   => 'https://www.surfaceskinhabit.com/img/MAIZURA.jpg',
        ],
    ];
}

$first = $items[0];
?>

<section class="testi" id="testimoni">
    <div class="container">
        <div class="testi__head">
            <div>
                <span class="eyebrow">Testimoni</span>
                <h2>Apa Kata Pasien Kami</h2>
            </div>
            <p class="lead">Sudah banyak pasien Alya Esthetic Center yang merasakan sendiri hasilnya. Lihat cerita mereka di sini!</p>
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
                <div class="stars">
                    <svg viewBox="0 0 24 24"><path d="M12 2l3 6 6 .9-4.5 4.3 1 6-5.5-3-5.5 3 1-6L3 8.9 9 8z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 2l3 6 6 .9-4.5 4.3 1 6-5.5-3-5.5 3 1-6L3 8.9 9 8z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 2l3 6 6 .9-4.5 4.3 1 6-5.5-3-5.5 3 1-6L3 8.9 9 8z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 2l3 6 6 .9-4.5 4.3 1 6-5.5-3-5.5 3 1-6L3 8.9 9 8z"/></svg>
                    <svg viewBox="0 0 24 24"><path d="M12 2l3 6 6 .9-4.5 4.3 1 6-5.5-3-5.5 3 1-6L3 8.9 9 8z"/></svg>
                </div>
                <p id="testiFeatQuote"><?php echo esc_html($first['quote']); ?></p>
            </div>
        </div>

        <div class="testi-strip">
            <div class="testi-strip__track" id="testiStrip">
                <?php foreach ($items as $idx => $item) : ?>
                    <button class="testi-avatar<?php echo $idx === 0 ? ' active' : ''; ?>"
                            data-name="<?php echo esc_attr($item['name']); ?>"
                            data-role="<?php echo esc_attr($item['role']); ?>"
                            data-img="<?php echo esc_url($item['img']); ?>"
                            data-quote="<?php echo esc_attr($item['quote']); ?>">
                        <span class="thumb">
                            <?php if (!empty($item['img'])) : ?>
                                <img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['name']); ?>">
                            <?php else : ?>
                                <span class="initial"><?php echo esc_html(mb_substr($item['name'], 0, 1)); ?></span>
                            <?php endif; ?>
                        </span>
                        <span><?php echo esc_html($item['name']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

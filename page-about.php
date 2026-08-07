<?php
/**
 * Template Name: Tentang
 *
 * @package Alya_Esthetic
 */

get_header();

$alya_hero_bg       = get_field('alya_hero_bg');
if (is_array($alya_hero_bg)) {
    $alya_hero_bg = $alya_hero_bg['url'] ?? '';
}
if (empty($alya_hero_bg)) {
    $alya_hero_bg = 'https://alyaesthetic.id/wp-content/uploads/2025/01/DSCF5732-scaled-e1737607374147-1536x1233.jpg';
}
$alya_hero_subtitle = get_field('alya_hero_subtitle') ?: 'Tentang Kami';
$alya_hero_title    = get_field('alya_hero_title') ?: 'Mengenal Lebih Dekat Alya Esthetic Center';

$alya_about_image_raw = get_field('alya_about_image');
$alya_about_image_url = '';

if ($alya_about_image_raw) {
    if (is_array($alya_about_image_raw)) {
        $alya_about_image_url = $alya_about_image_raw['url'] ?? '';
    } elseif (is_numeric($alya_about_image_raw)) {
        $alya_about_image_url = wp_get_attachment_image_url($alya_about_image_raw, 'full');
    } elseif (is_string($alya_about_image_raw)) {
        $alya_about_image_url = $alya_about_image_raw;
    }
}

if (empty($alya_about_image_url) && has_post_thumbnail()) {
    $alya_about_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
}

if (empty($alya_about_image_url)) {
    $theme_mod_img = get_theme_mod('alya_about_image');
    if (is_array($theme_mod_img)) {
        $alya_about_image_url = $theme_mod_img['url'] ?? '';
    } elseif (is_numeric($theme_mod_img)) {
        $alya_about_image_url = wp_get_attachment_image_url($theme_mod_img, 'full');
    } elseif (is_string($theme_mod_img)) {
        $alya_about_image_url = $theme_mod_img;
    }
}

if (empty($alya_about_image_url)) {
    $alya_about_image_url = 'https://alyaesthetic.id/wp-content/uploads/2024/09/interior-alya-esthetic-1-768x512.jpg';
}

$alya_about_badge_title = get_field('alya_about_badge_title') ?: get_theme_mod('alya_about_badge_title', 'One Stop');
$alya_about_badge_desc  = get_field('alya_about_badge_desc') ?: get_theme_mod('alya_about_badge_desc', 'Semua solusi kecantikan di satu tempat');
$alya_about_points_raw = get_field('alya_about_points');
$alya_about_points = is_array($alya_about_points_raw) ? $alya_about_points_raw : alya_parse_list($alya_about_points_raw);

$alya_about_title = get_field('alya_about_title') ?: 'Hospitality, Kesehatan, dan Solusi Satu Pintu';
$alya_about_text  = get_field('alya_about_text');

$alya_stats_raw = get_field('alya_stats');
$alya_stats = is_array($alya_stats_raw) ? $alya_stats_raw : alya_parse_pipe_text($alya_stats_raw);

$alya_vision_title   = get_field('alya_vision_title') ?: 'Visi';
$alya_vision_text    = get_field('alya_vision_text');
$alya_mission_title  = get_field('alya_mission_title') ?: 'Misi';
$alya_mission_text   = get_field('alya_mission_text');
$alya_mission_points_raw = get_field('alya_mission_points');
$alya_mission_points = is_array($alya_mission_points_raw) ? $alya_mission_points_raw : alya_parse_list($alya_mission_points_raw);

$alya_values_raw = get_field('alya_values');
$alya_values = is_array($alya_values_raw) ? $alya_values_raw : alya_parse_values_text($alya_values_raw);

$alya_cta_title    = get_field('alya_cta_title') ?: 'Rawat Kulit Terbaik, Satu Pintu di Alya Esthetic';
$alya_cta_desc     = get_field('alya_cta_desc') ?: 'Konsultasikan kebutuhan kecantikan Anda bersama tim dokter profesional kami di Jakarta Selatan.';
$alya_cta_btn_text = get_field('alya_cta_btn_text') ?: 'Buat Janji Temu';
$alya_cta_btn_url  = get_field('alya_cta_btn_url') ?: home_url('/kontak/');
$alya_cta_bg       = get_field('alya_cta_bg');
if (is_array($alya_cta_bg)) {
    $alya_cta_bg = $alya_cta_bg['url'] ?? '';
}
if (empty($alya_cta_bg)) {
    $alya_cta_bg = 'https://alyaesthetic.id/wp-content/uploads/2025/11/DSCF5148-scaled-e1762063528772.jpg';
}

$alya_doctors = alya_get_posts('doctor', ['posts_per_page' => 6]);

$about_text_default = '<p>Alya Esthetic Center hadir sebagai klinik kecantikan yang mengedepankan hospitality, kesehatan, dan solusi satu pintu untuk semua orang. Kami percaya bahwa kecantikan sejati dimulai dari rasa nyaman dan aman selama menjalani perawatan.</p><p>Berlokasi di Jakarta Selatan, kami membangun kepercayaan Sahabat Alya melalui tim dokter profesional, teknologi terkini, dan pendekatan yang personal untuk setiap kebutuhan kulit dan tubuh — mulai dari perawatan wajah, tubuh, hingga program pelangsingan dan wellness.</p><p>Kenyamanan dan kepuasan pasien merupakan prioritas utama kami, begitu pula dengan menjaga kerahasiaan setiap Sahabat Alya yang berkonsultasi dan menjalani perawatan bersama kami.</p>';

if (!$alya_about_text) {
    $alya_about_text = $about_text_default;
}

$about_points_default = [
    'Tim dokter berpengalaman',
    'Perawatan efektif & personal',
    'Kerahasiaan terjamin',
    'Ramah keluarga'
];

if (!$alya_about_points) {
    $alya_about_points = $about_points_default;
}
?>

<!-- ============ PAGE HERO ============ -->
<section class="page-hero">
    <div class="page-hero__bg" style="background-image:url('<?php echo esc_url($alya_hero_bg); ?>')"></div>
    <div class="container">
        <span class="eyebrow" style="color:#efd9c8"><?php echo esc_html($alya_hero_subtitle); ?></span>
        <h1><?php echo esc_html($alya_hero_title); ?></h1>
        <div class="breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Beranda</a>
            <span>/</span>
            <a href="<?php the_permalink(); ?>" style="color:#fff"><?php the_title(); ?></a>
        </div>
    </div>
</section>

<!-- ============ ABOUT ============ -->
<section class="about">
    <div class="container grid">
        <div class="about__media">
            <img src="<?php echo esc_url($alya_about_image_url); ?>" alt="Interior Alya Esthetic">
            <?php if ($alya_about_badge_title): ?>
                <div class="badge">
                    <b><?php echo esc_html($alya_about_badge_title); ?></b>
                    <span><?php echo esc_html($alya_about_badge_desc); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="about__text">
            <span class="eyebrow">Cerita Kami</span>
            <h2><?php echo esc_html($alya_about_title); ?></h2>
            <?php if ($alya_about_text) : ?>
                <?php echo wp_kses_post($alya_about_text); ?>
            <?php else: ?>
                <p><?php the_content(); ?></p>
            <?php endif; ?>
            <?php if (!empty($alya_about_points)): ?>
                <ul class="about__points">
                    <?php foreach ($alya_about_points as $point): ?>
                        <li><?php echo alya_icon('check'); ?> <?php echo esc_html($point); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============ STATS ============ -->
<section class="stats">
    <div class="container grid">
        <?php if (!empty($alya_stats) && is_array($alya_stats)): ?>
            <?php foreach ($alya_stats as $stat): ?>
                <div><b><?php echo esc_html($stat['number'] ?? ''); ?></b><span><?php echo esc_html($stat['label'] ?? ''); ?></span></div>
            <?php endforeach; ?>
        <?php else: ?>
            <div><b>10+</b><span>Tahun Pengalaman</span></div>
            <div><b>15+</b><span>Dokter & Terapis</span></div>
            <div><b>30+</b><span>Jenis Treatment</span></div>
            <div><b>1000+</b><span>Sahabat Alya Puas</span></div>
        <?php endif; ?>
    </div>
</section>

<!-- ============ VISION MISSION ============ -->
<section class="vm">
    <div class="container vm__grid">
        <div class="vm__card">
            <div class="card__icon"><?php echo alya_icon('pin'); ?></div>
            <h3><?php echo esc_html($alya_vision_title); ?></h3>
            <p>
                <?php if ($alya_vision_text): ?>
                    <?php echo esc_html($alya_vision_text); ?>
                <?php else: ?>
                    Menjadi klinik kecantikan terpercaya dan terdepan di Indonesia yang menghadirkan solusi kecantikan satu pintu, aman, dan berbasis hospitality bagi setiap Sahabat Alya.
                <?php endif; ?>
            </p>
        </div>
        <div class="vm__card">
            <div class="card__icon"><?php echo alya_icon('check'); ?></div>
            <h3><?php echo esc_html($alya_mission_title); ?></h3>
            <?php if (!empty($alya_mission_points)): ?>
                <ul>
                    <?php foreach ($alya_mission_points as $point): ?>
                        <li><?php echo alya_icon('check'); ?> <?php echo esc_html($point); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php elseif ($alya_mission_text): ?>
                <p><?php echo esc_html($alya_mission_text); ?></p>
            <?php else: ?>
                <ul>
                    <li><?php echo alya_icon('check'); ?> Memberikan pelayanan yang ramah, personal, dan mengutamakan kenyamanan pasien.</li>
                    <li><?php echo alya_icon('check'); ?> Menghadirkan tim dokter dan terapis profesional yang terus mengikuti perkembangan teknologi kecantikan.</li>
                    <li><?php echo alya_icon('check'); ?> Menjaga kerahasiaan dan kepercayaan setiap Sahabat Alya.</li>
                    <li><?php echo alya_icon('check'); ?> Menyediakan solusi kecantikan yang efektif, aman, dan terjangkau.</li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ============ VALUES ============ -->
<section class="values">
    <div class="container">
        <div class="values__head">
            <span class="eyebrow">Nilai Kami</span>
            <h2>Mengapa Memilih Alya Esthetic</h2>
            <p class="lead">Komitmen kami dibangun di atas empat nilai utama yang menjadi pedoman setiap layanan.</p>
        </div>
        <div class="cards">
            <?php if (!empty($alya_values) && is_array($alya_values)): ?>
                <?php foreach ($alya_values as $value): ?>
                    <article class="card">
                        <div class="card__icon"><?php echo alya_icon($value['icon'] ?? 'star'); ?></div>
                        <h3><?php echo esc_html($value['title'] ?? ''); ?></h3>
                        <p><?php echo esc_html($value['description'] ?? ''); ?></p>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <article class="card">
                    <div class="card__icon"><?php echo alya_icon('heart'); ?></div>
                    <h3>Hospitality</h3>
                    <p>Keramahan dan kenyamanan pasien menjadi dasar dari setiap interaksi di klinik kami.</p>
                </article>
                <article class="card">
                    <div class="card__icon"><?php echo alya_icon('user'); ?></div>
                    <h3>Keamanan</h3>
                    <p>Setiap prosedur dijalankan sesuai standar medis oleh dokter dan tenaga profesional bersertifikat.</p>
                </article>
                <article class="card">
                    <div class="card__icon"><?php echo alya_icon('star'); ?></div>
                    <h3>Kualitas</h3>
                    <p>Kami hanya menggunakan produk dan teknologi terkini yang teruji untuk hasil yang optimal.</p>
                </article>
                <article class="card">
                    <div class="card__icon"><?php echo alya_icon('lock'); ?></div>
                    <h3>Kerahasiaan</h3>
                    <p>Privasi dan kerahasiaan setiap Sahabat Alya selama berkonsultasi dan menjalani perawatan selalu kami jaga.</p>
                </article>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
$doctor_items = [];
if ($alya_doctors && $alya_doctors->have_posts()) {
    while ($alya_doctors->have_posts()) {
        $alya_doctors->the_post();
        $avatar   = get_field('alya_avatar');
        $position = get_field('alya_position') ?: get_field('alya_specialist') ?: 'Aesthetic Doctor';
        $img_url  = '';
        if ($avatar && is_array($avatar)) {
            $img_url = $avatar['url'];
        } elseif (has_post_thumbnail()) {
            $img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
        }
        $doctor_items[] = [
            'name'     => get_the_title(),
            'position' => $position,
            'img'      => $img_url,
            'url'      => get_permalink(),
        ];
    }
    wp_reset_postdata();
}

$default_doc_url = get_post_type_archive_link('doctor') ?: home_url('/dokter/');

if (empty($doctor_items)) {
    $doctor_items = [
        [
            'name'     => 'dr. Fadhilah Saptogino',
            'position' => 'Aesthetic Doctor · (dr. Alya)',
            'img'      => 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png',
            'url'      => $default_doc_url,
        ],
        [
            'name'     => 'dr. Intan Rhama, MARS',
            'position' => 'Doctor',
            'img'      => 'https://alyaesthetic.id/wp-content/uploads/2025/06/IMG_7279_edit-copy-scaled-e1751174958482.jpg',
            'url'      => $default_doc_url,
        ],
        [
            'name'     => 'dr. Vidyani Adiningtyas',
            'position' => 'Dermatologist & Venereologist · (dr. Tyas)',
            'img'      => 'https://alyaesthetic.id/wp-content/uploads/2024/08/ALYA_5070_Edit-scaled-e1749967350811.png',
            'url'      => $default_doc_url,
        ],
        [
            'name'     => 'dr. Renata Yuliasari',
            'position' => 'Sp. D.V.E',
            'img'      => 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5285-scaled-e1749961075511.jpg',
            'url'      => $default_doc_url,
        ],
        [
            'name'     => 'dr. Bela Cantika',
            'position' => 'Doctor',
            'img'      => 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5381-scaled-e1749961387297.jpg',
            'url'      => $default_doc_url,
        ],
        [
            'name'     => 'dr. Vini Tien Hajjar Dwianti',
            'position' => 'Doctor · (dr. Vini)',
            'img'      => 'https://alyaesthetic.id/wp-content/uploads/2024/08/ALYA_4567_Edit-scaled-e1749966815138.png',
            'url'      => $default_doc_url,
        ],
    ];
}
?>

<!-- ============ DOCTORS ============ -->
<section class="doctors">
    <div class="container">
        <div class="doctors__head">
            <span class="eyebrow">Our Expert</span>
            <h2>Tim Dokter Kami</h2>
            <p class="lead">Dipercaya sebagai klinik kecantikan terbaik di Jakarta Selatan dengan tim dokter profesional dan berpengalaman.</p>
        </div>
        <div class="docs-wrap">
            <div class="docs-carousel" id="docsCarousel">
                <?php foreach ($doctor_items as $doc): ?>
                    <a href="<?php echo esc_url($doc['url'] ?: $default_doc_url); ?>" class="doc">
                        <img src="<?php echo esc_url($doc['img'] ?: 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png'); ?>" alt="<?php echo esc_attr($doc['name']); ?>">
                        <div class="doc__info">
                            <img class="doc-avatar" src="<?php echo esc_url($doc['img'] ?: 'https://alyaesthetic.id/wp-content/uploads/2024/06/ALYA_5754_Edit-scaled-e1749969873976.png'); ?>" alt="">
                            <h4><?php echo esc_html($doc['name']); ?></h4>
                            <p><?php echo esc_html($doc['position']); ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <div class="docs-nav">
                <button id="docsPrev" aria-label="Sebelumnya">&larr;</button>
                <button id="docsNext" aria-label="Berikutnya">&rarr;</button>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA ============ -->
<section class="cta" style="background-image:url('<?php echo esc_url($alya_cta_bg); ?>')">
    <div class="container">
        <h2><?php echo esc_html($alya_cta_title); ?></h2>
        <p><?php echo esc_html($alya_cta_desc); ?></p>
        <a class="btn btn--ghost" href="<?php echo esc_url($alya_cta_btn_url); ?>"><?php echo esc_html($alya_cta_btn_text); ?></a>
    </div>
</section>

<?php get_footer(); ?>
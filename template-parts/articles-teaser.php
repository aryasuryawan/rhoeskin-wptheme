<?php
/**
 * Articles Teaser — Blog cards
 *
 * @package Alya_Esthetic
 */

$posts = alya_get_posts('post', ['posts_per_page' => 3]);
$articles_list = [];

if ($posts && $posts->have_posts()) {
    while ($posts->have_posts()) {
        $posts->the_post();
        $cats = get_the_category();
        $articles_list[] = [
            'title' => get_the_title(),
            'url'   => get_permalink(),
            'tag'   => !empty($cats) ? $cats[0]->name : 'Tips & Edukasi',
            'img'   => get_the_post_thumbnail_url(get_the_ID(), 'medium_large') ?: 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png',
        ];
    }
    wp_reset_postdata();
}

if (empty($articles_list)) {
    $blog_page_url = get_permalink(get_option('page_for_posts')) ?: home_url('/artikel/');
    $articles_list = [
        [
            'title' => 'Rahasia Glass Skin: Perawatan yang Tepat untuk Kulit Bercahaya Alami',
            'url'   => $blog_page_url,
            'tag'   => 'Skin Serenity',
            'img'   => 'https://alyaesthetic.id/wp-content/uploads/2024/08/27.-glass-skin-facial-1024x819.png',
        ],
        [
            'title' => 'Slimming Injection vs Diet Ketat: Mana yang Lebih Efektif?',
            'url'   => $blog_page_url,
            'tag'   => 'Slimming & Wellness',
            'img'   => 'https://alyaesthetic.id/wp-content/uploads/2024/09/34.-slimming-injection-1024x819.png',
        ],
        [
            'title' => 'Filler Wajah: Apa yang Perlu Diketahui Sebelum Melakukan Treatment',
            'url'   => $blog_page_url,
            'tag'   => 'Beauty Advance',
            'img'   => 'https://alyaesthetic.id/wp-content/uploads/2024/08/13.-filler-1024x819.png',
        ],
    ];
}
?>

<section class="articles">
    <div class="container sec-head">
        <div>
            <span class="eyebrow">Blog Alya Esthetic</span>
            <h2>Artikel &amp; Tips Terbaru</h2>
        </div>
        <a class="btn btn--ghostdark" href="<?php echo esc_url(get_permalink(get_option('page_for_posts')) ?: home_url('/artikel/')); ?>">
            Lihat Semua Artikel
        </a>
    </div>
    <div class="container">
        <div class="articles-grid">
            <?php foreach ($articles_list as $item) : ?>
                <a class="post-card" href="<?php echo esc_url($item['url']); ?>">
                    <div class="thumb">
                        <img src="<?php echo esc_url($item['img']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy">
                    </div>
                    <div class="p-body">
                        <span class="tag"><?php echo esc_html($item['tag']); ?></span>
                        <h3><?php echo esc_html($item['title']); ?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

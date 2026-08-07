<?php
/**
 * FAQ — Tabbed accordion (CPT: faq, Taxonomy: faq_category)
 *
 * @package Alya_Esthetic
 */

$title  = get_theme_mod('alya_v2_faq_title', 'Pertanyaan yang Sering Diajukan');
$lead   = get_theme_mod('alya_v2_faq_lead', 'Belum menemukan jawaban yang kamu cari? Hubungi tim kami langsung via WhatsApp.');

// Get FAQ categories (tabs)
$categories = get_terms([
    'taxonomy'   => 'faq_category',
    'hide_empty' => true,
    'orderby'    => 'term_order',
    'order'      => 'ASC',
]);

$faq_data = [];

if (!empty($categories) && !is_wp_error($categories)) {
    foreach ($categories as $cat) {
        $items = [];
        $faq_posts = get_posts([
            'post_type'      => 'faq',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'tax_query'      => [
                [
                    'taxonomy' => 'faq_category',
                    'field'    => 'term_id',
                    'terms'    => $cat->term_id,
                ],
            ],
        ]);

        foreach ($faq_posts as $post) {
            $items[] = [
                'q' => $post->post_title,
                'a' => apply_filters('the_content', $post->post_content),
            ];
        }

        if (!empty($items)) {
            $faq_data[] = [
                'tab'   => $cat->name,
                'items' => $items,
            ];
        }
    }
}

// Fallback if no CPT data
if (empty($faq_data)) {
    $faq_data = [
        [
            'tab'   => 'Booking & Jadwal',
            'items' => [
                ['q' => 'Bagaimana cara booking treatment?', 'a' => 'Anda bisa booking melalui tombol WhatsApp di website ini, atau langsung menghubungi hotline klinik. Tim kami akan membantu memilihkan jadwal dan dokter yang sesuai kebutuhan Anda.'],
                ['q' => 'Saya sudah booking tapi belum menerima konfirmasi', 'a' => 'Silakan hubungi tim WhatsApp kami dengan menyertakan nama dan tanggal booking, tim akan segera mengecek dan mengonfirmasi jadwal Anda.'],
                ['q' => 'Saya ingin membatalkan booking, bagaimana caranya?', 'a' => 'Pembatalan dapat dilakukan melalui WhatsApp minimal 12 jam sebelum jadwal, agar slot dapat dialokasikan ke pasien lain.'],
                ['q' => 'Saya terlambat datang, apakah masih bisa dilayani?', 'a' => 'Keterlambatan lebih dari 15 menit berpotensi memperpendek durasi treatment atau perlu dijadwalkan ulang, tergantung ketersediaan dokter dan pasien berikutnya.'],
                ['q' => 'Apakah Alya Esthetic Center punya program loyalitas?', 'a' => 'Ya, pasien tetap kami mendapatkan promo dan penawaran khusus secara berkala. Informasi lengkap dapat ditanyakan langsung ke tim WhatsApp kami.'],
            ],
        ],
        [
            'tab'   => 'Layanan & Treatment',
            'items' => [
                ['q' => 'Treatment apa saja yang tersedia di Alya Esthetic Center?', 'a' => 'Kami menyediakan empat pilar layanan: Skin Serenity, Beauty Advance, Slimming & Wellness, dan Alya Beauty Bar, seluruhnya dipandu oleh tim dokter berpengalaman.'],
                ['q' => 'Apakah perlu konsultasi dokter sebelum treatment?', 'a' => 'Ya, setiap pasien akan melalui konsultasi terlebih dahulu agar dokter dapat menentukan jenis treatment yang paling sesuai dengan kondisi kulit atau tubuh Anda.'],
                ['q' => 'Berapa lama hasil treatment mulai terlihat?', 'a' => 'Setiap treatment memiliki durasi hasil yang berbeda-beda, umumnya terlihat setelah beberapa sesi rutin. Dokter akan menjelaskan estimasi hasil sesuai jenis perawatan yang Anda pilih.'],
                ['q' => 'Apakah treatment aman untuk kulit sensitif?', 'a' => 'Aman, karena setiap treatment disesuaikan dengan hasil konsultasi dan kondisi kulit masing-masing pasien terlebih dahulu.'],
            ],
        ],
        [
            'tab'   => 'Pembayaran & Voucher',
            'items' => [
                ['q' => 'Metode pembayaran apa saja yang diterima?', 'a' => 'Kami menerima pembayaran tunai, kartu debit/kredit, QRIS, serta transfer bank di seluruh cabang Alya Esthetic Center.'],
                ['q' => 'Apakah voucher atau paket treatment memiliki masa berlaku?', 'a' => 'Ya, setiap voucher dan paket memiliki masa berlaku yang tertera saat pembelian. Silakan hubungi tim kami untuk informasi masa berlaku voucher Anda.'],
                ['q' => 'Bagaimana kebijakan refund?', 'a' => 'Kebijakan refund berlaku sesuai syarat dan ketentuan masing-masing paket. Tim kami akan menjelaskan detailnya sebelum Anda melakukan pembayaran.'],
            ],
        ],
        [
            'tab'   => 'Kebijakan Klinik',
            'items' => [
                ['q' => 'Apa saja protokol kebersihan di klinik?', 'a' => 'Seluruh ruang treatment dan alat disterilkan sebelum dan sesudah digunakan, dan tim kami mengikuti standar kebersihan klinik yang ketat.'],
                ['q' => 'Apakah bisa membawa pendamping saat treatment?', 'a' => 'Bisa, namun pendamping akan menunggu di area lobi demi kenyamanan dan privasi pasien lain yang sedang menjalani treatment.'],
                ['q' => 'Bagaimana jika saya ingin komplain terkait layanan?', 'a' => 'Silakan sampaikan langsung ke tim WhatsApp kami atau ke resepsionis di klinik, keluhan Anda akan segera kami tindaklanjuti.'],
            ],
        ],
    ];
}

$wa_url = alya_wa_link();
?>

<section class="faq" id="faq">
    <div class="container">
        <div class="faq__head">
            <div>
                <span class="eyebrow">FAQ</span>
                <h2><?php echo esc_html($title); ?></h2>
            </div>
            <p class="lead"><?php echo esc_html($lead); ?></p>
        </div>

        <?php if (!empty($faq_data)) : ?>
        <div class="faq-tabs-wrap">
            <button class="faq-arrow" id="faqPrev" aria-label="Sebelumnya">
                <svg viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></svg>
            </button>
            <div class="faq-tabs" id="faqTabs">
                <?php foreach ($faq_data as $i => $tab) : ?>
                    <button class="faq-tab<?php echo $i === 0 ? ' active' : ''; ?>" data-target="faqPanel-<?php echo esc_attr($i); ?>">
                        <?php echo esc_html($tab['tab'] ?? ''); ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <button class="faq-arrow" id="faqNext" aria-label="Berikutnya">
                <svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg>
            </button>
        </div>

        <?php foreach ($faq_data as $i => $tab) : ?>
            <div class="faq-panel<?php echo $i === 0 ? ' active' : ''; ?>" id="faqPanel-<?php echo esc_attr($i); ?>">
                <?php if (!empty($tab['items']) && is_array($tab['items'])) : ?>
                    <?php foreach ($tab['items'] as $j => $item) : ?>
                        <div class="faq-item<?php echo $j === 0 ? ' open' : ''; ?>">
                            <button class="faq-item__q">
                                <span><?php echo esc_html($item['q'] ?? ''); ?></span>
                                <span class="plus"></span>
                            </button>
                            <div class="faq-item__a">
                                <p><?php echo wp_kses_post($item['a'] ?? ''); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <div class="faq-contact">
            <span>Hubungi kami kapan saja:</span>
            <a class="btn btn--ghostdark" href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener">Chat via WhatsApp</a>
        </div>
    </div>
</section>

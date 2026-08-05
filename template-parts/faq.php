<?php
/**
 * FAQ — Tabbed accordion
 *
 * @package Alya_Esthetic
 */

$title  = get_theme_mod('alya_v2_faq_title', 'Pertanyaan yang Sering Diajukan');
$lead   = get_theme_mod('alya_v2_faq_lead', 'Belum menemukan jawaban yang kamu cari? Hubungi tim kami langsung via WhatsApp.');
$faq_data = alya_field_raw('alya_faq_data');

// Fallback FAQ data
if (empty($faq_data) || !is_array($faq_data)) {
    $faq_data = [
        [
            'tab'   => 'Booking & Jadwal',
            'items' => [
                ['q' => 'Bagaimana cara booking treatment?', 'a' => 'Anda bisa booking melalui tombol WhatsApp di website ini, atau langsung menghubungi hotline klinik. Tim kami akan membantu memilihkan jadwal dan dokter yang sesuai kebutuhan Anda.'],
                ['q' => 'Saya sudah booking tapi belum menerima konfirmasi', 'a' => 'Silakan hubungi tim WhatsApp kami dengan menyertakan nama dan tanggal booking, tim akan segera mengecek dan mengonfirmasi jadwal Anda.'],
                ['q' => 'Saya ingin membatalkan booking, bagaimana caranya?', 'a' => 'Pembatalan dapat dilakukan melalui WhatsApp minimal 12 jam sebelum jadwal, agar slot dapat dialokasikan ke pasien lain.'],
            ],
        ],
        [
            'tab'   => 'Layanan & Treatment',
            'items' => [
                ['q' => 'Treatment apa saja yang tersedia?', 'a' => 'Kami menyediakan empat pilar layanan: Skin Serenity, Beauty Advance, Slimming & Wellness, dan Alya Beauty Bar, seluruhnya dipandu oleh tim dokter berpengalaman.'],
                ['q' => 'Apakah perlu konsultasi dokter sebelum treatment?', 'a' => 'Ya, setiap pasien akan melalui konsultasi terlebih dahulu agar dokter dapat menentukan jenis treatment yang paling sesuai dengan kondisi kulit atau tubuh Anda.'],
            ],
        ],
        [
            'tab'   => 'Pembayaran & Voucher',
            'items' => [
                ['q' => 'Metode pembayaran apa saja yang diterima?', 'a' => 'Kami menerima pembayaran tunai, kartu debit/kredit, QRIS, serta transfer bank di seluruh cabang Alya Esthetic Center.'],
                ['q' => 'Apakah voucher memiliki masa berlaku?', 'a' => 'Ya, setiap voucher dan paket memiliki masa berlaku yang tertera saat pembelian. Silakan hubungi tim kami untuk informasi masa berlaku voucher Anda.'],
            ],
        ],
        [
            'tab'   => 'Kebijakan Klinik',
            'items' => [
                ['q' => 'Apa saja protokol kebersihan di klinik?', 'a' => 'Seluruh ruang treatment dan alat disterilkan sebelum dan sesudah digunakan, dan tim kami mengikuti standar kebersihan klinik yang ketat.'],
                ['q' => 'Apakah bisa membawa pendamping saat treatment?', 'a' => 'Bisa, namun pendamping akan menunggu di area lobi demi kenyamanan dan privasi pasien lain yang sedang menjalani treatment.'],
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
                                <p><?php echo esc_html($item['a'] ?? ''); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="faq-contact">
            <span>Hubungi kami kapan saja:</span>
            <a class="btn btn--outline" href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener">Chat via WhatsApp</a>
        </div>
    </div>
</section>

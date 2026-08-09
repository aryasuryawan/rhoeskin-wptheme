<?php
/**
 * Contact V2 — Info card + map
 *
 * @package Alya_Esthetic
 */

$address  = get_theme_mod('alya_address', 'Jakarta Selatan, Indonesia');
$phone    = get_theme_mod('alya_phone', '+62 812-9000-0000');
$phone_link = get_theme_mod('alya_phone_link', '6281290000000');
$hours    = get_theme_mod('alya_clinic_hours', 'Setiap hari, 10.00 – 20.00 WIB');
$maps     = get_theme_mod('alya_google_maps_embed', '');
$wa_url   = alya_wa_link();
?>

<section class="contact" id="kontak">
    <div class="container sec-head">
        <div>
            <span class="eyebrow">Kontak Kami</span>
            <h2>Kunjungi atau Hubungi Kami</h2>
        </div>
        <p class="lead">Buat janji temu melalui WhatsApp atau kunjungi klinik kami langsung di Jakarta Selatan.</p>
    </div>
    <div class="container contact__grid">
        <div class="contact__info">
            <div>
                <h3>Rhoé Skin Center</h3>
                <div class="contact__list">
                    <div class="row">
                        <div class="ic">
                            <svg viewBox="0 0 24 24"><path d="M12 2a7 7 0 00-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 00-7-7zm0 9.5A2.5 2.5 0 1112 6a2.5 2.5 0 010 5.5z"/></svg>
                        </div>
                        <div>
                            <b>Alamat</b>
                            <span><?php echo esc_html($address); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="ic">
                            <svg viewBox="0 0 24 24"><path d="M12 6v6l4 2-.8 1.6-5.2-2.6V6h2zm0-4a10 10 0 100 20 10 10 0 000-20z"/></svg>
                        </div>
                        <div>
                            <b>Jam Operasional</b>
                            <span><?php echo esc_html($hours); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="ic">
                            <svg viewBox="0 0 24 24"><path d="M17.5 14.4c-.3-.2-1.8-.9-2-.9-.3-.1-.5-.1-.7.2-.2.2-.7.9-.9 1.1-.2.2-.3.2-.6.1-1.3-.6-2.2-1.1-3-2.3-.2-.4.2-.4.6-1.1.1-.2 0-.3 0-.4s-.7-1.7-1-2.3c-.2-.6-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-1.1 1.1-1.3 2.5-.3 4 .1.1 2.3 3.6 5.7 5.1a9 9 0 001.9.7c.8.3 1.5.2 2.1.1.6-.1 1.8-.7 2-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.5-.3zM12 21a9 9 0 01-7.7-4.4l-1.8.6 1-1.8A9 9 0 1112 21zm0-19.8C5.9 1.2 1 6 1 12c0 1.9.6 3.8 1.6 5.5L1 21l3.6-1a11 11 0 002.2 1.6A10.9 10.9 0 0012 23c6.1 0 11-4.9 11-11C23 6 18 1.2 12 1.2z"/></svg>
                        </div>
                        <div>
                            <b>WhatsApp</b>
                            <span>Respon cepat untuk booking &amp; konsultasi</span>
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn" href="<?php echo esc_url($wa_url); ?>" target="_blank" rel="noopener" style="width:100%;justify-content:center">Chat via WhatsApp</a>
        </div>
        <div class="contact__map">
            <?php if ($maps) : ?>
                <iframe src="<?php echo esc_url($maps); ?>" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <?php else : ?>
                <iframe src="https://maps.google.com/maps?q=Jakarta%20Selatan&t=&z=13&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <?php endif; ?>
        </div>
    </div>
</section>

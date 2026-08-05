<?php
/**
 * Signature Banner — Full-bleed editorial promo
 *
 * @package Alya_Esthetic
 */

$title    = get_theme_mod('alya_v2_signature_title', 'Glass Skin Facial: Kulit Bercahaya Ala Korea');
$desc     = get_theme_mod('alya_v2_signature_desc', 'Kombinasi pembersihan mendalam, eksfoliasi lembut, dan infus nutrisi untuk kulit yang tampak lebih halus dan bercahaya seketika.');
$cta_text = get_theme_mod('alya_v2_signature_cta_text', 'Lihat Detail Treatment');
$cta_url  = get_theme_mod('alya_v2_signature_cta_url', '#');
$bg_image = get_theme_mod('alya_v2_signature_bg', '');
?>

<section class="signature" <?php if ($bg_image) : ?>style="background-image:url('<?php echo esc_url($bg_image); ?>')"<?php endif; ?>>
    <div class="container">
        <span class="eyebrow eyebrow--light">Signature Treatment</span>
        <h2><?php echo esc_html($title); ?></h2>
        <p><?php echo esc_html($desc); ?></p>
        <?php if ($cta_text) : ?>
            <a class="btn" href="<?php echo esc_url($cta_url); ?>"><?php echo esc_html($cta_text); ?></a>
        <?php endif; ?>
    </div>
</section>

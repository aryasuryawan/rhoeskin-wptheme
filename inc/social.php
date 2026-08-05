<?php
/**
 * Social Share Template + Functions
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

/**
 * Render social share buttons
 * Usage: alya_social_share(); or alya_social_share(get_post());
 */
function alya_social_share($post = null) {
    $links = alya_share_links($post);
    if (empty($links)) return;

    $platforms = [
        'facebook'  => ['label' => 'Facebook',  'color' => '#1877F2'],
        'twitter'   => ['label' => 'Twitter',   'color' => '#1DA1F2'],
        'whatsapp'  => ['label' => 'WhatsApp',  'color' => '#25D366'],
        'linkedin'  => ['label' => 'LinkedIn',  'color' => '#0A66C2'],
        'telegram'  => ['label' => 'Telegram',  'color' => '#0088CC'],
        'line'      => ['label' => 'Line',      'color' => '#00B900'],
        'email'     => ['label' => 'Email',     'color' => '#EA4335'],
        'pinterest' => ['label' => 'Pinterest', 'color' => '#BD081C'],
    ];
    ?>
    <div class="social-share">
        <span class="social-share__label">Bagikan:</span>
        <div class="social-share__buttons">
            <?php foreach ($links as $platform => $url) : ?>
                <a href="<?php echo esc_url($url); ?>"
                   class="social-share__btn social-share__btn--<?php echo esc_attr($platform); ?>"
                   style="--share-color: <?php echo esc_attr($platforms[$platform]['color']); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   title="Bagikan ke <?php echo esc_attr($platforms[$platform]['label']); ?>"
                   aria-label="Bagikan ke <?php echo esc_attr($platforms[$platform]['label']); ?>">
                    <?php echo alya_icon($platform); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

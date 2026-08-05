<?php
/**
 * Analytics — GA4, Facebook Pixel, TikTok Pixel (conditional)
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

/**
 * Google Analytics 4
 */
function alya_ga4_head() {
    $id = get_theme_mod('alya_ga4_id', '');
    if (empty($id)) return;
    ?>
    <!-- Google Analytics 4 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($id); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo esc_js($id); ?>');
    </script>
    <?php
}
add_action('wp_head', 'alya_ga4_head', 1);

/**
 * Facebook Pixel
 */
function alya_fb_pixel_head() {
    $id = get_theme_mod('alya_fb_pixel_id', '');
    if (empty($id)) return;
    ?>
    <!-- Facebook Pixel -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '<?php echo esc_js($id); ?>');
      fbq('track', 'PageView');
    </script>
    <noscript>
      <img height="1" width="1" style="display:none"
           src="https://www.facebook.com/tr?id=<?php echo esc_attr($id); ?>&ev=PageView&noscript=1"/>
    </noscript>
    <?php
}
add_action('wp_head', 'alya_fb_pixel_head', 2);

/**
 * TikTok Pixel
 */
function alya_tiktok_pixel_head() {
    $id = get_theme_mod('alya_tiktok_pixel_id', '');
    if (empty($id)) return;
    ?>
    <!-- TikTok Pixel -->
    <script>
      !function (w, d, t) {
        w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e+""]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};var o=document.createElement("script");o.type="text/javascript",o.async=!0,o.src=i+"?sdkid="+e+"&lib="+t;var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(o,a)};
        ttq.load('<?php echo esc_js($id); ?>');
        ttq.page();
      }(window, document, 'ttq');
    </script>
    <?php
}
add_action('wp_head', 'alya_tiktok_pixel_head', 3);

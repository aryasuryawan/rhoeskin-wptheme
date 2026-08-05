<?php
/**
 * Template Part: Service Card
 *
 * @package Alya_Esthetic
 */
?>
<?php alya_card([
    'title' => get_the_title(),
    'desc'  => wp_trim_words(get_the_excerpt(), 15),
    'image' => get_the_post_thumbnail(get_the_ID(), 'alya-card'),
    'link'  => get_the_permalink(),
    'icon'  => alya_icon('check'),
    'class' => 'card--service',
]); ?>

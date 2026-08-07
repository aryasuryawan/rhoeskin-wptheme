<?php
/**
 * Dropdown Walker — for navigation menu
 *
 * @package Alya_Esthetic
 */

defined('ABSPATH') || exit;

class Alya_Dropdown_Walker extends Walker_Nav_Menu {
    
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown\">\n";
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add dropdown class to parent items
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'has-dropdown';
        }
        
        // Check if current page
        if (get_queried_object_id() == $item->object_id) {
            $classes[] = 'active';
        }

        // Mark menu item that points to the promo archive
        $promo_url = get_post_type_archive_link('promo');
        if ($promo_url && trailingslashit($item->url) === trailingslashit($promo_url)) {
            $classes[] = 'promo-nav-item';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li' . $class_names . '>';
        
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = !empty($item->url)        ? $item->url        : '';
        
        // Add nav__link-wrap class to dropdown parents
        if (in_array('menu-item-has-children', $classes)) {
            $atts['class'] = 'nav__link-wrap';
        }
        
        $attributes  = !empty($atts['href'])    ? ' href="' . esc_url($atts['href']) . '"' : '';
        $attributes .= !empty($atts['title'])   ? ' title="' . esc_attr($atts['title']) . '"' : '';
        $attributes .= !empty($atts['target'])  ? ' target="' . esc_attr($atts['target']) . '"' : '';
        $attributes .= !empty($atts['rel'])     ? ' rel="' . esc_attr($atts['rel']) . '"' : '';
        $attributes .= !empty($atts['class'])   ? ' class="' . esc_attr($atts['class']) . '"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= $item->title . '<svg viewBox="0 0 24 24" width="10" height="10"><path d="M7 10l5 5 5-5z" fill="currentColor"/></svg>';
        } else {
            $item_output .= $item->title;
        }

        $promo_url = get_post_type_archive_link('promo');
        if ($promo_url && trailingslashit($item->url) === trailingslashit($promo_url)) {
            $item_output .= '<span class="promo-nav-badge">HOT</span>';
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}